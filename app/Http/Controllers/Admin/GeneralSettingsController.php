<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Library\Enum;
use App\Models\Config;
use App\Library\Helper;
use App\Mail\DefaultMail;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\Admin\Config\SocialLinkRequest;
use App\Http\Requests\Admin\Config\EmailSettingsRequest;
use App\Http\Requests\Admin\EmailTemplates\UpdateRequest;
use App\Http\Requests\Admin\Config\GeneralSettingsRequest;

class GeneralSettingsController extends Controller
{
    public function systemDetails()
    {
        return view('admin.pages.config.general_settings.system_details', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function address()
    {
        return view('admin.pages.config.general_settings.address', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function communication()
    {
        return view('admin.pages.config.general_settings.communication', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function multimedia()
    {
        return view('admin.pages.config.general_settings.media', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function date_time()
    {
        return view('admin.pages.config.general_settings.date_time', [
            'countries' => Helper::getCountries(),
            'timezones' => Helper::getTimeZones(),
        ]);
    }

    public function currency()
    {
        return view('admin.pages.config.general_settings.currency', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function posSettings()
    {
        return view('admin.pages.config.general_settings.pos', [
            'countries' => Helper::getCountries(),
        ]);
    }

    public function updateEmailTemplateForm(EmailTemplate $email_template)
    {
        $shortcodes = explode(',', $email_template->shortcodes);
        $systemShortCodes = Enum::systemShortcodesWithValues();

        return view('admin.pages.config.email_template.update', [
            'data'             => $email_template,
            'shortcodes'       => $shortcodes,
            'systemShortCodes' => $systemShortCodes,
        ]);
    }

    public function updateEmailTemplate(EmailTemplate $email_template, UpdateRequest $request)
    {
        $data = $request->validated();
        $email_template->update([
            'subject' => $data['subject'],
            'message' => $data['message']
        ]);

        return back()->with('success', __('Successfully Updated'));
    }

    public function emailSettings()
    {
        return view('admin.pages.config.general_settings.email_settings');
    }

    public function updateEmailSettings(EmailSettingsRequest $request)
    {
        try {
            $data = $request->validated();

            $this->updateConfig($data);

            updateEnv($data);

            return back()->with('success', __('Successfully Updated'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return back()->with('error', __('Something went wrong! Please try again'));
        }
    }

    public function socialLink()
    {
        return view('admin.pages.config.general_settings.social_link');
    }

    public function settlement()
    {
        return view('admin.pages.config.general_settings.settlement');
    }

    public function courier()
    {
        return view('admin.pages.config.general_settings.courier');
    }

    public function shippingCost()
    {
        return view('admin.pages.config.general_settings.shipping_price');
    }

    public function updateSocialLink(SocialLinkRequest $request)
    {
        $data = $request->validated();

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }

    public function updateShippingCost(Request $request)
    {
        $data = $request->all();

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }

    public function updateGeneralSettings(GeneralSettingsRequest $request)
    {
        $data = $request->validated();

        if (isset($data['logo'])) {
            $width = '300';
            $height = '50';

            if ($data['width']) {
                $width = $data['width'];
            }

            if ($data['height']) {
                $height = $data['height'];
            }

            $data['logo'] = Helper::uploadImage($data['logo'], Enum::CONFIG_IMAGE_DIR, $width, $height);
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = Helper::uploadImage($data['favicon'], Enum::CONFIG_IMAGE_DIR, 32, 32);
        }

        if (isset($data['og_image'])) {
            $data['og_image'] = Helper::uploadImage($data['og_image'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['invoice_logo'])) {
            $data['invoice_logo'] = Helper::uploadImage($data['invoice_logo'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['login_logo'])) {
            $data['login_logo'] = Helper::uploadImage($data['login_logo'], Enum::CONFIG_IMAGE_DIR, 200, 200);
        }

        if (isset($data['login_bg_image'])) {
            $data['login_bg_image'] = Helper::uploadImage($data['login_bg_image'], Enum::CONFIG_IMAGE_DIR, '', '');
        }

        $this->updateConfig($data);

        unset($data['date_format'], $data['time_format']);

        if (isset($data['app_timezone'])) {
            updateEnv($data);
        }

        return back()->with('success', __('Successfully Updated'));
    }

    public function preference()
    {
        return view('admin.pages.config.general_settings.preference');
    }

    protected function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            Config::where('key', $key)->update(['value' => $value]);
        }

        Artisan::call('cache:clear');
    }

    public function sendTestMail(Request $request)
    {
        $subject = 'Testing Email';
        $message = 'This is a test email, <br> please ignore if you are not meant to be get this email.';

        try {
            $emailDetails = [
                'email'   => $request->email,
                'subject' => $subject,
                'message' => $message,
            ];

            //(new EmailFactory())->initializeEmail($emailDetails);
            Mail::to($emailDetails['email'])->send(new DefaultMail($emailDetails['subject'], $emailDetails['message']));


            return back()->with('success', __('You will receive a test email soon'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return back()->with('error', __('please check your email settings'));
        }
    }

    public function backendColor()
    {
        return view('admin.pages.config.general_settings.color.backend_color');
    }

    public function frontendColor()
    {
        return view('admin.pages.config.general_settings.color.frontend_color');
    }

    public function backendColorDynamic()
    {
        $btn_primary = settings('btn_primary');
        $btn_secondary = settings('btn_secondary');
        $btn_light = settings('btn_light');
        $btn_disabled = settings('btn_disabled');
        $btn_primary_text = settings('btn_primary_text');
        $btn_secondary_text = settings('btn_secondary_text');
        $btn_light_text = settings('btn_light_text');
        $btn_primary_hover = settings('btn_primary_hover');
        $btn_secondary_hover = settings('btn_secondary_hover');
        $btn_light_hover = settings('btn_light_hover');
        $btn_disabled_hover = settings('btn_disabled_hover');
        $btn_primary_text_hover = settings('btn_primary_text_hover');
        $btn_secondary_text_hover = settings('btn_secondary_text_hover');
        $btn_light_text_hover = settings('btn_light_text_hover');
        $text_heading = settings('text_heading');
        $general_text = settings('general_text');
        $tab_color = settings('tab_color');
        $card_heading = settings('card_heading');
        $bg_color = settings('bg_color');
        $card_heading_text = settings('card_heading_text');
        $card_bg = settings('card_bg');
        $table_heading = settings('table_heading');
        $table_heading_text = settings('table_heading_text');
        $table_btn = settings('table_btn');
        $table_btn_hover = settings('table_btn_hover');

        return response("
        :root {
            --btn-primary: {$btn_primary};
            --btn-secondary: {$btn_secondary};
            --btn-light: {$btn_light};
            --btn-disabled: {$btn_disabled};
            --btn-primary-text: {$btn_primary_text};
            --btn-secondary-text: {$btn_secondary_text};
            --btn-light-text: {$btn_light_text};
            --btn-primary-hover: {$btn_primary_hover};
            --btn-secondary-hover: {$btn_secondary_hover};
            --btn-light-hover: {$btn_light_hover};
            --btn-disabled-hover: {$btn_disabled_hover};
            --btn-primary-text-hover: {$btn_primary_text_hover};
            --btn-secondary-text-hover: {$btn_secondary_text_hover};
            --btn-light-text-hover: {$btn_light_text_hover};
            --text-heading: {$text_heading};
            --general-text: {$general_text};
            --tab-color: {$tab_color};
            --card-heading: {$card_heading};
            --bg-color: {$bg_color};
            --card-heading-text: {$card_heading_text};
            --card-bg: {$card_bg};
            --table-heading: {$table_heading};
            --table-heading-text: {$table_heading_text};
            --table-btn: {$table_btn};
            --table-btn-hover: {$table_btn_hover};
        }")->header('Content-Type', 'text/css');
    }

    public function frontendColorDynamic()
    {
        $primary_color = settings('primary_color');
        $secondary_color = settings('secondary_color');
        $accent_color = settings('accent_color');
        $background_color = settings('background_color');
        $breadcrumb_bg_color = settings('breadcrumb_bg_color');
        $footer_color = settings('footer_color');
        $general_color = settings('general_color');
        $heading_text = settings('heading_text');
        $secondary_text = settings('secondary_text');
        $card_color = settings('card_color');
        $card_hover_color = settings('card_hover_color');

        return response("
        :root {
            --primary-color: {$primary_color};
            --secondary-color: {$secondary_color};
            --accent-color: {$accent_color};
            --background-color: {$background_color};
            --breadcrumb-bg-color: {$breadcrumb_bg_color};
            --footer-color: {$footer_color};
            --general-color: {$general_color};
            --heading-text: {$heading_text};
            --secondary-text: {$secondary_text};
            --card-color: {$card_color};
            --card-hover-color: {$card_hover_color};
        }")->header('Content-Type', 'text/css');
    }

    public function resetColorSettings($website)
    {
        $route = '';
        if ($website == 'backend') {
            $colors = setDefaultColor();

            $route = 'admin.config.general_settings.backend.color';

            $this->updateConfig($colors);
        } else {
            $colors = setFrontendDefaultColor();

            $route = 'admin.config.general_settings.frontend.color';

            $this->updateConfig($colors);
        }

        return redirect()->route($route)->with('status', 'Color settings have been reset!');
    }
}
