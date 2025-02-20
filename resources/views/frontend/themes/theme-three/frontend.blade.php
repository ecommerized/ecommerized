@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
<!-- Banner -->
@if(getOption('hero_banner_status') == STATUS_ACTIVE)
    <section class="hero-banner-one hero-banner-three" data-background="{{ getFileUrl(landingPageSetting($collection,'hero_banner_image_2','[]')) }}">
        <div class="container">
            <div class="hero-banner-one-content-wrap hero-banner-three-content-wrap">
                <div class="row rg-24 justify-content-center">
                    <div class="col-lg-8">
                        <div class="hero-banner-one-left hero-banner-three-left">
                            <p class="section-subtitle text-title-text bd-c-black-stroke">
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
                            <h4 class="section-title text-title-text">{{ landingPageSetting($collection,'hero_banner_title','') }}</h4>
                            <p class="section-info text-para-text">{{ landingPageSetting($collection,'hero_banner_details','') }}</p>
                            <div class="link-wrap">
                                <a href="#plan" class="sf-icon-btn">
                                    <span>{{__('View pricing')}}</span>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1873 1.81303L14.1873 0.813029L15.1873 0.813029L15.1873 1.81303L14.1873 1.81303ZM2.52003 14.8945C2.12951 15.285 1.49635 15.285 1.10582 14.8945C0.715297 14.504 0.715297 13.8708 1.10582 13.4803L2.52003 14.8945ZM4.2878 0.813029H14.1873L14.1873 2.81303H4.2878L4.2878 0.813029ZM15.1873 1.81303L15.1873 11.7125H13.1873L13.1873 1.81303L15.1873 1.81303ZM14.8944 2.52014L2.52003 14.8945L1.10582 13.4803L13.4802 1.10592L14.8944 2.52014Z" fill="#0E191E" />
                                        </svg>
                                    </div>
                                </a>
                                <a href="{{ route('about-us') }}" class="sf-icon-btn banner-altBtn">
                                    <span>{{__('Know more')}}</span>
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
        </div>
    </section>
@endif
<!-- Best Features -->
@if(getOption('choose_us_status') == STATUS_ACTIVE)
<section class="section-gap bg-button">
    <div class="container">
        <div class="row rg-24 justify-content-center">
            <div class="col-lg-4">
                <div class="max-w-599 m-auto">
                    <div class="text-center text-lg-start">
                        <p class="section-subtitle text-white bd-c-white-10">
                            @php
                                $values = json_decode(landingPageSetting($collection, 'choose_us_sub_title', '[]'), true);
                            @endphp
                            @foreach ($values as $index => $value)
                                <span>{{ strtoupper($value) }}</span>
                                @if ($index < count($values) - 1)
                                    <span class="bar bg-white"></span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <h4 class="section-title text-white text-center text-lg-start">{{ landingPageSetting($collection,'choose_us_title','') }}</h4>
                </div>
            </div>
            @foreach($chooseUs as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="feature-item-one">
                        <div class="content">
                            <div class="icon"><img src="{{ getFileUrl($data->icon) }}" alt="" /></div>
                            <h4 class="title">{{ $data->title }}</h4>
                        </div>
                        <p class="info">{{ $data->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if(getOption('about_us_status') == STATUS_ACTIVE)
    <section class="section-gap">
        <div class="container">
            <div class="row rg-24">
                <div class="col-lg-5">
                    <div class="aboutUs-three-img"><img src="{{ getFileUrl($aboutUs?->banner_image) }}" alt="" /></div>
                </div>
                <div class="col-lg-7">
                    <div class="aboutUs-three-content">
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
                        <a href="{{ route('about-us') }}" class="title d-block">{{ landingPageSetting($collection,'about_us_title','') }}</a>
                    </div>
                    <div class="row rg-24 justify-content-lg-between">
                        <div class="col-lg-auto col-md-3 col-sm-4 col-6">
                            <div class="statistics-item-two">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-5.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title"><span class="counter">{{ getOption('our_achievement_live_project_number') ?? 0 }}</span>+</h4>
                                    <p class="info">{{ getOption('our_achievement_live_project_title') ?? 'Project Live' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-3 col-sm-4 col-6">
                            <div class="statistics-item-two">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-6.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title"><span class="counter">{{ getOption('our_achievement_wining_award_number') ?? 0 }}</span></h4>
                                    <p class="info">{{ getOption('our_achievement_wining_award_title') ?? 'Wining Award' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-3 col-sm-4 col-6">
                            <div class="statistics-item-two">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-7.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title"><span class="counter">{{ getOption('our_achievement_satisfied_clients_number') ?? 0 }}</span>+</h4>
                                    <p class="info">{{ getOption('our_achievement_satisfied_clients_title') ?? 'Satisfied Client' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-3 col-sm-4 col-6">
                            <div class="statistics-item-two">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-8.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title"><span class="counter">{{ getOption('our_achievement_years_of_experience_number') ?? 0 }}</span>+</h4>
                                    <p class="info">{{ getOption('our_achievement_years_of_experience_title') ?? 'Years Of Experience' }}</p>
                                </div>
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
<section class="section-gap bg-title-text" id="serviceSection">
    <div class="container">
        <div class="section-content-wrap max-w-599 m-auto">
            <div class="text-center">
                <p class="section-subtitle bd-c-white-10 text-white">
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
            <h4 class="section-title text-center text-white">{{ landingPageSetting($collection,'our_service_title','') }}</h4>
        </div>
        <div class="row justify-content-center rg-24">
            @foreach($serviceData as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="service-items-three">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ getFileUrl($data->icon) }}" alt="" />
                            </div>
                            <div class="text-content">
                                <h4 class="sub-title">{{ $data->title }}</h4>
                                <h4 class="title">{!!  getSubText($data->description, 90) !!}</h4>
                                <a href="{{ route('service-details',$data->slug) }}" class="link">
                                    <span>{{__('Learn More')}}</span>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16" fill="none">
                                            <path d="M19 8L19.6971 7.28301L20.4346 8L19.6971 8.717L19 8ZM1 9C0.447717 9 1.24711e-06 8.55228 1.29539e-06 8C1.34367e-06 7.44771 0.447717 7 1 7L1 9ZM12.4971 0.283005L19.6971 7.28301L18.3029 8.717L11.1029 1.71699L12.4971 0.283005ZM19.6971 8.717L12.4971 15.717L11.1029 14.283L18.3029 7.28301L19.6971 8.717ZM19 9L1 9L1 7L19 7L19 9Z" fill="#0E191E" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Our Projects -->
@if(getOption('our_project_status') == STATUS_ACTIVE)
    <section class="section-gap" id="portfolioSection">
    <div class="container">
        <div class="section-content-wrap">
            <div class="row rg-24 justify-content-md-between align-items-md-end">
                <div class="col-lg-5">
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
                    <h4 class="section-title">{{ landingPageSetting($collection,'our_project_title','') }}</h4>
                </div>
                <div class="col-lg-5">
                    <div class="pb-lg-9 max-w-456 ms-lg-auto">
                        <p class="section-info text-para-text">{{ landingPageSetting($collection,'our_project_details','') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills zTab-reset zTab-one justify-content-start" id="pills-tab" role="tablist">
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
                    <div class="row rg-24 justify-content-center">
                        @if(isset($portfolioData[$category->id]))
                            @foreach($portfolioData[$category->id] as $data)
                                <div class="col-lg-4 col-md-6">
                                    <div class="portfolio-item-three" data-background="{{ getFileUrl($data->banner_image) }}">
                                        <div class="content-wrap">
                                            <div class="portfolio-item-info">
                                                <ul class="d-flex justify-content-center justify-content-md-start align-items-center flex-wrap g-16">
                                                    @foreach($data->tag as $tag)
                                                        <li><a href="#" class="portfolio-item-tag">{{ $tag }}</a></li>
                                                    @endforeach
                                                </ul>
                                                <a href="{{ route('portfolio-details',encodeId($data->id)) }}" class="title">{{ $data->title }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('No portfolio items found for this category.') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Working Process -->
@if(getOption('our_process_status') == STATUS_ACTIVE)
<section class="section-gap bg-frame">
    <div class="container">
        <div class="section-content-wrap max-w-482 m-auto">
            <div class="text-center">
                <p class="section-subtitle">
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
            <h4 class="section-title text-center">{{ landingPageSetting($collection,'our_process_title','') }}</h4>
        </div>
        <div class="workProcess-items-wrap-one">
            <div class="row rg-30">
                @foreach($workingProcessData as $index => $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="workProcess-item-two">
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
    <section class="section-gap bg-title-text" id="plan">
        <div class="container">
            <div class="section-content-wrap">
                <div class="row rg-24 justify-content-md-between align-items-md-end">
                    <div class="col-lg-4 col-md-7">
                        <p class="section-subtitle text-white bd-c-white-10">
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
                        <h4 class="section-title text-white">{{ landingPageSetting($collection,'pricing_plan_title','') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="text-md-end">
                            <ul class="nav nav-tabs d-inline-flex zTab-reset zTab-three" id="pricePlanTab" role="tablist">
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
                                <div class="price-item-three h-100">
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
                                        <h4 class="title">{{__('What’s included')}}:</h4>
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
<section class="section-gap bg-bg">
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
            <h4 class="section-title text-center">{{ landingPageSetting($collection,'membership_benefits_title','') }}</h4>
        </div>
        <!--  -->
        <div class="row rg-24 justify-content-center">
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
<section class="section-gap bg-frame section-testimonial-three">
    <div class="container">
        <div class="section-content-wrap">
            <div class="row rg-24 justify-content-md-between align-items-md-end">
                <div class="col-lg-5">
                    <p class="section-subtitle">
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
                    <h4 class="section-title">{{ landingPageSetting($collection,'testimonial_title','') }}</h4>
                </div>
                <div class="col-lg-5">
                    <div class="pb-lg-9 max-w-456 ms-lg-auto">
                        <p class="section-info text-para-text">{{ landingPageSetting($collection,'testimonial_details','') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper testimonialSliderThree">
            <div class="swiper-wrapper">
                @foreach($testimonialData as $data)
                    <div class="swiper-slide">
                        <div class="testimonial-item-three">
                            <div class="authorRating">
                                <div class="author">
                                    <div class="img"><img src="{{ getFileUrl($data->image) }}" alt="" /></div>
                                    <div class="text-content">
                                        <h4 class="title">{{ $data->name }}</h4>
                                        <p class="info">{{ $data->designation }}</p>
                                    </div>
                                </div>
                                <div class="review">
                                    @for ($i = 0; $i < $data->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @for ($i = 0; $i < (5 - $data->rating); $i++)
                                        <i class="fa-regular fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text">“{{ $data->comment }}”</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
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
            <div class="row rg-24 justify-content-center">
                @foreach($blogData->take(3) as $data)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('blog-details',$data->slug) }}" class="blog-item-four">
                            <div class="img"><img src="{{ getFileUrl($data->banner_image) }}" alt="" /></div>
                            <div class="text-content">
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
                                    <span class="seperate text-white">/</span>
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
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- FAQ -->
@if(getOption('faq_status') == STATUS_ACTIVE)
    <section class="section-gap-bottom" id="faqSection">
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
        <div class="cta-content cta-content-three" data-background="{{ asset('assets/images/cta-image-3.png') }}">
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
        </div>
    </div>
</section>
@endsection
