<?php

namespace App\Http\Services;

use App\Http\Services\Payment\Payment;
use App\Models\Bank;
use App\Models\ClientInvoice;
use App\Models\Currency;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Package;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    use ResponseTrait;

    public function userCheckoutOrder($request)
    {
        DB::beginTransaction();
        try {
            if ($request['checkout_type'] == CHECKOUT_TYPE_USER_INVOICE) {

                $clientInvoice = ClientInvoice::with('order.plan')->findOrFail($request->invoice_id);
                $gateway = Gateway::where(['slug' => $request->gateway,'status' => ACTIVE])->firstOrFail();
                $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id, 'currency' => $request->currency])->firstOrFail();

                $clientInvoice->gateway_id = $gateway->id;
                $clientInvoice->gateway_currency = $gatewayCurrency->currency;
                $clientInvoice->conversion_rate = $gatewayCurrency->conversion_rate;
                $clientInvoice->transaction_amount = $clientInvoice->total * $gatewayCurrency->conversion_rate;
                $clientInvoice->system_currency = Currency::where('current_currency', 'on')
                    ->orWhere(['current_currency' => 1])->first()->currency_code;
                $clientInvoice->save();

                orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_UNPAID);
            } elseif ($request['checkout_type'] == CHECKOUT_TYPE_USER_PLAN) {
                $plan = Package::findOrFail($request->item_id);
                $gateway = Gateway::where(['id' => $request->gateway_id, 'status' => ACTIVE])->firstOrFail();
                $productPrice = $plan->subscriptionPrice->where('gateway_id', $gateway->id)->first();
                $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id, 'id' => $request->currency])->firstOrFail();

                $userClient = auth()->user();
                $amount = $request->duration_type == DURATION_MONTH ? $plan->monthly_price : $plan->yearly_price;

                if (is_null($productPrice)){
                    // Create order and invoice if productPrice is null
                    $order_create_type = CREATE_BY_USER;

                    $orderItems = [
                        (object)[
                            'plan_id' => $plan->id,
                            'price' => $amount,
                            'duration' => $request->duration_type,
                            'quantity' => 1,
                        ]
                    ];

                    $orderData = [
                        'package_id' => $plan->id,
                        'amount' => $amount,
                        'order_create_type' => $order_create_type,
                        'package_type' => $request->duration_type,
                        'orderItems' => (object)($orderItems),
                    ];

                    $clientOrder = makeClientOrder($orderData, $userClient);

                    if ($clientOrder['success'] != true) {
                        throw new Exception($clientOrder['message']);
                    }

                    $invoiceData = [
                        'order' => $clientOrder['data'],
                        'gateway' => $gateway,
                        'gateway_currency' => $gatewayCurrency
                    ];

                    $clientInvoice = makeClientInvoice($invoiceData, $userClient->id);
                    if ($clientInvoice['success'] != true) {
                        throw new Exception($clientInvoice['message']);
                    }
                    $clientInvoice = $clientInvoice['data'];

                    orderMailNotify($clientInvoice->id, INVOICE_MAIL_TYPE_UNPAID);
                }
            } else {
                return back()->with('error', __(SOMETHING_WENT_WRONG));
            }

            $data['gateway'] = $request->gateway;
            $data['checkout_type'] = $request['checkout_type'];

            if ($gateway->slug == 'bank') {
                $bank = Bank::where(['gateway_id' => $gateway->id])->find($request->bank_id);
                if (is_null($bank)) {
                    throw new Exception(__('The bank not found'));
                }

                $bank_id = $bank->id;
                $deposit_by = auth()->user()->name;
                $deposit_slip_id = null;
                if ($request->hasFile('bank_slip')) {
                    $newFile = new FileManager();
                    $uploaded = $newFile->upload('ClientInvoice', $request->bank_slip);
                    if ($uploaded) {
                        $deposit_slip_id = $uploaded->id;
                    }
                } else {
                    throw new Exception(__('The bank slip is required'));
                }

                $clientInvoice->bank_id = $bank_id;
                $clientInvoice->bank_deposit_by = $deposit_by;
                $clientInvoice->bank_deposit_slip_id = $deposit_slip_id;
                $clientInvoice->payment_id = uniqid('BNK');
                $clientInvoice->save();
                DB::commit();
                $message = __('Bank Details Sent Successfully! Wait for approval');
                return $this->success($data, $message);
            } elseif ($gateway->slug == 'cash') {
                $clientInvoice->payment_id = uniqid('CAS');
                $clientInvoice->save();
                DB::commit();
                $message = __('Cash Payment Request Sent Successfully! Wait for approval');
                return $this->success($data, $message);
            } else {
                $object = [
                    'id' => $clientInvoice->id ?? 'subscribe',
                    'callback_url' => route('payment.verify'),
                    'currency' => $gatewayCurrency->currency,
                    'cancel_url' => route('failed'),
                ];

                if (isset($productPrice) && isset($plan) && $request['checkout_type'] == CHECKOUT_TYPE_USER_PLAN) {
                    $object['callback_url'] = route('payment.verify', ['subscription_success' => true]);
                    $payment = new Payment($gateway->slug, $object);
                    $planId = $request->duration_type == DURATION_MONTH ? $productPrice->monthly_price_id : $productPrice->yearly_price_id;
                    $responseData = $payment->subscribeSaas($planId, ['package_id' => $plan->id, 'package_gateway_price_id' => $productPrice->id, 'duration_type' => $request->duration_type]);
                } else {
                    $payment = new Payment($gateway->slug, $object);
                    $responseData = $payment->makePayment($clientInvoice->total);
                }

                if ($responseData['success']) {
                    if (isset($clientInvoice)) {
                        $clientInvoice->payment_id = $responseData['payment_id'];
                        $clientInvoice->save();
                    }
                    $data['redirect_url'] = $responseData['redirect_url'];
                    DB::commit();
                    return $this->success($data);
                } else {
                    throw new Exception($responseData['message']);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], __(SOMETHING_WENT_WRONG));
        }
    }
}
