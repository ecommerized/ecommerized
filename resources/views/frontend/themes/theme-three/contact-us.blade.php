@extends('frontend.layouts.app')
@push('title')
    {{ __(@$pageTitle) }}
@endpush
@section('content')

    <!-- Breadcrumb -->
    <section class="section-breadcrumb" data-background="assets/images/breadcrumb-one.png">
        <div class="container">
            <div class="section-breadcrumb-content">
                <h4 class="title">{{ $pageTitle }}</h4>
                <ol class="breadcrumb sf-breadcrumb inner-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">{{__('Contact Us')}}</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="section-gap">
        <div class="container">
            <div class="contact-wrap-one">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="contact-one-left">
                            <h4 class="title">{{__('Get in Touch')}}.</h4>
                            <!--  -->
                            <ul class="contact-item-one">
                                <li class="item">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="24" viewBox="0 0 19 24" fill="none">
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M9.69688 22.3039C11.0492 21.0768 12.3008 19.7431 13.4395 18.3156C15.8381 15.302 17.2973 12.3307 17.3961 9.68865C17.4352 8.6149 17.2574 7.54428 16.8735 6.54076C16.4895 5.53723 15.9073 4.62139 15.1614 3.84793C14.4156 3.07448 13.5216 2.45928 12.5327 2.03909C11.5438 1.6189 10.4803 1.40233 9.40587 1.40233C8.33141 1.40233 7.26797 1.6189 6.27907 2.03909C5.29018 2.45928 4.39612 3.07448 3.6503 3.84793C2.90449 4.62139 2.32221 5.53723 1.93827 6.54076C1.55433 7.54428 1.37659 8.6149 1.41567 9.68865C1.51562 12.3307 2.97597 15.302 5.37344 18.3156C6.51217 19.7431 7.76372 21.0768 9.11604 22.3039C9.24616 22.4215 9.34297 22.5069 9.40646 22.5602L9.69688 22.3039ZM8.53871 23.6737C8.53871 23.6737 0 16.4825 0 9.40646C0 6.91171 0.991035 4.51914 2.75509 2.75509C4.51914 0.991035 6.91171 0 9.40646 0C11.9012 0 14.2938 0.991035 16.0578 2.75509C17.8219 4.51914 18.8129 6.91171 18.8129 9.40646C18.8129 16.4825 10.2742 23.6737 10.2742 23.6737C9.79918 24.1111 9.01727 24.1064 8.53871 23.6737ZM9.40646 12.6987C10.2796 12.6987 11.117 12.3519 11.7344 11.7344C12.3519 11.117 12.6987 10.2796 12.6987 9.40646C12.6987 8.5333 12.3519 7.6959 11.7344 7.07848C11.117 6.46106 10.2796 6.1142 9.40646 6.1142C8.5333 6.1142 7.6959 6.46106 7.07848 7.07848C6.46106 7.6959 6.1142 8.5333 6.1142 9.40646C6.1142 10.2796 6.46106 11.117 7.07848 11.7344C7.6959 12.3519 8.5333 12.6987 9.40646 12.6987ZM9.40646 14.1097C8.15909 14.1097 6.9628 13.6142 6.08077 12.7321C5.19875 11.8501 4.70323 10.6538 4.70323 9.40646C4.70323 8.15909 5.19875 6.9628 6.08077 6.08077C6.9628 5.19875 8.15909 4.70323 9.40646 4.70323C10.6538 4.70323 11.8501 5.19875 12.7321 6.08077C13.6142 6.9628 14.1097 8.15909 14.1097 9.40646C14.1097 10.6538 13.6142 11.8501 12.7321 12.7321C11.8501 13.6142 10.6538 14.1097 9.40646 14.1097Z"
                                                fill="#FF521C"
                                            />
                                        </svg>
                                    </div>
                                    <div class="text-content">
                                        <p>{{ getOption('app_location') }}</p>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
                                            <path d="M21.0938 15.1875L19.9007 16.3806L22.0784 18.5625H15.1875C14.2924 18.5625 13.4339 18.9181 12.801 19.551C12.1681 20.184 11.8125 21.0424 11.8125 21.9375C11.8125 22.8326 12.1681 23.691 12.801 24.324C13.4339 24.9569 14.2924 25.3125 15.1875 25.3125H16.875V23.625H15.1875C14.7399 23.625 14.3107 23.4472 13.9943 23.1307C13.6778 22.8143 13.5 22.3851 13.5 21.9375C13.5 21.4899 13.6778 21.0607 13.9943 20.7443C14.3107 20.4278 14.7399 20.25 15.1875 20.25H22.0784L19.899 22.4328L21.0938 23.625L25.3125 19.4062L21.0938 15.1875Z" fill="#FF521C" />
                                            <path d="M8.4375 18.5625H3.375L3.37247 5.82694L13.0199 12.5061C13.161 12.6037 13.3285 12.656 13.5 12.656C13.6715 12.656 13.839 12.6037 13.9801 12.5061L23.625 5.83031V13.5H25.3125V5.0625C25.3121 4.61508 25.1341 4.18612 24.8177 3.86975C24.5014 3.55338 24.0724 3.37545 23.625 3.375H3.375C2.92789 3.375 2.49905 3.55244 2.18265 3.86836C1.86626 4.18428 1.68817 4.61285 1.6875 5.05997V18.5625C1.68817 19.0098 1.86617 19.4387 2.1825 19.755C2.49882 20.0713 2.92765 20.2493 3.375 20.25H8.4375V18.5625ZM21.7679 5.0625L13.5 10.7865L5.23209 5.0625H21.7679Z" fill="#FF521C" />
                                        </svg>
                                    </div>
                                    <div class="text-content">
                                        <p>{{ getOption('app_email') }}</p>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                            <path d="M21 11.375H19.25C19.2493 10.679 18.9725 10.0117 18.4804 9.51961C17.9883 9.02748 17.321 8.75069 16.625 8.75V7C17.7849 7.00139 18.8969 7.46277 19.7171 8.28294C20.5372 9.10311 20.9986 10.2151 21 11.375Z" fill="#FF521C" />
                                            <path d="M24.5 11.375H22.75C22.7481 9.75112 22.1022 8.19428 20.954 7.04602C19.8057 5.89776 18.2489 5.25185 16.625 5.25V3.5C18.7129 3.50232 20.7146 4.33274 22.1909 5.80909C23.6673 7.28544 24.4977 9.28713 24.5 11.375Z" fill="#FF521C" />
                                            <path
                                                d="M22.7499 25.375H22.6012C5.40741 24.3862 2.96616 9.87875 2.62491 5.45125C2.57157 4.75716 2.79613 4.0703 3.24919 3.54176C3.70224 3.01322 4.34669 2.68629 5.04078 2.63288C5.1102 2.62763 5.17991 2.625 5.24991 2.625H9.86116C10.2116 2.62466 10.5542 2.72957 10.8443 2.92614C11.1345 3.12271 11.359 3.40189 11.4887 3.7275L12.8187 7C12.9467 7.3181 12.9785 7.66682 12.91 8.00283C12.8416 8.33884 12.6759 8.64734 12.4337 8.89L10.5699 10.7713C10.8599 12.4262 11.6517 13.9519 12.8382 15.1414C14.0247 16.331 15.5483 17.1269 17.2024 17.4212L19.1012 15.54C19.3475 15.3004 19.6589 15.1386 19.9965 15.0748C20.3342 15.011 20.6832 15.048 20.9999 15.1813L24.2987 16.5025C24.6194 16.6363 24.893 16.8625 25.0847 17.1523C25.2763 17.4422 25.3774 17.7825 25.3749 18.13V22.75C25.3749 23.4462 25.0983 24.1139 24.6061 24.6062C24.1138 25.0984 23.4461 25.375 22.7499 25.375ZM5.24991 4.375C5.135 4.37466 5.02115 4.39695 4.91486 4.4406C4.80857 4.48425 4.71192 4.54842 4.63042 4.62943C4.54893 4.71043 4.48418 4.8067 4.43989 4.91273C4.3956 5.01876 4.37263 5.13247 4.37228 5.24738C4.37228 5.27188 4.37316 5.29608 4.37491 5.32C4.77741 10.5 7.35866 22.75 22.6974 23.625C22.929 23.6389 23.1566 23.5602 23.3302 23.4063C23.5038 23.2524 23.6092 23.0358 23.6232 22.8043L23.6249 22.75V18.13L20.3262 16.8087L17.8149 19.3025L17.3949 19.25C9.78241 18.2963 8.74991 10.6838 8.74991 10.605L8.69741 10.185L11.1824 7.67375L9.86991 4.375H5.24991Z"
                                                fill="#FF521C"
                                            />
                                        </svg>
                                    </div>
                                    <div class="text-content">
                                        <p>{{ getOption('app_contact_number') }}</p>
                                    </div>
                                </li>
                            </ul>
                            <!--  -->
                            <p class="info">{{__('If you would like to work with us or just want to get in touch, we’d love to hear from you')}}!</p>
                            <!--  -->
                            <p class="fs-14 fw-500 lh-24 text-para-text">{{__('It might take 6 -12 hour to replay')}}</p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="contact-one-right">
                            <h4 class="title">{{__('Send Us A Message')}}.</h4>
                            <form class="ajax" action="{{ route('contact-us-store') }}" method="POST" data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                                @csrf
                                <div class="row rg-24">
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control zForm-control-alt bd-ra-12 pl-24" id="inputName" name="name" placeholder="{{__('Enter name')}}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control zForm-control-alt bd-ra-12 pl-24" name="email" id="inputPhoneNumberOrEmail" placeholder="{{__('Enter Email')}}" />
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control zForm-control-alt bd-ra-12 pl-24"  name="message" placeholder="{{__('Your Message')}}"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="sf-btn-primary w-100 justify-content-center">{{__('Submit')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
