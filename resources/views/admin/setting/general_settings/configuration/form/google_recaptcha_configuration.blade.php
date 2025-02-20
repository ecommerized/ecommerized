<div class="email-inbox__area">
    <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
        <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Google Recaptcha Credentials') }}</h2>
        <button type="button" class="bd-one bd-c-black-stroke rounded-circle w-25 h-25 bg-transparent text-para-text" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
    </div>
    <form class="ajax" action="{{ route('admin.setting.settings_env.update') }}" method="post" class="form-horizontal"
        data-handler="commonResponseForModal">
        @csrf

        <div class="">
            <div class="col-lg-12">
                <label class="zForm-label">{{ __('Google Recaptcha Site Key') }} </label>
                <input type="text" min="0" max="100" step="any" name="google_recaptcha_site_key"
                       value="{{ getOption('google_recaptcha_site_key') }}" id="google_recaptcha_site_key" class="form-control zForm-control">
            </div>
        </div>
        <div class="pt-5">
            <div class="col-lg-12">
                <label class="zForm-label">{{ __('Google Recaptcha Secret Key') }} </label>
                <input type="text" min="0" max="100" step="any" name="google_recaptcha_secret_key" id="google_recaptcha_secret_key"
                       value="{{ getOption('google_recaptcha_secret_key') }}" class="form-control zForm-control">
            </div>
        </div>
        <div class="d-flex g-12 flex-wrap mt-25">
            <button class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white"
                    type="submit">{{ __('Save') }}</button>
        </div>
    </form>
</div>
