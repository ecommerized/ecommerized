<div class="d-flex justify-content-between align-items-center cg-10 pb-16">
    <h4 class="fs-18 fw-600 lh-24 text-textBlack">{{__("Payment Status Change")}}</h4>
    <button type="button"
            class="w-30 h-30 rounded-circle d-flex justify-content-center align-items-center bd-one bd-c-stroke bg-transparent"
            data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/icon/close.svg')}}" alt=""/>
    </button>
</div>
<hr>
<form class="ajax reset" action="{{ route('admin.client-invoice.payment_status_change', $clientInvoice->id) }}"
      method="POST"
      data-handler="settingCommonHandler">
    @csrf
    <input type="hidden" value="{{$clientInvoice->client_id}}" name="client_id">
    <input type="hidden" value="{{$clientInvoice->total}}" id="pay-amount" name="total">
    <input type="hidden" value="{{$clientInvoice->client_order_id}}" name="order_id">
    <div class="row rg-20">
        <div class="col-12 ">
            <div class="zForm-wrap ">
                <label class="zForm-label">{{ __('Payment Status') }}</label>
                <select class="sf-select-without-search cs-select-form" id="payment_status" name="payment_status">
                    <option {{ $clientInvoice->payment_status == PAYMENT_STATUS_PAID ? 'selected' : ''}} value="{{
                    PAYMENT_STATUS_PAID}}">{{__('Paid')}}</option>
                    <option {{ $clientInvoice->payment_status == PAYMENT_STATUS_PENDING ? 'selected' : ''}} value="{{
                    PAYMENT_STATUS_PENDING }}">{{__('Pending')}}</option>
                    <option {{ $clientInvoice->payment_status == PAYMENT_STATUS_CANCELLED? 'selected' : ''}} value="{{
                    PAYMENT_STATUS_CANCELLED }}">{{__('Cancel')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 {{ $clientInvoice->payment_status == PAYMENT_STATUS_PAID || !is_null($clientInvoice->gateway_id) ? '' :'d-none' }}" id="change-status-gateway-block">
            <label for="change-status-gateway" class="zForm-label-alt">{{ __('Gateway') }} <span
                    class="text-danger">*</span></label>
            <select class="sf-select-two" id="change-status-gateway" name="gateway">
                <option selected value="">{{__('Select Gateway')}}</option>
                @foreach($gateways as $gateway)
                    <option {{$clientInvoice->gateway_id == $gateway->id ? 'selected' : ''}} value="{{$gateway->id}}">
                        {{ $gateway->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 {{ $clientInvoice->payment_status == PAYMENT_STATUS_PAID || !is_null($clientInvoice->gateway_id) ? '' :'d-none' }}" id="change-status-gateway-currency-block">
            <label for="change-status-gateway-currency"
                   class="zForm-label-alt">{{ __('Payment Currency') }} <span
                    class="text-danger">*</span></label>
            <select class="sf-select-two" id="change-status-gateway-currency"
                    name="gateway_currency">
                @if($clientInvoice->gateway_currency)
                    <option value="{{$clientInvoice->gateway_currency}}">
                        {{ getNumberFormat($clientInvoice->total*$clientInvoice->conversion_rate).' '.$clientInvoice->gateway_currency }}
                    </option>
                    @else
                <option value="">
                    {{ __('-- Select Currency --') }}
                </option>
                    @endif
            </select>
        </div>
    </div>

    <button type="submit"
            class="mt-25 border-0 bd-ra-12 py-13 px-25 bg-button fs-16 fw-600 lh-19 text-white">{{__('Update')}}</button>
</form>
