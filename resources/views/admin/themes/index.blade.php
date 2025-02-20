@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="row rg-20">
            <div class="col-xl-3">
                <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                    @include('admin.themes.partials.sidebar')
                </div>
            </div>
            <div class="col-xl-9">
                <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                    <div class="d-flex justify-content-between align-items-center g-10 bd-b-one bd-c-stroke pb-20 mb-20">
                        <h4 class="fs-18 fw-600 lh-22 text-title-text">{{ $pageTitle }}</h4>
                        <a href="{{ route('frontend') }}" target="_blank" class="py-10 px-26 bg-badge-open-text bd-ra-8 fs-15 fw-600 lh-25 text-white">View Site</a>
                    </div>
                    <form class="ajax" action="{{ route('admin.setting.themes-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf

                        <div class="row rg-24">
                            <div class="col-lg-6">
                                <div class="d-flex flex-column rg-20">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="app_theme_style" class="zForm-label">{{ __('Choose Theme') }}</label>
                                            <select name="app_theme_style" id="app_theme_style"
                                                    class="nice-select sf-select-without-search" required>
                                                <option value="{{ THEME_HOME_ONE }}"
                                                    {{ getOption('app_theme_style', THEME_HOME_ONE) == THEME_HOME_ONE ? 'selected' : '' }}>
                                                    {{ __('Design Agency') }}
                                                </option>
                                                <option value="{{ THEME_HOME_TWO }}"
                                                    {{ getOption('app_theme_style', THEME_HOME_TWO) == THEME_HOME_TWO ? 'selected' : '' }}>
                                                    {{ __('Development Agency') }}
                                                </option>
                                                <option value="{{ THEME_HOME_THREE }}"
                                                    {{ getOption('app_theme_style', THEME_HOME_THREE) == THEME_HOME_THREE ? 'selected' : '' }}>
                                                    {{ __('Marketing Agency') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Update') }}</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="primary-form-group theme-img-preview bd-one bd-c-stroke bd-ra-8 overflow-hidden bg-frame">
                                    <img class="theme-img {{ getOption('app_theme_style', THEME_HOME_ONE) == THEME_HOME_ONE ? '' : 'd-none' }}"
                                         id="theme-{{ THEME_HOME_ONE }}"
                                         src="{{ asset('assets/images/themes/theme-1.png') }}"
                                         alt="Theme 1">
                                    <img class="theme-img {{ getOption('app_theme_style', THEME_HOME_TWO) == THEME_HOME_TWO ? '' : 'd-none' }}"
                                         id="theme-{{ THEME_HOME_TWO }}"
                                         src="{{ asset('assets/images/themes/theme-2.png') }}"
                                         alt="Theme 2">
                                    <img class="theme-img {{ getOption('app_theme_style', THEME_HOME_THREE) == THEME_HOME_THREE ? '' : 'd-none' }}"
                                         id="theme-{{ THEME_HOME_THREE }}"
                                         src="{{ asset('assets/images/themes/theme-3.png') }}"
                                         alt="Theme 3">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="activity-log-history-route" value="{{ route('admin.setting.activity-log.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/theme/js/theme.js') }}"></script>
@endpush
