@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div class="p-sm-30 p-15">
        <div class="">
            <div class="row rg-20">
                <div class="col-xl-12">
                    <form class="ajax" action="{{ route('admin.theme-settings.about-us.store')}}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <input type="hidden" value="{{$aboutUsData->id ?? ''}}" name="id">
                        <div class="bg-white p-sm-25 mb-20 p-15 bd-one bd-c-stroke bd-ra-8">
                            <div class="row rg-20 d-none">
                                <div class="col-xxl-12 col-lg-12 pt-10">
                                    <label for="aboutUsTitle" class="zForm-label-alt">{{ __('Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="aboutUsTitle" placeholder="{{__('Title')}}" value="{{ $aboutUsData->title ?? '' }}"
                                           class="form-control zForm-control">
                                </div>
                            </div>
                            <div class="row pt-10">
                                <div class="col-6">
                                    <div class="primary-form-group mt-3">
                                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                                            <div class="zImage-inside text-center">
                                                <div class="d-flex justify-content-center pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="bannerImage" class="zForm-label-alt">
                                                {{ __('Banner Image') }}
                                                <span class="text-mime-type">{{ __('(jpeg, png, jpg, svg, webp)') }}</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="upload-img-box text-center">
                                                <img src="{{ (isset($aboutUsData) && !is_null($aboutUsData->banner_image)) ? getFileUrl($aboutUsData->banner_image) : '' }}" id="banner_image"/>
                                                <input type="file" name="banner_image" id="bannerImage" accept="image/*"
                                                       onchange="previewFile(this)" />
                                            </div>
                                            <span
                                                class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 1326 px / 520 px")}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="primary-form-group mt-3">
                                        <div class="primary-form-group-wrap zImage-upload-details mw-100">
                                            <div class="zImage-inside text-center">
                                                <div class="d-flex justify-content-center pb-12">
                                                    <img src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                                </div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">
                                                    {{ __('Drag & drop files here') }}
                                                </p>
                                            </div>
                                            <label for="image" class="zForm-label-alt">
                                                {{ __('Image') }}
                                                <span class="text-mime-type">{{ __('(jpeg, png, jpg, svg, webp)') }}</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="upload-img-box text-center">
                                                <img src="{{ (isset($aboutUsData) && !is_null($aboutUsData->image)) ? getFileUrl($aboutUsData->image) : '' }}" id="image"/>
                                                <input type="file" name="image" id="image" accept="image/*"
                                                       onchange="previewFile(this)" />
                                            </div>
                                            <span
                                                class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 690 px / 540 px")}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-lg-12 pt-4 d-none">
                                <label for="aboutUsDetails" class="zForm-label-alt">{{ __('Details') }} <span
                                        class="text-danger">*</span></label>
                                <textarea name="details" id="aboutUsDetails" class="form-control zForm-control summernoteOne" cols="10" rows="5">{!! $aboutUsData->details ?? '' !!}</textarea>
                            </div>
                        </div>
                        <div class="bg-white p-sm-25 mb-20 p-15 bd-one bd-c-stroke bd-ra-8">
                            <div class="bd-c-black-stroke d-flex justify-content-between align-items-center bd-b-one bd-c-black-stroke pb-10">
                                <h4 class="fs-18 fw-700 lh-24 text-title-text">{{ __('Our Mission') }}</h4>
                            </div>
                            <div class="row pt-10">
                                <div class="col-6">
                                    <label for="ourMissionTitle" class="zForm-label-alt">{{ __('Our Mission Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="our_mission[title]" id="ourMissionTitle" placeholder="{{__('Our Mission Title')}}" value="{{$aboutUsData->our_mission['title'] ?? ''}}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6 pt-4">
                                    <label for="ourMissionDetails" class="zForm-label-alt">{{ __('Our Mission Details') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="our_mission[details]" id="ourMissionDetails" class="form-control zForm-control summernoteOne">{!! $aboutUsData->our_mission['details'] ?? '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-sm-25 mb-20 p-15 bd-one bd-c-stroke bd-ra-8">
                            <div class="bd-c-black-stroke d-flex justify-content-between align-items-center bd-b-one bd-c-black-stroke pb-10">
                                <h4 class="fs-18 fw-700 lh-24 text-title-text">{{ __('Our Vision') }}</h4>
                            </div>
                            <div class="row pt-10">
                                <div class="col-6">
                                    <label for="ourVisionTitle" class="zForm-label-alt">{{ __('Our Vision Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="our_vision[title]" id="ourVisionTitle" placeholder="{{__('Our Vision Title')}}" value="{{$aboutUsData->our_vision['title'] ?? ''}}"
                                           class="form-control zForm-control our_vision">
                                </div>
                                <div class="col-xxl-6 col-lg-6 pt-4">
                                    <label for="ourVisionDetails" class="zForm-label-alt">{{ __('Our Vision Details') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="our_vision[details]" id="ourVisionDetails" class="form-control zForm-control summernoteOne">{!! $aboutUsData->our_vision['details'] ?? '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-sm-25 mb-20 p-15 bd-one bd-c-stroke bd-ra-8">
                            <div class="bd-c-black-stroke d-flex justify-content-between align-items-center bd-b-one bd-c-black-stroke pb-10">
                                <h4 class="fs-18 fw-700 lh-24 text-title-text">{{ __('Our Goal') }}</h4>
                            </div>
                            <div class="row pt-10">
                                <div class="col-6">
                                    <label for="ourGoalTitle" class="zForm-label-alt">{{ __('Our Goal Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="our_goal[title]" id="ourGoalTitle" placeholder="{{__('Our Goal Title')}}" value="{{$aboutUsData->our_goal['title'] ?? ''}}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6 pt-4">
                                    <label for="ourGoalDetails" class="zForm-label-alt">{{ __('Our Goal Details') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="our_goal[details]" id="ourGoalDetails" class="form-control zForm-control summernoteOne">{!! $aboutUsData->our_goal['details'] ?? '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="p-sm-25 p-15 bd-one bd-c-stroke mb-20 bd-ra-10 bg-white">
                            <div id="about-us-block">
                                <div class="bd-c-black-stroke justify-content-between align-items-center text-end d-flex justify-content-between">
                                    <h4 class="fs-18 fw-700 lh-24 text-title-text">{{__('Team Member')}}</h4>
                                    <button type="button" class="py-3 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white" id="addAboutUs">
                                        + {{__('Add More')}}
                                    </button>
                                </div>
                                @foreach($aboutUsData->team_member ?? [[]] as $index => $ourTeamMember)
                                    <input type="hidden" class="old_team_member_image" name="old_team_member_image[{{$index}}]" value="{{ $ourTeamMember['image'] ?? '' }}">
                                    <div class="about-us-item">
                                        <div class="row rg-20">
                                            <div class="col-md-4">
                                                <label for="team_member_name_{{$index}}" class="zForm-label">{{__('Name')}} <span class="text-danger">*</span></label>
                                                <input type="text" name="team_member_name[]" id="team_member_name_{{$index}}"
                                                       placeholder="{{__('Type name')}}"
                                                       value="{{$ourTeamMember['title'] ?? ''}}"
                                                       class="form-control team_member_name zForm-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="team_member_designation_{{$index}}"
                                                       class="zForm-label">{{__('Designation')}} <span class="text-danger">*</span></label>
                                                <input type="text" name="team_member_designation[]"
                                                       id="team_member_designation_{{$index}}"
                                                       placeholder="{{__('Designation')}}"
                                                       value="{{$ourTeamMember['designation'] ?? ''}}"
                                                       class="form-control team_member_designation zForm-control">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="image-block d-flex g-10 justify-content-between flex-column flex-xxl-row align-items-end align-items-xxl-center flex-xl-wrap flex-xl-nowrap">
                                                    <div class="w-100">
                                                        <label for="team_member_image_{{$index}}" class="zForm-label">{{__('Image')}}
                                                            <span class="text-danger">*</span>
                                                            @if($ourTeamMember['image'] ?? '')
                                                                <small class="preview-image-div">
                                                                    <a href="{{getFileUrl($ourTeamMember['image'])}}"
                                                                       target="_blank"><i class="fa-solid fa-eye"></i></a>
                                                                </small>
                                                            @endif
                                                        </label>
                                                        <div class="file-upload-one file-upload-one-alt d-flex flex-column g-10 w-100">
                                                            <label for="team_member_image_{{$index}}">
                                                                <p class="fileName fs-12 fw-500 lh-16 text-para-text">{{__('Choose Image to upload')}}</p>
                                                                <p class="fs-12 fw-500 lh-16 text-white">{{__('Browse File')}}</p>
                                                            </label>
                                                            <span
                                                                class="fs-12 fw-400 text-main-color">{{__('Recommended: (jpeg,png,jpg,svg,webp) | 273 px / 316 px')}}</span>
                                                            <div class="max-w-150 flex-shrink-0">
                                                                <input type="file" name="team_member_image[]" id="team_member_image_{{$index}}"
                                                                       accept="image/*"
                                                                       class="fileUploadInput team_member_image position-absolute invisible"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($index > 0)
                                                        <button type="button"
                                                                class="removeAboutUs top-0 end-0 bg-transparent border-0 p-0 m-2 rounded-circle d-flex justify-content-center align-items-center">
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
                                            <div class="col-md-4">
                                                <label for="team_member_facebook_link{{$index}}" class="zForm-label">{{__('Facebook Link')}}</label>
                                                <input type="text" name="team_member_facebook_link[]" id="team_member_facebook_link{{$index}}"
                                                       placeholder="{{__('Type facebook link')}}"
                                                       value="{{$ourTeamMember['facebook'] ?? ''}}"
                                                       class="form-control team_member_facebook zForm-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="team_member_linkedin_{{$index}}" class="zForm-label">{{__('Linkedin Link')}}</label>
                                                <input type="text" name="team_member_linkedin_link[]" id="team_member_linkedin_{{$index}}"
                                                       placeholder="{{__('Type linkedin link')}}"
                                                       value="{{$ourTeamMember['linkedin'] ?? ''}}"
                                                       class="form-control team_member_linkedin zForm-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="team_member_twitter_{{$index}}" class="zForm-label">{{__('Twitter / X Link')}}</label>
                                                <input type="text" name="team_member_twitter_link[]" id="team_member_twitter_{{$index}}"
                                                       placeholder="{{__('Type twitter link')}}"
                                                       value="{{$ourTeamMember['twitter'] ?? ''}}"
                                                       class="form-control team_member_twitter zForm-control">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bd-c-black-stroke justify-content-between align-items-center text-end pt-15">
                            <button type="submit" class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/theme/js/about-us.js') }}"></script>
@endpush
