<div class="email-inbox__area">
    <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
        <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Our Project / Portfolio Area') }}</h2>
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
                <input type="hidden" name="our_project_sub_title" value="">
                <select class="primary-form-control sf-select-edit-modal" multiple name="our_project_sub_title[]">
                    @php
                        $subTitles = json_decode(landingPageSetting($collection, 'our_project_sub_title') ?? '');
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
                <input type="text" name="our_project_title"
                       value="{{ landingPageSetting($collection, 'our_project_title') }}"
                       class="form-control zForm-control">
            </div>
            @if(getOption('app_theme_style') != THEME_HOME_ONE)
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-12 mb-3">
                <label class="zForm-label-alt">{{ __('Details') }}</label>
                <textarea class="form-control zForm-control"  name="our_project_details" rows="6" cols="50">{{ landingPageSetting($collection,'our_project_details') }}</textarea>
            </div>
            @endif

        </div>
        <div class="d-flex g-12 flex-wrap mt-25">
            <button type="submit"
                    class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Save') }}</button>
        </div>
    </form>
</div>
