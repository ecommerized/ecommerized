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
                    <a href="{{route('admin.services.create')}}" class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Add Service')}}</a>
                </div>
                <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                    <table class="table zTable zTable-last-item-right" id="serviceDataTable">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('Icon') }}</div>
                            </th>
                            <th scope="col">
                                <div class="text-nowrap">{{ __('Banner Image') }}</div>
                            </th>
                            <th scope="col">
                                <div >{{ __('Title') }}</div>
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

    <input type="hidden" id="service-route" value="{{ route('admin.services.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/service.js') }}"></script>
@endpush


