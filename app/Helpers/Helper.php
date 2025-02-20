<?php

use App\Mail\CustomEmailNotify;
use App\Models\Currency;
use App\Models\EmailTemplate;
use App\Models\FileManager;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Page;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketConversation;
use App\Models\User;
use Jenssegers\Agent\Agent;
use App\Models\UserActivityLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\ClientInvoice;
use App\Models\ClientOrder;
use App\Models\ClientOrderItem;
use App\Models\Gateway;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

if (!function_exists("getOption")) {
    function getOption($option_key, $default = NULL)
    {
        $system_settings = config('settings');

        if ($option_key && isset($system_settings[$option_key])) {
            return $system_settings[$option_key];
        } else {
            return $default;
        }
    }
}

if (!function_exists('pageModalData')) {
    function pageModalData()
    {
        return Page::where('status', STATUS_ACTIVE)->get();
    }
}


if (!function_exists("landingPageSetting")) {
    function landingPageSetting($collection, $option_key, $default = null)
    {
        $system_setting = $collection->where('option_key', $option_key)->first();
        if ($system_setting !== null) {
            return $system_setting->option_value;
        } else {
            return $default;
        }
    }
}

function getSettingImage($option_key)
{

    if ($option_key && $option_key != null) {


        $setting = Setting::where('option_key', $option_key)->first();
        if (isset($setting->option_value) && isset($setting->option_value) != null) {

            $file = FileManager::select('path', 'storage_type')->find($setting->option_value);


            if (!is_null($file)) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {

                    if ($file->storage_type == 'public') {
                        return asset('storage/' . $file->path);
                    }

                    return Storage::disk($file->storage_type)->url($file->path);
                }
            }
        }
    }
    return asset('assets/images/no-image.jpg');
}

function settingImageStoreUpdate($option_value, $requestFile)
{

    if ($requestFile) {

        /*File Manager Call upload*/
        if ($option_value && $option_value != null) {
            $new_file = FileManager::where('id', $option_value)->first();

            if ($new_file) {
                $new_file->removeFile();
                $uploaded = $new_file->upload('Setting', $requestFile, '', $new_file->id);
            } else {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('Setting', $requestFile);
            }
        } else {
            $new_file = new FileManager();
            $uploaded = $new_file->upload('Setting', $requestFile);
        }

        /*End*/

        return $uploaded->id;
    }

    return null;
}


if (!function_exists("getDefaultImage")) {
    function getDefaultImage()
    {
        return asset('assets/images/icon/upload-img-1.svg');
    }
}

if (!function_exists("getDefaultLanguage")) {
    function getDefaultLanguage()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists("getCurrencySymbol")) {
    function getCurrencySymbol()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)
            ->orWhere(['current_currency' => 1])->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists("getIsoCode")) {
    function getIsoCode()
    {
        $currency = Currency::where('current_currency', 'on')
            ->orWhere(['current_currency' => 1])->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists("getCurrencyPlacement")) {
    function getCurrencyPlacement()
    {
        $currency = Currency::where('current_currency', STATUS_ACTIVE)
            ->orWhere(['current_currency' => 1])->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->symbol;
            return $placement;
        }

        return $placement;
    }
}

if (!function_exists("showPrice")) {
    function showPrice($price)
    {
        $price = getNumberFormat($price);
        if (config('app.currencyPlacement') == 'after') {
            return $price . config('app.currencySymbol');
        } else {
            return config('app.currencySymbol') . $price;
        }
    }
}


if (!function_exists("getNumberFormat")) {
    function getNumberFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists("decimalToInt")) {
    function decimalToInt($amount)
    {
        return number_format(number_format($amount, 2, '.', '') * 100, 0, '.', '');
    }
}

if (!function_exists("intToDecimal")) {
}
function intToDecimal($amount)
{
    return number_format($amount / 100, 2, '.', '');
}

if (!function_exists("appLanguages")) {
    function appLanguages()
    {
        return Language::where('status', 1)->get();
    }
}

if (!function_exists("selectedLanguage")) {
    function selectedLanguage()
    {
        $language = Language::where('iso_code', session()->get('local'))->first();
        if (!$language) {
            $language = Language::find(1);
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }

        return $language;
    }
}

if (!function_exists("getVideoFile")) {
    function getFile($path, $storageType)
    {
        if (!is_null($path)) {
            if (Storage::disk($storageType)->exists($path)) {

                if ($storageType == 'public') {
                    return asset('storage/' . $path);
                }

                if ($storageType == 'wasabi') {
                    return Storage::disk('wasabi')->url($path);
                }


                return Storage::disk($storageType)->url($path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists("notificationForUser")) {
    function notificationForUser()
    {
        $instructor_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 2)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        $student_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 3)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        return array('instructor_notifications' => $instructor_notifications, 'student_notifications' => $student_notifications);
    }
}

if (!function_exists("adminNotifications")) {
    function adminNotifications()
    {
        return \App\Models\Notification::where('user_type', 1)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->paginate(5);
    }
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int)$buildVersion;
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}

if (!function_exists('getAddonCodeBuildVersion')) {
    function getAddonCodeBuildVersion($appCode)
    {
        Artisan::call("config:clear");
        return config('addon.' . $appCode . '.build_version', 0);
    }
}

if (!function_exists('getCustomerAddonBuildVersion')) {
    function getCustomerAddonBuildVersion($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        if (is_null($buildVersion)) {
            return 0;
        }
        return (int)$buildVersion;
    }
}

if (!function_exists('isAddonInstalled')) {
    function isAddonInstalled($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        $codeBuildVersion = config('addon.' . $code . '.build_version', 0);
        if (is_null($buildVersion) || $codeBuildVersion == 0) {
            return 0;
        }
        return (int)$buildVersion;
    }
}

if (!function_exists('setCustomerAddonCurrentVersion')) {
    function setCustomerAddonCurrentVersion($code)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_current_version']);
        if (config($code . '.current_version', 0) > 0) {
            $option->option_value = config($code . '.current_version', 0);
            $option->save();
        }
    }
}

if (!function_exists('setCustomerAddonBuildVersion')) {
    function setCustomerAddonBuildVersion($code, $version)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('updateEnv')) {
    function updateEnv($values)
    {
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                setEnvironmentValue($envKey, $envValue);
            }
            return true;
        }
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            if ($keyPosition) {
                if (PHP_OS_FAMILY === 'Windows') {
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                } else {
                    $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
                }
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"";
                if ($oldLine != $newLine) {
                    $str = str_replace($oldLine, $newLine, $str);
                    $str = substr($str, 0, -1);
                    $fp = fopen($envFile, 'w');
                    fwrite($fp, $str);
                    fclose($fp);
                }
            } else if (strtoupper($envKey) == $envKey) {
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"\n";
                $str .= $newLine;
                $str = substr($str, 0, -1);
                $fp = fopen($envFile, 'w');
                fwrite($fp, $str);
                fclose($fp);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('base64urlEncode')) {
    function base64urlEncode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}

if (!function_exists('getTimeZone')) {
    function getTimeZone()
    {
        return DateTimeZone::listIdentifiers(
            DateTimeZone::ALL
        );
    }
}

function getErrorMessage($e, $customMsg = null)
{
    if ($customMsg != null) {
        return $customMsg;
    }
    if (env('APP_DEBUG')) {
        return $e->getMessage() . $e->getLine();
    } else {
        return SOMETHING_WENT_WRONG;
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($id = null)
    {

        $file = FileManager::select('path', 'storage_type')->find($id);

        if (!is_null($file)) {
            if (Storage::disk($file->storage_type)->exists($file->path)) {

                if ($file->storage_type == 'public') {
                    return asset('storage/' . $file->path);
                }

                if ($file->storage_type == 'wasabi') {
                    return Storage::disk('wasabi')->url($file->path);
                }


                return Storage::disk($file->storage_type)->url($file->path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists('getFileData')) {
    function getFileData($id, $property)
    {
        $file = FileManager::find($id);
        if ($file) {
            return $file->{$property};
        }
        return null;
    }
}

if (!function_exists('emailTemplateStatus')) {
    function emailTemplateStatus($category)
    {
        $status = EmailTemplate::where('category', $category)->where('user_id', auth()->id())->pluck('status')->first();
        if ($status) {
            return $status;
        }
        return DEACTIVATE;
    }
}


if (!function_exists('languageLocale')) {
    function languageLocale($locale)
    {
        $data = Language::where('code', $locale)->first();
        if ($data) {
            return $data->code;
        }
        return 'en';
    }
}


if (!function_exists('getUseCase')) {
    function getUseCase($useCase = [])
    {
        if (in_array("-1", $useCase)) {
            return __("All");
        }
        return count($useCase);
    }
}

function currentCurrency($attribute = '')
{
    $currentCurrency = Currency::where('current_currency', STATUS_ACTIVE)
        ->orWhere(['current_currency' => 1])->first();
    if (isset($currentCurrency->{$attribute})) {
        return $currentCurrency->{$attribute};
    }
    return '';
}


function currentCurrencyType()
{
    $currentCurrency = Currency::where('current_currency', 'on')
        ->orWhere(['current_currency' => 1])->first();
    return $currentCurrency->currency_code;
}

function currentCurrencyIcon()
{
    $currentCurrency = Currency::where('current_currency', 'on')
        ->orWhere(['current_currency' => 1])->first();
    return $currentCurrency->symbol;
}

function random_strings($length_of_string)
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

function getUserId()
{
    try {
        return Auth::id();
    } catch (\Exception $e) {
        return 0;
    }
}


if (!function_exists('visual_number_format')) {
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 10, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

function getError($e)
{
    if (env('APP_DEBUG')) {
        return " => " . $e->getMessage();
    }
    return '';
}

function notification($title = null, $body = null, $user_id = null, $link = null)
{
    try {
        $obj = new Notification();
        $obj->title = $title;
        $obj->body = $body;
        $obj->user_id = $user_id;
        $obj->link = $link;
        $obj->save();
        return "notification sent!";
    } catch (\Exception $e) {
        return "something error!";
    }
}

if (!function_exists('get_default_language')) {
    function get_default_language()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol()
    {
        $currency = Currency::where('current_currency', 'on')
            ->orWhere(['current_currency' => 1])->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists('get_currency_code')) {
    function get_currency_code()
    {
        $currency = Currency::where('current_currency', 'on')
            ->orWhere(['current_currency' => 1])->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists('get_currency_placement')) {
    function get_currency_placement()
    {
        $currency = Currency::where('current_currency', 'on')
            ->orWhere(['current_currency' => 1])->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}


if (!function_exists('customNumberFormat')) {
    function customNumberFormat($value)
    {
        $number = explode('.', $value);
        if (!isset($number[1])) {
            return number_format($value, 8, '.', '');
        } else {
            $result = substr($number[1], 0, 8);
            if (strlen($result) < 8) {
                $result = number_format($value, 8, '.', '');
            } else {
                $result = $number[0] . "." . $result;
            }

            return $result;
        }
    }
}


if (!function_exists('calculateFees')) {
    function calculateFees($amount, $feeMethod, $feePercentage, $feeFixed)
    {
        try {
            if ($feeMethod == 1) {
                return customNumberFormat($feeFixed);
            } elseif ($feeMethod == 2) {
                return customNumberFormat(bcdiv(bcmul($feePercentage, $amount), 100));
            } elseif ($feeMethod == 3) {
                return customNumberFormat(bcadd($feeFixed, bcdiv(bcmul($feePercentage, $amount), 100)));
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('trade_max_level')) {
    function trade_max_level()
    {
        return 5;
    }
}

if (!function_exists('reviewStar')) {
    function reviewStar($star)
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i > $star) {
                $html .= '<li class="no-rating"><i class="fa-solid fa-star"></i></li>';
            } else {
                $html .= '<li><i class="fa-solid fa-star"></i></li>';
            }
        }
        return $html;
    }
}

if (!function_exists('getExistingClients')) {
    function getExistingClients($userId = null)
    {
        $totalCount = User::query()
            ->where('created_by', $userId)
            ->where('role', USER_ROLE_CLIENT)
            ->count();
        return $totalCount;
    }
}

if (!function_exists('getExistingOrders')) {
    function getExistingOrders($userId = null)
    {
        $totalCount = ClientOrder::query()
            ->where(['user_id' => $userId])
            ->count();
        return $totalCount;

    }
}

if (!function_exists('getRandomDecimal')) {
    function getRandomDecimal($min, $max, $probabilityRatio)
    {
        // Calculate the adjusted maximum value based on the probability ratio
        $adjustedMax = $max + ($max - $min) * ($probabilityRatio - 1);

        // Generate a random decimal number within the range
        $randomDecimal = mt_rand($min * 10000, $adjustedMax * 10000) / 10000;

        // Check if the random decimal number needs to be adjusted
        if ($randomDecimal > $max) {
            // Set the number to the maximum value
            $randomDecimal = $max;
        }

        return $randomDecimal;
    }
}

if (!function_exists('privateUserNotification')) {
    function privateUserNotification()
    {
        return Notification::where('user_id', Auth::id())
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}
if (!function_exists('publicUserNotification')) {
    function publicUserNotification()
    {
        return Notification::where('user_id', null)
            ->where('status', ACTIVE)
            ->orderBy('id', 'DESC')
            ->where('view_status', STATUS_PENDING)
            ->get();
    }
}

function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

function humanFileSize($size, $unit = '')
{
    if ((!$unit && $size >= 1 << 30) || $unit == 'GB') {
        return number_format($size / (1 << 30), 2) . 'GB';
    }

    if ((!$unit && $size >= 1 << 20) || $unit == 'MB') {
        return number_format($size / (1 << 20), 2) . 'MB';
    }

    if ((!$unit && $size >= 1 << 10) || $unit == 'KB') {
        return number_format($size / (1 << 10), 2) . 'KB';
    }

    return number_format($size) . ' bytes';
}

if (!function_exists('getMeta')) {
    function getMeta($slug)
    {
        $metaData = [
            'meta_title' => null,
            'meta_description' => null,
            'meta_keyword' => null,
            'og_image' => null,
        ];

        $metaData['meta_title'] = $metaData['meta_title'] != NULL ? $metaData['meta_title'] : getOption('app_name');
        $metaData['meta_description'] = $metaData['meta_description'] != NULL ? $metaData['meta_description'] : getOption('app_name');
        $metaData['meta_keyword'] = $metaData['meta_keyword'] != NULL ? $metaData['meta_keyword'] : getOption('app_name');
        $metaData['og_image'] = $metaData['og_image'] != NULL ? getFileUrl($metaData['og_image']) : getFileUrl(getOption('app_logo'));

        return $metaData;
    }
}


function genericEmailNotify($singleData = null, $userData = null, $customData = null, $template = null)
{
    if ($singleData != null) {
        Mail::to($singleData->to)->send(new CustomEmailNotify($singleData, $userData, $customData, $template));
    } elseif ($userData != null) {
        Mail::to($userData->email)->send(new CustomEmailNotify($singleData, $userData, $customData, $template));
    }
}

function getEmailTemplate($category, $property, $link = null, $customData = null, $userData = null)
{
    $data = EmailTemplate::where('slug', $category)->first();
    if ($data && $data != null) {
        if ($property == 'body') {
            $body = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{reset_password_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{email_verify_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{order_id}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->order_id : $customData['order_id'], $body);
                } else if ($key == '{{ticket_id}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->ticket_id : $customData['ticket_id'], $body);
                } else if ($key == '{{username}}') {
                    $body = str_replace($key, $userData->name, $body);
                } else if ($key == '{{otp}}') {
                    $body = str_replace($key, $userData->otp, $body);
                } else {
                    $body = str_replace($key, $item, $body);
                }
            }
            return $body;
        } else if ($property == 'subject') {

            $subject = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{customField}}') {
                    $subject = str_replace($key, $customData->customField, $subject);
                }
            }
            return $subject;
        } else {
            return $data->{$property};
        }
    }
    return '';
}

function getEmailTemplateContent($body, $category = null, $customizedFieldsArray = [])
{
    if ($body) {
        $body = $body;
        if ($customizedFieldsArray) {
            foreach (emailTempFields($category) as $key => $item) {
                if (isset($customizedFieldsArray[$key])) {
                    $body = str_replace($key, $customizedFieldsArray[$key], $body);
                }
            }
        }
        return $body;
    }
    return '';
}

function getInvoiceSettingContent($content, $customizedFieldsArray = [])
{
    if ($content) {
        $content = $content;
        if ($customizedFieldsArray) {
            foreach (invoiceSettingFields() as $field) {
                if (isset($customizedFieldsArray[$field])) {
                    $content = str_replace($field, $customizedFieldsArray[$field], $content);
                }
            }
        }
        return $content;
    }
    return '';
}

function gatewaySettings()
{
    return '{"paypal":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
             "stripe":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":0},{"label":"Secret Key","name":"secret","is_show":1}],
             "razorpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
             "instamojo":[{"label":"Url","name":"url","is_show":0},{"label":"Api Key","name":"key","is_show":1},{"label":"Auth Token","name":"secret","is_show":1}],
             "mollie":[{"label":"Url","name":"url","is_show":0},{"label":"Mollie Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],
             "paystack":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],
             "mercadopago":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
             "sslcommerz":[{"label":"Url","name":"url","is_show":0},{"label":"Store ID","name":"key","is_show":1},{"label":"Store Password","name":"secret","is_show":1}],
             "flutterwave":[{"label":"Hash","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
             "coinbase":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],
             "binance":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
            "bitpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],
            "iyzico":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
            "payhere":[{"label":"Url","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Merchant Secret","name":"secret","is_show":1}],
            "maxicash":[{"label":"Url","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Password","name":"secret","is_show":1}],
            "paytm":[{"label":"Industry Type","name":"url","is_show":1},{"label":"Merchant Key","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":1}],
            "zitopay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":0}],
            "cinetpay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Site ID","name":"secret","is_show":1}],
            "voguepay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":0}],
            "toyyibpay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Secret Key","name":"key","is_show":1},{"label":"Category Code","name":"secret","is_show":1}],
            "paymob":[{"label":"Industry Type","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Integration ID","name":"secret","is_show":1}],
            "alipay":[{"label":"APP ID","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Private Key","name":"secret","is_show":1}],
            "xendit":[{"label":"APP ID","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],
            "authorize":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Login ID","name":"key","is_show":1},{"label":"Transaction Key","name":"secret","is_show":1}],
            "paddle":[{"label":"Vendor Id","name":"url","is_show":1},{"label":"Vendor Auth Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],
            "cash":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Login ID","name":"key","is_show":0},{"label":"Transaction Key","name":"secret","is_show":0}]
             }';
}

if (!function_exists('setUserGateway')) {
    function setUserGateway($tenantId, $userId = null)
    {
        $data = [
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Paypal', 'slug' => 'paypal', 'image' => 'assets/images/gateway-icon/paypal.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Stripe', 'slug' => 'stripe', 'image' => 'assets/images/gateway-icon/stripe.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Razorpay', 'slug' => 'razorpay', 'image' => 'assets/images/gateway-icon/razorpay.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Instamojo', 'slug' => 'instamojo', 'image' => 'assets/images/gateway-icon/instamojo.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Mollie', 'slug' => 'mollie', 'image' => 'assets/images/gateway-icon/mollie.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Paystack', 'slug' => 'paystack', 'image' => 'assets/images/gateway-icon/paystack.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Sslcommerz', 'slug' => 'sslcommerz', 'image' => 'assets/images/gateway-icon/sslcommerz.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Flutterwave', 'slug' => 'flutterwave', 'image' => 'assets/images/gateway-icon/flutterwave.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Mercadopago', 'slug' => 'mercadopago', 'image' => 'assets/images/gateway-icon/mercadopago.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Bank', 'slug' => 'bank', 'image' => 'assets/images/gateway-icon/bank.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
            ['user_id' => $userId, 'tenant_id' => $tenantId, 'title' => 'Cash', 'slug' => 'cash', 'image' => 'assets/images/gateway-icon/cash.png', 'status' => ACTIVE, 'mode' => GATEWAY_MODE_SANDBOX, 'url' => '', 'key' => '', 'secret' => ''],
        ];
        Gateway::insert($data);
    }
}

if (!function_exists('setUserEmailTemplate')) {
    function setUserEmailTemplate($tenantId, $userId = null)
    {
        $data = [
            [
                'user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Create Notify For Client',
                'slug' => 'ticket-create-notify-for-client',
                'subject' => 'New Ticket Created - {{tracking_no}}',
                'body' => '<p><b>Dear</b> {{username}},</p>
                            <p>We are happy to inform you that a new ticket has been successfully created in our system with the following details:</p>
                            <p>Tracking No: <b>{{tracking_no}}</p>
                            <p>Date Created: {{ticket_created_time}}</p>
                            <p> Title: {{ticket_title}}</p>
                            <p>
                                You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal.
                                If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}}  or {{contact_phone}}.
                                Thank you for using our services!
                            </p>
                            <p><b>Best regards</b>, {{app_name}}</p>',
                'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()
            ],

            [
                'user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Create Notify For Admin',
                'slug' => 'ticket-create-notify-for-admin',
                'subject' => 'New Ticket Created - {{tracking_no}}',
                'body' => '<p><b>Dear</b> {{username}},            </p>
                            <p>We are happy to inform you that a new ticket has been successfully created in our system with the following details:            </p>
                            <p>Tracking No: <b>{{tracking_no}}</p>
                            <p>Date Created: {{ticket_created_time}}</p>
                            <p> Title: {{ticket_title}}</p>
                            <p>
                                You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal.
                                If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}}  or {{contact_phone}}.
                                Thank you for using our services!
                            </p>
                            <p><b>Best regards</b>, {{app_name}}</p>',
                'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()
            ],

            [
                'user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Create Notify For Team Member',
                'slug' => 'ticket-create-notify-for-team-member',
                'subject' => 'New Ticket Created - {{tracking_no}}',
                'body' => '<p><b>Dear</b> {{username}},</p>
                            <p>We are happy to inform you that a new ticket has been successfully created in our system with the following details:</p>
                            <p>Tracking No: <b>{{tracking_no}}</p>
                            <p>Date Created: {{ticket_created_time}}</p>
                            <p>Title: {{ticket_title}}</p>
                            <p>
                                You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal.
                                If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}}  or {{contact_phone}}.
                                Thank you for using our services!
                            </p>
                            <p> <b>Best regards</b>, {{app_name}} </p>',
                'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()
            ],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Conversation For Admin', 'slug' => 'ticket-conversation-for-admin', 'subject' => 'New Reply For Your Ticket -{{tracking_no}}', 'body' => '<div><span style="font-weight: bolder;">Dear</span>&nbsp;{{username}},</div><div><br></div><div>A new ticket has been created in our system. Ticket Tracking No: {{tracking_no}} with the following details:</div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>Thank you for your attention.</div><div><span style="font-weight: bolder;">Best regards,</span>&nbsp;{{app_name}}</div>', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Conversation For Team Member', 'slug' => 'ticket-conversation-for-team-member', 'subject' => 'New Reply For Your Ticket - {{tracking_no}}', 'body' => '<div><span style="font-weight: bolder;">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{tracking_no}} has reply in our system with the following details:&nbsp;</div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>Thank you for your attention.</div><div><span style="font-weight: bolder;">Best regards</span>, {{app_name}}</div>', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Conversation For Client', 'slug' => 'ticket-conversation-for-client', 'subject' => 'New Reply For Your Ticket - {{tracking_no}}', 'body' => '<div><span style="font-weight: bolder;">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{tracking_no}} has reply in our system with the following details:&nbsp;</div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal. If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}} or {{contact_phone}}. Thank you for using our services!</div><div><br></div><div><span style="font-weight: bolder;">Best regards</span>, {{app_name}}</div>', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket Status Change For Client', 'slug' => 'ticket-status-change-for-client', 'subject' => 'Ticket Status Changed - {{tracking_no}}', 'body' => '<div><span style="font-weight: bolder;">Dear</span>&nbsp;{{username}},</div><div><br></div><div>We are happy to inform you that your Tracking No: {{tracking_no}} has ticket status change in our system with the following details:&nbsp;</div><div>Date Created: {{ticket_created_time}}&nbsp;</div><div><br></div><div>Title: {{ticket_title}}&nbsp;</div><div><br></div><div>You can track the progress of your ticket and provide any additional information or updates by logging into your account on our support portal. If you have any questions or need further assistance, please don\'t hesitate to reply to this email or contact our support team at {{contact_email}} or {{contact_phone}}. Thank you for using our services!</div><div><br></div><div><span style="font-weight: bolder;">Best regards</span>, {{app_name}}</div>', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'ticket', 'title' => 'Ticket assign For Team Member', 'slug' => 'ticket-assign-for-team-member', 'subject' => 'ticket assign', 'body' => 'ticket asaingn', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'quotation', 'title' => 'Quotation Email Send', 'slug' => 'quotation-email-send', 'subject' => 'ticket assign', 'body' => 'ticket asaingn', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'invoice', 'title' => 'Invoice Unpaid Notify For Client', 'slug' => 'invoice-unpaid-notify-for-client', 'subject' => 'Invoice Unpaid Notify For Client', 'body' => 'Invoice Unpaid Notify For Client', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['user_id' => $userId, 'tenant_id' => $tenantId, 'category' => 'invoice', 'title' => 'Invoice Paid Notify For Client', 'slug' => 'invoice-paid-notify-for-client', 'subject' => 'Invoice Paid Notify For Client', 'body' => 'Invoice Paid Notify For Client', 'default' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];
        EmailTemplate::insert($data);
    }
}

function replaceBrackets($content, $customizedFieldsArray)
{
    $pattern = '/{{(.*?)}}/';
    $content = preg_replace_callback($pattern, function ($matches) use ($customizedFieldsArray) {
        $field = trim($matches[1]);
        if (array_key_exists($field, $customizedFieldsArray)) {
            return $customizedFieldsArray[$field];
        }
        return $matches[0];
    }, $content);
    return $content;
}

// checkout order generate
function makeClientOrder($orderData, $client)
{
    try {

        $clientOrder = new ClientOrder();
        $clientOrder->package_id = $orderData['package_id'];
        $clientOrder->amount = $orderData['amount'];
        $clientOrder->package_type = $orderData['package_type'];
        $clientOrder->payment_status = PAYMENT_STATUS_PENDING;
        $clientOrder->order_create_type = $orderData['order_create_type'];
        $clientOrder->working_status = WORKING_STATUS_PENDING;
        $clientOrder->client_id = $client->id;
        $clientOrder->created_by = auth()->id();
        $clientOrder->save();

        $plan = Package::where('id', $clientOrder->package_id)->first();
        foreach ($plan->package_services as $package_service) {
            $clientOrder->client_order_items()->updateOrCreate([
                'service_id' => $package_service->service_id,
            ], [
                'service_id' => $package_service->service_id,
                'quantity' => $package_service->quantity,
                'status' => WORKING_STATUS_PENDING, // Retain status or set default
            ]);
        }

        $clientOrder->order_id = 'ODR-' . sprintf('%06d', $clientOrder->id);
        $clientOrder->save();
        return ['success' => true, 'data' => $clientOrder];
    } catch (Exception $e) {
        Log::info($e->getMessage());

        return ['success' => false, 'data' => [], 'message' => $e->getMessage()];
    }
}

function makeClientInvoice($invoiceData, $clientId)
{
    try {
        Log::info(">>>>>>>>>>");

        $clientInvoice = new ClientInvoice();
        $clientInvoice->client_order_id = $invoiceData['order']->id;
        $clientInvoice->payment_status = PAYMENT_STATUS_PENDING;

        $clientInvoice->total = $invoiceData['order']->amount;
        $clientInvoice->gateway_id = $invoiceData['gateway']->id;
        $clientInvoice->gateway_currency = $invoiceData['gateway_currency']->currency;
        $clientInvoice->conversion_rate = $invoiceData['gateway_currency']->conversion_rate;
        $clientInvoice->transaction_amount = $invoiceData['order']->total * $invoiceData['gateway_currency']->conversion_rate;
        $clientInvoice->system_currency = Currency::where('current_currency', 'on')->orWhere(['current_currency' => 1])->first()->currency_code;
        $clientInvoice->client_id = $clientId;
        $clientInvoice->save();

        $clientInvoice->invoice_id = 'INV-' . sprintf('%06d', $clientInvoice->id);
        $clientInvoice->save();
        return ['success' => true, 'data' => $clientInvoice];
    } catch (Exception $e) {
        return ['success' => false, 'data' => [], 'message' => $e->getMessage()];
    }
}

function custom_number_format($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 10, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 8);
}

if (!function_exists('setCommonNotification')) {
    function setCommonNotification($userId, $title, $details, $link = NULL,)
    {
        try {
            DB::beginTransaction();
            $obj = new Notification();
            $obj->user_id = $userId != NULL ? $userId : NULL;
            $obj->title = $title;
            $obj->body = $details;
            $obj->link = $link != NULL ? $link : NULL;
            $obj->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

if (!function_exists('checkoutPaymentMail')) {
    function checkoutPaymentMail($invoice)
    {
        return true;
    }
}

if (!function_exists('userNotification')) {
    function userNotification($type)
    {
        if ($type == 'seen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', '!=', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        } else if ($type == 'unseen') {
            $test = Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
            return $test;
        } else if ($type == 'seen-unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        }
    }
}

if (!function_exists('getSubText')) {
    function getSubText($html, $limit = 100000)
    {
        return \Illuminate\Support\Str::limit(strip_tags($html), $limit);
    }
}
if (!function_exists('getPaymentType')) {
    function getPaymentType($object)
    {
        return $className = class_basename(get_class($object));
    }
}
if (!function_exists('thousandFormat')) {
    function thousandFormat($number)
    {
        $number = (int)preg_replace('/[^0-9]/', '', $number);
        if ($number >= 1000) {
            $rn = round($number);
            $format_number = number_format($rn);
            $ar_nbr = explode(',', $format_number);
            $x_parts = array('K', 'M', 'B', 'T', 'Q');
            $x_count_parts = count($ar_nbr) - 1;
            $dn = $ar_nbr[0] . ((int)$ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
            $dn .= $x_parts[$x_count_parts - 1];

            return $dn;
        }
        return $number;
    }
}

if (!function_exists('getTicketNumber')) {
    function getTicketNumber($eventId, $oldTotal)
    {
        return $eventId . sprintf('%04d', ++$oldTotal);
    }
}

if (!function_exists('userMessageUnseen')) {
    function userMessageUnseen()
    {
        return Chat::where('receiver_id', auth()->id())->where('is_seen', STATUS_PENDING)->count();
    }
}

//notification helper start
function newTicketNotify($ticket_id)
{
    try {
        $ticketData = Ticket::find($ticket_id);

        if ($ticketData && $ticketData != null) {
            $userData = User::find($ticketData->client_id);

            //send customer mail
            $templeate = 'ticket-create-notify-for-client';
            setCommonNotification($userData->id, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $userData), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $userData));


            //send admin mail
            $templeate = 'ticket-create-notify-for-admin';
            $adminData = User::where(['tenant_id' => $ticketData->tenant_id, 'role' => USER_ROLE_ADMIN])->first();
            setCommonNotification($adminData->id, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $adminData), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $adminData));


            //send agent mail if exist
            $agentAssignee = getTicketAssigned($ticket_id);
            if (count($agentAssignee) > 0) {
                $templeate = 'ticket-create-notify-for-team-member';
                foreach ($agentAssignee as $agent) {
                    setCommonNotification($agent->assigned_to, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $agent), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $agent));
                }
            }
        } else {
            Log::info('New Ticket Create Email Notify Alert: Ticket not found');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('New Ticket Create Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

if (!function_exists('encodeId')) {
    function encodeId($num)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($chars);
        $encoded = '';

        while ($num > 0) {
            $encoded = $chars[$num % $base] . $encoded;
            $num = intdiv($num, $base);
        }

        $prefix = 'ab';
        $suffix = 'xy';

        return $prefix . $encoded . $suffix;
    }
}

if (!function_exists('decodeId')) {
    function decodeId($slug)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($chars);

        $encoded = substr($slug, 2, -2);
        $decoded = 0;

        for ($i = 0; $i < strlen($encoded); $i++) {
            $decoded = $decoded * $base + strpos($chars, $encoded[$i]);
        }

        return $decoded;
    }
}

function addUserActivityLog($action, $user)
{
    $current_ip = get_clientIp();
    $agent = new Agent();
    $deviceType = isset($agent) && $agent->isMobile() == true ? 'Mobile' : 'Web';
    $location = geoip()->getLocation($current_ip);
    $activity['action'] = $action;
    $activity['user_id'] = Auth::user()->id;
    $activity['ip_address'] = isset($current_ip) ? $current_ip : '0.0.0.0';
    $activity['source'] = $deviceType;
    $activity['location'] = $location->country;
    UserActivityLog::create($activity);
}

;


function currencyPrice($price)
{
    if ($price == null) {
        return 0;
    }
    if (getCurrencyPlacement() == 'after')
        return number_format($price, 2) . '' . getCurrencySymbol();
    else {
        return getCurrencySymbol() . number_format($price, 2);
    }
}

function getEmailByUserId($user_id)
{
    return User::where('id', $user_id)->first(['email'])?->email;
}

function getUserData($user_id, $property)
{
    $data = User::where('id', $user_id)->first();
    if (!is_null($data)) {
        return $data->{$property};
    }
    return null;
}

if (!function_exists('getTicketIdHtml')) {
    function getTicketIdHtml($data)
    {
        if ($data->last_reply_id == null && $data->status == TICKET_STATUS_OPEN) {
            return '<a href="' . getRoute($data) . '" class="btn bd-one bd-c-button text-button position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->ticket_id . '
                             <span class="badge bg-danger position-absolute rounded-pill agent-msg-new start-100 top-0 translate-middle">
                                ' . __("New") . '
                             </span>
                        </a>';
        } else if ($data->is_seen == 0) {
            if (\auth()->user()->role == USER_ROLE_CLIENT) {
                return '<a href="' . getRoute($data) . '" class="btn bd-one bd-c-button text-button position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->ticket_id . '
                              <span class="badge bg-danger position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
            } else {
                if ($data->last_reply_by != null && getRoleByUserId($data->last_reply_by) == USER_ROLE_CLIENT) {
                    return '<a href="' . getRoute($data) . '" class="btn bd-one bd-c-button text-button position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->ticket_id . '
                              <span class="badge bg-danger position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
                } else {
                    return '<a href="' . getRoute($data) . '" class="btn bd-one bd-c-button text-button position-relative ticket-tracking-id  agent-ticket-id" >
                            ' . $data->ticket_id . '
                            <span class="badge bg-danger position-absolute agent-msg-no-message rounded-pill top-0 translate-middle">
                                <i class="fa-regular  fa-envelope mb-0"></i>
                             </span>
                        </a>';
                }
            }
        } else {
            return '<a href="' . getRoute($data) . '" class="btn bd-one bd-c-button text-button position-relative ticket-tracking-id agent-ticket-id" >
                            ' . $data->ticket_id . '
                        </a>';
        }
    }
}

function getRoleByUserId($user_id)
{
    return User::where('id', $user_id)->first(['role'])->role;
}

function getRoute($data)
{
    $view_route = '';
    if (Auth::user()->role == USER_ROLE_CLIENT) {
        $view_route = route('user.ticket.details', encrypt($data->id));
    } else {
        $view_route = route('admin.ticket.details', encrypt($data->id));
    }
    return $view_route;
}

function getCustomEmailTemplate($type, $template, $property, $link = null, $customData = null, $userData = null)
{
    $data = EmailTemplate::where('slug', $template)->first();
    if ($data && $data != null) {
        if ($property == 'body') {
            $body = $data->{$property};
            foreach (customEmailTempFields($type) as $key => $item) {
                if ($key == '{{reset_password_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{email_verify_url}}') {
                    $body = str_replace($key, $link, $body);
                } else if ($key == '{{order_id}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->order_id : $customData['order_id'], $body);
                } else if ($key == '{{tracking_no}}' && $customData != NULL) {
                    $body = str_replace($key, is_object($customData) ? $customData->ticket_id : $customData['ticket_id'], $body);
                } else if ($key == '{{username}}') {
                    $body = str_replace($key, is_object($customData) ? (isset($userData->name) ? $userData->name : '') : (isset($userData['name']) ? $userData['name'] : ''), $body);
                } else if ($key == '{{ticket_title}}') {
                    $body = str_replace($key, $customData->ticket_title, $body);
                } else if ($key == '{{ticket_description}}') {
                    $body = str_replace($key, $customData->ticket_description, $body);
                } else if ($key == '{{ticket_created_time}}') {
                    $body = str_replace($key, $customData->created_at, $body);
                } else if ($key == '{{client_name}}') {
                    $body = str_replace($key, $customData->client_name, $body);
                } else if ($key == '{{link}}') {
                    $body = str_replace($key, $link, $body);
                } else {
                    $body = str_replace($key, $item, $body);
                }
            }
            return $body;
        } else if ($property == 'subject') {
            $subject = $data->{$property};

            foreach (customEmailTempFields($type) as $key => $item) {
                if ($key == '{{tracking_no}}') {
                    $subject = str_replace($key, $customData->ticket_id, $subject);
                }
            }

            return $subject;
        } else {
            return $data->{$property};
        }
    }
    return '';
}

function getTicketAssigned($ticketId)
{
    try {
        $ticketActiveAssignee = [];
        $ticketsData = Ticket::where('id', $ticketId)->with(['assignee'])->first();
        if ($ticketsData) {
            return $ticketsData->assignee;
        }
        return $ticketActiveAssignee;
    } catch (\Exception $e) {
        return [];
    }
}

//email notification helper start
function newTicketEmailNotify($ticket_id, $email = null)
{
    try {
        if (getOption('app_mail_status')) {

            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::find($ticketData->client_id);

                //send client mail
                $template = 'ticket-create-notify-for-client';
                Mail::to($userData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $userData, ''));

                //send admin mail
                $template = 'ticket-create-notify-for-admin';
                $adminData = User::where(['role' => USER_ROLE_ADMIN])->first();
                Mail::to($adminData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $adminData, ''));

                //send assignee mail if exist
                $agentAssignee = getTicketAssigned($ticket_id);
                if (count($agentAssignee) > 0) {
                    $template = 'ticket-create-notify-for-team-member';
                    foreach ($agentAssignee as $agent) {
                        Mail::to(getEmailByUserId($agent->assigned_to))->send(new CustomEmailNotify('ticket', $ticketData, $template, $agent, ''));
                    }
                }
            } else {
                Log::info('New Ticket Create Email Notify Alert: Ticket not found');
            }
        } else {
            Log::info('New Ticket Create Email Notify Alert: App mail status not active');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('New Ticket Create Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

function ticketStatusChangeEmailNotify($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::find($ticketData->client_id);
                //send customer mail
                $template = 'ticket-status-change-for-client';
                Mail::to($userData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $userData, ''));
            } else {
                Log::info('Ticket Status Change Email Notify Alert: Ticket not found');
            }
        } else {
            Log::info('Ticket Status Change Email Notify Alert: App mail status not active');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('Ticket Status Change Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

function ticketConversationEmailNotifyToAdminAndTeamMember($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {

            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {

                //send admin mail
                $template = 'ticket-conversation-for-admin';
                $adminData = User::where(['role' => USER_ROLE_ADMIN])->first();
                Mail::to($adminData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $adminData, ''));

                //send agent mail if exist
                $memberAssignee = getTicketAssigned($ticket_id);
                if (count($memberAssignee) > 0) {
                    $replyData = TicketConversation::where('ticket_id', $ticket_id)->get();
                    $memberList = [];
                    $assignMembertList = [];
                    $replyMemberList = [];
                    foreach ($memberAssignee as $member) {
                        $assignMembertList[] = [
                            'email' => getUserData($member->assigned_to, 'email'),
                            'name' => getUserData($member->assigned_to, 'name'),
                            'role' => getUserData($member->assigned_to, 'role')
                        ];
                    }
                    if (count($replyData) > 0) {
                        foreach ($replyData as $member) {
                            $userData = User::where('id', $member->user_id)
                                ->where('role', USER_ROLE_TEAM_MEMBER)
                                ->first();
                            if (is_null($userData)) {
                                continue;
                            }
                            $replyMemberList[] = [
                                'email' => $userData->email,
                                'name' => $userData->name,
                                'role' => $userData->role
                            ];
                        }
                        if ($replyMemberList != null && count($replyMemberList) > 0) {
                            $assignMembertList = array_unique(array_merge($assignMembertList, $replyMemberList), SORT_REGULAR);
                        }
                    }

                    $template = 'ticket-conversation-for-team-member';
                    foreach ($assignMembertList as $member) {
                        Mail::to($member['email'])->send(new CustomEmailNotify('ticket', $ticketData, $template, $member, ''));
                    }
                }
            } else {
                Log::info('Ticket Conversation Email Notify Alert: Ticket not found');
            }
        } else {
            Log::info('Ticket Conversation Email Notify Alert: App mail status not active');
        }

        return true;
    } catch (\Exception $e) {
        Log::info('Ticket Conversation Email Notify Error: ' . $e->getMessage());
        return true;
    }
}


function ticketConversationNotifyToAdminAndTeamMember($ticket_id)
{
    $ticketData = Ticket::find($ticket_id);
    if ($ticketData && $ticketData != null) {

        //send admin mail
        $templeate = 'ticket-conversation-for-admin';
        $adminData = User::where(['role' => USER_ROLE_ADMIN])->first();
        setCommonNotification($adminData->id, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $adminData), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $adminData));

        //send agent mail if exist
        $agentAssignee = getTicketAssigned($ticket_id);
        if (count($agentAssignee) > 0) {
            $templeate = 'ticket-conversation-for-team-member';
            foreach ($agentAssignee as $agent) {
                setCommonNotification($agent->assigned_to, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $agent), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $agent));
            }
        }
    }
}

function ticketConversationNotifyForCustomer($ticket_id)
{
    try {
        $ticketData = Ticket::find($ticket_id);
        if ($ticketData && $ticketData != null) {
            $userData = User::find($ticketData->client_id);
            //send customer mail
            $templeate = 'ticket-conversation-for-client';
            setCommonNotification($userData->id, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $userData), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $userData));
        }
    } catch (\Exception $e) {
        Log::info($e->getMessage());
    }
}

function ticketConversationEmailNotifyForCustomer($ticket_id)
{
    try {
        if (getOption('app_mail_status')) {
            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::find($ticketData->client_id);
                //send customer mail
                $template = 'ticket-conversation-for-client';
                Mail::to($userData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $userData, ''));
            } else {
                Log::info('Ticket Conversation Email Notify Alert: Ticket not found');
            }
        } else {
            Log::info('Ticket Conversation Email Notify Alert: App mail status not active');
        }

        return true;
    } catch (\Exception $e) {
        Log::info('Ticket Conversation Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

function orderMailNotify($invoice_id, $type = INVOICE_MAIL_TYPE_UNPAID)
{
    try {
        if (getOption('app_mail_status')) {
            $clientInvoice = ClientInvoice::find($invoice_id);

            if ($clientInvoice && $clientInvoice != null) {
                $userData = User::find($clientInvoice->client_id);
                //send customer mail
                if ($type == INVOICE_MAIL_TYPE_PAID) {
                    $template = 'invoice-paid-notify-for-client';
                } else {
                    $template = 'invoice-unpaid-notify-for-client';
                }
                Mail::to($userData->email)->send(new CustomEmailNotify('invoice', $clientInvoice, $template, $userData, ''));
            } else {
                Log::info('Invoice Email Notify Alert: Invoice not found');
            }
        } else {
            Log::info('Invoice Email Notify Alert: App mail status not active');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('Ticket Conversation Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

function sendForgotMail($email)
{
    try {
        if (getOption('app_mail_status')) {
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]);

            $user = User::where('email', $email)->first();

            //send customer mail
            $customizedFieldsArray = [];

            $link = route('password.reset.verify', $token);

            Mail::to($email)->send(new CustomEmailNotify('reset-password', collect($customizedFieldsArray), 'password-reset', $user, $link));
        } else {
            Log::info('Forgot Email Notify Alert: App mail status not active');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('Ticket Conversation Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

function assigneMemberEmailNotify($ticket_id, $assigne_to)
{
    try {
        if (getOption('app_mail_status')) {

            $ticketData = Ticket::find($ticket_id);
            if ($ticketData && $ticketData != null) {
                $userData = User::find($assigne_to);

                //send client mail
                $template = 'ticket-assign-for-team-member';
                Mail::to($userData->email)->send(new CustomEmailNotify('ticket', $ticketData, $template, $userData, ''));
            } else {
                Log::info('Assign Member Email Notify Alert: Ticket not found');
            }
        } else {
            Log::info('Assign Member Email Notify Alert: App mail status not active');
        }
        return true;
    } catch (\Exception $e) {
        Log::info('Assign Member Email Notify Error: ' . $e->getMessage());
        return true;
    }
}

//email notification helper end

function getServiceById($id, $property)
{
    $data = Service::withTrashed()->find($id);
    return $data?->{$property};
}

function getOrderItemByOrderId($id)
{
    return ClientOrderItem::where('client_order_id', $id)->get();
}

function ticketStatusChangeNotify($ticket_id)
{
    $ticketData = Ticket::find($ticket_id);
    if ($ticketData && $ticketData != null) {
        $userData = User::find($ticketData->client_id);
        //send customer mail
        $templeate = 'ticket-status-change-for-client';
        setCommonNotification($userData->id, getCustomEmailTemplate('ticket', $templeate, 'subject', $link = '', $ticketData, $userData), getCustomEmailTemplate('ticket', $templeate, 'body', '', $ticketData, $userData));
    }
}


function getOrderIdByOrderCustomId($id)
{
    return ClientOrder::where('order_id', $id)->first('id')?->id;
}

if (!function_exists('get_domain_name')) {
    function get_domain_name($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}

if (!function_exists('generateUniqueTaskboardId')) {
    function generateUniqueTaskboardId($taskNumber)
    {
        // Ensure the task number is a 2-digit number
        $taskId = str_pad($taskNumber % 100, 2, '0', STR_PAD_LEFT);

        // Check for uniqueness in the database
        while (\App\Models\OrderTask::where('taskId', $taskId)->exists()) {
            $taskNumber++;
            $taskNumberFormatted = str_pad($taskNumber % 100, 2, '0', STR_PAD_LEFT);
            $taskId = $taskNumberFormatted;
        }

        return $taskId;
    }
}
if (!function_exists('formatDate')) {
    function formatDate($date = null, $format = 'M d')
    {
        // Use current date if no date is provided
        $date = $date ? Carbon::parse($date) : Carbon::now();
        $formattedDate = $date->format($format);

        return $formattedDate;
    }
}

if (!function_exists('syncMissingGateway')) {
    function syncMissingGateway(): void
    {
        $users = \App\Models\User::where('role', USER_ROLE_ADMIN)->get();
        $gateways = getPaymentServiceClass(); // Get all the available gateways

        // Loop through each user
        foreach ($users as $user) {
            // Get all existing gateways for the current user
            $existingGateways = \App\Models\Gateway::pluck('slug')->toArray();

            // Loop through each gateway in the payment services list
            foreach ($gateways as $gatewaySlug => $gatewayService) {
                // If the gateway doesn't exist for the user, insert it
                if (!in_array($gatewaySlug, $existingGateways)) {
                    // Insert missing gateway for the user
                    $gateway = new \App\Models\Gateway();
                    $gateway->title = ucfirst($gatewaySlug);
                    $gateway->slug = $gatewaySlug;
                    $gateway->image = 'assets/images/gateway-icon/' . $gatewaySlug . '.png';
                    $gateway->status = 1;
                    $gateway->mode = 2; // Assuming '2' is the default mode
                    $gateway->created_at = now();
                    $gateway->updated_at = now();
                    $gateway->save();

                    // Insert currency for the new gateway
                    $currency = new \App\Models\GatewayCurrency();
                    $currency->gateway_id = $gateway->id;
                    $currency->currency = 'USD';
                    $currency->conversion_rate = 1.0;
                    $currency->created_at = now();
                    $currency->updated_at = now();
                    $currency->save();
                }
            }
        }
    }
}

if (!function_exists('getPrefix')) {
    function getPrefix()
    {
        $themeStyle = getOption('app_theme_style');
        if ($themeStyle == THEME_HOME_ONE) {
            return 'theme-one';
        } elseif ($themeStyle == THEME_HOME_TWO) {
            return 'theme-two';
        } elseif ($themeStyle == THEME_HOME_THREE) {
            return 'theme-three';
        } else {
            return 'theme-one';
        }
    }
}

if (!function_exists('getAddonCodeCurrentVersion')) {
    function getAddonCodeCurrentVersion($appCode)
    {
        Artisan::call("config:clear");
        return config('addon.' . $appCode . '.current_version', 0);
    }
}
