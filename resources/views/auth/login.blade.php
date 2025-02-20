@extends('auth.layouts.app')
@push('title')
    {{ __('Login') }}
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
                    <p class="title">{{__('Where Crafting Digital Experiences')}}.</p>
                </div>
            </div>
        </div>
        <div class="sign-up-right-content">
            <div class="wrap">
                <div class="text-content">
                    <h4 class="title">{{__('Sign in to')}} {{getOption('app_name')}}.</h4>
                    <p class="info">{{__("Don’t have an account?")}} <a href="{{ route('register') }}" class="link">{{__('Sign Up')}}</a></p>
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
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="row rg-25 pb-15">
                        <div class="col-md-6">
                            <div class="">
                                <input type="email" name="email" class="form-control zForm-control" id="inputPhoneEmail" placeholder="Your email address" />
                                @error('email')
                                <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <input type="password" name="password" class="form-control zForm-control" id="inputPassword" placeholder="Password" />
                                @error('password')
                                <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="remeberForgot">
                        <a href="{{ route('password.request') }}" class="forgotPass">{{__('Forget Password')}}?</a>
                    </div>
                    <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                    <button type="submit" class="submitButton">{{__('Sign In')}}</button>
                </form>
                @if (env('LOGIN_HELP') == 'active')
                    <div class="row pt-12 fs-14">
                        <div class="col-md-12 mb-25">
                            <div class="table-responsive login-info-table mt-3">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td colspan="2" id="adminCredentialShow" class="login-info">
                                            <b>{{ __('Admin ') }}:</b> {{ __('admin@gmail.com') }} | 123456
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="tmemberCredentialShow" class="login-info">
                                            <b>{{ __('Team Member ') }}:</b> {{ __('team-member@gmail.com') }} |
                                            123456
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="clientCredentialShow" class="login-info">
                                            <b>{{ __('Client ') }}:</b> {{ __('client@gmail.com') }} | 123456
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script>
        "use strict"
        $('#adminCredentialShow').on('click', function() {
            $('#inputPhoneEmail').val('admin@gmail.com');
            $('#inputPassword').val('123456');
        });
        $('#tmemberCredentialShow').on('click', function() {
            $('#inputPhoneEmail').val('team-member@gmail.com');
            $('#inputPassword').val('123456');
        });
        $('#clientCredentialShow').on('click', function() {
            $('#inputPhoneEmail').val('client@gmail.com');
            $('#inputPassword').val('123456');
        });

    </script>
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
