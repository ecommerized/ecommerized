@extends('admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush
@section('content')
    <!-- Content -->
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <!-- Tab - Create -->
        <div
            class="d-flex flex-column-reverse flex-md-row justify-content-center justify-content-md-between align-items-center align-items-md-start flex-wrap g-10 table-pl">
            <!-- Left -->
            <ul class="nav nav-tabs zTab-reset zTab-five flex-wrap pl-sm-20" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active bg-transparent orderStatusTab" id="allOrder-tab" data-bs-toggle="tab"
                            data-bs-target="#allOrder-tab-pane" type="button" role="tab"
                            aria-controls="allOrder-tab-pane"
                            aria-selected="true" data-status="all">{{__("All")}}</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent orderStatusTab" id="pendingOrder-tab" data-bs-toggle="tab"
                            data-bs-target="#pendingOrder-tab-pane" type="button" role="tab"
                            aria-controls="pendingOrder-tab-pane" aria-selected="false"
                            data-status="{{WORKING_STATUS_PENDING}}">{{__("Pending")}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent orderStatusTab" id="workingOrder-tab" data-bs-toggle="tab"
                            data-bs-target="#workingOrder-tab-pane" type="button" role="tab"
                            aria-controls="workingOrder-tab-pane" aria-selected="false"
                            data-status="{{WORKING_STATUS_WORKING}}">{{__("Working")}}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent orderStatusTab" id="completedOrder-tab" data-bs-toggle="tab"
                            data-bs-target="#completedOrder-tab-pane" type="button" role="tab"
                            aria-controls="completedOrder-tab-pane" aria-selected="false"
                            data-status="{{WORKING_STATUS_COMPLETED}}">{{__("Completed")}}</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent orderStatusTab" id="cancelledOrder-tab" data-bs-toggle="tab"
                            data-bs-target="#cancelledOrder-tab-pane" type="button" role="tab"
                            aria-controls="cancelledOrder-tab-pane" aria-selected="false"
                            data-status="{{WORKING_STATUS_CANCELED}}">{{__("Cancelled")}}</button>
                </li>
            </ul>
            <a href="{{route('admin.client-orders.add')}}"
               class="border-0 bg-button py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__("Add Orders")}}</a>
        </div>
        <!--  -->
        <div class="tab-content" id="myTabContent">
            <!-- All Order -->
            <div class="tab-pane fade show active" id="allOrder-tab-pane" role="tabpanel" aria-labelledby="allOrder-tab"
                 tabindex="0">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="orderTable-all">
                        <thead>
                        <tr>
                            <th>
                                <div class="text-nowrap">{{__('Client Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Plan Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Order ID')}}</div>
                            </th>
                            <th>
                                <div>{{__('Price')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Working Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Payment Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('End Date')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Track Order')}}</div>
                            </th>
                            <th>
                                <div>{{__('Action')}}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Pending Order -->
            <div class="tab-pane fade" id="pendingOrder-tab-pane" role="tabpanel" aria-labelledby="pendingOrder-tab"
                 tabindex="0">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="orderTable-{{WORKING_STATUS_PENDING}}">
                        <thead>
                        <tr>
                            <th>
                                <div class="text-nowrap">{{__('Client Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Plan Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Order ID')}}</div>
                            </th>
                            <th>
                                <div>{{__('Price')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Working Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Payment Status')}}</div>
                            </th>
                            <th>
                                <div>{{__('End Date')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Track Order')}}</div>
                            </th>
                            <th>
                                <div>{{__('Action')}}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Done Pending Order -->
            <!-- Working Order -->
            <div class="tab-pane fade" id="workingOrder-tab-pane" role="tabpanel" aria-labelledby="workingOrder-tab"
                 tabindex="0">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="orderTable-{{WORKING_STATUS_WORKING}}">
                        <thead>
                        <tr>
                            <th>
                                <div class="text-nowrap">{{__('Client Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Plan Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Order ID')}}</div>
                            </th>
                            <th>
                                <div>{{__('Price')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Working Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Payment Status')}}</div>
                            </th>
                            <th>
                                <div>{{__('End Date')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Track Order')}}</div>
                            </th>
                            <th>
                                <div>{{__('Action')}}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Completed Order -->
            <!-- Cancelled Order -->
            <div class="tab-pane fade" id="completedOrder-tab-pane" role="tabpanel" aria-labelledby="completedOrder-tab"
                 tabindex="0">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="orderTable-{{WORKING_STATUS_COMPLETED}}">
                        <thead>
                        <tr>
                            <th>
                                <div class="text-nowrap">{{__('Client Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Plan Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Order ID')}}</div>
                            </th>
                            <th>
                                <div>{{__('Price')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Working Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Payment Status')}}</div>
                            </th>
                            <th>
                                <div>{{__('End Date')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Track Order')}}</div>
                            </th>
                            <th>
                                <div>{{__('Action')}}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Cancelled Order -->
            <div class="tab-pane fade" id="cancelledOrder-tab-pane" role="tabpanel" aria-labelledby="cancelledOrder-tab"
                 tabindex="0">
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <table class="table zTable zTable-last-item-right" id="orderTable-{{WORKING_STATUS_CANCELED}}">
                        <thead>
                        <tr>
                            <th>
                                <div class="text-nowrap">{{__('Client Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Plan Name')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Order ID')}}</div>
                            </th>
                            <th>
                                <div>{{__('Price')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Working Status')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Payment Status')}}</div>
                            </th>
                            <th>
                                <div>{{__('End Date')}}</div>
                            </th>
                            <th>
                                <div class="text-nowrap">{{__('Track Order')}}</div>
                            </th>
                            <th>
                                <div>{{__('Action')}}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="status-change-modal" tabindex="-1" aria-labelledby="status-change-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-4 p-25 invoice-content-wrap">

            </div>
        </div>
    </div>

    <input type="hidden" id="client-order-list-route" value="{{ route('admin.client-orders.list') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/client-orders.js') }}"></script>
@endpush
