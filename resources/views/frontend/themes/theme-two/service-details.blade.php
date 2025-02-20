@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="section-breadcrumb" data-background="{{ asset('assets/images/breadcrumb-one.png') }}">
        <div class="container">
            <div class="section-breadcrumb-content">
                <h4 class="title">{{__('Service Details')}}</h4>
                <ol class="breadcrumb sf-breadcrumb inner-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('frontend') }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">{{ $serviceData->title }}</li>
                </ol>
            </div>
        </div>
    </section>
    <!-- About Service -->
    <section class="section-gap">
        <div class="container">
            <div class="section-content-wrap max-w-728 m-auto">
                <div class="text-center">
                    <p class="section-subtitle">
                        @php
                            $values = json_decode(landingPageSetting($collection,'our_service_sub_title','[]'),true)
                        @endphp
                        @foreach($values as $index => $data)
                            <span>{{ strtoupper($data) }}</span>
                            @if($index < count($values) -1 )
                                <span class="bar"></span>
                            @endif
                        @endforeach
                    </p>
                </div>
                <h4 class="section-title text-center">{{ $serviceData->title }}</h4>
                <p class="section-info text-center text-para-text">{{ $serviceData->description }}</p>
            </div>
            <div class="aboutService-one"><img src="{{ getFileUrl($serviceData->banner_image) }}" alt="" /></div>
        </div>
    </section>

    <!-- ALL TOUCHPOINTS -->
    @if(getOption('service_details_touch_point_status') == STATUS_ACTIVE)
        <section class="section-gap bg-bg">
            <div class="container">
                <div class="section-content-wrap max-w-675 m-auto">
                    <div class="text-center">
                        <p class="section-subtitle">
                            @php
                                $values = json_decode(landingPageSetting($collection,'service_details_touch_point_sub_title','[]'),true)
                            @endphp
                            @foreach($values as $index => $data)
                                <span>{{ strtoupper($data) }}</span>
                                @if($index < count($values) -1 )
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <h4 class="section-title text-center">{{ landingPageSetting($collection,'service_details_touch_point_title','') }}</h4>
                </div>
                <!--  -->
                <div class="row rg-24">
                    @foreach($serviceData->our_touch_point as $touchPoint)
                        <div class="col-lg-4 col-md-6">
                            <div class="touchpoint-item-one">
                                <div class="icon"><img src="{{ getFileUrl($touchPoint['icon']) }}" alt="{{ $touchPoint['title'] }}" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ $touchPoint['title'] }}</h4>
                                    <p class="info">{{ $touchPoint['details'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Our Approach -->
    @if(getOption('service_details_our_approach_status') == STATUS_ACTIVE)
         <section class="section-gap section-ourApproach bg-title-text overflow-hidden">
            <div class="container">
                <!--  -->
                <div class="section-content-wrap">
                    <div class="row rg-24">
                        <div class="col-xxl-3 col-lg-4">
                            <div class="text-center text-lg-start">
                                <p class="section-subtitle text-white bd-c-white-stroke">
                                    @php
                                        $values = json_decode(landingPageSetting($collection,'service_details_our_approach_sub_title',''),true)
                                    @endphp
                                    @foreach($values as $index => $data)
                                        <span>{{ strtoupper($data) }}</span>
                                        @if($index < count($values) -1 )
                                            <span class="bar"></span>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="col-xxl-9 col-lg-8">
                            <div class="ourApproach-wrap max-w-892 text-center text-lg-start">
                                <p class="section-title-alt pt-0 text-white">{{ landingPageSetting($collection,'service_details_our_approach_title','') }}</p>
                                <a href="{{ route('contact-us') }}" class="sf-icon-btn">
                                    <span>{{__('Get In Touch')}}</span>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1873 1.81303L14.1873 0.813029L15.1873 0.813029L15.1873 1.81303L14.1873 1.81303ZM2.52003 14.8945C2.12951 15.285 1.49635 15.285 1.10582 14.8945C0.715297 14.504 0.715297 13.8708 1.10582 13.4803L2.52003 14.8945ZM4.2878 0.813029H14.1873L14.1873 2.81303H4.2878L4.2878 0.813029ZM15.1873 1.81303L15.1873 11.7125H13.1873L13.1873 1.81303L15.1873 1.81303ZM14.8944 2.52014L2.52003 14.8945L1.10582 13.4803L13.4802 1.10592L14.8944 2.52014Z" fill="#0E191E" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper ourApproachSliderOne">
                    <div class="swiper-wrapper">
                        @foreach($serviceData->our_approach as $data)
                            <div class="swiper-slide">
                                <div class="ourApproach-item-one">
                                    <div class="iconStep">
                                        <div class="icon"><img src="{{ getFileUrl($data['icon']) }}" alt="" /></div>
                                        <p class="step">{{ __('Step') }} {{ $loop->index + 1 }} / {{ $loop->count }}</p>
                                    </div>
                                    <div class="text-content">
                                        <h4 class="title">{{ $data['title'] }}</h4>
                                        <p class="info">{{ $data['details'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    <!-- Choose Us -->
    @if(getOption('choose_us_status') == STATUS_ACTIVE)
        <!-- Choose Us -->
        <section class="section-gap">
            <div class="container">
                <div class="section-content-wrap max-w-519 m-auto">
                    <div class="text-center">
                        <p class="section-subtitle">
                            @php
                                $values = json_decode(landingPageSetting($collection, 'choose_us_sub_title', '[]'), true);
                            @endphp
                            @foreach ($values as $index => $value)
                                <span>{{ strtoupper($value) }}</span>
                                @if ($index < count($values) - 1)
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <h4 class="section-title text-center">{{ landingPageSetting($collection,'choose_us_title','') }}</h4>
                </div>
                <div class="row rg-24">
                    @foreach($chooseUs as $data)
                        <div class="col-lg-4 col-sm-6">
                            <div class="choose-item-two bg-bg">
                                <div class="icon"><img src="{{ getFileUrl($data->icon) }}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ $data->title }}</h4>
                                    <p class="info">{{ $data->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- FAQ -->
    @if(getOption('faq_status') == STATUS_ACTIVE)
        <section class="section-gap-bottom">
            <div class="container">
                <div class="section-content-wrap">
                    <div class="text-center">
                        <p class="section-subtitle">
                            @php
                                $values = json_decode(landingPageSetting($collection, 'faq_sub_title', '[]'), true);
                            @endphp
                            @foreach ($values as $index => $value)
                                <span>{{ strtoupper($value) }}</span>
                                @if ($index < count($values) - 1)
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <h4 class="section-title text-center">{{ landingPageSetting($collection,'faq_title','') }}</h4>
                </div>
                <div class="accordion zAccordion-reset zAccordion-one" id="accordionExample">
                    @foreach($faqData as $index => $data)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}"
                                        aria-controls="collapse-{{ $index }}" aria-expanded="false">
                                    {{ $data->question }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $index }}"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $data->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <div class="left">
                    <p class="section-subtitle">
                        @php
                            $values = json_decode(getOption('cta_footer_sub_title','[]'), true);
                        @endphp
                        @foreach ($values as $index => $value)
                            <span>{{ strtoupper($value) }}</span>
                            @if ($index < count($values) - 1)
                                <span class="bar"></span>
                            @endif
                        @endforeach
                    </p>
                    <h4 class="section-title">{{ getOption('cta_footer_title') }}</h4>
                    <p class="section-info">{{ getOption('cta_footer_description') }}</p>
                    <a href="{{ route('contact-us') }}" class="sf-icon-btn">
                        <span>{{__('Get In Touch')}}</span>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M14.1873 1.81303L14.1873 0.813029L15.1873 0.813029L15.1873 1.81303L14.1873 1.81303ZM2.52003 14.8945C2.12951 15.285 1.49635 15.285 1.10582 14.8945C0.715297 14.504 0.715297 13.8708 1.10582 13.4803L2.52003 14.8945ZM4.2878 0.813029H14.1873L14.1873 2.81303H4.2878L4.2878 0.813029ZM15.1873 1.81303L15.1873 11.7125H13.1873L13.1873 1.81303L15.1873 1.81303ZM14.8944 2.52014L2.52003 14.8945L1.10582 13.4803L13.4802 1.10592L14.8944 2.52014Z" fill="#0E191E" />
                            </svg>
                        </div>
                    </a>
                </div>
                <div class="right"><img src="{{ getFileUrl(getOption('cta_footer_image')) }}" alt="" /></div>
            </div>
        </div>
    </section>
@endsection
