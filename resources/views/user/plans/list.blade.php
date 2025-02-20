@extends('user.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <div class="p-sm-30 p-15">
        <div class="section-content-wrap">
            <div class="text-md-center">
                <ul class="nav nav-tabs d-inline-flex zTab-reset zTab-two" id="pricePlanTab"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="billingMonthly-tab" data-bs-toggle="tab"
                                data-bs-target="#billingMonthly-tab-pane" type="button" role="tab"
                                aria-controls="billingMonthly-tab-pane"
                                aria-selected="true">{{__('Monthly')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="billingAnnually-tab" data-bs-toggle="tab"
                                data-bs-target="#billingAnnually-tab-pane" type="button" role="tab"
                                aria-controls="billingAnnually-tab-pane" aria-selected="false"
                                tabindex="-1">{{__('Annually')}}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row rg-24">
            @foreach($planList as $plan)
                <div class="col-xxl-4 col-md-6">
                    <div class="price-item-one h-100 5 bg-bg">
                        <div class="info-content">
                            <div class="icon">
                                <img src="{{getFileUrl($plan->icon)}}" alt=""></div>
                            <div class="text-content">
                                <h4 class="title">{{$plan->name}}</h4>
                                <p class="info">Best for personal use.</p>
                            </div>
                            <p class="price zPrice-plan-monthly d-block"><span>{{showPrice($plan->monthly_price)}}</span>/ Per Month</p>
                            <p class="price zPrice-plan-annually d-none"><span>{{showPrice($plan->yearly_price)}}</span>/ Per Year</p>
                            <button onclick="getEditModal('{{ route('user.checkout.modal', [$plan->id, DURATION_MONTH]) }}', '#buyNowModal')" id="zPrice-plan-monthly-{{$plan->slug}}" class="zPrice-plan-monthly d-block link border-0">{{__('Checkout')}}</button>
                            <button onclick="getEditModal('{{ route('user.checkout.modal', [$plan->id, DURATION_YEAR]) }}', '#buyNowModal')" id="zPrice-plan-annually-{{$plan->slug}}" class="zPrice-plan-annually d-none link border-0">{{__('Checkout')}}</button>
                        </div>
                        <div class="list-wrap 5">
                            <h4 class="title">{{ __('What’s included') }}:</h4>
                            <ul class="list">
                                @foreach($plan->others ?? [] as $other)
                                    <li class="item">
                                        @if($other['value'] == STATUS_ACTIVE)
                                            <div class="icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.07 4.95008C23.04 8.92008 22.97 15.4 18.87 19.29C15.08 22.88 8.92996 22.88 5.12996 19.29C1.01996 15.4 0.94995 8.92008 4.92995 4.95008C8.82995 1.04008 15.17 1.04008 19.07 4.95008Z" stroke="#0E191E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M8 16L15.9998 8.00016" stroke="#0E191E" stroke-width="1.5"/>
                                                    <path d="M16 16L8.00016 8.00016" stroke="#0E191E" stroke-width="1.5"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                    <path d="M18.07 3.95008C22.04 7.92008 21.97 14.4 17.87 18.29C14.08 21.88 7.92996 21.88 4.12996 18.29C0.0199623 14.4 -0.0500498 7.92008 3.92995 3.95008C7.82995 0.040078 14.17 0.040078 18.07 3.95008Z" stroke="#0E191E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M6.75 10.9999L9.58 13.8299L15.25 8.16992" stroke="#0E191E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        @endif
                                        <p class="text">{{ $other['name'] ?? '' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-4 p-25">
            </div>
        </div>
    </div>
    <input type="hidden" id="serviceSearchRoute" value="{{ route('user.plans.search') }}">
    <input type="hidden" id="getCurrencyByGatewayIdRoute" value="{{route('user.currency.list')}}">
    <input type="hidden" id="waitingRoute" value="{{route('waiting')}}">
    <input type="hidden" id="gotoRoute" value="{{ route('waiting') }}">
@endsection

@push('script')
    <script src="{{ asset('user/custom/js/services.js') }}"></script>
    <script src="{{ asset('user/custom/js/checkout.js') }}"></script>
@endpush
