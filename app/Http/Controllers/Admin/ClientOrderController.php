<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientOrderRequest;
use App\Models\ClientInvoice;
use App\Models\ClientOrder;
use App\Models\ClientOrderItemAssignee;
use App\Models\ClientOrderItem;
use App\Models\ClientOrderItemNote;
use App\Models\Gateway;
use App\Models\Package;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClientOrderController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        $data['pageTitle'] = __('Client Order list');
        $data['activeClientOrderIndex'] = 'active';
        if ($request->ajax()) {
            $order = ClientOrder::query()
                ->orderBy('client_orders.id', 'DESC')
                ->select([
                    'client_orders.*',
                ])
                ->with(['client_order_items.service', 'plan'])->whereHas('plan');

            if ($request->status != 'all') {
                $order->where('client_orders.working_status', $request->status);
            }

            if (auth()->user()->role == USER_ROLE_CLIENT) {
                $order->where('client_orders.client_id', auth()->id());
            } elseif (auth()->user()->role == USER_ROLE_TEAM_MEMBER) {
                $order->join('client_order_assignees', function ($join) {
                    $join->on('client_orders.id', '=', 'client_order_assignees.order_id')
                        ->where('client_order_assignees.assigned_to', '=', auth()->id())
                        ->whereNull('client_order_assignees.deleted_at');
                });
            }


            return datatables($order)
                ->addIndexColumn()
                ->addColumn('plan_name', function ($order) {
                    return $order->plan->name;
                })
                ->addColumn('total_price', function ($order) {
                    return showPrice($order->amount);
                })
                ->addColumn('end_date', function ($order) {
                    if ($order->end_date) {
                        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->end_date);
                        $formattedDate = $endDate->format('j F Y');

                        // Check if the end date is less than now
                        if ($endDate->isPast()) {
                            return '<div class="d-flex align-items-center g-5">
                        <p class="text-nowrap">' . $formattedDate . '</p>
                        <p class="text-danger text-nowrap">' . __('Expired') . '</p>
                    </div>';
                        }

                        return '<div class="d-flex align-items-center g-5">
                    <p class="text-nowrap">' . $formattedDate . '</p>
                </div>';
                    } else {
                        return __('N/A');
                    }
                })
                ->addColumn('client_name', function ($order) {
                    if ($order->is_seen === 0) {
                        $data = '<div class="d-flex align-items-center g-5">
                                <p class="text-nowrap">' . $order->client?->name . '</p>
                               <div class="w-16 h-16 rounded-circle bg-green flex-shrink-0 d-flex justify-content-center align-items-center">
                               <img src="' . asset('assets/images/icon/bell-white.svg') . '" class="max-w-8" alt=""></div>
                            </div>';
                    } else {
                        $data = '<div class="d-flex align-items-center g-5">
                               <p class="text-nowrap">' . $order->client?->name . '</p>
                            </div>';
                    }
                    return $data;

                })
                ->addColumn('progress', function ($order) {
                    if (auth()->user()->role == USER_ROLE_CLIENT) {
                        return '<div class="align-items-center d-flex g-10 justify-content-start">
                        <a href="' . route('user.orders.service.list', $order->id) . '" class="text-nowrap border-0 bg-badge-trackOrder-bg py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-badge-trackOrder-text" title="' . __('Track Order') . '"><span>' . __('Track My Order') . '</span></a>
                    </div>';
                    }
                    return '<div class="align-items-center d-flex g-10 justify-content-start">
                        <a href="' . route('admin.client-orders.service.list', $order->id) . '" class="text-nowrap border-0 bg-badge-trackOrder-bg py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-badge-trackOrder-text" title="' . __('Track Order') . '"><span>' . __('Track Order') . '</span></a>
                    </div>';
                })
                ->addColumn('payment_status', function ($order) {
                    if ($order->payment_status == PAYMENT_STATUS_PAID) {
                        return '<p class="zBadge zBadge-paid">' . __("Paid") . '</p>';
                    } elseif ($order->payment_status == PAYMENT_STATUS_PENDING) {
                        return '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>';
                    } elseif ($order->payment_status == PAYMENT_STATUS_CANCELLED) {
                        return '<p class="zBadge zBadge-cancel">' . __("Cancelled") . '</p>';
                    }
                })
                ->addColumn('working_status', function ($order) {
                    if ($order->working_status == WORKING_STATUS_COMPLETED) {
                        return '<p class="zBadge zBadge-paid">' . __("Completed") . '</p>';
                    } elseif ($order->working_status == WORKING_STATUS_WORKING) {
                        return '<p class="zBadge zBadge-open">' . __("Working") . '</p>';
                    } elseif ($order->working_status == WORKING_STATUS_CANCELED) {
                        return '<p class="zBadge zBadge-cancel">' . __("Cancelled") . '</p>';
                    } elseif ($order->working_status == WORKING_STATUS_PENDING) {
                        return '<p class="zBadge zBadge-pending">' . __("Pending") . '</p>';
                    }
                })
                ->addColumn('action', function ($order) {
                    if (auth()->user()->role == USER_ROLE_CLIENT) {
                        return "";
                    } else {
                        $return = "<div class='dropdown dropdown-one'>
                        <button class='dropdown-toggle p-0 bg-transparent w-30 h-30 ms-auto bd-one bd-c-black-stroke rounded-circle d-flex justify-content-center align-items-center' type='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa-solid fa-ellipsis'></i></button><ul class='dropdown-menu dropdownItem-two'>
                            <li>
                               <button onclick='getEditModal(\"" . route('admin.client-orders.status.change-modal', $order->id) . "\", \"#status-change-modal\")' class='d-flex align-items-center cg-8 border-0 text-nowrap p-0 bg-transparent'>
                                    <div class='d-flex'>
                                        <svg width='17' height='17' viewBox='0 0 17 17' fill='none'
                                            xmlns='http://www.w3.org/2000/svg'>
                                            <path
                                                d='M5.21875 6.75C5.0447 6.75 4.87778 6.81914 4.75471 6.94221C4.63164 7.06528 4.5625 7.2322 4.5625 7.40625C4.5625 7.5803 4.63164 7.74722 4.75471 7.87029C4.87778 7.99336 5.0447 8.0625 5.21875 8.0625C5.3928 8.0625 5.55972 7.99336 5.68279 7.87029C5.80586 7.74722 5.875 7.5803 5.875 7.40625C5.875 7.2322 5.80586 7.06528 5.68279 6.94221C5.55972 6.81914 5.3928 6.75 5.21875 6.75ZM4.5625 12.2188C4.5625 12.0447 4.63164 11.8778 4.75471 11.7547C4.87778 11.6316 5.0447 11.5625 5.21875 11.5625C5.3928 11.5625 5.55972 11.6316 5.68279 11.7547C5.80586 11.8778 5.875 12.0447 5.875 12.2188C5.875 12.3928 5.80586 12.5597 5.68279 12.6828C5.55972 12.8059 5.3928 12.875 5.21875 12.875C5.0447 12.875 4.87778 12.8059 4.75471 12.6828C4.63164 12.5597 4.5625 12.3928 4.5625 12.2188ZM0.625 3.46875C0.625 2.71454 0.924608 1.99122 1.45792 1.45792C1.99122 0.924608 2.71454 0.625 3.46875 0.625H13.5312C14.2855 0.625 15.0088 0.924608 15.5421 1.45792C16.0754 1.99122 16.375 2.71454 16.375 3.46875V13.5312C16.375 14.2855 16.0754 15.0088 15.5421 15.5421C15.0088 16.0754 14.2855 16.375 13.5312 16.375H3.46875C2.71454 16.375 1.99122 16.0754 1.45792 15.5421C0.924608 15.0088 0.625 14.2855 0.625 13.5312V3.46875ZM3.25 7.40625C3.25 7.66479 3.30092 7.9208 3.39986 8.15966C3.4988 8.39852 3.64382 8.61555 3.82663 8.79837C4.00945 8.98118 4.22648 9.1262 4.46534 9.22514C4.7042 9.32408 4.96021 9.375 5.21875 9.375C5.47729 9.375 5.7333 9.32408 5.97216 9.22514C6.21102 9.1262 6.42805 8.98118 6.61087 8.79837C6.79368 8.61555 6.9387 8.39852 7.03764 8.15966C7.13658 7.9208 7.1875 7.66479 7.1875 7.40625C7.1875 6.88411 6.98008 6.38335 6.61087 6.01413C6.24165 5.64492 5.74089 5.4375 5.21875 5.4375C4.69661 5.4375 4.19585 5.64492 3.82663 6.01413C3.45742 6.38335 3.25 6.88411 3.25 7.40625ZM5.21875 10.25C4.69661 10.25 4.19585 10.4574 3.82663 10.8266C3.45742 11.1958 3.25 11.6966 3.25 12.2188C3.25 12.7409 3.45742 13.2417 3.82663 13.6109C4.19585 13.9801 4.69661 14.1875 5.21875 14.1875C5.74089 14.1875 6.24165 13.9801 6.61087 13.6109C6.98008 13.2417 7.1875 12.7409 7.1875 12.2188C7.1875 11.6966 6.98008 11.1958 6.61087 10.8266C6.24165 10.4574 5.74089 10.25 5.21875 10.25ZM8.5 7.40625C8.5 7.7685 8.794 8.0625 9.15625 8.0625H13.0938C13.2678 8.0625 13.4347 7.99336 13.5578 7.87029C13.6809 7.74722 13.75 7.5803 13.75 7.40625C13.75 7.2322 13.6809 7.06528 13.5578 6.94221C13.4347 6.81914 13.2678 6.75 13.0938 6.75H9.15625C8.9822 6.75 8.81528 6.81914 8.69221 6.94221C8.56914 7.06528 8.5 7.2322 8.5 7.40625ZM9.15625 11.5625C8.9822 11.5625 8.81528 11.6316 8.69221 11.7547C8.56914 11.8778 8.5 12.0447 8.5 12.2188C8.5 12.3928 8.56914 12.5597 8.69221 12.6828C8.81528 12.8059 8.9822 12.875 9.15625 12.875H13.0938C13.2678 12.875 13.4347 12.8059 13.5578 12.6828C13.6809 12.5597 13.75 12.3928 13.75 12.2188C13.75 12.0447 13.6809 11.8778 13.5578 11.7547C13.4347 11.6316 13.2678 11.5625 13.0938 11.5625H9.15625ZM3.25 3.46875C3.25 3.831 3.544 4.125 3.90625 4.125H13.0938C13.2678 4.125 13.4347 4.05586 13.5578 3.93279C13.6809 3.80972 13.75 3.6428 13.75 3.46875C13.75 3.2947 13.6809 3.12778 13.5578 3.00471C13.4347 2.88164 13.2678 2.8125 13.0938 2.8125H3.90625C3.7322 2.8125 3.56528 2.88164 3.44221 3.00471C3.31914 3.12778 3.25 3.2947 3.25 3.46875Z'
                                                fill='#5D697A' />
                                        </svg>
                                    </div>
                                    <p class='fs-14 fw-500 lh-17 text-para-text'>" . __('Change Status') . "</p>
                                </button>
                            </li>";


                        if ($order->order_create_type == CREATE_BY_ADMIN && $order->payment_status != PAYMENT_STATUS_PAID) {
                            $return .= "<li><a class='d-flex align-items-center cg-8' href='" . route('admin.client-orders.edit', $order->id) . "'>
                            <div class='d-flex'><svg width='12' height='13' viewBox='0 0 12 13' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z' fill='#5D697A' /></svg></div><p class='fs-14 fw-500 lh-17 text-para-text'>" . __('Edit') . "</p></a></li>";
                        }

                        if ($order->order_create_type == CREATE_BY_ADMIN) {
                            $return .= "<li><button class='d-flex align-items-center cg-8 border-0 p-0 bg-transparent' onclick='deleteItem(\"" . route('admin.client-orders.delete', $order->id) . "\")'>
                            <div class='d-flex'><svg width='14' height='15' viewBox='0 0 14 15' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd'clip-rule='evenodd'd='M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z'fill='#5D697A'/></svg></div>
                            <p class='fs-14 fw-500 lh-17 text-para-text'>" . __('Delete') . "</p></button></li>";
                        }
                        $return .= "</ul></div>";
                        return $return;
                    }
                })
                ->rawColumns(['working_status', 'payment_status', 'action', 'plan_name', 'client_name', 'total_price', 'end_date', 'progress'])
                ->make(true);

        }

        if (auth()->user()->role == USER_ROLE_CLIENT) {
            $data['orderCount'] = ClientOrder::where(['client_id' => auth()->id()])->count();
            $data['pageTitle'] = __('Order list');
            return view('user.orders.list', $data);
        }

        return view('admin.orders.list', $data);
    }

    public function add()
    {
        $data['pageTitleParent'] = __('Order');
        $data['pageTitle'] = __('Client Order Add');
        $data['activeClientOrderIndex'] = 'active';
        $data['allClient'] = User::where('role', USER_ROLE_CLIENT)->where('status', STATUS_ACTIVE)->get();
        $data['allPackage'] = Package::where('status', STATUS_ACTIVE)->get();
        return view('admin.orders.add', $data);
    }

    public function serviceList($id)
    {
        $data['pageTitleParent'] = __('Order');
        $data['pageTitle'] = __('Track Order');
        $data['activeClientOrderIndex'] = 'active';
        $data['order'] = ClientOrder::where('id', $id)->with('client_order_items.service')->first();
        return view('admin.orders.service-list', $data);
    }


    public function store(ClientOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            // Fetch package services
            $plan = Package::with('package_services')->findOrFail($request->package_id);
            $id = $request->get('id', null);

            // Create or update ClientOrder
            $clientOrder = $id ? ClientOrder::findOrFail($id) : new ClientOrder();

            if ($clientOrder->payment_status === PAYMENT_STATUS_PAID) {
                DB::rollBack();
                return $this->error([], __('Order can not be editable'));
            }

            if (is_null($id)) {
                $clientOrder->created_by = auth()->id();
            }

            $clientOrder->package_id = $request->package_id;
            $clientOrder->client_id = $request->client_id;
            if($request->plan_duration == DURATION_MONTH){
                $clientOrder->amount = $plan->monthly_price;
            }else{
                $clientOrder->amount = $plan->yearly_price;
            }
            $clientOrder->package_type = $request->plan_duration;
            $clientOrder->order_create_type = CREATE_BY_ADMIN;
            $clientOrder->save();

            if (is_null($id)) {
                $clientOrder->payment_status = PAYMENT_STATUS_PENDING;
                $clientOrder->working_status = WORKING_STATUS_PENDING;
                $clientOrder->order_id = 'ODR-' . sprintf('%06d', $clientOrder->id);
                $clientOrder->save();
            }

            // Fetch existing items once to minimize database queries
            $existingItems = $clientOrder->client_order_items()
                ->pluck('status', 'service_id')
                ->toArray();

            $currentOrderItem = [];

            foreach ($plan->package_services as $package_service) {
                $currentOrderItem[] = $package_service->service_id;
                $item = $clientOrder->client_order_items()->updateOrCreate([
                    'service_id' => $package_service->service_id,
                ], [
                    'service_id' => $package_service->service_id,
                    'quantity' => $package_service->quantity,
                    'status' => $existingItems[$package_service->service_id] ?? WORKING_STATUS_PENDING, // Retain status or set default
                ]);

                $currentOrderItem[] = $item->id;
            }

            // Delete items not in the current package
            $clientOrder->client_order_items()
                ->whereNotIn('id', $currentOrderItem)
                ->delete();

            //create invoice if new else update if not paid
            $invoice = ClientInvoice::firstOrNew(['client_order_id' => $clientOrder->id]);
            $invoice->client_id = $clientOrder->client_id;
            $invoice->total = $clientOrder->amount;
            $invoice->payment_status = PAYMENT_STATUS_PENDING;
            $invoice->create_type = CREATE_BY_ADMIN;
            $invoice->save();
            $invoice->invoice_id = 'INV-' . sprintf('%06d', $invoice->id);
            $invoice->save();

            DB::commit();
            $message = $id ? __(UPDATED_SUCCESSFULLY) : __(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getErrorMessage($e, $e->getMessage()));
        }
    }

    public function edit($id)
    {
        $data['pageTitleParent'] = __('Order');
        $data['pageTitle'] = __('Edit Order');
        $data['activeClientOrderIndex'] = 'active';
        $data['order'] = ClientOrder::with('client')->find($id);
        $data['allClient'] = User::where('role', USER_ROLE_CLIENT)->where('status', STATUS_ACTIVE)->get();
        $data['allPackage'] = Package::where('status', STATUS_ACTIVE)->get();
        return view('admin.orders.edit', $data);
    }

    public function delete($id)
    {
        try {
            ClientInvoice::where('client_order_id', $id)->delete();
            $order = ClientOrder::findOrFail($id);
            $order->delete();
            return $this->success([], __(DELETED_SUCCESSFULLY));
        } catch (Exception $e) {
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function statusChange($order_item_id, $status)
    {
        DB::beginTransaction();
        try {
            $data = ClientOrderItem::find(decrypt($order_item_id));
            $data->status = $status;
            $data->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'Status Change successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => SOMETHING_WENT_WRONG]);
        }
    }

    public function orderStatusChangeModal($order_id)
    {
        $data['order'] = ClientOrder::where('id', $order_id)->first();
        return view('admin.orders.status-modal', $data);
    }

    public function orderStatusChange(Request $request, $order_id)
    {
        DB::beginTransaction();
        try {
            $data = ClientOrder::find($order_id);
            $data->working_status = $request->working_status;
            $data->save();

            DB::commit();
            return $this->success([], __('Status Change successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __(SOMETHING_WENT_WRONG));
        }
    }

    public function assignMember(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->checked_status == 1) {
                $data = ClientOrderItemAssignee::updateOrCreate(
                    [
                        'client_order_id' => $request->client_order_id,
                        'client_order_item_id' => $request->client_order_item_id,
                        'assigned_to' => $request->member_id
                    ],
                    [
                        'assigned_by' => auth()->id(),
                        'is_active' => ACTIVE
                    ]
                );
            } else {
                if ($request->member_id == auth()->id() && auth()->user()->role == USER_ROLE_TEAM_MEMBER) {
                    throw new \Exception(__('You cannot unassign yourself'));
                }
                $data = ClientOrderItemAssignee::where(['client_order_item_id' => $request->client_order_item_id, 'assigned_to' => $request->member_id])->first();
                $data->delete();
            }
            DB::commit();
            return $this->success($data, 'Assignee Update');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], getErrorMessage($e, $e->getMessage()));
        }
    }

    public function noteStore(Request $request)
    {

        $request->validate([
            'client_order_id' => 'required',
            'client_order_item_id' => 'required',
            'details' => 'required'
        ]);

        DB::beginTransaction();
        try {
            if ($request->id) {
                $data = ClientOrderItemNote::find(decrypt($request->id));
                $msg = __("Note Updated Successfully");
            } else {
                $data = new ClientOrderItemNote();
                $msg = __("Note Created Successfully");
            }

            $data->client_order_id = $request->client_order_id;
            $data->client_order_item_id = $request->client_order_item_id;
            $data->details = $request->details;
            $data->user_id = auth()->id();
            $data->save();

            DB::commit();
            return $this->success([], $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], getErrorMessage($e, $e->getMessage()));
        }
    }

    public function noteDelete($id)
    {
        try {
            DB::beginTransaction();
            $data = ClientOrderItemNote::where('id', decrypt($id))->first();
            $data->delete();
            DB::commit();
            return $this->success([], getMessage(DELETED_SUCCESSFULLY));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], getErrorMessage($e, $e->getMessage()));
        }
    }
}






