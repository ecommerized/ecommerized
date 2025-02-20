@extends('admin.layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <div class="row rg-20">
            <div class="col-xl-3">
                <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                    @include('admin.themes.partials.sidebar')
                </div>
            </div>
            <div class="col-xl-9">
                <div class="bg-white p-sm-25 p-15 bd-one bd-c-black-stroke bd-ra-8">
                    <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                          method="POST" enctype="multipart/form-data" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="row">
                            <div class="row">
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Project Live Title') }}</label>
                                    <input type="text" name="our_achievement_live_project_title" placeholder="{{__('Title of live project')}}" value="{{ getOption('our_achievement_live_project_title') }}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Project Live Number') }}</label>
                                    <input type="text" name="our_achievement_live_project_number" placeholder="{{__('Number of live project')}}" value="{{ getOption('our_achievement_live_project_number') }}"
                                           class="form-control zForm-control">
                                </div>
                            </div>
                            <div class="row pt-10">
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Wining Award Title') }}</label>
                                    <input type="text" name="our_achievement_wining_award_title" placeholder="{{__('Title of Wining Award')}}" value="{{ getOption('our_achievement_wining_award_title') }}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Wining Award Number') }}</label>
                                    <input type="text" name="our_achievement_wining_award_number" placeholder="{{__('Number of wining award')}}" value="{{ getOption('our_achievement_wining_award_number') }}"
                                           class="form-control zForm-control">
                                </div>
                            </div>
                            <div class="row pt-10">
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Satisfied Clients Title') }}</label>
                                    <input type="text" name="our_achievement_satisfied_clients_title" placeholder="{{__('Title of satisfied clients')}}" value="{{ getOption('our_achievement_satisfied_clients_title') }}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Satisfied Clients Number') }}</label>
                                    <input type="text" name="our_achievement_satisfied_clients_number" placeholder="{{__('Number of satisfied clients')}}" value="{{ getOption('our_achievement_satisfied_clients_number') }}"
                                           class="form-control zForm-control">
                                </div>
                            </div>
                            <div class="row pt-10">
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Years Experience Title') }}</label>
                                    <input type="text" name="our_achievement_years_of_experience_title" placeholder="{{__('Title of years experience')}}" value="{{ getOption('our_achievement_years_of_experience_title') }}"
                                           class="form-control zForm-control">
                                </div>
                                <div class="col-xxl-6 col-lg-6">
                                    <label class="zForm-label">{{ __('Years Experience Number') }}</label>
                                    <input type="text" name="our_achievement_years_of_experience_number" placeholder="{{__('Number of years experience')}}" value="{{ getOption('our_achievement_years_of_experience_number') }}"
                                           class="form-control zForm-control">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex g-12 flex-wrap mt-25">
                            <button type="submit"
                                    class="py-10 px-26 bg-button bd-one bd-c-button bd-ra-8 fs-15 fw-600 lh-25 text-white">{{
                                __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="activity-log-history-route" value="{{ route('admin.setting.activity-log.index') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/activity-log.js') }}"></script>
@endpush
