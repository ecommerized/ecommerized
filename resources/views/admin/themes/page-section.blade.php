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
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="row">
                            <div class="">
                                <h4 class="fs-18 fw-600 lh-22 text-title-text">{{__('Terms & Services Page')}}</h4>
                            </div>
                            <div class="item-top">
                                <hr>
                            </div>
                            <div>
                                <label class="zForm-label-alt ">{{ __('Terms & services page title') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="terms_services_page_title" value="{{ getOption('terms_services_page_title') }}" placeholder="{{__('Type terms & services page title')}}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="pt-15">
                                <label class="zForm-label-alt">{{ __('Terms & services page details') }} <span
                                        class="text-danger">*</span></label>
                                <textarea class="summernoteOne" name="terms_services_page_details" placeholder="{{__('Type terms & services page details')}}">{!! getOption('terms_services_page_details') !!}</textarea>
                            </div>
                            <div class="align-items-center d-flex justify-content-between pb-sm-30 pt-30">
                                <h4 class="fs-18 fw-600 lh-22 text-title-text">{{__('Refund Policy Page')}}</h4>
                            </div>
                            <div class="item-top">
                                <hr>
                            </div>
                            <div class="">
                                <label class="zForm-label-alt">{{ __('Type refund policy page Title') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="refund_policy_page_title" value="{{ getOption('refund_policy_page_title') }}" placeholder="{{__('Type refund policy page Title')}}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="pt-15">
                                <div class="">
                                    <label class="zForm-label-alt">{{ __('Refund Policy Page Details') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="summernoteOne" name="refund_policy_page_details" placeholder="{{__('Type refund policy page details')}}" >{!! getOption('refund_policy_page_details') !!}</textarea>
                                </div>
                            </div>
                            <div class="align-items-center d-flex justify-content-between pb-sm-30 pt-30">
                                <h4 class="fs-18 fw-600 lh-22 text-title-text">{{__('Privacy Policy Page')}}</h4>
                            </div>
                            <div class="item-top">
                                <hr>
                            </div>
                            <div class="">
                                <label class="zForm-label-alt">{{ __('Privacy policy page title') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="privacy_policy_page_title" value="{{ getOption('privacy_policy_page_title') }}" placeholder="{{__('Type privacy policy page title')}}"
                                       class="form-control zForm-control">
                            </div>
                            <div class="pt-15">
                                <div class="">
                                    <label class="zForm-label-alt">{{ __('Privacy policy page details') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="summernoteOne" name="privacy_policy_page_details" placeholder="{{__('Type privacy policy page details')}}">{!! getOption('privacy_policy_page_details') !!}</textarea>
                                </div>
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
    <input type="hidden" id="activity-log-history-route" value="{{ route('admin.setting.activity-log.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/activity-log.js') }}"></script>
@endpush
