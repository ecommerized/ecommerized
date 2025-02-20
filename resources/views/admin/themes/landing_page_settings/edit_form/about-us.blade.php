<div class="email-inbox__area">
    <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
        <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('About Us Area') }}</h2>
        <button type="button" class="bd-one bd-c-black-stroke rounded-circle w-25 h-25 bg-transparent text-para-text"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>

    <form class="ajax" action="{{ route('admin.setting.configuration-landing-page-settings.update') }}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
        @csrf
        <div class="row rg-20">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                <label for="label" class="zForm-label-alt">{{ __('Sub Title') }}</label>
                <input type="hidden" name="about_us_sub_title" value="">
                <select class="primary-form-control sf-select-edit-modal" multiple name="about_us_sub_title[]">
                    @php
                        $subTitles = json_decode(landingPageSetting($collection, 'about_us_sub_title') ?? '');
                    @endphp

                    @if (!empty($subTitles) && is_array($subTitles))
                        @foreach ($subTitles as $subtitle)
                            <option value="{{ $subtitle }}" selected>{{ $subtitle }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                <label class="zForm-label-alt">{{ __('Title') }}</label>
                <input type="text" name="about_us_title"
                       value="{{ landingPageSetting($collection, 'about_us_title') }}"
                       class="form-control zForm-control">
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-12 mb-3">
                <label class="zForm-label-alt">{{ __('Details') }}</label>
                <textarea class="form-control zForm-control"  name="about_us_details" rows="6" cols="50">{{ landingPageSetting($collection,'about_us_details') }}</textarea>
            </div>

            @if(getOption('app_theme_style') != THEME_HOME_ONE)
                <div class="bd-b-one bd-c-black-stroke pb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
                    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('About Us Extra Feature') }}</h2>
                </div>

                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-3">
                    <label class="zForm-label-alt">{{ __('Extra Feature Title 1') }}</label>
                    <input type="text" name="about_us_extra_feature_title_1"
                           value="{{ landingPageSetting($collection, 'about_us_extra_feature_title_1') }}"
                           class="form-control zForm-control">
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-3">
                    <label class="zForm-label-alt">{{ __('Extra Feature Title 2') }}</label>
                    <input type="text" name="about_us_extra_feature_title_2"
                           value="{{ landingPageSetting($collection, 'about_us_extra_feature_title_2') }}"
                           class="form-control zForm-control">
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-3">
                    <label class="zForm-label-alt">{{ __('Extra Feature Title 3') }}</label>
                    <input type="text" name="about_us_extra_feature_title_3"
                           value="{{ landingPageSetting($collection, 'about_us_extra_feature_title_3') }}"
                           class="form-control zForm-control">
                </div>

                <div class="col-xl-4 col-md-4 col-sm-6">
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
                            <label for="zImageUpload" class="form-label">{{ __('Extra Feature Icon 1') }}</label>
                            <div class="upload-img-box">
                                @if (landingPageSetting($collection,'about_us_extra_feature_icon_1'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'about_us_extra_feature_icon_1'))}}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="about_us_extra_feature_icon_1" id="zImageUpload"
                                       accept="image/*,video/*" onchange="previewFile(this)" />
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('about_us_extra_feature_icon_1'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first('about_us_extra_feature_icon_1') }}</span>
                    @endif
                    <p>
                    <span class="text-black">
                        <span class="text-black">{{ __('Recommend Size') }}:</span>
                        30 x 30
                    </span>
                    </p>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6">
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
                            <label for="zImageUpload" class="form-label">{{ __('Extra Feature Icon 2') }}</label>
                            <div class="upload-img-box">
                                @if (landingPageSetting($collection,'about_us_extra_feature_icon_2'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'about_us_extra_feature_icon_2')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="about_us_extra_feature_icon_2" id="zImageUpload"
                                       accept="image/*,video/*" onchange="previewFile(this)" />
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('about_us_extra_feature_icon_2'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first('about_us_extra_feature_icon_2') }}</span>
                    @endif
                    <p>
                    <span class="text-black">
                        <span class="text-black">{{ __('Recommend Size') }}:</span>
                        30 x 30
                    </span>
                    </p>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6">
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
                            <label for="zImageUpload" class="form-label">{{ __('Extra Feature Icon 3') }}</label>
                            <div class="upload-img-box">
                                @if (landingPageSetting($collection,'about_us_extra_feature_icon_3'))
                                    <img src="{{ getFileUrl(landingPageSetting($collection,'about_us_extra_feature_icon_3')) }}" />
                                @else
                                    <img src="" />
                                @endif
                                <input type="file" name="about_us_extra_feature_icon_3" id="zImageUpload"
                                       accept="image/*,video/*" onchange="previewFile(this)" />
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('about_us_extra_feature_icon_3'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first('about_us_extra_feature_icon_3') }}</span>
                    @endif
                    <p>
                    <span class="text-black">
                        <span class="text-black">{{ __('Recommend Size') }}:</span>
                        30 x 30
                    </span>
                    </p>
                </div>
            @endif
        </div>
        <div class="d-flex g-12 flex-wrap mt-25">
            <button type="submit"
                    class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Save') }}</button>
        </div>
    </form>
</div>
