<div class="invoice-content">
    <div class="bd-b-one bd-c-black-stroke pb-25 mb-25 d-flex justify-content-between align-items-center flex-wrap">
        <!--  -->
        <a href="" data-bs-dismiss="modal" aria-label="Close"
           class="d-inline-flex align-items-center cg-13 fs-18 fw-500 lh-22 text-para-text">
            <i class="fa-solid fa-long-arrow-left"></i>
            {{__('Back')}}
        </a>

        <!--  -->
        <a target="blank" href="{{route('admin.client-invoice.print', $clientInvoice->id)}}"
           class="d-inline-flex align-items-center cg-10 border-0 bd-ra-4 py-5 px-10 bg-green fs-14 fw-500 lh-20 text-white bg-button">
            {{__('Download')}}
        </a>
    </div>
    <!--  -->
    <div class="d-flex justify-content-between align-items-center pb-50">
        <!--  -->
        <div class="max-w-167">
            <img src="{{ getSettingImage('app_logo_black') }}" alt="{{ getOption('app_name') }}"/>
        </div>
        <!--  -->

        <div class="d-flex align-items-center cg-10">
            @if ($clientInvoice->payment_status == PAYMENT_STATUS_PAID)
                <p class="zBadge zBadge-completed">{{__('Paid')}}</p>
            @elseif ($clientInvoice->payment_status == PAYMENT_STATUS_PENDING)
                <p class="zBadge zBadge-pending">{{__('Pending')}}</p>
            @elseif ($clientInvoice->payment_status == PAYMENT_STATUS_CANCELLED)
                <p class="zBadge zBadge-cancel">{{__('Cancelled')}}</p>
            @endif
        </div>

    </div>
    <!--  -->
    <div class="bd-ra-10 bg-body-bg p-25 mb-30">
        <div class="d-flex justify-content-between invoice-item">
            <div class="item">
                <h4 class="fs-27 fw-600 lh-40 text-title-text pb-10">{{__('Invoice')}}</h4>
                <p class="fs-15 fw-500 lh-20 text-title-text"> {{$clientInvoice->invoice_id}}</p>
            </div>
            <div class="item">
                <p class="fs-14 fw-600 lh-24 text-para-text">{{__('Invoice To')}}:</p>
                <p class="fs-14 fw-400 lh-24 text-para-text">{{$clientInvoice->client?->name}}</p>
                <p class="fs-14 fw-400 lh-24 mailto:text-para-text">{{$clientInvoice->client?->email}}</p>
                <p class="fs-14 fw-400 lh-24 text-para-text">{{$clientInvoice->client?->company_address}}</p>
            </div>
            <div class="item">
                <p class="fs-14 fw-600 lh-24 text-para-text">{{__('Pay to')}}:</p>
                <p class="fs-14 fw-400 lh-24 text-para-text">{{ getOption('app_name') }}</p>
                <p class="fs-14 fw-400 lh-24 text-para-text">{{ getOption('app_address') }}</p>
                <p class="fs-14 fw-400 lh-24 text-para-text">{{ getOption('app_number') }}</p>
            </div>
        </div>
    </div>

    <div class="pb-15">
        <h4 class="fs-18 fw-600 lh-28 text-title-text pb-15">{{__('Invoice Items')}}</h4>
        <div class="table-responsive pb-15">
            <table class="table zTable zTable-last-item-right zTable-last-item-border">
                <thead>
                <tr>
                    <th>
                        <div class="text-nowrap">{{__('Order ID')}}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{__('Plan Name')}}</div>
                    </th>
                    <th>
                        <div class="text-nowrap">{{__('Duration')}}</div>
                    </th>
                    <th>
                        <div>{{__('Price')}}</div>
                    </th>
                    <th>
                        <div>{{__('Quantity')}}</div>
                    </th>
                    <th>
                        <div>{{__('Total')}}</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-nowrap">{{$clientInvoice->order->order_id}}</td>
                    <td class="text-nowrap">{{$clientInvoice->order->plan->name}}</td>
                    <td>
                        @if($clientInvoice->package_type == DURATION_MONTH)
                            {{__('Monthly')}}
                        @else
                            {{__('Monthly')}}
                        @endif
                    </td>
                    <td>{{showPrice($clientInvoice->total)}}</td>
                    <td>1</td>
                    <td>{{showPrice($clientInvoice->total)}}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <!--  -->
    <div class="max-w-374 w-100 ms-auto mb-30 text-end invoiceTotal">
        <ul class="zList-pb-15">
            <li>
                <div class="row align-items-center">
                    <div class="col-6">
                        <p class="fs-14 fw-500 lh-17 text-para-text">{{__('Total')}}:</p>
                    </div>
                    <div class="col-6">
                        <p class="fs-14 fw-600 lh-17 text-button">{{showPrice($clientInvoice->total)}}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!--  -->
    <h4 class="fs-18 fw-600 lh-28 text-title-text pb-15">{{__('Transaction Details')}}</h4>
    <div class="table-responsive pb-15">
        <table class="table zTable zTable-last-item-right zTable-last-item-border">
            <thead>
            <tr>
                <th>
                    <div>{{__("Date")}}</div>
                </th>
                <th>
                    <div class="text-nowrap">{{__("Payment Gateway")}}</div>
                </th>
                <th>
                    <div class="text-nowrap">{{__("Transaction ID")}}</div>
                </th>
                <th>
                    <div>{{__("Amount")}}</div>
                </th>
            </tr>
            </thead>
            <tbody>
            @if($clientInvoice->payment_status == PAYMENT_STATUS_PAID)
                <tr>
                    <td class="text-nowrap">{{$clientInvoice->created_at}}</td>
                    <td>{{$clientInvoice->gateway != null?$clientInvoice->gateway->title:'N/A'}}</td>
                    <td class="text-nowrap">{{$clientInvoice->payment_id}}</td>
                    <td>{{showPrice($clientInvoice->total)}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
