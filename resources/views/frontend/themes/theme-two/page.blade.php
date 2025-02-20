@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="section-breadcrumb" data-background="assets/images/breadcrumb-one.png">
        <div class="container">
            <div class="section-breadcrumb-content">
                <h4 class="title">{{ $pageData->title }}</h4>
                <ol class="breadcrumb sf-breadcrumb inner-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">{{ $pageData->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <!--  -->
    <section class="section-gap">
        <div class="container">
            <div class="section-innerWrap">
                <div class="blockItem">
                    <h4 class="title">{{ $pageData->title }}</h4>
                    <div class="text-content">
                        {!! $pageData->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>


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
