@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-15">
        <div class="row rg-20">
            <div class="px-sm-30  p-15 bd-c-stroke-2 d-flex justify-content-between align-items-center">
                <h4 class="fs-18 fw-700 lh-24 text-title-text">{{__('Update Service')}}</h4>
                <a href="{{route('admin.services.index')}}"
                   class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Back')}}</a>
            </div>
            <div class="">
                <div class="row rg-20">
                    <form class="ajax reset" action="{{ route('admin.services.store') }}" method="post"
                          data-handler="commonResponseRedirect"
                          data-redirect-url="{{ route('admin.services.index') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{encodeId($serviceData->id)}}">
                        @include('admin.services.form')
                        <div class="bd-c-stroke-2 justify-content-between align-items-center text-end pt-15">
                            <button type="submit" class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{__('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/service.js') }}"></script>
@endpush


