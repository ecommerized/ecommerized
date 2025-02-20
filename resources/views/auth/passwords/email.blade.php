@extends('auth.layouts.app')

@push('title')
    {{ __('Forget Password') }}
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
                <form method="post" action="{{ route('password.email') }}">
                    @csrf
                    <div class="row rg-25 pb-24">
                        <div class="col-12">
                            <div class="">
                                <input type="email" name="email" class="form-control zForm-control" id="inputPhoneNumberOrEmail" placeholder="{{__('Your email address')}}" value="{{ old('email') }}" />
                                @error('email')
                                <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submitButton">{{__('Get Code')}}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
