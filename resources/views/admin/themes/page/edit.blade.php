<div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Update Pages') }}</h2>
    <div class="mClose">
        <button type="button"
                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
<form class="ajax reset" action="{{ route('admin.theme-settings.pages.store') }}" method="post"
      data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$pageData->id}}">
    <div class="row rg-20">
        <div class="col-6">
            <label class="zForm-label">{{ __('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" value="{{$pageData->title}}" name="title" id="title"
                   placeholder="{{ __('Title') }}">
        </div>
        <div class="col-6">
            <label class="zForm-label" for="status">{{ __('Status') }} <span
                    class="text-danger">*</span></label>
            <select name="status" class="sf-select-without-search">
                <option {{ $pageData->status == STATUS_ACTIVE ? 'selected' : '' }} value="{{STATUS_ACTIVE}}">{{ __('Active') }}</option>
                <option {{ $pageData->status == STATUS_DEACTIVATE ? 'selected' : '' }} value="{{STATUS_DEACTIVATE}}">{{ __('Deactivate') }}</option>
            </select>
        </div>
        <div class="pt-15">
            <label class="zForm-label-alt">{{ __('Description') }} <span
                    class="text-danger">*</span></label>
            <textarea class="summernoteOne" name="description" placeholder="{{__('Type description')}}">{!! $pageData->description !!}</textarea>
        </div>
    </div>
    <div class="d-flex g-12 flex-wrap mt-25">
        <button
            class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white"
            type="submit">{{__('Save') }}</button>
    </div>
</form>
