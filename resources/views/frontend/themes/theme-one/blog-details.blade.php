@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="section-breadcrumb" data-background="{{asset('assets/images/breadcrumb-one.png')}}">
        <div class="container">
            <div class="section-breadcrumb-content">
                <h4 class="title">{{ $pageTitle }}</h4>
                <ol class="breadcrumb sf-breadcrumb inner-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog-list') }}">{{__('Blog List') }}</a></li>
                    <li class="breadcrumb-item">{{ $blogDetails->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Blog Details -->
    <section class="section-gap">
        <div class="container">
            <div class="row rg-24">
                <div class="col-lg-8">
                    <div class="blog-details">
                        <div class="thumbnail"><img src="{{ getFileUrl($blogDetails->banner_image) }}" alt="" /></div>
                        <div class="authorDate">
                            <div class="author">
                                <div class="img"><img src="{{ getFileUrl($blogDetails->image) }}" alt="" /></div>
                                <div class="text-content">
                                    <h4 class="name">{{ $blogDetails->name }}</h4>
                                    <p class="info">{{ $blogDetails->designationTitle }}</p>
                                </div>
                            </div>
                            <!--  -->
                            <div class="dateWrap">
                                <p>{{ \Carbon\Carbon::parse($blogDetails->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="innerContent">
                            <div class="blockItem">
                                <h4 class="title max-w-576">{{ $blogDetails->title }}</h4>
                                <div class="text-content">
                                   {!! $blogDetails->details !!}
                                </div>
                            </div>
                            <div class="blogShare">
                                <h4 class="title">{{__('SHARES')}}:</h4>
                                <ul class="d-flex justify-content-start align-items-center g-12">
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url={{ (route('blog-details', $blogDetails->slug)) }}" class="blog-social-link" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none">
                                                <path
                                                    d="M17.4702 1.71279C16.8341 1.99416 16.1593 2.17904 15.4686 2.26116C16.1967 1.82566 16.7416 1.14029 17.0018 0.332786C16.3186 0.739536 15.5693 1.02454 14.7886 1.17866C14.2641 0.617411 13.5688 0.245285 12.8109 0.11991C12.0532 -0.0053395 11.2752 0.123161 10.5979 0.485661C9.92069 0.848161 9.38219 1.42416 9.06619 2.12429C8.75006 2.82441 8.67419 3.60929 8.85019 4.35704C7.46444 4.28754 6.10881 3.92741 4.87131 3.30004C3.63369 2.67266 2.54194 1.79204 1.66681 0.715286C1.35711 1.24741 1.19434 1.85216 1.1952 2.46779C1.1952 3.67616 1.81019 4.74366 2.74519 5.36866C2.19194 5.35116 1.65069 5.20179 1.16688 4.93279V4.97616C1.16704 5.78091 1.44551 6.56079 1.95506 7.18366C2.46469 7.80654 3.17394 8.23403 3.96269 8.39366C3.44906 8.53278 2.91044 8.55341 2.38769 8.45366C2.61006 9.14629 3.04356 9.75216 3.62731 10.1863C4.21119 10.6203 4.91619 10.8609 5.64356 10.8744C4.92056 11.4423 4.09281 11.8619 3.20756 12.1097C2.32231 12.3573 1.39698 12.428 0.484375 12.3178C2.07744 13.3423 3.93194 13.8863 5.82606 13.8844C12.2368 13.8844 15.7427 8.57366 15.7427 3.96779C15.7427 3.81779 15.7386 3.66616 15.7318 3.51779C16.4143 3.02466 17.0023 2.41279 17.4702 1.71279Z"
                                                    fill="white"
                                                />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ (route('blog-details', $blogDetails->slug)) }}" class="blog-social-link" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                                <path
                                                    d="M3.78447 2.16656C3.78435 2.60856 3.60847 3.03244 3.29572 3.34481C2.9831 3.65719 2.5591 3.83256 2.11697 3.83231C1.67497 3.83219 1.2511 3.65631 0.938723 3.34356C0.626348 3.03094 0.450947 2.60694 0.451172 2.16481C0.451397 1.72281 0.627222 1.29894 0.939972 0.986561C1.2526 0.674186 1.6766 0.498799 2.11872 0.499024C2.56072 0.499236 2.9846 0.67506 3.29697 0.98781C3.60935 1.30044 3.78472 1.72443 3.78447 2.16656ZM3.83447 5.06656H0.501172V15.4998H3.83447V5.06656ZM9.10122 5.06656H5.78447V15.4998H9.06785V10.0248C9.06785 6.97481 13.0428 6.69156 13.0428 10.0248V15.4998H16.3345V8.89156C16.3345 3.74981 10.4512 3.94156 9.06785 6.46656L9.10122 5.06656Z"
                                                    fill="white"
                                                />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/sharer.php?u={{ (route('blog-details', $blogDetails->slug)) }}" target="_blank"  class="blog-social-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path
                                                    d="M8.99836 0.667969C11.2625 0.667969 11.545 0.676306 12.4334 0.717969C13.3209 0.759644 13.925 0.898806 14.4567 1.10547C15.0067 1.31714 15.47 1.60381 15.9334 2.06631C16.3572 2.48289 16.685 2.98679 16.8942 3.54297C17.1 4.07381 17.24 4.67881 17.2817 5.56631C17.3209 6.45464 17.3317 6.73714 17.3317 9.00131C17.3317 11.2655 17.3234 11.548 17.2817 12.4364C17.24 13.3239 17.1 13.928 16.8942 14.4596C16.6857 15.0161 16.3577 15.5201 15.9334 15.9364C15.5167 16.3599 15.0128 16.6877 14.4567 16.8971C13.9259 17.103 13.3209 17.243 12.4334 17.2846C11.545 17.3239 11.2625 17.3346 8.99836 17.3346C6.7342 17.3346 6.4517 17.3264 5.56336 17.2846C4.67586 17.243 4.0717 17.103 3.54004 16.8971C2.98364 16.6884 2.47964 16.3604 2.06336 15.9364C1.63954 15.5197 1.31164 15.0159 1.10254 14.4596C0.895864 13.9289 0.756702 13.3239 0.715039 12.4364C0.675864 11.548 0.665039 11.2655 0.665039 9.00131C0.665039 6.73714 0.673364 6.45464 0.715039 5.56631C0.756702 4.67797 0.895864 4.07464 1.10254 3.54297C1.31106 2.98646 1.63904 2.48241 2.06336 2.06631C2.47976 1.64233 2.98373 1.31442 3.54004 1.10547C4.0717 0.898806 4.67504 0.759644 5.56336 0.717969C6.4517 0.678806 6.7342 0.667969 8.99836 0.667969ZM8.99836 4.83464C7.8933 4.83464 6.83349 5.27363 6.05209 6.05503C5.27069 6.83643 4.8317 7.89624 4.8317 9.00131C4.8317 10.1064 5.27069 11.1662 6.05209 11.9476C6.83349 12.729 7.8933 13.168 8.99836 13.168C10.1034 13.168 11.1633 12.729 11.9447 11.9476C12.726 11.1662 13.165 10.1064 13.165 9.00131C13.165 7.89624 12.726 6.83643 11.9447 6.05503C11.1633 5.27363 10.1034 4.83464 8.99836 4.83464ZM14.415 4.62631C14.415 4.35004 14.3053 4.08509 14.1099 3.88974C13.9145 3.69439 13.6497 3.58464 13.3734 3.58464C13.0972 3.58464 12.8322 3.69439 12.6368 3.88974C12.4414 4.08509 12.3317 4.35004 12.3317 4.62631C12.3317 4.90258 12.4414 5.16753 12.6368 5.36288C12.8322 5.55823 13.0972 5.66798 13.3734 5.66798C13.6497 5.66798 13.9145 5.55823 14.1099 5.36288C14.3053 5.16753 14.415 4.90258 14.415 4.62631ZM8.99836 6.50131C9.66141 6.50131 10.2973 6.76471 10.7661 7.23354C11.235 7.70238 11.4984 8.33827 11.4984 9.00131C11.4984 9.66436 11.235 10.3002 10.7661 10.7691C10.2973 11.2379 9.66141 11.5014 8.99836 11.5014C8.33533 11.5014 7.69944 11.2379 7.2306 10.7691C6.76176 10.3002 6.49836 9.66436 6.49836 9.00131C6.49836 8.33827 6.76176 7.70238 7.2306 7.23354C7.69944 6.76471 8.33533 6.50131 8.99836 6.50131Z"
                                                    fill="white"
                                                />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ (route('blog-details', ['slug' => $blogDetails->slug])) }}" class="blog-social-link" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="18" viewBox="0 0 10 18" fill="none">
                                                <path d="M6.66345 10.2504H8.7467L9.58008 6.91702H6.66345V5.25039C6.66345 4.39202 6.66345 3.58364 8.33008 3.58364H9.58008V0.783667C9.30845 0.74783 8.28258 0.666992 7.1992 0.666992C4.9367 0.666992 3.33008 2.04789 3.33008 4.58364V6.91702H0.830078V10.2504H3.33008V17.3336H6.66345V10.2504Z" fill="white" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="item">
                            <h4 class="title">{{__('Popular Post')}}</h4>
                            <ul class="blog-popularPost">
                                @foreach($popularPost as $data)
                                    <li>
                                        <a href="{{ route('blog-details',$data->slug) }}" class="item">
                                            <div class="img"><img src="{{ getFileUrl($data->banner_image) }}" alt="" /></div>
                                            <div class="text-content">
                                                <h4 class="title">{{ $data->title }}</h4>
                                                <p class="date">{{ \Carbon\Carbon::parse($data->created_at)->format('M d, Y') }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
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
