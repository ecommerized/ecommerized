<div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Update Portfolio') }}</h2>
    <div class="mClose">
        <button type="button"
                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
<form class="ajax reset" action="{{ route('admin.theme-settings.portfolios.store') }}" method="post"
      data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$portfolioData->id}}">
    <div class="row rg-20">
        <div class="col-6">
            <label class="zForm-label">{{ __('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" name="title" value="{{ $portfolioData->title }}"
                   placeholder="{{ __('Type title') }}">
        </div>
        <div class="col-6">
            <label for="label" class="zForm-label-alt">{{ __('Services') }} <span
                    class="text-danger">*</span></label>
            @php
                $subTitles = is_string($portfolioData->tag) ? json_decode($portfolioData->tag, true) : $portfolioData->tag;
            @endphp
            <select class="primary-form-control sf-select-modal-label" multiple name="tag[]">
                @foreach ($subTitles as $subtitle)
                    <option value="{{ $subtitle }}" selected>{{ $subtitle }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label class="zForm-label">{{ __('Client Name') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" name="client_name" value="{{ $portfolioData->client_name }}"
                   placeholder="{{ __('Type client name') }}">
        </div>
        <div class="col-4">
            <label class="zForm-label">{{ __('Client Location') }} <span
                    class="text-danger">*</span></label>
            <input type="text" class="form-control zForm-control" name="location" value="{{ $portfolioData->location }}"
                   placeholder="{{ __('Type location') }}">
        </div>
        <div class="col-4">
            <label class="zForm-label">{{ __('Date') }} <span
                    class="text-danger">*</span></label>
            <input type="date" class="form-control zForm-control" name="date" value="{{ $portfolioData->date }}">
        </div>
        <div class="col-6">
            <label class="zForm-label" for="status">{{ __('Portfolio Category') }} <span
                    class="text-danger">*</span></label>
            <select name="category_id" class="sf-select-without-search">
                @foreach($category as $data)
                    <option {{ $portfolioData->category_id == $data->id ? 'selected' : '' }} value="{{$data->id}}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <label class="zForm-label" for="status">{{ __('Status') }} <span
                    class="text-danger">*</span></label>
            <select name="status" class="sf-select-without-search">
                <option {{ $portfolioData->status == STATUS_ACTIVE ? 'selected' : '' }} value="{{STATUS_ACTIVE}}">{{ __('Active') }}</option>
                <option {{ $portfolioData->status == STATUS_DEACTIVATE ? 'selected' : '' }} value="{{STATUS_DEACTIVATE}}">{{ __('Deactivate') }}</option>
            </select>
        </div>
        <div class="col-12">
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
                        <img src="{{ getFileUrl($portfolioData->banner_image) }}" />
                        <input type="file" name="banner_image" accept="image/*"
                               onchange="previewFile(this)" />
                    </div>
                    <span
                        class="fs-12 fw-400 lh-24 text-main-color pt-3">{{__("Recommended: 1320 px / 710 px")}}</span>
                </div>
            </div>
        </div>
        <div class="pt-15">
            <div class="">
                <label class="zForm-label-alt">{{ __('Details') }} <span
                        class="text-danger">*</span></label>
                <textarea class="summernoteOne" name="details" placeholder="{{__('Type details')}}" >{!! $portfolioData->details !!}</textarea>
            </div>
        </div>
    </div>
    <div class="d-flex g-12 flex-wrap mt-25">
        <button
            class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white"
            type="submit">{{__('Save') }}</button>
    </div>
</form>
