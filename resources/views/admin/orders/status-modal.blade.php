<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Order Working Status Change")}}</h4>
    <button type="button" class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke text-para-text bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax reset" action="{{ route('admin.client-orders.order.status.change', $order->id) }}" method="POST"
      data-handler="settingCommonHandler">
    @csrf
    <div class="row rg-20">
        <div class="col-12">
            <div class="zForm-wrap">
                <label class="zForm-label">{{ __('Order ID') }}</label>
                <input class="form-control zForm-control" type="text" readonly value="{{$order->order_id}}">
            </div>
        </div>
        <div class="col-12 ">
            <div class="zForm-wrap">
                <label class="zForm-label">{{ __('Order Working Status') }}</label>
                <select class="sf-select-without-search cs-select-form" id="working_status" name="working_status">
                    <option {{ $order->working_status == WORKING_STATUS_PENDING ? 'selected' : ''}} value="{{
                    WORKING_STATUS_PENDING}}">{{__('Pending')}}</option>
                    <option {{ $order->working_status == WORKING_STATUS_WORKING ? 'selected' : ''}} value="{{
                    WORKING_STATUS_WORKING }}">{{__('Working')}}</option>
                    <option {{ $order->working_status == WORKING_STATUS_COMPLETED? 'selected' : ''}} value="{{
                    WORKING_STATUS_COMPLETED }}">{{__('Completed')}}</option>
                    <option {{ $order->working_status == WORKING_STATUS_CANCELED? 'selected' : ''}} value="{{
                    WORKING_STATUS_CANCELED }}">{{__('Cancel')}}</option>
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class="mt-25 border-0 bd-ra-12 py-13 px-25 bg-button fs-16 fw-600 lh-19 text-white">{{__('Update')}}</button>
</form>
