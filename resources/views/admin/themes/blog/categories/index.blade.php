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
                        {{ __('Add Blog Category') }}
                    </button>
                </div>
                <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                    <table class="table zTable zTable-last-item-right" id="blogCategoryDatatable">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('#Sl') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Name') }}</div>
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">
                <div class="bd-b-one bd-c-black-stroke pb-20 mb-20 d-flex align-items-center flex-wrap justify-content-between g-10">
                    <h2 class="fs-18 fw-600 lh-22 text-title-text">{{ __('Add Blog Category') }}</h2>
                    <div class="mClose">
                        <button type="button"
                                class="bd-one bd-c-black-stroke rounded-circle w-24 h-24 bg-transparent text-para-text fs-13"
                                data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>

                <form class="ajax reset" action="{{ route('admin.blogs.categories.store') }}" method="post"
                      data-handler="commonResponseWithPageLoad" enctype="multipart/form-data">
                    @csrf
                    <div class="row rg-20">
                        <div class="">
                            <label for="name" class="zForm-label-alt">{{ __('Category') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="{{ __('Type Blog Categories') }}"
                                   class="form-control zForm-control">
                        </div>
                        <div class="">
                            <label for="status" class="zForm-label-alt">{{ __('Status') }}
                                <span class="text-danger">*</span></label>
                            <select class="sf-select-without-search" id="status" name="status">
                                <option value="{{STATUS_ACTIVE}}">{{ __('Active') }}</option>
                                <option value="{{STATUS_DEACTIVATE}}">{{ __('Deactivate') }}</option>
                            </select>
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->

    <input type="hidden" id="blog-category-route" value="{{ route('admin.blogs.categories.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/theme/js/blog-category.js') }}"></script>
@endpush

