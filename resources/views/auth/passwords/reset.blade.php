@extends('auth.layouts.app')
@push('title')
    {{ __('Reset Password') }}
@endpush
@section('content')


    <!-- Main Content -->
    <section class="sign-up-page">
        <div class="sign-up-left-content">
            <div class="wrap" data-background="{{getFileUrl(getOption('auth_page_image'))}}">
                <div class="content">
                    <div class="logo">
                        <a href="{{ route('frontend') }}"><img src="{{getFileUrl(getOption('app_logo_white'))}}" alt="logo" /></a>
                    </div>
                    <p class="title">{{__('Where Crafting Digital Experiences')}}</p>
                </div>
            </div>
        </div>
        <div class="sign-up-right-content">
            <div class="wrap">
                <div class="text-content">
                    <h4 class="title">{{__('Forget Password')}}</h4>
                    <p class="info">{{__('Remember Password?')}} <a href="{{route('login')}}" class="link">{{__('Sign In')}}</a></p>
                </div>
                <form method="post" action="{{ route('password.update', $token) }}">
                    @csrf
                    <div class="pb-20">
                        <label for="inputEmailAddress" class="zForm-label">{{ __('Email Address') }}</label>
                        <input type="email" class="form-control zForm-control" id="inputEmailAddress"
                               value="{{ $email }}" name="email" placeholder="{{ __('Enter email address') }}"
                               readonly />
                        @error('email')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="pb-20">
                        <label for="inputNewPassword" class="zForm-label">{{ __('New Password') }}</label>
                        <input type="password" class="form-control zForm-control" id="inputNewPassword"
                               placeholder="{{ __('Enter new password') }}" value="{{ old('password') }}"
                               name="password" />
                        @error('password')
                        <span class="fs-12 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="pb-30">
                        <label for="inputConfirmPassword" class="zForm-label">{{ __('Confirm Password') }}</label>
                        <input type="password" class="form-control zForm-control" id="inputConfirmPassword"
                               placeholder="{{ __('Enter confirm password') }}" name="password_confirmation" />
                    </div>
                    <button type="submit"
                            class="submitButton">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
