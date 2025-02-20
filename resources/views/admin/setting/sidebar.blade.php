<ul class="settings-sidebar zList-three">
    <li>
        <a href="{{ route('admin.setting.profile.index') }}"
            class="d-flex justify-content-between align-items-center cg-10 {{ @$activeProfile }}">
            <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Profile') }}</span>
            <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
        </a>
    </li>
    @can('Settings')
        <li>
            <a href="{{ route('admin.setting.application-settings') }}"
                class="d-flex justify-content-between align-items-center cg-10 {{ @$subApplicationSettingActiveClass }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Application Setting') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.logo-settings') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$subLogoSettingActiveClass }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Logo Setting') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.currencies.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$activeCurrenciesSetting }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Currency Settings') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.languages.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$activeLanguageSettings }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Language Settings') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.storage.index') }}"
                class="d-flex justify-content-between align-items-center cg-10 {{ @$subStorageSettingActiveClass }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Storage Setting') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.gateway.index') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$activeGateway }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Payment Settings') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.role-permission.list') }}"
               class="d-flex justify-content-between align-items-center cg-10 {{ @$activeRolePermission }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Role & Permission') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.maintenance') }}"
                class="d-flex justify-content-between align-items-center cg-10 {{ @$subMaintenanceModeActiveClass }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Maintenance Mode') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.designation.index') }}"
                class="d-flex justify-content-between align-items-center cg-10 {{ @$activeDesignation }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Designation') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.setting.activity-log.index') }}"
                class="d-flex justify-content-between align-items-center cg-10 {{ @$activeClientActivityLog }}">
                <span class="fs-16 fw-600 lh-22 text-title-text">{{ __('Activity Log') }}</span>
                <div class="d-flex text-title-text"><i class="fa-solid fa-angle-right"></i></div>
            </a>
        </li>
    @endcan
</ul>
