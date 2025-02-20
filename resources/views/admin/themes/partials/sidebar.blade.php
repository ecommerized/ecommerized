<ul class="settings-sidebar zList-three">
    <li>
        <a href="{{ route('admin.theme-settings.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeTheme }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Themes Settings') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.setting.color-settings') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeColorIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Color Settings') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.landing-page-setting') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeLandingPageSettings }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Landing Page Settings') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.choose-us.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeChooseUsIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Choose Us') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.working-process.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeWorkingProcessIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Working Process') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.membership-benefits.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeMembershipBenefitsIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Membership Benefits') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    @if(getOption('app_theme_style') == THEME_HOME_ONE)
        <li>
            <a href="{{ route('admin.theme-settings.testimonials.categories.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$activeTestimonialsCategories }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Testimonial Category') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
    @endif
    <li>
        <a href="{{ route('admin.theme-settings.testimonials.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeTestimonialIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Testimonial') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.faqs.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeFaqIndex }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Faq') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.cta-section') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeCtaSection }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('CTA Section') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.our-achievements') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activeOurAchievements }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Our Achievements') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.theme-settings.pages.index') }}"
           class="d-flex justify-content-between align-items-center cg-10 {{ @$activePageSection }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Page Section') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>

</ul>
