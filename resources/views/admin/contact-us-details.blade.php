<div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Contact Us Details') }}</h2>
    <div class="mClose">
        <button type="button"
                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
<div class="row rg-20">
    <div class="col-6">
        <label class="zForm-label">{{ __('Name') }}</label>
        <input type="text" class="form-control zForm-control" readonly name="question" value="{{ $contactUsData->name }}">
    </div>
    <div class="col-6">
        <label class="zForm-label">{{ __('Email') }}</label>
        <input type="text" class="form-control zForm-control" readonly name="question" value="{{ $contactUsData->email }}">
    </div>

    <div class="col-12">
        <label class="zForm-label">{{ __('Message') }}</label>
        <textarea class="form-control zForm-control"  readonly name="answer" rows="10" cols="50">{!! $contactUsData->message !!}</textarea>
    </div>
</div>


