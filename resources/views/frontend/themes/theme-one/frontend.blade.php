@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
<!-- Banner -->
@if(getOption('hero_banner_status') == STATUS_ACTIVE)
    <section class="hero-banner-one">
        <div class="container">
            <div class="hero-banner-one-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-6">
                        <div class="hero-banner-one-left">
                            <p class="section-subtitle">
                                @php
                                    $values = json_decode(landingPageSetting($collection,'hero_banner_sub_title','[]'),true);
                                @endphp
                                @foreach($values as $index => $data)
                                    <span>{{ strtoupper($data) }}</span>
                                    @if($index < count($values) -1 )
                                        <span class="bar"></span>
                                    @endif
                                @endforeach
                            </p>
                            <h4 class="section-title">{{ landingPageSetting($collection,'hero_banner_title','') }}</h4>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-banner-one-right">
                            <ul class="logoWrap">
                                <li class="d-flex"><img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_1','[]')) }}" alt="" /></li>
                                <li class="d-flex"><img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_2','[]')) }}" alt="" /></li>
                                <li class="d-flex"><img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_3','[]')) }}" alt="" /></li>
                            </ul>
                            <p class="section-info">{{ landingPageSetting($collection,'hero_banner_details','') }}</p>
                            <a href="#plan" class="link">
                                <span>{{__("View Pricing")}}</span>
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
        </div>
        <div class="companyWrap-one">
            <div class="company-images">
                <div class="swiper swiperHroBannerSliderOne">
                    <div class="swiper-wrapper">
                        @php
                            $heroBannerImages = json_decode(landingPageSetting($collection, 'hero_banner_image', '[]'), true);
                        @endphp

                        @foreach($heroBannerImages as $imageId)
                            <div class="swiper-slide">
                                <div class="company-images-item">
                                    <img src="{{ getFileUrl($imageId)  }}" alt="Banner Image {{ $imageId }}" />
                                    <a href="{{ route('about-us') }}" class="link">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M14.3641 1.63603L14.35 0.636127L15.3784 0.621642L15.364 1.65011L14.3641 1.63603ZM2.34324 15.0711C1.95272 15.4616 1.31955 15.4616 0.929026 15.0711C0.538502 14.6805 0.538502 14.0474 0.929026 13.6568L2.34324 15.0711ZM4.30905 0.777547L14.35 0.636127L14.3781 2.63593L4.33722 2.77735L4.30905 0.777547ZM15.364 1.65011L15.2225 11.691L13.2227 11.6629L13.3642 1.62194L15.364 1.65011ZM15.0712 2.34313L2.34324 15.0711L0.929026 13.6568L13.6569 0.928921L15.0712 2.34313Z" fill="#FFFFFF" />
                                            </svg>
                                        </div>
                                        <p class="text">{{ __('View More') }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="swiper autoImageslider">
                <div class="swiper-wrapper">
                    @php
                        $heroBannerIcon = json_decode(landingPageSetting($collection, 'hero_banner_icon', '[]'), true);
                    @endphp
                    @foreach($heroBannerIcon as $icon)
                        <div class="swiper-slide">
                            <div class="partner-list-2">
                                <img src="{{ getFileUrl($icon) }}" alt="" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
<!-- About Us -->
@if(getOption('about_us_status') == STATUS_ACTIVE)
    <section class="section-gap">
        <div class="container">
            <div class="section-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-6">
                        <div class="text-center text-lg-start max-w-650 m-auto">
                            <p class="section-subtitle">
                                @php
                                    $values = json_decode(landingPageSetting($collection,'about_us_sub_title','[]'),true);
                                @endphp
                                @foreach($values as $index => $data)
                                    <span>{{ strtoupper($data) }}</span>
                                    @if($index < count($values) -1 )
                                        <span class="bar"></span>
                                    @endif
                                @endforeach
                            </p>
                            <h4 class="section-title-alt">{{ landingPageSetting($collection,'about_us_title','') }}</h4>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="pb-lg-9 max-w-482 m-auto ms-lg-auto text-center text-lg-start">
                            <p class="section-info pt-0 pb-md-34 pb-20">{{ landingPageSetting($collection,'about_us_details','') }}</p>
                            <a href="{{ route('about-us') }}" class="sf-icon-btn">
                                <span>{{__('Know More')}}</span>
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
            <div class="aboutStatics-wrap">
                <div class="row rg-24 justify-content-lg-between">
                    <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                        <div class="statistics-item-one">
                            <div class="icon"><img src="{{ asset('assets/images/icon/statistics-item-1.svg') }}" alt="" /></div>
                            <div class="text-content">
                                <h4 class="title"><span class="counter">{{ getOption('our_achievement_live_project_number') ?? 0 }}</span>+</h4>
                                <p class="info">{{ getOption('our_achievement_live_project_title') ?? 'Project Live' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                        <div class="statistics-item-one">
                            <div class="icon"><img src="{{ asset('assets/images/icon/statistics-item-2.svg') }}" alt="" /></div>
                            <div class="text-content">
                                <h4 class="title"><span class="counter">{{ getOption('our_achievement_wining_award_number') ?? 0 }}</span></h4>
                                <p class="info">{{ getOption('our_achievement_wining_award_title') ?? 'Wining Award' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                        <div class="statistics-item-one">
                            <div class="icon"><img src="{{ asset('assets/images/icon/statistics-item-3.svg') }}" alt="" /></div>
                            <div class="text-content">
                                <h4 class="title"><span class="counter">{{ getOption('our_achievement_satisfied_clients_number') ?? 0 }}</span>+</h4>
                                <p class="info">{{ getOption('our_achievement_satisfied_clients_title') ?? 'Satisfied Client' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                        <div class="statistics-item-one">
                            <div class="icon"><img src="{{ asset('assets/images/icon/statistics-item-4.svg') }}" alt="" /></div>
                            <div class="text-content">
                                <h4 class="title"><span class="counter">{{ getOption('our_achievement_years_of_experience_number') ?? 0 }}</span>+</h4>
                                <p class="info">{{ getOption('our_achievement_years_of_experience_title') ?? 'Years Of Experience' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- Our Services -->
@if(getOption('our_service_status') == STATUS_ACTIVE)
<section class="section-gap bg-bg" id="serviceSection">
    <div class="container">
        <div class="section-content-wrap max-w-519 m-auto">
            <div class="text-center">
                <p class="section-subtitle">
                    @php
                        $values = json_decode(landingPageSetting($collection,'our_service_sub_title','[]'),true);
                    @endphp
                    @foreach($values as $index => $data)
                        <span>{{ strtoupper($data) }}</span>
                        @if($index < count($values) -1 )
                            <span class="bar"></span>
                        @endif
                    @endforeach
                </p>
            </div>
            <h4 class="section-title text-center">{{ landingPageSetting($collection,'our_service_title','') }}</h4>
        </div>
        <div class="row rg-24 justify-content-center">
            @foreach($serviceData as $data)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="service-item-one">
                        <div class="text-content">
                            <img src="{{ asset('assets/images/service-item-one-bg.png') }}" alt="" class="overlay-img" />
                            <div class="icon"><img src="{{ getFileUrl($data->icon) }}" alt="" /></div>
                            <h4 class="title">{!!  getSubText($data->title, 90) !!}</h4>
                            <p class="info">{!!  getSubText($data->description, 250) !!}</p>
                        </div>
                        <div class="linkWrap">
                            <a href="{{ route('service-details',$data->slug) }}" class="link">
                                <span>{{__('More Details')}}</span>
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16" fill="none">
                                        <path d="M19 8L19.6971 7.28301L20.4346 8L19.6971 8.717L19 8ZM1 9C0.447717 9 1.24711e-06 8.55228 1.29539e-06 8C1.34367e-06 7.44771 0.447717 7 1 7L1 9ZM12.4971 0.283005L19.6971 7.28301L18.3029 8.717L11.1029 1.71699L12.4971 0.283005ZM19.6971 8.717L12.4971 15.717L11.1029 14.283L18.3029 7.28301L19.6971 8.717ZM19 9L1 9L1 7L19 7L19 9Z" fill="#0E191E" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Our Portfolio -->
@if(getOption('our_project_status') == STATUS_ACTIVE)
    <section class="section-gap" id="portfolioSection">
        <div class="container">
            <div class="section-content-wrap max-w-432 m-auto">
                <div class="text-center">
                    <p class="section-subtitle">
                        @php
                            $values = json_decode(landingPageSetting($collection,'our_project_sub_title','[]'),true);
                        @endphp
                        @foreach($values as $index => $data)
                            <span>{{ strtoupper($data) }}</span>
                            @if($index < count($values) -1 )
                                <span class="bar"></span>
                            @endif
                        @endforeach
                    </p>
                </div>
                <h4 class="section-title text-center">{{ landingPageSetting($collection,'our_project_title','') }}</h4>
            </div>

            <ul class="nav nav-pills zTab-reset zTab-one" id="pills-tab" role="tablist">
                @foreach($portfolioCategory as $key => $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $key == 0 ? 'active' : '' }}" id="pills-{{ $category->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $category->id }}" type="button" role="tab" aria-controls="pills-{{ $category->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                            {{ $category->name }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="pills-tabContent">
                @foreach($portfolioCategory as $key => $category)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="pills-{{ $category->id }}" role="tabpanel" aria-labelledby="pills-{{ $category->id }}-tab" tabindex="0">
                        <ul class="portfolio-items">
                            @if(isset($portfolioData[$category->id]))
                                @foreach($portfolioData[$category->id] as $data)
                                    <li class="portfolio-item-one">
                                        <div class="row rg-24 justify-content-between align-items-center">
                                            <div class="col-lg-5 col-md-6">
                                                <div class="portfolio-item-info">
                                                    <ul class="d-flex justify-content-center justify-content-md-start align-items-center flex-wrap g-16">
                                                        @foreach($data->tag as $tag)
                                                            <li><a href="#" class="portfolio-item-tag">{{ $tag }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="text-content">
                                                        <h4 class="title">{{ $data->title }}</h4>
                                                        <p class="infot">{!! getSubText($data->details, 200) !!}</p>
                                                    </div>
                                                    <a href="{{ route('portfolio-details',encodeId($data->id)) }}" class="link">
                                                        <span>{{ __('View Project') }}</span>
                                                        <div class="icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                                <path d="M14.1873 1.81303L14.1873 0.813029L15.1873 0.813029L15.1873 1.81303L14.1873 1.81303ZM2.52003 14.8945C2.12951 15.285 1.49635 15.285 1.10582 14.8945C0.715297 14.504 0.715297 13.8708 1.10582 13.4803L2.52003 14.8945ZM4.2878 0.813029H14.1873L14.1873 2.81303H4.2878L4.2878 0.813029ZM15.1873 1.81303L15.1873 11.7125H13.1873L13.1873 1.81303L15.1873 1.81303ZM14.8944 2.52014L2.52003 14.8945L1.10582 13.4803L13.4802 1.10592L14.8944 2.52014Z" fill="#0E191E" />
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-6">
                                                <div class="portfolio-item-img">
                                                    <img src="{{ getFileUrl($data->banner_image) }}" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="portfolio-item-one">
                                    <p>{{ __('No portfolio items found for this category.') }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- Choose Us -->
@if(getOption('choose_us_status') == STATUS_ACTIVE)
    <section class="section-gap-bottom">
        <div class="container">
            <div class="section-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-5">
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
                        <h4 class="section-title">{{ landingPageSetting($collection,'choose_us_title') }}</h4>
                    </div>
                    <div class="col-lg-5">
                        <div class="pb-lg-9 max-w-446 ms-lg-auto">
                            <p class="section-info pb-md-34 pb-20">{{ landingPageSetting($collection,'choose_us_details') }}</p>
                            <a href="{{ route('about-us') }}" class="sf-icon-btn">
                                <span>{{__('Know More')}}</span>
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
            <div class="row rg-24 justify-content-center">
                @foreach($chooseUs as $data)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="choose-item-one">
                            <div class="icon"><img src="{{getFileUrl($data->icon)}}" alt="" /></div>
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
<!-- Working Process -->
@if(getOption('our_process_status') == STATUS_ACTIVE)
<section class="section-gap bg-title-text">
    <div class="container">
        <div class="section-content-wrap max-w-576 m-auto">
            <div class="text-center">
                <p class="section-subtitle bd-c-white-stroke text-white">
                    @php
                        $values = json_decode(landingPageSetting($collection,'our_process_sub_title','[]'),true);
                    @endphp
                    @foreach($values as $index => $data)
                        <span>{{ strtoupper($data) }}</span>
                        @if($index < count($values) -1 )
                            <span class="bar"></span>
                        @endif
                    @endforeach
                </p>
            </div>
            <h4 class="section-title text-white text-center">{{ landingPageSetting($collection,'our_process_title','') }}</h4>
        </div>
        <div class="workProcess-items-wrap-one">
            <div class="row rg-30">
                @foreach($workingProcessData as $index => $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="workProcess-item-one">
                            <div class="icon"><img src="{{ getFileUrl($data->icon) }}" alt="" /></div>
                            <p class="no"><span>{{ $index + 1 }}</span></p>
                            <div class="text-content">
                                <h4 class="title">{{ $data->title }}</h4>
                                <p class="info">{{ $data->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!-- Pricing -->
@if(getOption('pricing_plan_status') == STATUS_ACTIVE)
    <section class="section-gap bg-bg" id="plan">
        <div class="container">
            <div class="section-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-4 col-md-7">
                        <p class="section-subtitle">
                            @php
                                $values = json_decode(landingPageSetting($collection,'pricing_plan_sub_title','[]'),true);
                            @endphp
                            @foreach($values as $index => $data)
                                <span>{{ strtoupper($data) }}</span>
                                @if($index < count($values) -1 )
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                        <h4 class="section-title">{{ landingPageSetting($collection,'pricing_plan_title','') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="text-md-end">
                            <ul class="nav nav-tabs d-inline-flex zTab-reset zTab-two" id="pricePlanTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="billingMonthly-tab" data-bs-toggle="tab" data-bs-target="#billingMonthly-tab-pane" type="button" role="tab" aria-controls="billingMonthly-tab-pane" aria-selected="true">Monthly</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="billingAnnually-tab" data-bs-toggle="tab" data-bs-target="#billingAnnually-tab-pane" type="button" role="tab" aria-controls="billingAnnually-tab-pane" aria-selected="false" tabindex="-1">Annually</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pricingSliderWrap-one">
            <div class="container">
                <div class="swiper pricingSliderOne">
                    <div class="swiper-wrapper">
                        @foreach($packageData as $data)
                            <div class="swiper-slide">
                                <div class="price-item-one h-100">
                                    <div class="info-content">
                                        <div class="icon"><img src="{{ getFileUrl($data->icon) }}" alt="" /></div>
                                        <div class="text-content">
                                            <h4 class="title">{{ $data->name }}</h4>
                                            <p class="info">{{ $data->details }}</p>
                                        </div>
                                        <p class="price zPrice-plan-monthly"><span>{{ showPrice($data->monthly_price) }}</span>/ {{__('Per Month')}}</p>
                                        <p class="price zPrice-plan-annually"><span>{{ showPrice($data->yearly_price) }}</span>/ {{__('Per Year')}}</p>
                                        @if(!auth()->check() || auth()->user()->role == USER_ROLE_CLIENT)
                                            <a href="{{ route('user.plans.list', ['plan' => $data->slug ,'duration_type' => DURATION_MONTH]) }}" class="link zPrice-plan-monthly d-block">{{__('Get started')}}</a>
                                            <a href="{{ route('user.plans.list', ['plan' => $data->slug ,'duration_type' => DURATION_YEAR]) }}" class="link zPrice-plan-annually d-none">{{__('Get started')}}</a>
                                        @endif
                                    </div>
                                    <div class="list-wrap">
                                        <h4 class="title">{{ __('What’s included') }}:</h4>
                                        <ul class="list">
                                            @foreach($data->others ?? [] as $other)
                                                <li class="item">
                                                    @if($other['value'] != STATUS_ACTIVE)
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
                    <div class="swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="18" viewBox="0 0 23 18" fill="none">
                            <path d="M2 9L1.29289 8.29289L0.585786 9L1.29289 9.70711L2 9ZM22 10C22.5523 10 23 9.55229 23 9C23 8.44772 22.5523 8 22 8V10ZM9.29289 0.292893L1.29289 8.29289L2.70711 9.70711L10.7071 1.70711L9.29289 0.292893ZM1.29289 9.70711L9.29289 17.7071L10.7071 16.2929L2.70711 8.29289L1.29289 9.70711ZM2 10H22V8H2V10Z" fill="#0E191E" />
                        </svg>
                    </div>
                    <div class="swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="18" viewBox="0 0 23 18" fill="none">
                            <path d="M21 9L21.7071 8.29289L22.4142 9L21.7071 9.70711L21 9ZM1 10C0.447716 10 0 9.55229 0 9C0 8.44772 0.447716 8 1 8V10ZM13.7071 0.292893L21.7071 8.29289L20.2929 9.70711L12.2929 1.70711L13.7071 0.292893ZM21.7071 9.70711L13.7071 17.7071L12.2929 16.2929L20.2929 8.29289L21.7071 9.70711ZM21 10H1V8H21V10Z" fill="#0E191E" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- Membership Benefits -->
@if(getOption('membership_benefits_status') == STATUS_ACTIVE)
<section class="section-gap">
    <div class="container">
        <!--  -->
        <div class="section-content-wrap max-w-576 m-auto">
            <div class="text-center">
                <p class="section-subtitle">
                    @php
                        $values = json_decode(landingPageSetting($collection, 'membership_benefits_sub_title', '[]'), true);
                    @endphp
                    @foreach ($values as $index => $value)
                        <span>{{ strtoupper($value) }}</span>
                        @if ($index < count($values) - 1)
                            <span class="bar"></span>
                        @endif
                    @endforeach
                </p>
            </div>
            <h4 class="section-title text-center">{{ landingPageSetting($collection,'membership_benefits_title', '') }}</h4>
        </div>
        <!--  -->
        <div class="row justify-content-center rg-24">
            @foreach($memberBenefits as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="membership-benefits-item-three">
                        <div class="icon">
                            <img src="{{ getFileUrl($data->icon) }}" alt="">
                        </div>
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
<!-- Testimonial -->
@if(getOption('testimonial_status') == STATUS_ACTIVE)
<section class="section-gap section-testimonial bg-title-text">
    <div class="container">
        <div class="swiper testimonialSliderOne">
            <!--  -->
            <div class="section-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-6 col-md-9">
                        <p class="section-subtitle text-white bd-c-white-stroke">
                            @php
                               $values = json_decode(landingPageSetting($collection,'testimonial_sub_title','[]'),true);
                            @endphp
                            @foreach($values as $index => $data)
                                <span>{{ strtoupper($data) }}</span>
                                @if($index < count($values) -1 )
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                        <h4 class="section-title text-white">{{ landingPageSetting($collection,'testimonial_title','') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-3">
                        <div class="d-flex justify-content-md-end">
                            <div class="sliderControls">
                                <div class="swiper-button-prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="18" viewBox="0 0 23 18" fill="none">
                                        <path d="M2 9L1.29289 8.29289L0.585786 9L1.29289 9.70711L2 9ZM22 10C22.5523 10 23 9.55229 23 9C23 8.44772 22.5523 8 22 8V10ZM9.29289 0.292893L1.29289 8.29289L2.70711 9.70711L10.7071 1.70711L9.29289 0.292893ZM1.29289 9.70711L9.29289 17.7071L10.7071 16.2929L2.70711 8.29289L1.29289 9.70711ZM2 10H22V8H2V10Z" fill="white" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="18" viewBox="0 0 23 18" fill="none">
                                        <path d="M21 9L21.7071 8.29289L22.4142 9L21.7071 9.70711L21 9ZM1 10C0.447716 10 0 9.55229 0 9C0 8.44772 0.447716 8 1 8V10ZM13.7071 0.292893L21.7071 8.29289L20.2929 9.70711L12.2929 1.70711L13.7071 0.292893ZM21.7071 9.70711L13.7071 17.7071L12.2929 16.2929L20.2929 8.29289L21.7071 9.70711ZM21 10H1V8H21V10Z" fill="white" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="swiper-wrapper">
                @foreach($testimonialData as $data)
                    <div class="swiper-slide">
                        <div class="testimonial-item-one">
                            <p class="sub-title">{{ $data->categoryName }}</p>
                            <p class="text">“{{ $data->comment }}”</p>
                            <div class="authorQuote d-flex justify-content-between align-items-end">
                                <div class="author">
                                    <div class="img"><img src="{{ getFileUrl($data->image) }}" alt="" /></div>
                                    <div class="text-content">
                                        <h4 class="name">{{ $data->name }}</h4>
                                        <p class="degi">{{ $data->designation }}</p>
                                    </div>
                                </div>
                                <div class="quoteIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" viewBox="0 0 66 66" fill="none">
                                        <path d="M9.42864 33.5496H27.7358V60.7354H0.55V32.9996C0.55 17.8894 12.6946 5.56325 27.7358 5.26924V13.6002C17.2877 13.8924 8.87864 22.4822 8.87864 32.9996V33.5496H9.42864Z" stroke="white" stroke-opacity="0.1" stroke-width="1.1" />
                                        <path d="M46.5925 33.0006V33.5506H47.1425H65.4496V60.7364H38.2639V33.0006C38.2639 17.8904 50.4085 5.56422 65.4496 5.27022V13.6012C55.0016 13.8933 46.5925 22.4832 46.5925 33.0006Z" stroke="white" stroke-opacity="0.1" stroke-width="1.1" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!-- Blog -->
@if(getOption('blog_status') == STATUS_ACTIVE)
    <section class="section-gap" id="blogSection">
        <div class="container">
            <div class="section-content-wrap max-w-487 m-auto">
                <div class="text-center">
                    <p class="section-subtitle">
                        @php
                            $values = json_decode(landingPageSetting($collection, 'blog_sub_title','[]'), true);
                        @endphp
                        @foreach ($values as $index => $value)
                            <span>{{ strtoupper($value) }}</span>
                            @if ($index < count($values) - 1)
                                <span class="bar"></span>
                            @endif
                        @endforeach
                    </p>
                </div>
                <h4 class="section-title text-center">{{ landingPageSetting($collection,'blog_title','[]') }}</h4>
            </div>
            <!--  -->
            <div class="row rg-24 justify-content-center">
                @foreach($blogData->take(3) as $data)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('blog-details',$data->slug) }}" class="blog-item-one">
                            <div class="authorDate">
                                <div class="item">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M7.16803 12.8323L2.5 17.5003M6.66667 11.667C6.70159 12.0597 6.81777 12.4854 7.16633 12.834C7.51488 13.1826 7.94058 13.2987 8.33333 13.3337" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M3.33333 7.91664L8.75 5.83331L11.0801 3.17033C11.3976 2.80754 11.9557 2.78896 12.2965 3.12983L16.8702 7.70346C17.211 8.04433 17.1924 8.60239 16.8297 8.91989L14.1667 11.25L12.0833 16.6666L2.5 17.5L3.33333 7.91664Z" stroke="#5B5B5B" stroke-width="1.5" stroke-linejoin="round" />
                                            <path d="M8.75 5.83301L14.1667 11.2497" stroke="#5B5B5B" stroke-width="1.5" />
                                        </svg>
                                    </div>
                                    <p class="text">{{ $data->categoryName }}</p>
                                </div>
                                <span class="seperate text-para-text">/</span>
                                <div class="item">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15 1.66699V4.16699M5 1.66699V4.16699" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M16.2497 2.91699H3.74967C2.8292 2.91699 2.08301 3.66318 2.08301 4.58366V16.667C2.08301 17.5875 2.8292 18.3337 3.74967 18.3337H16.2497C17.1702 18.3337 17.9163 17.5875 17.9163 16.667V4.58366C17.9163 3.66318 17.1702 2.91699 16.2497 2.91699Z" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.08301 7.08301H17.9163" stroke="#5B5B5B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <p class="text">{{ \Carbon\Carbon::parse($data->created_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <h4 class="title">{{ $data->title }}</h4>
                            <div class="img"><img src="{{ getFileUrl($data->banner_image) }}" alt="" /></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- FAQ -->
@if(getOption('faq_status') == STATUS_ACTIVE)
    <section class="section-faq" id="faqSection">
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
                <h4 class="section-title text-center">{{ landingPageSetting($collection,'faq_title','')}}</h4>
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
<!-- End FAQ's -->


@endsection
