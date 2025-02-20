<div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Update Testimonial') }}</h2>
    <div class="mClose">
        <button type="button"
                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
<form class="ajax reset" action="{{ route('admin.theme-settings.testimonials.store') }}" method="post"
      data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$testimonialData->id}}">
    <div class="row rg-20">
        <div class="col-6">
            <label class="zForm-label">{{ __('Name') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" name="name" value="{{ $testimonialData->name }}"
                   placeholder="{{ __('Type name') }}">
        </div>
        <div class="col-6">
            <label class="zForm-label">{{ __('Designation') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" name="designation" value="{{ $testimonialData->designation }}"
                   placeholder="{{ __('Type designation') }}">
        </div>
        <div class="col-6">
            <div class="primary-form-group">
                <div class="primary-form-group-wrap zImage-upload-details mw-100">
                    <div class="zImage-inside">
                        <div class="d-flex pb-12"><img
                                src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                        </div>
                        <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                        </p>
                    </div>
                    <label for="zImageUpload" class="zForm-label">{{ __('Image') }} <span
                            class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span> <span
                            class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($testimonialData->image) }}" />
                        <input type="file" name="image" accept="image/*"
                               onchange="previewFile(this)" />
                    </div>
                    <span
                        class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 66 px / 66 px")}}</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <label class="zForm-label">{{ __('Comment') }} <span
                    class="text-danger">*</span></label>
            <textarea class="form-control zForm-control"  name="comment" rows="6" cols="50">{!! $testimonialData->comment !!}</textarea>
        </div>
        @if(getOption('app_theme_style') == THEME_HOME_ONE)
            <div class="col-6">
                <label class="zForm-label" for="status">{{ __('Category Id') }} <span
                        class="text-danger">*</span></label>
                <select name="category_id" class="sf-select-without-search">
                    @foreach($category as $data)
                        <option {{ $testimonialData->category_id == $data->id ? 'selected' : '' }} value="{{$data->id}}">{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-6">
            <label class="zForm-label" for="status">{{ __('Status') }} <span
                    class="text-danger">*</span></label>
            <select name="status" class="sf-select-without-search">
                <option {{ $testimonialData->status == STATUS_ACTIVE ? 'selected' : '' }} value="{{STATUS_ACTIVE}}">{{ __('Active') }}</option>
                <option {{ $testimonialData->status == STATUS_DEACTIVATE ? 'selected' : '' }} value="{{STATUS_DEACTIVATE}}">{{ __('Deactivate') }}</option>
            </select>
        </div>
        @if(getOption('app_theme_style') == THEME_HOME_THREE)
            <div class="col-6">
                <label class="zForm-label">{{ __('Rating') }} <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control zForm-control" name="rating" value="{{ $testimonialData->rating }}"
                       placeholder="{{ __('Type rating') }}">
            </div>
        @endif
    </div>
    <div class="d-flex g-12 flex-wrap mt-25">
        <button
            class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white"
            type="submit">{{__('Save') }}</button>
    </div>
</form>
