<div class="p-sm-25 p-15 mb-20 bd-one bd-c-black-stroke bd-ra-10 bg-white">
    <div class="row rg-20">
        <div class="col-md-4">
            <label for="title" class="zForm-label">{{ __('Title') }} <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" placeholder="{{ __('Type Title') }}"
                   value="{{ $serviceData->title ?? '' }}" class="form-control zForm-control">
        </div>
        <div class="col-md-4">
            <label for="status" class="zForm-label">{{ __('Status') }} <span class="text-danger">*</span></label>
            <select class="sf-select-without-search" id="status" name="status">
                <option
                    value="{{ STATUS_ACTIVE }}" {{ (isset($serviceData) && $serviceData->status == STATUS_ACTIVE) ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option
                    value="{{ STATUS_DEACTIVATE }}" {{ (isset($serviceData) && $serviceData->status == STATUS_DEACTIVATE) ? 'selected' : '' }}>{{ __('Inactive') }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <div class="icon-block d-flex g-10 justify-content-between">
                <div class="w-100">
                    <label for="icon" class="zForm-label">{{__('Icon')}}
                        <span class="text-danger">*</span>
                        @if($serviceData->icon ?? '')
                            <small class="preview-image-div">
                                <a href="{{getFileUrl($serviceData->icon)}}"
                                   target="_blank"><i class="fa-solid fa-eye"></i></a>
                            </small>
                        @endif
                    </label>
                    <div class="file-upload-one file-upload-one-alt d-flex flex-column g-10 w-100">
                        <label for="icon">
                            <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                            <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                        </label>
                        <span
                            class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) | 60 px / 60 px')}}</span>
                        <div class="max-w-150 flex-shrink-0">
                            <input type="file" name="icon" id="icon"
                                   accept="image/*"
                                   class="fileUploadInput icon position-absolute invisible"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="subtitle" class="zForm-label">{{ __('Description') }} <span class="text-danger">*</span></label>
            <textarea class="form-control zForm-control" name="description" id="description" cols="7" rows="7"
                      placeholder="{{ __('Type description') }}">{{ $serviceData->description ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <div class="primary-form-group">
                <div class="primary-form-group-wrap zImage-upload-details mw-100">
                    <div class="zImage-inside text-center">
                        <div class="d-flex justify-content-center pb-12">
                            <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt=""/>
                        </div>
                        <p class="fs-15 fw-500 lh-16 text-1b1c17">
                            {{ __('Drag & drop files here') }}
                        </p>
                    </div>
                    <label for="banner_image" class="zForm-label">
                        {{ __('Banner Image') }}
                        <span class="text-mime-type">{{ __('(jpeg,png,jpg,svg,webp)') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="upload-img-box text-center">
                        <img src="{{ (isset($serviceData) && !is_null($serviceData->banner_image)) ? getFileUrl($serviceData->banner_image) : '' }}" id="banner_image"/>
                        <input type="file" name="banner_image" id="banner_image"
                               accept="image/*"
                               onchange="previewFile(this)"/>
                    </div>
                    <span
                        class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 1320 px / 825 px")}}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-15 fs-18 fw-700 lh-24 text-title-text">{{__('Our Touch Point')}}</h4>
<div class="p-sm-25 p-15 bd-one bd-c-black-stroke mb-20 bd-ra-10 bg-white">
    <div id="our-touch-point-block">
        <div class="bd-c-stroke-2 d-flex justify-content-end">
            <button type="button" class="py-3 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white" id="addOurTouchPoint">
                + {{__('Add More')}}
            </button>
        </div>
        @foreach($serviceData->our_touch_point ?? [[]] as $index => $ourTouchPoint)
            <input type="hidden" class="old_our_touch_point_icon" name="old_our_touch_point_icon[{{$index}}]" value="{{ $ourTouchPoint['icon'] ?? '' }}">
            <div class="our-touch-point-item row rg-20 bd-b-one bd-c-one bd-c-black-stroke pb-15 mb-15">
                <div class="col-md-4">
                    <label for="our_touch_point_title_{{$index}}" class="zForm-label">{{__('Title')}} <span class="text-danger">*</span></label>
                    <input type="text" name="our_touch_point_title[]" id="our_touch_point_title_{{$index}}"
                           placeholder="{{__('Type title')}}"
                           value="{{$ourTouchPoint['title'] ?? ''}}"
                           class="form-control our_touch_point_title zForm-control">
                </div>
                <div class="col-md-4">
                    <label for="our_touch_point_details_{{$index}}"
                           class="zForm-label">{{__('Details')}} <span class="text-danger">*</span></label>
                    <input type="text" name="our_touch_point_details[]"
                           id="our_touch_point_details_{{$index}}"
                           placeholder="{{__('Details')}}"
                           value="{{$ourTouchPoint['details'] ?? ''}}"
                           class="form-control our_touch_point_details zForm-control">
                </div>
                <div class="col-md-4">
                    <div class="icon-block d-flex g-10 justify-content-between flex-column flex-xxl-row align-items-end align-items-xxl-center flex-xl-wrap flex-xl-nowrap">
                        <div class="w-100">
                            <label for="our_touch_point_icon_{{$index}}" class="zForm-label">{{__('Icon')}}
                                <span class="text-danger">*</span>
                                @if($ourTouchPoint['icon'] ?? '')
                                    <small class="preview-image-div">
                                        <a href="{{getFileUrl($ourTouchPoint['icon'])}}"
                                           target="_blank"><i class="fa-solid fa-eye"></i></a>
                                    </small>
                                @endif
                            </label>
                            <div class="file-upload-one file-upload-one-alt d-flex flex-column g-10 w-100">
                                <label for="our_touch_point_icon_{{$index}}">
                                    <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                                    <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                                </label>
                                <span
                                    class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) | 44 px / 44 px')}}</span>
                                <div class="max-w-150 flex-shrink-0">
                                    <input type="file" name="our_touch_point_icon[]" id="our_touch_point_icon_{{$index}}"
                                           accept="image/*"
                                           class="fileUploadInput our_touch_point_icon position-absolute invisible"/>
                                </div>
                            </div>
                        </div>
                        @if($index > 0)
                            <button type="button"
                                    class="removeOurTouchPoint top-0 end-0 bg-transparent border-0 p-0 m-2 rounded-circle d-flex justify-content-center align-items-center">
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

{{--out approach point--}}

<h4 class="mb-15 fs-18 fw-700 lh-24 text-title-text">{{__('Our Approach')}}</h4>
<div class="p-sm-25 p-15 bd-one bd-c-black-stroke mb-20 bd-ra-10 bg-white">
    <div id="our-approach-block">
        <div class="bd-c-stroke-2 d-flex justify-content-end">
            <button type="button" class="py-3 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white" id="addOurApproach">
                + {{__('Add More')}}
            </button>
        </div>
        @foreach($serviceData->our_approach ?? [[]] as $index => $ourApproach)
            <input type="hidden" class="old_our_approach_icon" name="old_our_approach_icon[{{$index}}]" value="{{ $ourApproach['icon'] ?? '' }}">
            <div class="our-approach-item row rg-20 bd-b-one bd-c-one bd-c-black-stroke pb-15 mb-15">
                <div class="col-md-4">
                    <label for="our_approach_title_{{$index}}" class="zForm-label">{{__('Title')}} <span class="text-danger">*</span></label>
                    <input type="text" name="our_approach_title[]" id="our_approach_title_{{$index}}"
                           placeholder="{{__('Type title')}}"
                           value="{{$ourApproach['title'] ?? ''}}"
                           class="form-control our_approach_title zForm-control">
                </div>
                <div class="col-md-4">
                    <label for="our_approach_details_{{$index}}"
                           class="zForm-label">{{__('Details')}} <span class="text-danger">*</span></label>
                    <input type="text" name="our_approach_details[]"
                           id="our_approach_details_{{$index}}"
                           placeholder="{{__('Details')}}"
                           value="{{$ourApproach['details'] ?? ''}}"
                           class="form-control our_approach_details zForm-control">
                </div>
                <div class="col-md-4">
                    <div class="icon-block d-flex g-10 justify-content-between flex-column flex-xxl-row align-items-end align-items-xxl-center flex-xl-wrap flex-xl-nowrap">
                        <div class="w-100">
                            <label for="our_approach_icon_{{$index}}" class="zForm-label">{{__('Icon')}}
                                <span class="text-danger">*</span>
                                @if($ourApproach['icon'] ?? '')
                                    <small class="preview-image-div">
                                        <a href="{{getFileUrl($ourApproach['icon'])}}"
                                           target="_blank"><i class="fa-solid fa-eye"></i></a>
                                    </small>
                                @endif
                            </label>
                            <div class="file-upload-one file-upload-one-alt d-flex flex-column g-10 w-100">
                                <label for="our_approach_icon_{{$index}}">
                                    <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                                    <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                                </label>
                                <span
                                    class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) | 32 px / 32 px')}}</span>
                                <div class="max-w-150 flex-shrink-0">
                                    <input type="file" name="our_approach_icon[]" id="our_approach_icon_{{$index}}"
                                           accept="image/*"
                                           class="fileUploadInput our_approach_icon position-absolute invisible"/>
                                </div>
                            </div>
                        </div>
                        @if($index > 0)
                            <button type="button"
                                    class="removeOurApproach top-0 end-0 bg-transparent border-0 p-0 m-2 rounded-circle d-flex justify-content-center align-items-center">
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
