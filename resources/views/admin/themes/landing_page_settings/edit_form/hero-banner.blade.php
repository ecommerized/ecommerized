<div class="email-inbox__area">
    <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
        <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Hero Banner Area') }}</h2>
        <button type="button" class="bd-one bd-c-black-stroke rounded-circle w-25 h-25 bg-transparent text-para-text"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>

    <form class="ajax" action="{{ route('admin.setting.configuration-landing-page-settings.update') }}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
        @csrf
        <div class="row rg-20">
            <div class="col-lg-6 col-xl-6">
                <label for="label" class="zForm-label-alt">{{ __('Sub Title') }}</label>
                <input type="hidden" name="hero_banner_sub_title" value="">
                <select class="primary-form-control sf-select-edit-modal" multiple name="hero_banner_sub_title[]">
                    @php
                        $subTitles = json_decode(landingPageSetting($collection, 'hero_banner_sub_title') ?? '');
                    @endphp
                    @if (!empty($subTitles) && is_array($subTitles))
                        @foreach ($subTitles as $subtitle)
                            <option value="{{ $subtitle }}" selected>{{ $subtitle }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-lg-6 col-xl-6">
                <label class="zForm-label-alt">{{ __('Title') }}</label>
                <input type="text" name="hero_banner_title"
                       value="{{ landingPageSetting($collection, 'hero_banner_title') }}"
                       class="form-control zForm-control">
            </div>
            <div class="col-12">
                <label class="zForm-label-alt">{{ __('Details') }}</label>
                <textarea class="form-control zForm-control"  name="hero_banner_details" rows="6" cols="50">{{ landingPageSetting($collection,'hero_banner_details') }}</textarea>
            </div>
            @if((getOption('app_theme_style') == THEME_HOME_TWO) || (getOption('app_theme_style') == THEME_HOME_THREE))
                <div class="col-lg-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                            <div class="zImage-inside">
                                <div class="d-flex pb-12"><img
                                        src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                </div>
                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                </p>
                            </div>
                            <label for="bannerHeroImage" class="zForm-label-alt">{{ __('BG Image') }} <span
                                    class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                            <div class="upload-img-box">
                                @php
                                    $heroBannerImages = json_decode(landingPageSetting($collection, 'hero_banner_image_2','[]'), true) ?? [];
                                @endphp
                                @if (landingPageSetting($collection,'hero_banner_image_2'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'hero_banner_image_2')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="hero_banner_image_2" id="bannerHeroImage" accept="image/*"
                                       onchange="previewFile(this)" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if((getOption('app_theme_style') == THEME_HOME_ONE) || (getOption('app_theme_style') == null))
                <div class="col-lg-4">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                            <div class="zImage-inside">
                                <div class="d-flex pb-12"><img
                                        src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                </div>
                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                </p>
                            </div>
                            <label for="bannerHeroImage" class="zForm-label-alt">{{ __('Company Batch Icon 1') }} <span
                                    class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                            <div class="upload-img-box">
                                @php
                                    $heroBannerImages = json_decode(landingPageSetting($collection, 'company_batch_icon_1','[]'), true) ?? [];
                                @endphp
                                @if (landingPageSetting($collection,'company_batch_icon_1'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_1')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="company_batch_icon_1" id="bannerHeroImage" accept="image/*"
                                       onchange="previewFile(this)" />

                            </div>
                            <span class="fs-12 fw-400 lh-24 text-button pt-3"><?php echo e(__('Recommended:
                                            210/42 px')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                            <div class="zImage-inside">
                                <div class="d-flex pb-12"><img
                                        src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                </div>
                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                </p>
                            </div>
                            <label for="bannerHeroImage" class="zForm-label-alt">{{ __('Company Batch Icon 2') }} <span
                                    class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                            <div class="upload-img-box">
                                @php
                                    $heroBannerImages = json_decode(landingPageSetting($collection, 'company_batch_icon_2','[]'), true) ?? [];
                                @endphp
                                @if (landingPageSetting($collection,'company_batch_icon_2'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_2')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="company_batch_icon_2" id="bannerHeroImage" accept="image/*"
                                       onchange="previewFile(this)" />
                            </div>
                            <span class="fs-12 fw-400 lh-24 text-button pt-3"><?php echo e(__('Recommended:
                                            210/42 px')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                            <div class="zImage-inside">
                                <div class="d-flex pb-12"><img
                                        src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                </div>
                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                </p>
                            </div>
                            <label for="bannerHeroImage" class="zForm-label-alt">{{ __('Company Batch Icon 3') }} <span
                                    class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                            <div class="upload-img-box">
                                @php
                                    $heroBannerImages = json_decode(landingPageSetting($collection, 'company_batch_icon_3','[]'), true) ?? [];
                                @endphp
                                @if (landingPageSetting($collection,'company_batch_icon_3'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'company_batch_icon_3')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="company_batch_icon_3" id="bannerHeroImage" accept="image/*"
                                       onchange="previewFile(this)" />
                            </div>
                            <span class="fs-12 fw-400 lh-24 text-button pt-3"><?php echo e(__('Recommended:
                                            210/42 px')); ?></span>
                        </div>
                    </div>
                </div>
            @endif
            @if((getOption('app_theme_style') == THEME_HOME_ONE) || (getOption('app_theme_style') == null))
                <div class="col-12">
                    <div class="row rg-20">
                        <div class="col-lg-6">
                            <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                                <div id="our-landing-page-image-block">
                                    <div class="d-flex justify-content-between align-items-center g-10 flex-wrap">
                                        <h4 class="zForm-label-alt">{{__('Project Preview Images') }}</h4>
                                        <button type="button" class="py-3 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white" id="addLandingPageImage">
                                            + {{__('Add More')}}
                                        </button>
                                    </div>
                                    @php
                                        $heroBannerImages = json_decode(landingPageSetting($collection, 'hero_banner_image'), true) ?? [];
                                            if (empty($heroBannerImages)) {
                                            $heroBannerImages = [null];
                                        }
                                    @endphp

                                    @foreach($heroBannerImages as $index => $heroBannerImage)
                                        <div class="landing-page-image-item">
                                            <div class="landing-page-image-itemBlock">
                                                <div class="icon-block d-flex g-10 justify-content-between">
                                                    <div class="w-100">
                                                        <label for="hero_banner_image_{{$index}}" class="zForm-label d-flex align-items-center g-10">{{__('Preview Image')}}
                                                            @if($heroBannerImage)
                                                                <small class="preview-image-div">
                                                                    <a class="w-30 h-30 bd-one bd-c-stroke rounded-circle d-flex justify-content-center align-items-center text-title-text" href="{{getFileUrl($heroBannerImage)}}"
                                                                       target="_blank"><i class="fa-solid fa-eye"></i></a>
                                                                </small>
                                                            @endif
                                                        </label>
                                                        <div class="file-upload-one d-flex flex-column g-10 w-100">
                                                            <label for="hero_banner_image_{{$index}}">
                                                                <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                                                                <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                                                            </label>
                                                            <span
                                                                class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) 800/710 px')}}</span>
                                                            <div class="max-w-150 flex-shrink-0">
                                                                <input type="hidden" name="hero_banner_image_id[]" value="{{$heroBannerImage}}">
                                                                <input type="file" name="hero_banner_image[]" id="hero_banner_image_{{$index}}"
                                                                       accept="image/*"
                                                                       class="fileUploadInput hero_banner_image position-absolute invisible"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($index > 0)
                                                        <button type="button"
                                                                class="removeLandingPageImage top-0 end-0 bg-transparent border-0 p-0 m-2 rounded-circle d-flex justify-content-center align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                                                 fill="none">
                                                                <path
                                                                    d="M16.25 4.58334L15.7336 12.9376C15.6016 15.072 15.5357 16.1393 15.0007 16.9066C14.7361 17.2859 14.3956 17.6061 14.0006 17.8467C13.2017 18.3333 12.1325 18.3333 9.99392 18.3333C7.8526 18.3333 6.78192 18.3333 5.98254 17.8458C5.58733 17.6048 5.24667 17.284 4.98223 16.904C4.4474 16.1355 4.38287 15.0668 4.25384 12.9293L3.75 4.58334"
                                                                    stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path
                                                                    d="M2.5 4.58333H17.5M13.3797 4.58333L12.8109 3.40977C12.433 2.63021 12.244 2.24043 11.9181 1.99734C11.8458 1.94341 11.7693 1.89545 11.6892 1.85391C11.3283 1.66666 10.8951 1.66666 10.0287 1.66666C9.14067 1.66666 8.69667 1.66666 8.32973 1.86176C8.24842 1.90501 8.17082 1.95491 8.09774 2.01097C7.76803 2.26391 7.58386 2.66796 7.21551 3.47605L6.71077 4.58333"
                                                                    stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path d="M7.91669 13.75V8.75" stroke="#EF4444" stroke-width="1.5"
                                                                      stroke-linecap="round"/>
                                                                <path d="M12.0833 13.75V8.75" stroke="#EF4444" stroke-width="1.5"
                                                                      stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                                <div id="our-landing-page-icon-block">
                                    <div class="d-flex justify-content-between align-items-center g-10 flex-wrap">
                                        <h4 class="zForm-label-alt">{{__('Company Logos Image') }}</h4>
                                        <button type="button" class="py-3 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white" id="addLandingPageIcon">
                                            + {{__('Add More')}}
                                        </button>
                                    </div>
                                    @php
                                        $heroBannerIcons = json_decode(landingPageSetting($collection, 'hero_banner_icon'), true) ?? [];
                                        if (empty($heroBannerIcons)) {
                                            $heroBannerIcons = [null];
                                        }
                                    @endphp
                                    @foreach($heroBannerIcons as $index => $heroBannerIcon)
                                        <div class="landing-page-icon-item">
                                            <div class="">
                                                <div class="icon-block d-flex g-10 justify-content-between">
                                                    <div class="w-100">
                                                        <label for="hero_banner_icon_{{$index}}" class="zForm-label d-flex align-items-center g-10">{{__('Logo')}}
                                                            @if($heroBannerIcon)
                                                                <small class="preview-image-div">
                                                                    <a class="w-30 h-30 bd-one bd-c-stroke rounded-circle d-flex justify-content-center align-items-center text-title-text" href="{{getFileUrl($heroBannerIcon)}}" target="_blank">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </a>
                                                                </small>
                                                            @endif
                                                        </label>
                                                        <div class="file-upload-one d-flex flex-column g-10 w-100">
                                                            <label for="hero_banner_icon">
                                                                <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                                                                <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                                                            </label>
                                                            <span class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) 800/710 px')}}</span>
                                                            <div class="max-w-150 flex-shrink-0">
                                                                <input type="hidden" name="hero_banner_icon_id[]" value="{{$heroBannerIcon}}">
                                                                <input type="file" name="hero_banner_icon[]" id="hero_banner_icon"
                                                                       accept="image/*"
                                                                       class="fileUploadInput hero_banner_icon position-absolute invisible"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($index > 0)
                                                        <button type="button"
                                                                class="removeLandingPageIcon top-0 end-0 bg-transparent border-0 p-0 m-2 rounded-circle d-flex justify-content-center align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                                                 fill="none">
                                                                <path
                                                                    d="M16.25 4.58334L15.7336 12.9376C15.6016 15.072 15.5357 16.1393 15.0007 16.9066C14.7361 17.2859 14.3956 17.6061 14.0006 17.8467C13.2017 18.3333 12.1325 18.3333 9.99392 18.3333C7.8526 18.3333 6.78192 18.3333 5.98254 17.8458C5.58733 17.6048 5.24667 17.284 4.98223 16.904C4.4474 16.1355 4.38287 15.0668 4.25384 12.9293L3.75 4.58334"
                                                                    stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path
                                                                    d="M2.5 4.58333H17.5M13.3797 4.58333L12.8109 3.40977C12.433 2.63021 12.244 2.24043 11.9181 1.99734C11.8458 1.94341 11.7693 1.89545 11.6892 1.85391C11.3283 1.66666 10.8951 1.66666 10.0287 1.66666C9.14067 1.66666 8.69667 1.66666 8.32973 1.86176C8.24842 1.90501 8.17082 1.95491 8.09774 2.01097C7.76803 2.26391 7.58386 2.66796 7.21551 3.47605L6.71077 4.58333"
                                                                    stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path d="M7.91669 13.75V8.75" stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                                <path d="M12.0833 13.75V8.75" stroke="#EF4444" stroke-width="1.5" stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex g-12 flex-wrap mt-25">
            <button type="submit"
                    class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Save') }}</button>
        </div>
    </form>
</div>

@push('script')
    <script src="{{ asset('admin/custom/js/configuration.js') }}"></script>
@endpush
