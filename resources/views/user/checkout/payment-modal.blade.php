<!--  -->
<div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
    <h4 class="fs-18 fw-500 lh-22 text-title-text">{{__("Checkout Plan")}}</h4>
    <button type="button"
            class="w-30 h-30 bd-one bd-c-black-stroke rounded-circle d-flex justify-content-center align-items-center p-0 bg-white"
            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<!--  -->
<form class="ajax" action="{{route('user.checkout.order.place')}}" method="POST" data-handler="checkoutOrderResponse">
    @csrf
    <input type="hidden" id="checkoutType" name="checkout_type" value="{{ CHECKOUT_TYPE_USER_PLAN }}">
    <input type="hidden" id="selectGateway" name="gateway">
    <input type="hidden" id="selectedGatewayId" value="0" name="gateway_id">
    <input type="hidden" id="currencyId" value="0" name="currency">
    <input type="hidden" id="duration" name="duration_type" value="{{$duration_type}}">
    <input type="hidden" id="itemId" name="item_id">
    <div id="gatewayListBlock">
        <div class="row rg-20 pb-20">
            <div class="col-lg-5 col-md-6">
                <div class="bd-one bd-c-stroke bd-ra-8 p-sm-25 p-15 bg-white">
                    <!--  -->
                    <h4 class="fs-18 fw-500 lh-22 text-title-text pb-12">{{__('Plan Details')}}</h4>
                    <!--  -->
                    <ul class="zList-pb-12">
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-14 fw-400 lh-16 text-para-text">{{__('Plan Name')}}</p>
                            <p class="fs-14 fw-400 lh-16 text-title-text">{{ $plan->name }}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-14 fw-400 lh-16 text-para-text">{{__('Duration')}}</p>
                            <p class="fs-14 fw-400 lh-16 text-title-text">{{$duration_type == DURATION_MONTH ? __('Monthly') : __('Yearly')}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-14 fw-400 lh-16 text-para-text">{{__('Types')}}</p>
                            <p class="fs-14 fw-400 lh-16 text-title-text">{{__('Subscription')}}</p>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <p class="fs-14 fw-400 lh-16 text-para-text">{{__('Amount')}}</p>
                            <p class="fs-14 fw-400 lh-16 text-title-text"><span class="amount">{{showPrice($price)}}</span></p>
                        </li>
                        @foreach($plan->others ?? [] as $item)
                            <li class="d-flex justify-content-between align-items-center">
                                <p class="fs-14 fw-400 lh-16 text-para-text">{{$item['name']}}</p>
                                <p class="fs-14 fw-400 lh-16 text-title-text">{{$item['value']}}</p>
                            </li>
                        @endforeach
                    </ul>
                    <!--  -->
                    <span id="currencyListBlock"></span>
                    <table class="table theme-border p-20 d-none" id="bankSection">
                        <tbody>
                        <tr>
                            <td>{{ __('Bank Deposit') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <label
                                    class="label-text-title color-heading font-medium mb-2">{{ __('Bank Name') }}</label>
                                <select name="bank_id" id="bank_id" class="form-control mb-2">
                                    <option value="">{{ __('Select Option') }}</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}"
                                                data-details="{{ nl2br($bank->details) }}">{{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="topic-content-item d-block bg-white theme-border radius-12 m-2 "
                                     id="bankDetails">
                                    <div
                                        class="topic-content-item-btns d-flex align-content-center justify-content-between">
                                        <p class="font-12 my-2 ps-2"></p>
                                    </div>
                                </div>
                                <label
                                    class="label-text-title color-heading font-medium mb-2">{{ __('Upload Deposit Slip') }}
                                    (png, jpg)</label>
                                <input type="file" name="bank_slip" id="bank_slip" class="form-control"
                                       accept="image/png, image/jpg">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="row rg-20">
                    @if($gateways !=null && count($gateways) > 0)
                        @foreach($gateways as $singleGateway)
                            <div class="col-xl-4 col-sm-6">
                                <div class="bd-one bd-c-black-stroke bd-ra-10 p-sm-20 p-10 payment-item">
                                    <h6 class="py-8 p-sm-20 p-10 bd-ra-20 mb-20 bg-body-bg text-center fs-14 fw-400 lh-16 text-para-text">
                                        {{ $singleGateway->title }}</h6>
                                    <div class="text-center mb-20">
                                        <img src="{{ asset($singleGateway->image) }}" alt=""/>
                                    </div>
                                    <button type="button"
                                            data-gateway="{{ $singleGateway->slug }}" data-id="{{ $singleGateway->id }}"
                                            data-item_id="{{ $plan->id }}" data-item_amount="{{ $price }}"
                                            class="bd-one bd-c-black-stroke bd-ra-5 py-8 p-sm-20 p-10 w-100 bg-white fs-14 fw-400 lh-16 text-para-text payment-item-btn">
                                        {{__("Select")}}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <button type="submit"
            class="w-75 m-auto p-12 d-flex justify-content-center align-items-center border-0 bd-ra-8 bg-button fs-15 fw-600 lh-20 text-white">
        {{__("Pay Now")}} <span id="orderPlaceSubmitBtnAmountBlock" class="d-none"> (<span id="orderPlaceSubmitBtnAmount"></span>)</span>
    </button>
</form>
