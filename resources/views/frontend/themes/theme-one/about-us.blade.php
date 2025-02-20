@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="section-breadcrumb" data-background="assets/images/breadcrumb-one.png">
        <div class="container">
            <div class="section-breadcrumb-content">
                <h4 class="title">{{$pageTitle}}</h4>
                <ol class="breadcrumb inner-breadcrumb sf-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">{{__('About Us')}}</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- About Us -->
    @if(getOption('about_us_our_journey_status') == STATUS_ACTIVE)
        <section class="section-gap">
            <div class="container">
                <div class="section-content-wrap">
                    <div class="row rg-24 justify-content-md-between align-items-md-end">
                        <div class="col-lg-6">
                            <div class="text-center text-lg-start max-w-650 m-auto">
                                <p class="section-subtitle">
                                    @php
                                        $values = json_decode(landingPageSetting($collection,'about_us_details_our_journey_sub_title','[]'),true);
                                    @endphp
                                    @foreach($values as $index => $data)
                                        <span>{{ strtoupper($data) }}</span>
                                        @if($index < count($values) -1 )
                                            <span class="bar"></span>
                                        @endif
                                    @endforeach
                                </p>
                                <h4 class="section-title">{{ landingPageSetting($collection,'about_us_details_our_journey_title','') }}</h4>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="pb-lg-9 max-w-482 m-auto ms-lg-auto text-center text-lg-start">
                                <p class="section-info pt-0 pb-md-34 pb-20 text-para-text">{{ landingPageSetting($collection,'about_us_details_our_journey_details','') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="aboutUs-img-wrap">
                        <div class="row rg-24">
                            <div class="">
                                <div class="aboutUs-img-one"><img src="{{ getFileUrl($aboutUs?->banner_image) }}" alt="" /></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="aboutStatics-wrap">
                    <div class="row rg-24 justify-content-lg-between">
                        <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                            <div class="statistics-item-one">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-1.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ getOption('our_achievement_live_project') ?? 0 }}</h4>
                                    <p class="info">{{__('Project Live')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                            <div class="statistics-item-one">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-2.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ getOption('our_achievement_wining_award') ?? 0 }}</h4>
                                    <p class="info">{{__('Wining Award')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                            <div class="statistics-item-one">
                                <div class="icon"><img src="{{asset('assets/images/icon/statistics-item-3.svg')}}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ getOption('our_achievement_satisfied_clients') ?? 0 }}</h4>
                                    <p class="info">{{__('Satisfied Clients')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-4 col-sm-6 col-6">
                            <div class="statistics-item-one">
                                <div class="icon"><img src="{{ asset('assets/images/icon/statistics-item-4.svg') }}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="title">{{ getOption('our_achievement_years_of_experience') ?? 0 }}</h4>
                                    <p class="info">{{__('Years of Experience')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Advantage -->
    <section class="section-gap bg-bg">
        <div class="container">
            <div class="section-content-wrap bd-b-one bd-c-black-stroke">
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
                            <p class="section-info text-para-text pt-0 pb-md-34 pb-20">{{ landingPageSetting($collection,'about_us_details','') }}</p>
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
            <!--  -->
            <div class="missionVisionGoal-one-wrap">
                <div class="img"><img src="{{ getFileUrl($aboutUs?->image) }}" alt="" /></div>
                <div class="row justify-content-end">
                    <div class="col-xl-7 col-lg-8">
                        <div class="missionVisionGoal-one-content">
                            <ul class="nav nav-pills zTab-reset zTab-four" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-ourMission-tab" data-bs-toggle="pill" data-bs-target="#pills-ourMission" type="button" role="tab" aria-controls="pills-ourMission" aria-selected="true">{{__('Our Mission')}}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-ourVision-tab" data-bs-toggle="pill" data-bs-target="#pills-ourVision" type="button" role="tab" aria-controls="pills-ourVision" aria-selected="false">{{__('Our Vision')}}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-ourGoals-tab" data-bs-toggle="pill" data-bs-target="#pills-ourGoals" type="button" role="tab" aria-controls="pills-ourGoals" aria-selected="false">{{__('Our Goals')}}</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-ourMission" role="tabpanel" aria-labelledby="pills-ourMission-tab" tabindex="0">
                                    <div class="missionVisionGoal-one-innerContent">
                                        <h4 class="title">{{ $aboutUs?->our_mission['title'] }}</h4>
                                        <p class="info">
                                            {!! $aboutUs?->our_mission['details'] !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-ourVision" role="tabpanel" aria-labelledby="pills-ourVision-tab" tabindex="0">
                                    <div class="missionVisionGoal-one-innerContent">
                                        <h4 class="title">{{ $aboutUs?->our_vision['title'] }}</h4>
                                        <p class="info">
                                            {!! $aboutUs?->our_vision['details'] !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-ourGoals" role="tabpanel" aria-labelledby="pills-ourGoals-tab" tabindex="0">
                                    <div class="missionVisionGoal-one-innerContent">
                                        <h4 class="title">{{ $aboutUs?->our_goal['title'] }}</h4>
                                        <p class="info">
                                            {!! $aboutUs?->our_goal['details'] !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    @if(getOption('about_us_our_team_member_status') == STATUS_ACTIVE)
        <section class="section-gap">
            <div class="container">
                <div class="section-content-wrap max-w-576 m-auto">
                    <div class="text-center">
                        <p class="section-subtitle">
                            @php
                                $values = json_decode(landingPageSetting($collection, 'about_us_details_team_member_sub_title', '[]'), true);
                            @endphp
                            @foreach ($values as $index => $value)
                                <span>{{ strtoupper($value) }}</span>
                                @if ($index < count($values) - 1)
                                    <span class="bar"></span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <h4 class="section-title text-center">{{ landingPageSetting($collection,'about_us_details_team_member_title','') }}</h4>
                </div>
                <div class="row rg-xl-54 rg-24 justify-content-center">
                    @if(!empty($aboutUs?->team_member) && is_iterable($aboutUs->team_member))
                        @foreach($aboutUs?->team_member as $data)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="team-member-one">
                                    <div class="imgWrap">
                                        <img src="{{ getFileUrl($data['image']) }}" alt="" />
                                        <ul class="social-icons">
                                            <li>
                                                <a href="{{ $data['facebook'] }}" target="_blank" class="item"><i class="fa-brands fa-facebook-f"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{ $data['linkedin'] }}" target="_blank" class="item"><i class="fa-brands fa-linkedin-in"></i></a>
                                            </li>
                                            <li>
                                                <a href="{{ $data['twitter'] }}" target="_blank" class="item"><i class="fa-brands fa-twitter"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="text-content">
                                        <h4 class="title">{{ $data['title'] }}</h4>
                                        <p class="info">{{ $data['designation'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>{{__('No team members available')}}</p>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- FAQ -->
    @if(getOption('faq_status') == STATUS_ACTIVE)
        <section class="section-faq">
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
@endsection
