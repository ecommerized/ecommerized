<?php

use App\Http\Controllers\AddonUpdateController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientInvoiceController;
use App\Http\Controllers\Admin\ClientOrderController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderTaskBoardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolePermisionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\Theme\AboutUsController;
use App\Http\Controllers\Admin\Theme\BlogCategoryController;
use App\Http\Controllers\Admin\Theme\BlogController;
use App\Http\Controllers\Admin\Theme\ChooseUsController;
use App\Http\Controllers\Admin\Theme\FaqController;
use App\Http\Controllers\Admin\Theme\MembershipBenefitsController;
use App\Http\Controllers\Admin\Theme\OurServiceController;
use App\Http\Controllers\Admin\Theme\PageController;
use App\Http\Controllers\Admin\Theme\PortfolioCategoryController;
use App\Http\Controllers\Admin\Theme\PortfolioController;
use App\Http\Controllers\Admin\Theme\TestimonialCategoryController;
use App\Http\Controllers\Admin\Theme\TestimonialController;
use App\Http\Controllers\Admin\Theme\ThemeController;
use App\Http\Controllers\Admin\Theme\WorkingProcessController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Superadmin\EmailTemplateController;
use App\Http\Controllers\VersionUpdateController;
use App\Models\Language;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/local/{ln}', function ($ln) {
    $language = Language::where('iso_code', $ln)->first();
    if (!$language) {
        $language = Language::where('default', 1)->first();
        if ($language) {
            $ln = $language->iso_code;
        }
    }
    session()->put('local', $ln);
    return redirect()->back();
})->name('local');


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('recent-open-order', [DashboardController::class, 'recentOpenOrder'])->name('recent-open-order');
Route::get('revenue-overview-chart-data', [DashboardController::class, 'revenueOverviewChartData'])->name('revenue-overview-chart-data');
Route::get('client-overview-chart-data', [DashboardController::class, 'clientOverviewChartData'])->name('client-overview-chart-data');
Route::get('contact-us', [DashboardController::class, 'contactUs'])->name('contact-us');
Route::get('contact-us-details/{id}', [DashboardController::class, 'contactUsDetails'])->name('contact-us-details');

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
    // setting start
    Route::get('application-settings', [SettingController::class, 'applicationSetting'])->name('application-settings')->middleware('can:Manage Setting');
    Route::post('application-settings-update', [SettingController::class, 'applicationSettingUpdate'])->name('application-settings.update')->middleware('can:Manage Setting');
    Route::post('theme-settings-update', [SettingController::class, 'themeSettingsUpdate'])->name('themes-settings.update')->middleware('can:Manage Setting')->middleware('isDemo');
    Route::get('configuration-settings', [SettingController::class, 'configurationSetting'])->name('configuration-settings')->middleware('can:Manage Setting')->middleware('isDemo');
    Route::get('configuration-settings/configure', [SettingController::class, 'configurationSettingConfigure'])->name('configuration-settings.configure')->middleware('can:Manage Setting');
    Route::get('configuration-landing-page-settings/configure', [SettingController::class, 'configurationLandingPageConfigure'])->name('configuration-landing-page-settings.configure')->middleware('can:Manage Setting');
    Route::get('configuration-settings/help', [SettingController::class, 'configurationSettingHelp'])->name('configuration-settings.help')->middleware('can:Manage Setting');
    Route::post('configuration-settings-update', [SettingController::class, 'configurationSettingUpdate'])->name('configuration-settings.update')->middleware('can:Manage Setting');
    Route::post('configuration-landing-page-settings-update', [SettingController::class, 'landingPageSettingUpdate'])->name('configuration-landing-page-settings.update')->middleware('isDemo')->middleware('can:Manage Setting');
    Route::post('application-env-update', [SettingController::class, 'saveSetting'])->name('settings_env.update')->middleware('can:Manage Setting');
    Route::get('logo-settings', [SettingController::class, 'logoSettings'])->name('logo-settings')->middleware('can:Manage Setting');
    Route::get('color-settings', [SettingController::class, 'colorSettings'])->name('color-settings')->middleware('can:Manage Setting');
    Route::get('storage-settings', [SettingController::class, 'storageSetting'])->name('storage.index')->middleware('can:Manage Setting');
    Route::post('storage-settings', [SettingController::class, 'storageSettingsUpdate'])->name('storage.update')->middleware('can:Manage Setting');
    Route::get('storage-link', [SettingController::class, 'storageLink'])->name('storage.link')->middleware('can:Manage Setting');
    Route::get('maintenance-mode-changes', [SettingController::class, 'maintenanceMode'])->name('maintenance')->middleware('can:Manage Setting')->middleware('isDemo');
    Route::post('maintenance-mode-changes', [SettingController::class, 'maintenanceModeChange'])->name('maintenance.change')->middleware('can:Manage Setting')->middleware('isDemo');

    Route::get('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration')->middleware('can:Manage Setting');
    Route::post('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration')->middleware('can:Manage Setting');
    Route::post('mail-test', [SettingController::class, 'mailTest'])->name('mail.test')->middleware('can:Manage Setting');
    // setting end

    Route::group(['prefix' => 'gateway', 'as' => 'gateway.'], function () {
        Route::get('/', [GatewayController::class, 'index'])->name('index')->middleware('can:Manage Setting');
        Route::post('store', [GatewayController::class, 'store'])->name('store')->middleware('isDemo')->middleware('can:Manage Setting');
        Route::get('edit/{id}', [GatewayController::class, 'edit'])->name('edit')->middleware('isDemo')->middleware('can:Manage Setting');
        Route::get('get-info', [GatewayController::class, 'getInfo'])->name('get.info')->middleware('can:Manage Setting');
        Route::get('get-currency-by-gateway', [GatewayController::class, 'getCurrencyByGateway'])->name('get.currency')->middleware('can:Manage Setting');
        Route::get('syncs', [GatewayController::class, 'syncs'])->name('syncs')->middleware('can:Manage Setting');

    });

    Route::group(['prefix' => 'language', 'as' => 'languages.'], function () {
        Route::get('/', [LanguageController::class, 'index'])->name('index')->middleware('can:Manage Setting');
        Route::post('store', [LanguageController::class, 'store'])->name('store')->middleware('can:Manage Setting');
        Route::get('edit/{id}/{iso_code?}', [LanguageController::class, 'edit'])->name('edit')->middleware('can:Manage Setting');
        Route::post('update/{id}', [LanguageController::class, 'update'])->name('update')->middleware('can:Manage Setting');
        Route::get('translate/{id}', [LanguageController::class, 'translateLanguage'])->name('translate')->middleware('can:Manage Setting');
        Route::post('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate')->middleware('can:Manage Setting');
        Route::post('delete/{id}', [LanguageController::class, 'delete'])->name('delete')->middleware('can:Manage Setting');
        Route::post('update-language/{id}', [LanguageController::class, 'updateLanguage'])->name('update-language')->middleware('can:Manage Setting');
        Route::get('translate/{id}/{iso_code?}', [LanguageController::class, 'translateLanguage'])->name('translate')->middleware('can:Manage Setting');
        Route::get('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate')->middleware('can:Manage Setting');
        Route::post('import', [LanguageController::class, 'import'])->name('import')->middleware('isDemo')->middleware('can:Manage Setting');
    });

    Route::group(['prefix' => 'currency', 'as' => 'currencies.'], function () {
        Route::get('', [CurrencyController::class, 'index'])->name('index')->middleware('can:Manage Setting');
        Route::post('currency', [CurrencyController::class, 'store'])->name('store')->middleware('can:Manage Setting');
        Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('edit')->middleware('can:Manage Setting');
        Route::patch('update/{id}', [CurrencyController::class, 'update'])->name('update')->middleware('can:Manage Setting');
        Route::post('delete/{id}', [CurrencyController::class, 'delete'])->name('delete')->middleware('can:Manage Setting');
    });

    Route::group(['prefix' => 'role-permission', 'as' => 'role-permission.'], function () {
        Route::get('/', [RolePermisionController::class, 'list'])->name('list')->middleware('can:Manage Setting');
        Route::get('add-new', [RolePermisionController::class, 'addNew'])->name('add-new')->middleware('can:Manage Setting');
        Route::get('edit/{id}', [RolePermisionController::class, 'edit'])->name('edit')->middleware('can:Manage Setting');
        Route::post('store', [RolePermisionController::class, 'store'])->name('store')->middleware('can:Manage Setting');
        Route::get('details/{id}', [RolePermisionController::class, 'details'])->name('details')->middleware('can:Manage Setting');
        Route::post('delete/{id}', [RolePermisionController::class, 'delete'])->name('delete')->middleware('can:Manage Setting');
        Route::get('permission/{id}', [RolePermisionController::class, 'permission'])->name('permission')->middleware('can:Manage Setting');
        Route::post('permission-update', [RolePermisionController::class, 'permissionUpdate'])->name('permission-update')->middleware('can:Manage Setting');
    });

    // designation
    Route::group(['prefix' => 'designation', 'as' => 'designation.'], function () {
        Route::get('/', [DesignationController::class, 'index'])->name('index')->middleware('can:Manage Setting');
        Route::get('add', [DesignationController::class, 'add'])->name('add')->middleware('can:Manage Setting');
        Route::post('store', [DesignationController::class, 'store'])->name('store')->middleware('can:Manage Setting');
        Route::get('edit/{id}', [DesignationController::class, 'edit'])->name('edit')->middleware('can:Manage Setting');
        Route::get('delete/{id}', [DesignationController::class, 'delete'])->name('delete')->middleware('can:Manage Setting');
    });

   // activity log
    Route::group(['prefix' => 'activity-log', 'as' => 'activity-log.'], function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index')->middleware('can:Manage Setting');
    });


    Route::get('email-template', [EmailTemplateController::class, 'emailTemplate'])->name('email-template')->middleware('can:Manage Setting');
    Route::get('email-template-config', [EmailTemplateController::class, 'emailTemplateConfig'])->name('email.template.config')->middleware('can:Manage Setting');
    Route::post('email-template-config-update', [EmailTemplateController::class, 'emailTemplateConfigUpdate'])->name('email.template.config.update')->middleware('can:Manage Setting');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
        Route::get('password', [ProfileController::class, 'password'])->name('password');
        Route::post('password-update', [ProfileController::class, 'passwordUpdate'])->name('password.update')->middleware('isDemo');
    });
});

Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('notification-mark-all-as-read', [NotificationController::class, 'notificationMarkAllAsRead'])->name('notification-mark-all-as-read');
    Route::get('view/{id}', [NotificationController::class, 'notificationView'])->name('view');
    Route::get('notification-mark-as-read/{id}', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
});

Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
    Route::get('index', [ServiceController::class, 'index'])->name('index')->middleware('can:Manage Services');
    Route::get('create', [ServiceController::class, 'create'])->name('create')->middleware('can:Manage Services');
    Route::post('store', [ServiceController::class, 'store'])->name('store')->middleware('can:Manage Services');
    Route::get('edit/{id}', [ServiceController::class, 'edit'])->name('edit')->middleware('can:Manage Services');
    Route::post('delete/{id}', [ServiceController::class, 'delete'])->name('delete')->middleware('can:Manage Services');
});

Route::group(['prefix' => 'team-member', 'as' => 'team-member.'], function () {
    Route::get('/', [TeamMemberController::class, 'index'])->name('index')->middleware('can:Manage Team Member');
    Route::get('add', [TeamMemberController::class, 'add'])->name('add')->middleware('can:Manage Team Member');
    Route::post('store', [TeamMemberController::class, 'store'])->name('store')->middleware('can:Manage Team Member');
    Route::get('edit/{id}', [TeamMemberController::class, 'edit'])->name('edit')->middleware('can:Manage Team Member');
    Route::get('delete/{id}', [TeamMemberController::class, 'delete'])->name('delete')->middleware('can:Manage Team Member');
});

//client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
    Route::get('/', [ClientController::class, 'list'])->name('list')->middleware('can:Manage Client');
    Route::get('client-add', [ClientController::class, 'add'])->name('add-list')->middleware('can:Manage Client');
    Route::post('client-store', [ClientController::class, 'store'])->name('store')->middleware('can:Manage Client');
    Route::post('client-delete/{id}', [ClientController::class, 'delete'])->name('delete')->middleware('can:Manage Client');
    Route::get('edit/{id}', [ClientController::class, 'edit'])->name('edit')->middleware('can:Manage Client');
    Route::get('details/{id}', [ClientController::class, 'details'])->name('details')->middleware('can:Manage Client');
    Route::get('invoice/{id}', [ClientController::class, 'clientInvoiceHistory'])->name('invoice')->middleware('can:Manage Client');
    Route::get('activity-log/{id}', [ClientController::class, 'clientActivityHistory'])->name('activity-log-history')->middleware('can:Manage Client');
    Route::post('/update-status/{id}', [ClientController::class, 'updateStatus'])->name('update-status')->middleware('can:Manage Client');

});

//client-order-info
Route::group(['prefix' => 'client-orders', 'as' => 'client-orders.'], function () {
    Route::get('/', [ClientOrderController::class, 'list'])->name('list')->middleware('can:Manage Orders');
    Route::get('add', [ClientOrderController::class, 'add'])->name('add')->middleware('can:Manage Orders');
    Route::get('service-list/{id}', [ClientOrderController::class, 'serviceList'])->name('service.list')->middleware('can:Manage Orders');
    Route::get('all-service', [ClientOrderController::class, 'getService'])->name('all-service')->middleware('can:Manage Orders');
    Route::post('store', [ClientOrderController::class, 'store'])->name('store')->middleware('can:Manage Orders');
    Route::get('edit/{id}', [ClientOrderController::class, 'edit'])->name('edit')->middleware('can:Manage Orders');
    Route::post('delete/{id}', [ClientOrderController::class, 'delete'])->name('delete')->middleware('can:Manage Orders');
    Route::get('status-change-modal/{order_id}', [ClientOrderController::class, 'orderStatusChangeModal'])->name('status.change-modal')->middleware('can:Manage Orders');
    Route::post('order-status-change/{order_id}', [ClientOrderController::class, 'orderStatusChange'])->name('order.status.change')->middleware('can:Manage Orders');
    Route::get('status-change/{order_item_id}/{status}', [ClientOrderController::class, 'statusChange'])->name('status.change')->middleware('can:Manage Orders');
    Route::get('assign-member', [ClientOrderController::class, 'assignMember'])->name('assign.member')->middleware('can:Manage Orders');
    Route::post('note-store', [ClientOrderController::class, 'noteStore'])->name('note.store')->middleware('can:Manage Orders');
    Route::post('note-delete/{id}', [ClientOrderController::class, 'noteDelete'])->name('note.delete')->middleware('can:Manage Orders');

    Route::group(['prefix' => 'task-board', 'as' => 'task-board.'], function () {
        Route::get('/{order_item_id}', [OrderTaskBoardController::class, 'list'])->name('index')->middleware('can:Manage Orders');
        Route::post('/{order_item_id}/{id?}', [OrderTaskBoardController::class, 'store'])->where(['order_item_id' => '[0-9]+', 'id' => '[0-9]*'])->name('store')->middleware('can:Manage Orders');
        Route::post('/{order_item_id}/update-task-status', [OrderTaskBoardController::class, 'updateStatus'])->name('update_status')->middleware('can:Manage Orders');
        Route::get('/{order_item_id}/edit/{id}', [OrderTaskBoardController::class, 'edit'])->name('edit')->middleware('can:Manage Orders');
        Route::post('/{order_item_id}/delete/{id}', [OrderTaskBoardController::class, 'delete'])->name('delete')->middleware('can:Manage Orders');
        Route::get('/{order_item_id}/view/{id}', [OrderTaskBoardController::class, 'view'])->name('view')->middleware('can:Manage Orders');
        Route::get('/{order_item_id}/upload-requirements/{id}', [OrderTaskBoardController::class, 'viewRequirement'])->name('view_requirements')->middleware('can:Manage Orders');
        Route::post('/{order_item_id}/delete-attachment/{id}/{attachment_id}', [OrderTaskBoardController::class, 'deleteAttachment'])->name('delete-attachment')->middleware('can:Manage Orders');
        Route::post('{order_item_id}/change-progress/{id}', [OrderTaskBoardController::class, 'changeProgress'])->name('change_progress')->middleware('can:Manage Orders');

        Route::group(['prefix' => 'conversation', 'as' => 'conversation.'], function () {
            Route::post('{order_item_id}/{id}', [OrderTaskBoardController::class, 'conversationStore'])->name('store')->middleware('can:Manage Orders');
        });
    });
});

//client invoice
Route::group(['prefix' => 'client-invoice', 'as' => 'client-invoice.'], function () {
    Route::get('/', [ClientInvoiceController::class, 'list'])->name('list')->middleware('can:Manage Invoice');
    Route::post('store', [ClientInvoiceController::class, 'store'])->name('store')->middleware('can:Manage Invoice');
    Route::post('delete/{id}', [ClientInvoiceController::class, 'delete'])->name('delete')->middleware('can:Manage Invoice');
    Route::get('all-service', [ClientInvoiceController::class, 'getService'])->name('all-service')->middleware('can:Manage Invoice');
    Route::get('details/{id}', [ClientInvoiceController::class, 'details'])->name('details')->middleware('can:Manage Invoice');
    Route::get('order', [ClientInvoiceController::class, 'getOrder'])->name('order')->middleware('can:Manage Invoice');
    Route::get('print/{id}', [ClientInvoiceController::class, 'invoicePrint'])->name('print')->middleware('can:Manage Invoice');
    Route::get('payment-edit/{id}', [ClientInvoiceController::class, 'paymentEdit'])->name('payment-edit')->middleware('can:Manage Invoice');
    Route::post('payment-status-change/{id}', [ClientInvoiceController::class, 'paymentStatusChange'])->name('payment_status_change')->middleware('can:Manage Invoice');
});

Route::get('version-update', [VersionUpdateController::class, 'versionFileUpdate'])->name('file-version-update');
Route::post('version-update', [VersionUpdateController::class, 'versionFileUpdateStore'])->name('file-version-update-store');
Route::get('version-update-execute', [VersionUpdateController::class, 'versionUpdateExecute'])->name('file-version-update-execute');
Route::get('version-delete', [VersionUpdateController::class, 'versionFileUpdateDelete'])->name('file-version-delete');

Route::group(['prefix' => 'addon', 'as' => 'addon.'], function () {
    Route::get('details/{code}', [AddonUpdateController::class, 'addonSaasDetails'])->name('details')->withoutMiddleware(['addon.update']);
    Route::post('store', [AddonUpdateController::class, 'addonSaasFileStore'])->name('store')->withoutMiddleware(['addon.update']);
    Route::post('execute', [AddonUpdateController::class, 'addonSaasFileExecute'])->name('execute')->withoutMiddleware(['addon.update']);
    Route::get('delete/{code}', [AddonUpdateController::class, 'addonSaasFileDelete'])->name('delete')->withoutMiddleware(['addon.update']);
});


Route::group(['prefix' => 'theme-setting', 'as' => 'theme-settings.'], function () {
    Route::get('index', [ThemeController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
    Route::get('landing-page-setting', [ThemeController::class, 'landingPageSetting'])->name('landing-page-setting')->middleware('can:Manage Cms Settings');
    Route::get('cta-section', [ThemeController::class, 'ctaSection'])->name('cta-section')->middleware('can:Manage Cms Settings');
    Route::get('our-achievements', [ThemeController::class, 'ourAchievement'])->name('our-achievements')->middleware('can:Manage Cms Settings');

    Route::group(['prefix' => 'choose-us', 'as' => 'choose-us.'], function (){
        Route::get('index', [ChooseUsController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [ChooseUsController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [ChooseUsController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [ChooseUsController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });
    Route::group(['prefix' => 'our-service', 'as' => 'our-services.'], function (){
        Route::get('index', [OurServiceController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::get('create', [OurServiceController::class, 'create'])->name('create')->middleware('can:Manage Cms Settings');
        Route::post('store', [OurServiceController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [OurServiceController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [OurServiceController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });
    Route::group(['prefix' => 'working-process', 'as' => 'working-process.'], function (){
        Route::get('index', [WorkingProcessController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [WorkingProcessController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [WorkingProcessController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [WorkingProcessController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });
    Route::group(['prefix' => 'page', 'as' => 'pages.'], function (){
        Route::get('index', [PageController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [PageController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [PageController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });
    Route::group(['prefix' => 'membership-benefits', 'as' => 'membership-benefits.'], function (){
        Route::get('index', [MembershipBenefitsController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [MembershipBenefitsController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [MembershipBenefitsController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [MembershipBenefitsController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });
    Route::group(['prefix' => 'faq', 'as' => 'faqs.'], function (){
        Route::get('index', [FaqController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [FaqController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [FaqController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [FaqController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });

    Route::group(['prefix' => 'testimonial', 'as' => 'testimonials.'], function (){
        Route::group(['prefix' => 'category', 'as' => 'categories.'], function (){
            Route::get('index', [TestimonialCategoryController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
            Route::post('store', [TestimonialCategoryController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
            Route::get('edit/{id}', [TestimonialCategoryController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
            Route::post('delete/{id}', [TestimonialCategoryController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
        });
        Route::get('index', [TestimonialController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [TestimonialController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [TestimonialController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [TestimonialController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });

    Route::group(['prefix' => 'portfolio', 'as' => 'portfolios.'], function (){
        Route::group(['prefix' => 'category', 'as' => 'categories.'], function (){
            Route::get('index', [PortfolioCategoryController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
            Route::post('store', [PortfolioCategoryController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
            Route::get('edit/{id}', [PortfolioCategoryController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
            Route::post('delete/{id}', [PortfolioCategoryController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
        });
        Route::get('index', [PortfolioController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [PortfolioController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [PortfolioController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [PortfolioController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });

    Route::group(['prefix' => 'about-us', 'as' => 'about-us.'], function (){
        Route::get('', [AboutUsController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [AboutUsController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
    });

});

Route::group(['prefix' => 'package', 'as' => 'packages.'], function (){
    Route::get('/', [PackageController::class, 'list'])->name('index')->middleware('can:Manage Packages');
    Route::get('add-new', [PackageController::class, 'addNew'])->name('add-new')->middleware('can:Manage Packages');
    Route::get('edit/{id}', [PackageController::class, 'edit'])->name('edit')->middleware('can:Manage Packages');
    Route::post('store', [PackageController::class, 'store'])->name('store')->middleware('can:Manage Packages');
    Route::get('details/{id}', [PackageController::class, 'details'])->name('details')->middleware('can:Manage Packages');
    Route::post('delete/{id}', [PackageController::class, 'delete'])->name('delete')->middleware('can:Manage Packages');
    Route::get('search', [PackageController::class, 'search'])->name('search')->middleware('can:Manage Packages');
});

Route::group(['prefix' => 'blog', 'as' => 'blogs.'], function (){

    Route::group(['prefix' => 'category', 'as' => 'categories.'], function (){
        Route::get('index', [BlogCategoryController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
        Route::post('store', [BlogCategoryController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
        Route::get('edit/{id}', [BlogCategoryController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
        Route::post('delete/{id}', [BlogCategoryController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
    });

    Route::get('index', [BlogController::class, 'index'])->name('index')->middleware('can:Manage Cms Settings');
    Route::post('store', [BlogController::class, 'store'])->name('store')->middleware('can:Manage Cms Settings');
    Route::get('edit/{id}', [BlogController::class, 'edit'])->name('edit')->middleware('can:Manage Cms Settings');
    Route::post('delete/{id}', [BlogController::class, 'delete'])->name('delete')->middleware('can:Manage Cms Settings');
});
Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('/', [TicketController::class, 'list'])->name('list')->middleware('can:Manage Tickets');
    Route::get('add-new', [TicketController::class, 'addNew'])->name('add-new')->middleware('can:Manage Tickets');
    Route::get('edit/{id}', [TicketController::class, 'edit'])->name('edit')->middleware('can:Manage Tickets');
    Route::post('store', [TicketController::class, 'store'])->name('store')->middleware('can:Manage Tickets');
    Route::get('details/{id}', [TicketController::class, 'details'])->name('details')->middleware('can:Manage Tickets');
    Route::post('delete/{id}', [TicketController::class, 'delete'])->name('delete')->middleware('can:Manage Tickets');
    Route::get('assign-member', [TicketController::class, 'assignMember'])->name('assign-member')->middleware('can:Manage Tickets');
    Route::get('priority-change/{ticket_id}/{priority}', [TicketController::class, 'priorityChange'])->name('priority-change')->middleware('can:Manage Tickets');
    Route::post('conversations-store', [TicketController::class, 'conversationsStore'])->name('conversations.store')->middleware('can:Manage Tickets');
    Route::post('conversations-edit', [TicketController::class, 'conversationsEdit'])->name('conversations.edit')->middleware('can:Manage Tickets');
    Route::post('conversations-delete/{id}', [TicketController::class, 'conversationsDelete'])->name('conversations.delete')->middleware('can:Manage Tickets');
    Route::get('status-change', [TicketController::class, 'statusChange'])->name('status.change')->middleware('can:Manage Tickets');
});
