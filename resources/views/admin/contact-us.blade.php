@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="row rg-20">
            <div class="col-xl-12">
                <div class="d-flex flex-column-reverse flex-sm-row justify-content-center justify-content-md-between align-items-center flex-wrap g-10 pb-18">
                    <div class="flex-grow-1">
                        <div class="search-one flex-grow-1 max-w-282">
                            <input type="text" id="search-key" placeholder="Search here..." />
                            <button class="icon"><img src="{{asset('assets/images/icon/search.svg')}}" alt="" /></button>
                        </div>
                    </div>
                </div>
                <div class="p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-10 bg-white">
                    <table class="table zTable zTable-last-item-right" id="contactUsDataTable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div>{{ __('#Sl') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('Name') }}</div>
                                </th>
                                <th scope="col">
                                    <div>{{ __('Email') }}</div>
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

    <div class="modal fade" id="contact-us-details" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

            </div>
        </div>
    </div>

    <input type="hidden" id="contact-us-route" value="{{ route('admin.contact-us') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/contact-us.js') }}"></script>
@endpush
