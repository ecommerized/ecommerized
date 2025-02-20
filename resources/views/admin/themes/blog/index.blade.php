@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="row rg-20">
            <div class="col-xl-12">
                <div
                    class="d-flex flex-column-reverse flex-sm-row justify-content-center justify-content-md-between align-items-center flex-wrap g-10 pb-18">
                    <div class="flex-grow-1">
                        <div class="search-one flex-grow-1 max-w-282">
                            <input type="text" id="search-key" placeholder="Search here..." />
                            <button class="icon"><img src="{{asset('assets/images/icon/search.svg')}}" alt="" /></button>
                        </div>
                    </div>
                    <!--  -->
                    <button class="border-0 bg-button py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white" type="button"
                            data-bs-toggle="modal" data-bs-target="#add-modal">
                        {{ __('Add Blog') }}
                    </button>
                </div>
                <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                    <table class="table zTable zTable-last-item-right" id="blogDatatable">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('#Sl') }}</div>
                            </th>
                            <th scope="col">
                                <div class="text-nowrap">{{ __('Banner Image') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Title') }}</div>
                            </th>
                            <th scope="col">
                                <div class="text-nowrap">{{ __('Category Name') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Status') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Action') }}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">
                <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
                    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Add Blog') }}</h2>
                    <div class="mClose">
                        <button type="button"
                                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                                data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                <form class="ajax reset" action="{{ route('admin.blogs.store') }}" method="post"
                      data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                    @csrf
                    <div class="row rg-20">
                        <div class="col-6">
                            <label for="title" class="zForm-label-alt">{{ __('Title') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" placeholder="{{ __('Type Blog Title') }}"
                                   class="form-control zForm-control">
                        </div>
                        <div class="col-6">
                            <label for="publishDate" class="zForm-label-alt">{{ __('Publish Date') }} <span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" name="publish_date" id="publishDate"
                                   class="form-control zForm-control">
                        </div>
                        <div class="col-6">
                            <label for="blogCategoryId" class="zForm-label-alt">{{ __('Blog Category') }}
                                <span class="text-danger">*</span></label>
                            <select class="sf-select-without-search" id="blogCategoryId" name="blog_category_id">
                                @foreach($category as $data)
                                    <option value="{{$data->id}}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="metaTitle" class="zForm-label-alt">{{ __('Meta Title') }} </label>
                            <input type="text" name="meta_title" id="metaTitle" placeholder="{{__('Type Meta Title')}}"
                                   class="form-control zForm-control">
                        </div>
                        <div class="col-6">
                            <label for="metaDescription" class="zForm-label-alt">{{ __('Meta Description') }} </label>
                            <input type="text" name="meta_description" id="metaDescription" placeholder="{{__('Type Meta Description')}}"
                                   class="form-control zForm-control">
                        </div>
                        <div class="col-6">
                            <label for="metaKeyword" class="zForm-label-alt">{{ __('Meta Keyword') }} </label>
                            <input type="text" name="meta_keyword" id="metaKeyword" placeholder="{{__('Type Meta Keyword')}}"
                                   class="form-control zForm-control">
                        </div>
                        <div class="col-6">
                            <label for="status" class="zForm-label-alt">{{ __('Status') }}
                                <span class="text-danger">*</span></label>
                            <select class="sf-select-without-search" id="status" name="status">
                                <option value="{{STATUS_ACTIVE}}">{{ __('Active') }}</option>
                                <option value="{{STATUS_DEACTIVATE}}">{{ __('Deactivate') }}</option>
                            </select>
                        </div>
                        <div class="">
                            <label for="details" class="zForm-label-alt">{{ __('Details') }} <span
                                    class="text-danger">*</span></label>
                            <textarea class="summernoteOne" name="details" id="details"
                                      placeholder="{{__('Details')}}"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details mw-100 mt-12">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12"><img
                                                src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                        </div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                        </p>
                                    </div>
                                    <label for="bannerImage" class="zForm-label-alt">{{ __('Banner Image') }} <span
                                            class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span> <span
                                            class="text-danger">*</span></label>
                                    <div class="upload-img-box">
                                        <img src="" />
                                        <input type="file" name="banner_image" id="bannerImage" accept="image/*"
                                               onchange="previewFile(this)" />
                                    </div>
                                    <span
                                        class="fs-12 fw-400 lh-24 text-button pt-3">{{__("Recommended: 880 px / 420 px")}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details mw-100 mt-12">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12"><img
                                                src="{{ asset('assets/images/icon/upload-img-1.svg') }}" alt="" />
                                        </div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}
                                        </p>
                                    </div>
                                    <label for="ogImage" class="zForm-label-alt">{{ __('OG Image') }} <span
                                            class="text-mime-type">{{__('(jpeg,png,jpg,svg,webp)')}}</span></label>
                                    <div class="upload-img-box">
                                        <img src="" />
                                        <input type="file" name="og_image" id="ogImage" accept="image/*"
                                               onchange="previewFile(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex g-12 flex-wrap mt-25">
                        <button
                            class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white"
                            type="submit">{{__('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->

    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->

    <input type="hidden" id="blog-route" value="{{ route('admin.blogs.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/theme/js/blog.js') }}"></script>
@endpush

