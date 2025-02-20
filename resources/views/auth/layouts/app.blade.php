<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.header')

<body class="{{ getOption('app_theme_style') == THEME_HOME_TWO ? 'theme-two' : (getOption('app_theme_style') == THEME_HOME_THREE ? 'theme-three' : '')}}  {{ !(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR) ? 'custom-color' : '' }}">
<!-- Main Content -->
@yield('content')

<!-- js file  -->
@include('admin.layouts.script')
</body>
</html>
