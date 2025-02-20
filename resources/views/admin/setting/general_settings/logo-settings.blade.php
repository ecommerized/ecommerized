@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>
            <div class="row rg-20">
                <div class="col-xl-3">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                        @include('admin.setting.sidebar')
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                        <h4 class="fs-18 fw-600 lh-22 text-title-text bd-b-one bd-c-black-stroke mb-25 pb-25">{{ $pageTitle }}
                        </h4>
                        <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                            method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                            @csrf
                            <div class="row rg-15">
                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="form-label">{{ __('App Preloader') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('app_preloader'))
                                                    <img src="{{ getSettingImage('app_preloader') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="app_preloader" id="zImageUpload"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_preloader'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_preloader') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                    </p>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop file shere') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="form-label">{{ __('App Logo White') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('app_logo_white'))
                                                    <img src="{{ getSettingImage('app_logo_white') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="app_logo_white" id="zImageUpload"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_logo') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                    </p>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop file shere') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="form-label">{{ __('App Logo Black') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('app_logo_black'))
                                                    <img src="{{ getSettingImage('app_logo_black') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="app_logo_black" id="zImageUpload"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_logo') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            140 x 40
                                        </span>
                                    </p>
                                </div>

                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="form-label">{{ __('App Fav Icon') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('app_fav_icon'))
                                                    <img src="{{ getSettingImage('app_fav_icon') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="app_fav_icon" id="zImageUpload"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('app_fav_icon'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('app_fav_icon') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            16 x 16
                                        </span>
                                    </p>
                                </div>

                                <div class="col-xl-3 col-md-4 col-sm-6">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="zImageUpload" class="form-label">{{ __('Auth Page Image') }}</label>
                                            <div class="upload-img-box">
                                                @if (getOption('auth_page_image'))
                                                    <img src="{{ getSettingImage('auth_page_image') }}" />
                                                @else
                                                    <img src="" />
                                                @endif
                                                <input type="file" name="auth_page_image" id="zImageUpload"
                                                    accept="image/*,video/*" onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('auth_page_image'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                            {{ $errors->first('auth_page_image') }}</span>
                                    @endif
                                    <p>
                                        <span class="text-black">
                                            <span class="text-black">{{ __('Recommend Size') }}:</span>
                                            800 x 900
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex g-12 flex-wrap mt-25">
                                <button type="submit"
                                    class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{ __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
