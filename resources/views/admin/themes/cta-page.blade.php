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
                    <h4 class="fs-18 fw-600 lh-22 text-title-text">{{ $pageTitle }}</h4>
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="item-top">
                            <hr>
                        </div>
                        <div class="row rg-20">
                            <div class="col-12">
                                <label for="label" class="zForm-label-alt">{{ __('Sub Title') }}</label>
                                <input type="hidden" name="cta_footer_sub_title" value="[]">
                                <select class="primary-form-control sf-select-modal-label" multiple name="cta_footer_sub_title[]">
                                    @php
                                        $ctaFooterSubTitle = json_decode(getOption('cta_footer_sub_title'), true);
                                    @endphp

                                    @if (is_array($ctaFooterSubTitle))
                                        @foreach($ctaFooterSubTitle as $data)
                                            <option value="{{ $data }}" selected>{{ $data }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col-12">
                                <label class="zForm-label">{{ __('Cta footer title') }}</label>
                                <input type="text" class="form-control zForm-control" name="cta_footer_title"
                                       placeholder="{{ __('Type cta footer title') }}" value="{{ getOption('cta_footer_title') }}">
                            </div>
                            <div class="col-12">
                                <label class="zForm-label">{{ __('Cta footer description') }}</label>
                                <textarea class="form-control zForm-control" placeholder="{{__('Type cta footer description')}}" name="cta_footer_description" rows="4" cols="50">{{ getOption('cta_footer_description') }}</textarea>
                            </div>
                            @if(getOption('app_theme_style') != THEME_HOME_THREE)
                                <div class="col-12">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12"><img
                                                        src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="zForm-label">{{ __('Cta footer image') }} <span
                                                    class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                                            <div class="upload-img-box">
                                                @if (getOption('cta_footer_image'))
                                                    <img src="{{ getSettingImage('cta_footer_image') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="cta_footer_image" accept="image/*"
                                                       onchange="previewFile(this)" />
                                            </div>
                                            <span
                                                class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 750 px / 400 px")}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
@endsection
@push('script')
    <script src="{{ asset('admin/theme/js/cta.js') }}"></script>
@endpush
