@extends('admin.layouts.app')
@push('pageTitle')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-title-text pb-16">{{ __($pageTitle) }}</h4>
            <div class="row rg-20">
                <div class="col-xl-3">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                        @include('admin.themes.partials.sidebar')
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                        <h4 class="fs-18 fw-600 lh-22 text-title-text">{{ $pageTitle }}</h4>
                        <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                              method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                            @csrf
                            <div class="item-top">
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="app_color_design_type"
                                                   class="zForm-label">{{ __('System Color') }}<span class="text-danger"> *</span></label>
                                            <select name="app_color_design_type" id="app_color_design_type"
                                                    class="form-control sf-select-without-search" required>
                                                <option value="{{ DEFAULT_COLOR }}"
                                                    {{ getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR ? 'selected' : '' }}>
                                                    {{ __('Default') }}</option>
                                                <option value="{{ CUSTOM_COLOR }}"
                                                    {{ getOption('app_color_design_type', DEFAULT_COLOR) == CUSTOM_COLOR ? 'selected' : '' }}>
                                                    {{ __('Custom') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-top">
                                <hr>
                            </div>
                            <div class="row rg-20 {{getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR ? 'd-none' : ''}}" id="custom-color-block">
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label">{{ __('Theme / Primary Color') }} <span
                                            class="text-danger"> *</span></label>
                                    <input type="color" name="main_color" value="{{ getOption('main_color') }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label">{{ __('Sidebar Color') }} <span
                                            class="text-danger"> *</span></label>
                                    <input type="color" name="sidebar_color" value="{{ getOption('sidebar_color') }}"
                                           class="form-control">
                                </div>
                                <div class="col-xxl-4 col-lg-6">
                                    <label class="zForm-label">{{ __('Sidebar Active Color') }} <span
                                            class="text-danger"> *</span></label>
                                    <input type="color" name="sidebar_active_color"
                                           value="{{ getOption('sidebar_active_color') }}" class="form-control">
                                </div>
                            </div>

                            <div class="d-flex g-12 flex-wrap mt-25">
                                <button type="submit"
                                        class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{
                                __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('sadmin/js/configuration.js') }}"></script>
@endpush
