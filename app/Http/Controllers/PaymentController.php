<?php

namespace App\Http\Controllers;

use App\Http\Services\Payment\Payment;
use App\Models\ClientInvoice;
use App\Models\ClientOrder;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Package;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use ResponseTrait;

    public function verify(Request $request)
    {
        if ($request->subscription_success) {
            return redirect()->route('thankyou')->with('success', __('Payment Successful!'));
        }

        $invoice_id = $request->get('id', '');
        $payerId = $request->get('PayerID', NULL);
        $payment_id = $request->get('payment_id', NULL);
        $clientInvoice = ClientInvoice::findOrFail($invoice_id);
        $clientOrder = ClientOrder::findOrFail($clientInvoice->client_order_id);
        if ($clientInvoice->payment_status == PAYMENT_STATUS_PAID) {
            return redirect()->route('thankyou');
        }

        $gateway = Gateway::find($clientInvoice->gateway_id);
        DB::beginTransaction();
        try {
            if ($clientInvoice->gateway_id == $gateway->id && $gateway->slug == MERCADOPAGO) {
                $clientInvoice->payment_id = $payment_id;
                $clientInvoice->save();
            }

            $gatewayBasePayment = new Payment($gateway->slug, ['currency' => $clientInvoice->gateway_currency, 'tenant_id' => $clientInvoice->tenant_id]);

            $payment_data = $gatewayBasePayment->paymentConfirmation($clientInvoice->payment_id, $payerId);

            if ($payment_data['success']) {
                if ($payment_data['data']['payment_status'] == 'success') {
                    // invoice update
                    $clientInvoice->payment_status = PAYMENT_STATUS_PAID;
                    $clientInvoice->transaction_id = uniqid();
                    $clientInvoice->save();

                    $clientOrder->working_status = WORKING_STATUS_WORKING;
                    $clientOrder->payment_status = PAYMENT_STATUS_PAID;
                    $clientOrder->start_date = now();
                    if ($clientOrder->package_type == DURATION_MONTH) {
                        $clientOrder->end_date = now()->addMonth();
                    } else {
                        $clientOrder->end_date = now()->addYear();
                    }
                    $clientOrder->save();
                    DB::commit();

                    //notification call start
                    setCommonNotification($clientInvoice->client_id, __('Have a new checkout'), __('Invoice Id: ') . $clientInvoice->invoice_id, '');
                    // send success mail
                    orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_PAID);

                    return redirect()->route('thankyou');
                }
            } else {
                return redirect()->route('failed');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('failed');
        }
    }


    public function getCurrencyByGateway(Request $request)
    {
        $currencies = GatewayCurrency::where(['gateway_id' => $request->id])->get();

        foreach ($currencies as $currency) {
            $currency->symbol = $currency->symbol;
        }
        $data = $currencies?->makeHidden(['created_at', 'updated_at', 'deleted_at']);
        return $this->success($data);
    }

    public function webhook(Request $request)
    {
        $gateway = Gateway::where(['slug' => $request->payment_method])->first();
        $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id])->first();

        if (!$gateway) {
            return response()->json(['success' => false, 'message' => 'Gateway not found']);
        }

        // Define the payment service object dynamically
        $object = [
            'type' => 'subscription',
            'currency' => $gatewayCurrency->currency,
        ];

        $paymentService = new Payment($request->payment_method, $object);

        // Handle the webhook request using the respective service (Stripe or PayPal)
        $response = $paymentService->handleWebhook($request);

        if ($response['success']) {
            // Determine whether the event is from Stripe or PayPal and handle it accordingly
            $event = $response['event'];

            Log::info($event);

            if ($request->payment_method === 'stripe') {
                // Call Stripe specific webhook handler
                $this->stripeWebhook($event);
            } elseif ($request->payment_method === 'paypal') {
                // Call PayPal specific webhook handler
                $this->paypalWebhook($event);
            }

            return response()->json(['success' => true, 'message' => 'Webhook handled successfully']);
        } else {
            return response()->json(['success' => false, 'message' => $response['message']]);
        }
    }

    function stripeWebhook($event)
    {
        try {
            DB::beginTransaction();
            // Process the event based on its type
            switch ($event->type) {
                case 'invoice.created':
                    $response = $event->data->object;
                    $metaData = $response->subscription_details->metadata;
                    $planData = $response->lines->data[0]->plan;

                    $plan = Package::where('id', $metaData->package_id)->first();

                    $userClient = User::where('id', $metaData->user_id)->first();
                    $amount = $planData->interval == 'month' ? $plan->monthly_price : $plan->yearly_price;

                    if ($amount * 100 <= $response->total) {

                        $payment = ClientInvoice::where(['payment_id' => $response->id])->first();
                        if (is_null($payment)) {

                            $orderItems = [
                                (object)[
                                    'plan_id' => $plan->id,
                                    'price' => $amount,
                                    'duration' => $metaData->duration_type,
                                    'quantity' => 1,
                                ]
                            ];

                            $orderData = [
                                'package_id' => $plan->id,
                                'amount' => $amount,
                                'order_create_type' => CREATE_BY_USER,
                                'package_type' => $metaData->duration_type,
                                'orderItems' => (object)($orderItems),
                            ];

                            $clientOrder = makeClientOrder($orderData, $userClient);

                            if ($clientOrder['success'] != true) {
                                Log::info('--------***client order create error***------');
                                Log::info($clientOrder['message']);
                                Log::info('--------***Webhook END***------');
                            }

                            $gateway = Gateway::where(['slug' => STRIPE, 'status' => ACTIVE])->first();
                            $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id])->first();

                            $invoiceData = [
                                'order' => $clientOrder['data'],
                                'gateway' => $gateway,
                                'gateway_currency' => $gatewayCurrency
                            ];

                            $clientInvoice = makeClientInvoice($invoiceData, $userClient->id);
                            if ($clientInvoice['success'] != true) {
                                Log::info('--------***client invoice create error***------');
                                Log::info($clientOrder['message']);
                                Log::info('--------***Webhook END***------');
                            }

                            $clientInvoice = $clientInvoice['data'];
                            $clientInvoice->payment_id = $response->id;
                            $clientInvoice->Save();

                            orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_UNPAID);
                        } else {
                            Log::info('--------***Already order found***------');
                            Log::info('--------***Check if invoice order already exist END***------');
                        }
                    } else {
                        Log::info('--------***Amount mismatch***------');
                        Log::info('--------***Webhook END***------');
                    }
                    DB::commit();
                    break;
                case 'invoice.payment_succeeded':
                    $response = $event->data->object;
                    $metaData = $response->subscription_details->metadata;
                    //check if the payment is there and in processing
                    Log::info('--------***Check if order exist or order status in processing START***------');

                    $clientInvoice = ClientInvoice::where(['payment_id' => $response->id])->with('order')->first();
                    if (!is_null($clientInvoice) && $clientInvoice->payment_status == PAYMENT_STATUS_PENDING) {
                        Log::info('--------***Order found***------');
                        Log::info('--------***Order invoice verify START***------');

                        $clientInvoice->payment_status = PAYMENT_STATUS_PAID;
                        $clientInvoice->transaction_id = uniqid();
                        $clientInvoice->save();

                        $clientOrder = $clientInvoice->order;
                        $clientOrder->working_status = WORKING_STATUS_WORKING;
                        $clientOrder->payment_status = PAYMENT_STATUS_PAID;
                        $clientOrder->start_date = now();
                        if ($clientOrder->package_type == DURATION_MONTH) {
                            $clientOrder->end_date = now()->addMonth();
                        } else {
                            $clientOrder->end_date = now()->addYear();
                        }
                        $clientOrder->save();

                        //notification call start
                        setCommonNotification($clientInvoice->client_id, __('Have a new checkout'), __('Invoice Id: ') . $clientInvoice->invoice_id, '');
                        // send success mail
                        orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_PAID);

                        $adminUser = User::where('status', USER_ROLE_ADMIN)->first();
                        setCommonNotification('Have a new payment', 'Order Id: ' . $clientOrder->order_id, '', $adminUser->id);

                        DB::commit();
                        Log::info('--------***Order invoice verify END***------');
                    } else {
                        Log::info('--------***Order not found with that criteria***------');
                        Log::info('--------***Check if order exist or order status in processing END***------');
                    }
                    DB::commit();
                    break;
                // Add more cases for other event types as needed
                default:
                    // Handle unknown event types
                    break;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Invalid payload
            Log::info('Stripe webhook error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            Log::info('--------***Webhook Failed -- END***------');
        }

    }

    public function paypalWebhook($event)
    {
        try {
            DB::beginTransaction();
            // Handle PayPal specific events
            switch ($event['event_type']) {
                case 'PAYMENT.SALE.COMPLETED':
                    $resource = $event['resource'];
                    Log::info('Handling PayPal Payment Completed:', $resource);

                    // Extract payment information from the webhook
                    $paymentId = $resource['id'];
                    $metaData = json_decode($resource['custom'], true); // Assuming 'custom_id' stores package_id and user_id

                    // Find the subscription order using the payment ID or transaction ID
                    $clientInvoice = ClientInvoice::where(['payment_id' => $paymentId])->first();

                    if (is_null($clientInvoice)) {
                        // No order found, create a new one
                        $userId = $metaData['user_id'] ?? null;
                        $userClient = User::where('id', $userId)->first();
                        $packageId = $metaData['package_id'] ?? null;
                        $package = Package::where('id', $packageId)->first();

                        if (is_null($package)) {
                            Log::error("Invalid metadata for PayPal event: " . json_encode($metaData));
                            DB::rollBack();
                            return;
                        }

                        if ($metaData['duration_type'] == DURATION_YEAR) {
                            $amount = $package->yearly_price;
                        } else {
                            $amount = $package->monthly_price;
                        }

                        $orderItems = [
                            (object)[
                                'plan_id' => $package->id,
                                'price' => $amount,
                                'duration' => $metaData['duration_type'],
                                'quantity' => 1,
                            ]
                        ];

                        $orderData = [
                            'package_id' => $package->id,
                            'amount' => $amount,
                            'order_create_type' => CREATE_BY_USER,
                            'package_type' => $metaData['duration_type'],
                            'orderItems' => (object)($orderItems),
                        ];

                        $clientOrder = makeClientOrder($orderData, $userClient);

                        if ($clientOrder['success'] != true) {
                            Log::info('--------***client order create error***------');
                            Log::info($clientOrder['message']);
                            Log::info('--------***Webhook END***------');
                        }

                        $gateway = Gateway::where(['slug' => PAYPAL, 'status' => ACTIVE])->first();
                        $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id])->first();

                        $invoiceData = [
                            'order' => $clientOrder['data'],
                            'gateway' => $gateway,
                            'gateway_currency' => $gatewayCurrency
                        ];

                        $clientInvoice = makeClientInvoice($invoiceData, $userClient->id);
                        if ($clientInvoice['success'] != true) {
                            Log::info('--------***client invoice create error***------');
                            Log::info($clientOrder['message']);
                            Log::info('--------***Webhook END***------');
                        }

                        $clientInvoice = $clientInvoice['data'];
                        $clientInvoice->payment_id = $paymentId;
                        $clientInvoice->Save();

                        orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_UNPAID);
                    }

                    // If order exists and payment is pending, mark it as paid
                    if (!is_null($clientInvoice) && $clientInvoice->payment_status == PAYMENT_STATUS_PENDING) {
                        $clientInvoice->payment_status = PAYMENT_STATUS_PAID;
                        $clientInvoice->transaction_id = $paymentId;  // PayPal Transaction ID
                        $clientInvoice->save();

                        $clientOrder = $clientInvoice->order;
                        $clientOrder->working_status = WORKING_STATUS_WORKING;
                        $clientOrder->payment_status = PAYMENT_STATUS_PAID;
                        $clientOrder->start_date = now();
                        if ($clientOrder->package_type == DURATION_MONTH) {
                            $clientOrder->end_date = now()->addMonth();
                        } else {
                            $clientOrder->end_date = now()->addYear();
                        }
                        $clientOrder->save();


                        //notification call start
                        setCommonNotification($clientInvoice->client_id, __('Have a new checkout'), __('Invoice Id: ') . $clientInvoice->invoice_id, '');
                        // send success mail
                        orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_PAID);

                        $adminUser = User::where('status', USER_ROLE_ADMIN)->first();
                        setCommonNotification('Have a new payment', 'Order Id: ' . $clientOrder->order_id, '', $adminUser->id);

                        Log::info('Payment successfully completed for order ID: ' . $clientInvoice->id);
                    } else {
                        Log::warning('Order not found or already processed for payment ID: ' . $paymentId);
                    }
                    DB::commit();
                    break;
                default:
                    DB::rollBack();
                    // Handle unknown event types
                    break;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Invalid payload
            Log::info('Stripe webhook error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            Log::info('--------***Webhook Failed -- END***------');
        }
    }

    public function thankyou()
    {
        return view('common.thankyou');
    }

    public function waiting()
    {
        return view('common.waiting');
    }

    public function failed()
    {
        return view('common.failed');
    }
}
