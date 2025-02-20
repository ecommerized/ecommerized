@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')

<!-- Breadcrumb -->
<section class="section-breadcrumb" data-background="{{ asset('assets/images/breadcrumb-one.png') }}">
    <div class="container">
        <div class="section-breadcrumb-content">
            <h4 class="title">{{ $pageTitle }}</h4>
            <ol class="breadcrumb sf-breadcrumb inner-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend') }}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog-list') }}">{{__('Blog List')}}</a></li>
            </ol>
        </div>
    </div>
</section>

<!-- Blog Items -->
<section class="section-gap">
    <div class="container">
        <div class="blog-items-wrap">
            <div class="row">
                @foreach($blogData as $data)
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
                            <span class="img"><img src="{{ getFileUrl($data->banner_image) }}" alt="" /></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="blog-pagination">
            {{ $blogData->links('user.layouts.partial.common_pagination')}}
        </ul>
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
