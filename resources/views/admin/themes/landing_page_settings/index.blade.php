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
                <div class="bg-white p-sm-3 p-15 bd-one bd-c-black-stroke bd-ra-8">
                    <form class="ajax" action="{{ route('admin.setting.configuration-settings.update') }}" method="POST"
                          enctype="multipart/form-data" data-handler="settingCommonHandler">
                        @csrf
                        <input type="hidden" id="configureUrl" value="{{ route('admin.setting.configuration-landing-page-settings.configure') }}">
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable zTable-last-item-right zTable-section-setting">
                                <thead>
                                <tr>
                                    <th class="min-w-160">
                                        <div>{{ __('Section Name') }}</div>
                                    </th>
                                    <th>
                                        <div class="text-center">{{ __('Status') }} </div>
                                    </th>
                                    <th>
                                        <div>{{ __('Action') }} </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <h6>{{ __('Hero Banner') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'hero_banner_status')" value="1" {{ getOption('hero_banner_status')==STATUS_ACTIVE ? 'checked' : '' }} name="hero_banner_status" type="checkbox" role="switch" id="hero_banner_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_hero_banner')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('About Us Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'about_us_status')" value="1" {{ getOption('about_us_status')==STATUS_ACTIVE ? 'checked' : '' }} name="about_us_status" type="checkbox" role="switch" id="service_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_about_us')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Our Service Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'our_service_status')" value="1" {{ getOption('our_service_status')==STATUS_ACTIVE ? 'checked' : '' }} name="our_service_status" type="checkbox" role="switch" id="our_service_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_our_service')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Our Project / Portfolio Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'our_project_status')" value="1" {{ getOption('our_project_status')==STATUS_ACTIVE ? 'checked' : '' }} name="our_project_status" type="checkbox" role="switch" id="our_project_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_our_project')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Choose Us Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'choose_us_status')" value="1" {{ getOption('choose_us_status')==STATUS_ACTIVE ? 'checked' : '' }} name="choose_us_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_choose_us')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Our Process Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'our_process_status')" value="1" {{ getOption('our_process_status')==STATUS_ACTIVE ? 'checked' : '' }} name="our_process_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_our_process')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Pricing Plan Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'pricing_plan_status')" value="1" {{ getOption('pricing_plan_status')==STATUS_ACTIVE ? 'checked' : '' }} name="pricing_plan_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_pricing_plan')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Membership Benefits Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'membership_benefits_status')" value="1" {{ getOption('membership_benefits_status')==STATUS_ACTIVE ? 'checked' : '' }} name="membership_benefits_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_membership_benefits')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Testimonial Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'testimonial_status')" value="1" {{ getOption('testimonial_status')==STATUS_ACTIVE ? 'checked' : '' }} name="testimonial_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_testimonial')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('News & Articles / Blog Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'blog_status')" value="1" {{ getOption('blog_status')==STATUS_ACTIVE ? 'checked' : '' }} name="blog_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_blog')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Faq Section') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the landing page and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'faq_status')" value="1" {{ getOption('faq_status')==STATUS_ACTIVE ? 'checked' : '' }} name="faq_status" type="checkbox" role="switch" id="faq_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('landing_page_faq')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Service Details Our Touch Point') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the service details our touch point and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'service_details_touch_point_status')" value="1" {{ getOption('service_details_touch_point_status')==STATUS_ACTIVE ? 'checked' : '' }} name="service_details_touch_point_status" type="checkbox" role="switch" id="service_details_touch_point_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('service_details_touch_point')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('Service Details Our Approach') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the service details our approach and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'service_details_our_approach_status')" value="1" {{ getOption('service_details_our_approach_status')==STATUS_ACTIVE ? 'checked' : '' }} name="service_details_our_approach_status" type="checkbox" role="switch" id="service_details_our_approach_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('service_details_our_approach')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('About Us Details Our Journey') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the about us details our journey and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'about_us_our_journey_status')" value="1" {{ getOption('about_us_our_journey_status')==STATUS_ACTIVE ? 'checked' : '' }} name="about_us_our_journey_status" type="checkbox" role="switch" id="about_us_our_journey_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('about_us_details_our_journey')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>{{ __('About Us Details Team Member') }}</h6>
                                        <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the about us details team member and updates the functionality of this content accordingly.') }})</small>
                                    </td>
                                    <td class="text-center pt-17">
                                        <div class="zCheck form-switch">
                                            <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'about_us_our_team_member_status')" value="1" {{ getOption('about_us_our_team_member_status')==STATUS_ACTIVE ? 'checked' : '' }} name="about_us_our_team_member_status" type="checkbox" role="switch" id="about_us_our_team_member_status">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                            <button type="button"
                                                    class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                    onclick="landingPageModal('about_us_details_our_team_member')"
                                                    title="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @if(getOption('app_theme_style') == THEME_HOME_THREE)
                                    <tr>
                                        <td>
                                            <h6>{{ __('About Us Details Our Mission') }}</h6>
                                            <small class="fst-italic fw-normal">({{ __('Enabling this section will ensure it is clearly visible to users on the about us details our mission and updates the functionality of this content accordingly.') }})</small>
                                        </td>
                                        <td class="text-center pt-17">
                                            <div class="zCheck form-switch">
                                                <input class="form-check-input mt-0" onchange="changeSettingStatus(this,'about_us_our_mission_status')" value="1" {{ getOption('about_us_our_mission_status')==STATUS_ACTIVE ? 'checked' : '' }} name="about_us_our_mission_status" type="checkbox" role="switch" id="about_us_our_mission_status">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action__buttons d-flex justify-content-end flex-wrap g-10">
                                                <button type="button"
                                                        class="d-inline-block fs-15 fw-500 lh-25 text-white py-6 px-15 bg-button hover-bg-one border-0 bd-ra-8"
                                                        onclick="landingPageModal('about_us_details_our_mission')"
                                                        title="{{ __('Edit') }}">
                                                    {{ __('Edit') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration section start -->
    <div class="modal fade main-modal" id="configureModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-4 p-sm-25 p-15">

            </div>
        </div>
    </div>
    <input type="hidden" id="statusChangeRoute" value="{{ route('admin.setting.configuration-settings.update') }}">

@endsection

@push('script')
    <script src="{{ asset('admin/custom/js/configuration.js') }}"></script>
@endpush
