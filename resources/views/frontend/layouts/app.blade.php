<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('user.layouts.header')

<body class="{{ selectedLanguage()->rtl == 1 ? 'direction-rtl' : 'direction-ltr' }} {{ getOption('app_theme_style') == THEME_HOME_TWO ? 'theme-two' : (getOption('app_theme_style') == THEME_HOME_THREE ? 'theme-three' : '')}} {{ !(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR) ? 'custom-color' : '' }}">
<input type="hidden" id="lang_code" value="{{session('local')}}">
@if (getOption('app_preloader_status', 0) == STATUS_ACTIVE)
    <div id="preloader">
        <div id="preloader_status">
            <img src="{{ getSettingImage('app_preloader') }}" alt="{{ getOption('app_name') }}"/>
        </div>
    </div>
@endif

@include('frontend.layouts.nav')
@yield('content')
@include('frontend.layouts.footer')

@if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
@endif
@include('user.layouts.script')
</body>

</html>
