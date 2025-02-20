@extends('admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush

@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="overflow-x-hidden">
        <div class="p-sm-30 p-15">
            <div class="max-w-894 m-auto">
                <!--  -->
                <div class="d-flex justify-content-between align-items-center g-10 pb-12">
                    <!--  -->
                    <h4 class="fs-18 fw-600 lh-20 text-title-text">{{__("Add Package")}}</h4>
                    <!--  -->
                </div>
                <form class="ajax reset" action="{{route('admin.packages.store')}}" method="POST"
                      enctype="multipart/form-data" data-handler="commonResponseRedirect"
                      data-redirect-url="{{route('admin.packages.index')}}">
                    @csrf

                    <!--  -->
                    <div class="py-sm-30 px-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white mb-40">
                        <div class="max-w-713 m-auto py-sm-52 px-sm-25">
                            <!--  -->
                            <div class="row rg-20">
                                <div class="col-12">
                                    <label for="createPackageName" class="zForm-label">{{__("Package Name")}}
                                        <span class="text-red">*</span></label>
                                    <input type="text" class="form-control zForm-control" id="createPackageName"
                                           placeholder="{{__("Package Name")}}" name="name"/>
                                </div>
                                <div class="col-12">
                                    <label for="createPackageDescription" class="zForm-label">{{__("Description")}}
                                        <span class="text-red">*</span></label>
                                    <textarea id="createPackageDescription" class="form-control zForm-control min-h-175"
                                              placeholder="{{__("Write description here....")}}"
                                              name="details"></textarea>
                                </div>

                                <div class="col-12 table-responsive">
                                    <label for="createPackageSetDeadline"
                                           class="zForm-label">{{__("Package Services")}}</label>
                                    <table class="table zTable zTable-last-item-right" id="inputTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="text-nowrap">{{ __('Service') }}</div>
                                            </th>
                                            <th>
                                                <div>{{ __('Quantity') }}</div>
                                            </th>
                                            <th>
                                                <div>{{ __('Action') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="packageItems">
                                        <tr>
                                            <td>
                                                <div class="min-w-100">
                                                    <select name="service_id[]" class="form-select form-select-lg service_id">
                                                        @foreach($serviceData as $data)
                                                            <option value="{{ $data->id }}">{{ $data->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td colspan="2" class="text-center pt-17">
                                                <div class="input-group mb-3 flex-nowrap mt-3">
                                                    <input type="number" name="quantity[]"
                                                           placeholder="{{ __('Quantity') }}"
                                                           class="quantity form-control zForm-control zForm-control-table">
                                                    <select name="quantity_type[]"
                                                            class="quantity_type customer_limit_type form-select form-select-lg">
                                                        <option selected value="1">{{ __('Limited') }}</option>
                                                        <option value="2">{{ __('Unlimited') }}</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <button type="button" id="addMorePackageBtn"
                                            class="mt-12 border-0 p-0 bg-transparent fs-14 fw-500 lh-22 text-button text-decoration-underline">
                                        +{{ __('Add More') }}
                                    </button>
                                </div>

                                <div class="col-12 table-responsive">
                                    <label for="createPackageSetDeadline"
                                           class="zForm-label">{{ __("Features") }}</label>
                                    <table class="table zTable zTable-last-item-right" id="featureTable">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="text-nowrap">{{ __('Title') }}</div>
                                            </th>
                                            <th>
                                                <div>{{ __('Available') }}</div>
                                            </th>
                                            <th>
                                                <div>{{ __('Action') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="featureItems">
                                        <tr>
                                            <td>
                                                <div class="min-w-100">
                                                    <input type="text" name="other_name[]"
                                                           class="other_name feature-name form-control zForm-control zForm-control-table"
                                                           placeholder="Feature Name"/>
                                                </div>
                                            </td>
                                            <td class="text-center pt-17">
                                                <select name="other_value[]"
                                                        class="form-select other_value form-select form-select-lg">
                                                    <option selected value="1">{{ __('Yes') }}</option>
                                                    <option value="0">{{ __('No') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button"
                                                        class="bd-one bd-c-black-stroke rounded-circle bg-transparent ms-auto w-30 h-30 d-flex justify-content-center align-items-center text-red removeFeature">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" id="addMoreFeatureBtn"
                                            class="mt-12 border-0 p-0 bg-transparent fs-14 fw-500 lh-22 text-button text-decoration-underline">
                                        +{{ __('Add More') }}
                                    </button>
                                </div>
                                <div class="col-6">
                                    <label for="monthlyPrice"
                                           class="zForm-label">{{__("Monthly Price")}}</label>
                                    <div class="sf-input-wrap">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control zForm-control"
                                                   id="monthlyPrice" placeholder="0.00"
                                                   name="monthly_price"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="yearlyPrice"
                                           class="zForm-label">{{__("Yearly Price")}}</label>
                                    <div class="sf-input-wrap">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control zForm-control"
                                                   id="yearlyPrice" placeholder="0.00"
                                                   name="yearly_price"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="fs-15 fw-600 lh-24 text-title-text pb-8">{{__("Upload Icon (JPG, JPEG, PNG)")}}</p>
                                    <div class="d-flex align-items-center g-10">
                                        <!--  -->
                                        <div class="servicePhotoUpload d-flex flex-column g-10 w-100">
                                            <label for="zImageUpload">
                                                <p class="fs-12 fw-500 lh-16 text-para-text">{{__("Choose Image to upload")}}</p>
                                                <p class="fs-12 fw-500 lh-16 text-white">{{__("Browse File")}}</p>
                                            </label>
                                            <span
                                                class="fs-12 fw-400 lh-24 text-button pt-3">{{__("Recommended: 36 PX/36 PX")}}</span>
                                            <div class="max-w-150 flex-shrink-0">
                                                <img src="" class="p-10" id="serviceImage"/>
                                                <input type="file" name="icon" id="zImageUpload" accept="image/*"
                                                       class="position-absolute invisible"
                                                       onchange="previewFile(this)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="zForm-label" for="rtl">{{ __('Status') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-select form-select-lg service_id">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0">{{ __('Deactivated') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex g-12 mt-25">
                        <button type="submit" class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white align-items-center d-flex gap-2">
                            <div class="d-none h-16 spinner-border w-16" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                            {{__("Save")}}
                        </button>
                        <a href="{{ URL::previous() }}"
                           class="py-10 px-26 bg-white bd-one bd-c-para-text bd-ra-8 fs-15 fw-600 lh-25 text-para-text">{{__("Cancel")}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="d-none" id="clone-custom-service">
        <tr>
            <td>
                <div class="min-w-100">
                    <select name="service_id[]" class="form-select service_id">
                        @foreach($serviceData as $data)
                            <option value="{{ $data->id }}">{{ $data->title }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td class="text-center pt-17">
                <div class="input-group mb-3 flex-nowrap mt-3">
                    <input type="number" name="quantity[]" placeholder="{{ __('Quantity') }}"
                           class="quantity form-control zForm-control zForm-control-table">
                    <select name="quantity_type[]" class="quantity_type customer_limit_type form-select form-select-lg">
                        <option selected value="1">{{ __('Limited') }}</option>
                        <option value="2">{{ __('Unlimited') }}</option>
                    </select>
                </div>
            </td>
            <td>
                <button type="button"
                        class="bd-one bd-c-black-stroke rounded-circle bg-transparent ms-auto w-30 h-30 d-flex justify-content-center align-items-center text-red removePackage">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    </table>

    <table class="d-none" id="clone-custom-features">
        <tr>
            <td>
                <div class="min-w-100">
                    <input type="text" name="other_name[]"
                           class="other_name feature-name form-control zForm-control zForm-control-table"
                           placeholder="Feature Name"/>
                </div>
            </td>
            <td class="text-center pt-17">
                <div class="min-w-100">
                    <select name="other_value[]" class="form-select other_value primary-form-control">
                        <option selected value="1">{{ __('Yes') }}</option>
                        <option value="0">{{ __('No') }}</option>
                    </select>
                </div>
            </td>
            <td>
                <button type="button"
                        class="bd-one bd-c-black-stroke rounded-circle bg-transparent ms-auto w-30 h-30 d-flex justify-content-center align-items-center text-red removeFeature">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    </table>

@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/packages.js') }}"></script>
@endpush

