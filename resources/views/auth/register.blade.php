@extends('auth.layouts.app')

@push('title')
{{ __('Registration') }}
@endpush

@section('content')
    <!-- Main Content -->
    <section class="sign-up-page">
        <div class="sign-up-left-content">
            <div class="wrap" data-background="{{ getFileUrl(getOption('auth_page_image')) }}">
                <div class="content">
                    <div class="logo">
                        <a href="{{ route('frontend') }}"><img src="{{ getFileUrl(getOption('app_logo_white')) }}" alt="logo" /></a>
                    </div>
                    <p class="title">{{__('Where Crafting Digital Experiences')}}</p>
                </div>
            </div>
        </div>
        <div class="sign-up-right-content">
            <div class="wrap">
                <div class="text-content">
                    <h4 class="title">{{__('Sign Up to')}} {{getOption('app_name')}}.</h4>
                    <p class="info">{{__('Already have an account')}}? <a href="{{route('login')}}" class="link">{{__('Sign In')}}</a></p>
                </div>
                @if (getOption('google_login_status') == 1 || getOption('facebook_login_status') == 1)
                    <div class="otherAuthWrap">
                        <ul class="authList">
                            @if (getOption('facebook_login_status') == 1)
                                <li>
                                    <a href="{{ route('facebook-login') }}" class="item">
                                        <img src="{{asset('assets/images/Facebook-Logo.svg')}}" alt="" />
                                        <span>{{__('Sign Up with Facebook')}}</span>
                                    </a>
                                </li>
                            @endif
                            @if (getOption('google_login_status') == 1)
                                <li>
                                    <a href="{{ route('google-login') }}" class="item">
                                        <img src="{{asset('assets/images/Google-Logo.svg')}}" alt="" />
                                        <span>{{__('Sign Up with Google')}}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <p class="text"><span>{{__('Or Continue With')}}</span></p>
                    </div>
                @endif
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="row rg-25 pb-15">
                        <div class="col-md-6">
                            <div class="">
                                <input type="text" name="name" class="form-control zForm-control" id="inputYourName" placeholder="{{__('Your name')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <input type="email" name="email" class="form-control zForm-control" id="inputPhoneNumberOrEmail" placeholder="{{__('Your email address')}}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="">
                                <input type="password" name="password" class="form-control zForm-control" id="inputPassword" placeholder="{{__('Password')}}" />
                            </div>
                        </div>
                    </div>
                    <div class="remeberForgot">
                        <div class="zForm-wrap-checkbox rememberMe-checkbox">
                            <input type="checkbox" class="form-check-input" id="rememberMe" />
                            <label for="rememberMe">{{__('I agree to all the')}} <a href="#" class="link">{{__('Terms & Conditions')}}.</a></label>
                        </div>
                    </div>
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button type="submit" class="submitButton">{{__('Sign Up')}}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('script')
    @if (!empty(getOption('google_recaptcha_status')) && getOption('google_recaptcha_status') == 1)
        <script
            src="https://www.google.com/recaptcha/api.js?render={{ getOption('google_recaptcha_site_key') }}"></script>
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ getOption('google_recaptcha_site_key') }}', {action: 'submit'}).then(function (token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
        </script>
    @endif
@endpush
