<?php

namespace App\Http\Services;

use App\Models\ClientInvoice;
use App\Models\ClientOrderItem;
use App\Models\ClientOrder;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Service;
use App\Models\UserActivityLog;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ClientInvoiceServices
{
    use ResponseTrait;

    public function getClientInvoiceListData($request, $id = null)
    {

        $clientInfo = ClientInvoice::with(['clientOrderItems', 'gateway', 'order.plan'])->whereHas('order.plan')->orderByDesc('client_invoices.id');
        if ($id) {
            $clientInfo->where('client_id', $id);
            $status = 'all';
        } else {
            $status = 0;
            if ($request->status == PAYMENT_STATUS_PAID) {
                $status = PAYMENT_STATUS_PAID;
            } else if ($request->status == PAYMENT_STATUS_PENDING) {
                $status = PAYMENT_STATUS_PENDING;
            } else if ($request->status == PAYMENT_STATUS_CANCELLED) {
                $status = PAYMENT_STATUS_CANCELLED;
            } else if ($request->status == 'all') {
                $status = 'all';
            }
            if ($status != 'all') {
                $clientInfo->where('payment_status', $status);
            }
            if (auth()->user()->role == USER_ROLE_CLIENT) {
                $clientInfo->where('client_id', auth()->id());
            }
        }
        return datatables($clientInfo)
            ->addIndexColumn()
            ->addColumn('plan_name', function ($clientInfo) {
                return $clientInfo->order->plan->name;
            })
            ->addColumn('order_name', function ($clientInfo) {
                return $clientInfo->order?->order_id;
            })
            ->addColumn('gateway_name', function ($clientInfo) {
                return $clientInfo->gateway?->title;
            })
            ->addColumn('client_name', function ($clientInfo) {
                return $clientInfo->client?->name;
            })
            ->addColumn('total_price', function ($clientInfo) {
                return showPrice($clientInfo->total);
            })
            ->addColumn('status', function ($clientInfo) {
                if ($clientInfo->payment_status == PAYMENT_STATUS_PAID) {
                    return '<p class="zBadge zBadge-paid">' . __("Paid") . '</p>';
                } elseif ($clientInfo->payment_status == PAYMENT_STATUS_PENDING) {
                    return '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>';
                } else {
                    return '<p class="zBadge zBadge-cancel">' . __("Cancelled") . '</p>';
                }
            })
            ->addColumn('action', function ($clientInfo) use ($status) {
                $return = "<div class='dropdown dropdown-one'>
                        <button class='dropdown-toggle p-0 bg-transparent w-30 h-30 ms-auto bd-one bd-c-stroke rounded-circle d-flex justify-content-center align-items-center' type='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa-solid fa-ellipsis'></i></button><ul class='dropdown-menu dropdownItem-invoice'>";

                if (($status == PAYMENT_STATUS_PENDING || $status == PAYMENT_STATUS_CANCELLED) && (auth()->user()->role == USER_ROLE_ADMIN || auth()->user()->role == USER_ROLE_TEAM_MEMBER)) {
                    $return .= "<li><button class='border-0 bg-transparent d-flex align-items-center cg-8' onclick='getEditModal(\"" . route("admin.client-invoice.payment-edit", $clientInfo->id) . "\"" . ", \"#showPaymentModal\")'>
                                <div class='d-flex'><svg width='12' height='13' viewBox='0 0 12 13' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z' fill='#5D697A' /></svg></div><p class='fs-14 fw-500 lh-17 text-nowrap text-para-text'>" . __('Status Change') . "</p></button></li>";
                }
                if (auth()->user()->role == USER_ROLE_ADMIN || auth()->user()->role == USER_ROLE_TEAM_MEMBER) {
                    $return .= "<li><button class='d-flex align-items-center cg-8 border-0 p-0 bg-transparent' onclick='getEditModal(\"" . route('admin.client-invoice.details', $clientInfo->id) . "\", \"#invoicePreviewModal\")'>";
                } else {
                    if ($clientInfo->payment_status == PAYMENT_STATUS_PENDING) {
                        $return .= "
                                            <li>
                                                <a href='#' class='d-flex align-items-center cg-8 border-0 p-0 bg-transparent payNowBtn' data-data='" . json_encode($clientInfo) . "'>
                                                    <div class='d-flex'>
                                                        <img src='" . asset('assets/images/icon/dollar-circle.svg') . "' alt='' />
                                                    </div>
                                                    <p class='fs-14 fw-500 lh-17 text-para-text'>" . __('Pay Now') . "</p>
                                                </a>
                                            </li>";
                    }
                    $return .= "<li><button class='d-flex align-items-center cg-8 border-0 p-0 bg-transparent' onclick='getEditModal(\"" . route('user.client-invoice.details', $clientInfo->id) . "\", \"#invoicePreviewModal\")'>";
                }
                $return .= "<div class='d-flex'>
                            <svg width='15' height='12' viewBox='0 0 15 12' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                <path d='M7.5 8C8.60457 8 9.5 7.10457 9.5 6C9.5 4.89543 8.60457 4 7.5 4C6.39543 4 5.5 4.89543 5.5 6C5.5 7.10457 6.39543 8 7.5 8Z' fill='#5D697A'></path> <path d='M14.9698 5.83C14.3817 4.30882 13.3608 2.99331 12.0332 2.04604C10.7056 1.09878 9.12953 0.561286 7.49979 0.5C5.87005 0.561286 4.29398 1.09878 2.96639 2.04604C1.6388 2.99331 0.617868 4.30882 0.0297873 5.83C-0.00992909 5.93985 -0.00992909 6.06015 0.0297873 6.17C0.617868 7.69118 1.6388 9.00669 2.96639 9.95396C4.29398 10.9012 5.87005 11.4387 7.49979 11.5C9.12953 11.4387 10.7056 10.9012 12.0332 9.95396C13.3608 9.00669 14.3817 7.69118 14.9698 6.17C15.0095 6.06015 15.0095 5.93985 14.9698 5.83ZM7.49979 9.25C6.857 9.25 6.22864 9.05939 5.69418 8.70228C5.15972 8.34516 4.74316 7.83758 4.49718 7.24372C4.25119 6.64986 4.18683 5.99639 4.31224 5.36596C4.43764 4.73552 4.74717 4.15642 5.20169 3.7019C5.65621 3.24738 6.23531 2.93785 6.86574 2.81245C7.49618 2.68705 8.14965 2.75141 8.74351 2.99739C9.33737 3.24338 9.84495 3.65994 10.2021 4.1944C10.5592 4.72886 10.7498 5.35721 10.7498 6C10.7485 6.86155 10.4056 7.68743 9.79642 8.29664C9.18722 8.90584 8.36133 9.24868 7.49979 9.25Z' fill='#5D697A'>
                                </path>
                            </svg>
                            </div>
                            <p class='fs-14 fw-500 lh-17 text-para-text'>" . __('View Details') . "</p></button></li>";

                if ($clientInfo->gateway_id != null && $clientInfo->gateway?->slug == 'bank') {
                    $return .= "<li>
                                <a target='_blank' href='" . getFileUrl($clientInfo->bank_deposit_slip_id) . "' class='d-flex align-items-center cg-8 border-0 p-0 bg-transparent'>
                                    <div class='d-flex'>
                                        <img src='" . asset('assets/images/icon/download-2.svg') . "' alt='' />
                                    </div>
                                    <p class='text-nowrap fs-14 fw-500 lh-17 text-para-text'>" . __('Download Slip') . "</p>
                                </a>
                            </li>";
                }
                $return .= "</ul>
                        </div>";

                return $return;
            })
            ->rawColumns(['status', 'action', 'total_price', 'due_date', 'order_name', 'gateway_name', 'order_id'])
            ->make(true);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id', '');
            $allDiscount = 0;
            $subTotal = 0;

            if ($id != '') {
                $invoice = ClientInvoice::find($id);
                $clientOrder = ClientOrder::where('id', $invoice->order_id)->first();

                if (!$request->order_id) {
                    $chekDataExist = ClientOrderItem::where('order_id', $invoice->order_id)->get();
                    if (count($chekDataExist) > 0) {
                        foreach ($chekDataExist as $item) {
                            $item->delete();
                        }
                    }
                }
            } else {
                $invoice = new ClientInvoice();
                $clientOrder = new ClientOrder();
            }

            if ($request->order_id && $request->order_id != null) {
                // save ClientInvoice data
                $clientOrder = ClientOrder::findOrFail($request->order_id);
                $invoice->client_id = $request->client_id;
                $invoice->due_date = $request->due_date;
                $invoice->tenant_id = auth()->user()->tenant_id;
                $invoice->total = $request->payable_amount;
                $invoice->order_id = $request->order_id;
                $invoice->payable_amount = $request->payable_amount;
                $invoice->payment_status = $request->payment_status ?? PAYMENT_STATUS_PENDING;
                $clientOrder->payment_status = $request->payment_status ?? PAYMENT_STATUS_PENDING;
                $clientOrder->working_status = WORKING_STATUS_PENDING;
                if ($request->payment_status == PAYMENT_STATUS_PAID) {
                    $clientOrder->increment('transaction_amount', $request->payable_amount);
                    if ($clientOrder->transaction_amount >= $clientOrder->total) {
                        $clientOrder->payment_status = PAYMENT_STATUS_PAID;
                        $clientOrder->working_status = WORKING_STATUS_WORKING;
                    }
                }
                $clientOrder->save();

                $invoice->transaction_id = $request->payment_status ?? uniqid();
                $invoice->create_type = CREATE_TYPE_ACTIVE;
                $invoice->save();
                $invoice->invoice_id = 'INV-' . sprintf('%06d', $invoice->id);
                $invoice->save();
            } else {
                // Get Total Amount
                foreach ($request->types as $key => $types) {
                    $totalSum = $request->price[$key] * $request->quantity[$key];
                    $subTotal = $subTotal + $totalSum - $request->discount[$key];
                    $allDiscount = $allDiscount + $request->discount[$key];
                }

                // save client order data
                $clientOrder->client_id = $request->client_id;
                $clientOrder->tenant_id = auth()->user()->tenant_id;
                $clientOrder->total = $subTotal;
                $clientOrder->discount = $allDiscount;
                $clientOrder->order_create_type = CREATE_TYPE_DEACTIVATE;
                $clientOrder->payment_status = $request->payment_status ?? PAYMENT_STATUS_PENDING;
                $clientOrder->working_status = WORKING_STATUS_PENDING;
                if ($clientOrder->payment_status == PAYMENT_STATUS_PAID) {
                    $clientOrder->working_status = WORKING_STATUS_WORKING;
                }
                $clientOrder->save();
                $clientOrder->order_id = 'ODR-' . sprintf('%06d', $clientOrder->id);
                $clientOrder->save();

                // save Client Invoice data
                $invoice->client_id = $request->client_id;
                $invoice->due_date = $request->due_date;
                $invoice->tenant_id = auth()->user()->tenant_id;
                $invoice->total = $subTotal;
                $invoice->order_id = $clientOrder->id;
                $invoice->payment_status = $request->payment_status ?? PAYMENT_STATUS_PENDING;
                $invoice->create_type = CREATE_TYPE_ACTIVE;
                $invoice->save();
                $invoice->invoice_id = 'INV-' . sprintf('%06d', $invoice->id);
                $invoice->save();

                // save client order item data
                foreach ($request->types as $key => $types) {
                    $totalQuantity = $request->price[$key] * $request->quantity[$key];
                    $subTotalAmount = $totalQuantity - $request->discount[$key];

                    $dataObj = new ClientOrderItem();
                    $dataObj->service_id = $request->service_id[$key];
                    $dataObj->price = $request->price[$key];
                    $dataObj->discount = $request->discount[$key];
                    $dataObj->quantity = $request->quantity[$key];
                    $dataObj->order_id = $clientOrder->id;
                    $dataObj->total = $subTotalAmount;
                    $dataObj->save();
                };
            }

            DB::commit();
            $message = $request->id ? __(UPDATED_SUCCESSFULLY) : __(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getService()
    {
        try {
            $data['service'] = Service::where(['tenant_id' => auth()->user()->tenant_id, 'status' => ACTIVE])->get();
            if (is_null($data['service'])) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            return $data['service'];
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getOrder($id)
    {
        try {
            $data['order'] = ClientOrder::where('client_id', $id)->where('payment_status', PAYMENT_STATUS_PENDING)->get();
            if (is_null($data['order'])) {
                return $this->error([], getMessage(SOMETHING_WENT_WRONG));
            }
            return $data['order'];
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function invoiceCount()
    {
        return ClientInvoice::query()->count();
    }

    public function delete($id)
    {
        try {
            $invoice = ClientInvoice::findOrFail($id);
            $invoice->delete();

            $order = ClientOrder::findOrFail($invoice->order_id);
            $order->delete();

            $chekDataExist = ClientOrderItem::where('order_id', $invoice->order_id)->get();
            if (count($chekDataExist) > 0) {
                foreach ($chekDataExist as $item) {
                    $item->delete();
                }
            }
            return $this->success([], __(DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function paymentStatusChange(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'payment_status' => 'required|string',
            'gateway' => 'required_if:payment_status,PAYMENT_STATUS_PAID',
            'gateway_currency' => 'required_if:payment_status,PAYMENT_STATUS_PAID',
        ]);

        DB::beginTransaction();
        try {
            // Retrieve the invoice and associated order
            $invoice = ClientInvoice::with('order')->findOrFail($id);
            $clientOrder = $invoice->order;

            // Handle payment status update
            if ($request->payment_status == PAYMENT_STATUS_PAID) {
                $clientOrder->payment_status = PAYMENT_STATUS_PAID;
                $clientOrder->working_status = WORKING_STATUS_WORKING;
                if($clientOrder->package_type == DURATION_MONTH){
                    $clientOrder->end_date = now()->addMonth();
                }else{
                    $clientOrder->end_date = now()->addYear();
                }
                $clientOrder->save();

                // Retrieve the gateway currency details
                $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $request->gateway, 'currency' => $request->gateway_currency])->first();

                // Update invoice details
                $invoice->gateway_id = $request->gateway;
                $invoice->gateway_currency = $gatewayCurrency->currency;
                $invoice->conversion_rate = $gatewayCurrency->conversion_rate;
                $invoice->transaction_amount = $invoice->total * $gatewayCurrency->conversion_rate;

                $systemCurrency = Currency::where('current_currency', 'on')
                    ->orWhere('current_currency', 1)
                    ->firstOrFail();
                $invoice->system_currency = $systemCurrency->currency_code;

                $invoice->payment_status = PAYMENT_STATUS_PAID;
                $invoice->transaction_id = uniqid();
            } else {
                $clientOrder->payment_status = $request->payment_status;
                $invoice->payment_status = $request->payment_status;
            }

            // Save the invoice
            $invoice->save();

            DB::commit();

            $message = __(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return $this->error([], __('Resource not found.'));
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function userActivity(Request $request, $user_id)
    {
        if ($request->ajax()) {

            if (!$user_id) {
                return redirect()->back()->with(['dismiss' => __('User Not found.')]);
            }
            $item = UserActivityLog::where(['user_id' => $user_id])->orderBy('id', 'DESC')->get();

            return datatables($item)
                ->addColumn('created_at', function ($item) {
                    return date('Y-m-d H:i:s', strtotime($item->created_at));
                })
                ->rawColumns(['created_at'])
                ->make(true);
        }
    }
}
