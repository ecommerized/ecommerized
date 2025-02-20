@extends('admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush
@section('content')
    <!-- Content -->
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="max-w-894 m-auto">
            <!--  -->
            <h4 class="fs-18 fw-600 lh-20 text-title-text pb-17">{{$pageTitle}}</h4>
            <!--  -->
            <form method="POST" class="ajax reset" action="{{ route('admin.client-orders.store') }}" data-handler="commonResponseRedirect"
                  data-redirect-url="{{route('admin.client-orders.list')}}">
                @csrf

                <div class="px-sm-25 px-15 bd-one bd-c-stroke bd-ra-10 bg-white mb-28">
                    <div class="max-w-713 m-auto py-sm-52 py-15">
                        <!--  -->
                        <input type="hidden" name="pay_amount" id="pay-amount" value="">
                        <div class="row rg-20">
                            <div class="col-12">
                                <label for="client_id" class="zForm-label">{{__('Select
                                    Client')}}</label>
                                <select class="sf-select-two" name="client_id" id="client_id">
                                    <option value="">{{__('Select client')}}</option>
                                    @foreach($allClient as $client)
                                        <option value="{{$client->id}}">{{$client?->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="package_id" class="zForm-label">{{__('Select
                                    Plan')}}</label>
                                <select class="sf-select-two" name="package_id" id="package_id">
                                    <option value="">{{__('Select Plan')}}</option>
                                    @foreach($allPackage as $package)
                                        <option value="{{$package->id}}">{{$package?->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="plan_duration" class="zForm-label">{{__('Select
                                    Plan Duration')}}</label>
                                <select class="sf-select-two" name="plan_duration" id="plan_duration">
                                    <option value="">{{__('Select Plan Duration')}}</option>
                                        <option value="{{DURATION_MONTH}}">{{__('Monthly')}}</option>
                                        <option value="{{DURATION_YEAR}}">{{__('Yearly')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-start flex-wrap g-14 pb-25">
                        <button type="submit"
                                class="bd-one bd-c-button bd-ra-8 py-10 px-26 bg-button fs-15 fw-600 lh-25 text-white">
                            {{__('Create Order')}}
                        </button>
                        <a href="{{ URL::previous() }}"
                           class="bd-one bd-c-para-text bd-ra-8 py-10 px-26 bg-white fs-15 fw-600 lh-25 text-para-text">
                            {{__('Cancel')}}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <input type="hidden" id="service-data-route" value="{{ route('admin.client-orders.all-service') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/client-orders.js') }}"></script>
@endpush
