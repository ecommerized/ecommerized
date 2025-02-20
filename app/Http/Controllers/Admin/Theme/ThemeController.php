<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Models\LandingPageSetting;


class ThemeController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = __('Themes Settings');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeTheme'] = 'active';
        return view('admin.themes.index', $data);
    }

    public function ctaSection()
    {
        $data['pageTitle'] = __('CTA Section');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeCtaSection'] = 'active';
        return view('admin.themes.cta-page', $data);
    }

    public function ourAchievement()
    {
        $data['pageTitle'] = __('Our Achievements');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeOurAchievements'] = 'active';
        return view('admin.themes.our-achievements', $data);
    }

    public function pageSection()
    {
        $data['pageTitle'] = __('Page Section');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activePageSection'] = 'active';
        return view('admin.themes.page-section', $data);
    }

    public function landingPageSetting(){

        $data['pageTitle'] = __('Landing Page Settings');
        $data['activeThemeSettingsIndex'] = 'active';
        $data['activeLandingPageSettings'] = 'active';
        $data['collection'] = LandingPageSetting::all();
        return view('admin.themes.landing_page_settings.index', $data);
    }
}






