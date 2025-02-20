<!-- Header -->
<div
    class="ld-header-section @if(request()->route()->getName() == 'frontend') {{ getOption('app_theme_style') == THEME_HOME_TWO ? 'ld-header-section-two' : (getOption('app_theme_style') == THEME_HOME_THREE ? 'ld-header-section-three' : '')}} @else ld-header-inner @endif">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-6">
                @if(getOption('app_theme_style') == THEME_HOME_ONE)
                    <a href="{{ route('frontend') }}" class="ld-header-logo"><img
                            src="{{ getFileUrl(getOption('app_logo_white')) }}" alt=""/></a>
                @else
                    <a href="{{ route('frontend') }}" class="ld-header-logo">
                        @if(request()->route()->getName() == 'frontend')
                            <img src="{{ getFileUrl(getOption('app_logo_black')) }}" alt=""/>
                        @else
                            <img src="{{ getFileUrl(getOption('app_logo_white')) }}" alt=""/>
                        @endif
                    </a>
                @endif
            </div>
            <div class="col-lg-8 col-6">
                <nav class="navbar navbar-expand-lg p-0">
                    <button class="navbar-toggler menu-navbar-toggler bd-c-black-color ms-auto" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="navbar-collapse menu-navbar-collapse offcanvas offcanvas-start" tabindex="-1"
                         id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <button type="button"
                                class="d-lg-none w-30 h-30 p-0 rounded-circle bg-white border-0 position-absolute top-10 right-10"
                                data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-times"></i>
                        </button>
                        <ul class="navbar-nav menu-navbar-nav @if(request()->route()->getName() == 'frontend') {{ getOption('app_theme_style') == THEME_HOME_TWO || getOption('app_theme_style') == THEME_HOME_THREE ? 'menu-navbar-nav-two' : '' }}  @endif justify-content-center flex-wrap cg-35 rg-10 w-100">
                            @if(env('LOGIN_HELP') == 'active')
                                <li class="nav-item dropdown d-none d-lg-block">
                                    <a class="nav-link fs-16 fw-500 lh-26 text-white p-0 dropdown-toggle menu-dropdown-toggle "
                                       href="#" role="button" data-bs-toggle="dropdown"
                                       aria-expanded="false">{{__('Home')}}</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ getOption('app_theme_style') == THEME_HOME_ONE ? route('frontend') : 'https://design-agency-zaiscrip.zainikthemes.com' }}">{{ __('Design Agency')  }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ getOption('app_theme_style') == THEME_HOME_TWO ? route('frontend') : 'https://dev-agency-zaiscrip.zainikthemes.com' }}">{{ __('Dev Agency')  }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ getOption('app_theme_style') == THEME_HOME_THREE ? route('frontend') : 'https://marketing-agency-zaiscrip.zainikthemes.com' }}">{{ __('Marketing Agency')  }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link fs-16 fw-500 lh-26 text-white p-0"
                                       href="{{ route('frontend') }}">{{__('Home')}}</a>
                                </li>
                            @endif
                            <li class="nav-item"><a
                                    class="nav-link fs-16 fw-500 lh-26 text-white p-0 {{@$activeAboutUs}}"
                                    href="{{ route('about-us') }}">{{__('About')}}</a></li>
                            <li class="nav-item"><a
                                    class="nav-link fs-16 fw-500 lh-26 text-white p-0 {{@$activeService}}"
                                    href="{{url('')}}#serviceSection">{{__('Services')}}</a></li>
                            <li class="nav-item"><a
                                    class="nav-link fs-16 fw-500 lh-26 text-white p-0 {{@$activePortfolio}}"
                                    href="{{url('')}}#portfolioSection">{{__('Portfolio')}}</a></li>
                            <li class="nav-item"><a class="nav-link fs-16 fw-500 lh-26 text-white p-0 {{@$activeBlog}}"
                                                    href="{{ route('blog-list') }}">{{__('Blog')}}</a></li>
                            <li class="nav-item"><a
                                    class="nav-link fs-16 fw-500 lh-26 text-white p-0 {{@$activeContactUs}}"
                                    href="{{route('contact-us')}}">{{__('Contact Us')}}</a></li>
                            <li class="nav-item dropdown d-none d-lg-block">
                                <a class="nav-link fs-16 fw-500 lh-26 text-white p-0 dropdown-toggle menu-dropdown-toggle {{@$activePage}}"
                                   href="#" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">{{__('Pages')}}</a>
                                <ul class="dropdown-menu">
                                    @foreach(pageModalData() as $data)
                                        <li><a class="dropdown-item"
                                               href="{{ route('page',$data->slug) }}">{{ $data->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item d-lg-none"><a
                                    class="d-inline-flex py-8 px-30 bg-white fs-16 fw-500 lh-26 text-button rounded-pill"
                                    href="{{ route('login') }}">
                                    @auth()
                                        {{__('Dashboard')}}
                                    @else
                                        {{__('Sign Up')}}
                                    @endif
                                </a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-lg-2 d-none d-lg-block text-end">
                <a href="{{ route('login') }}" class="sf-btn-primary">
                    @auth()
                        {{__('Dashboard')}}
                    @else
                        {{__('Sign Up')}}
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
