<div class="row rg-20 pb-20">
    <div class="col-lg-5 col-md-6">
        <div class="bd-one bd-c-black-stroke bd-ra-8 p-sm-25 p-15 bg-white">
            <!--  -->
            <h4 class="fs-18 fw-500 lh-22 text-title-text pb-12">{{__("Invoice Details")}}</h4>
            <!--  -->
            <ul class="zList-pb-12">
                <li class="d-flex justify-content-between align-items-center">
                    <p class="fs-14 fw-400 lh-16 text-para-text">{{__("Service Name")}}</p>
                    <p class="fs-14 fw-400 lh-16 text-title-text">{{$itemData->service_name}}</p>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <p class="fs-14 fw-400 lh-16 text-para-text">{{__("Amount")}}</p>
                    <p class="fs-14 fw-400 lh-16 text-title-text">{{currentCurrency('symbol')}}<span class="amount">{{$itemData->price}}</span></p>
                </li>
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
                                data-item_id="{{ $itemData->id }}" data-item_amount="{{ $itemData->price }}"
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
<input type="hidden" id="getCurrencyByGatewayIdRoute" value="{{ route('user.currency.list') }}">
<input type="hidden" id="getApplyCouponRoute" value="{{ route('user.apply.coupon') }}">
