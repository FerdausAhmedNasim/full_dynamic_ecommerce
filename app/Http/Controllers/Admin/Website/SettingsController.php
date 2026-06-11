<?php

namespace App\Http\Controllers\Admin\Website;

use App\Library\Enum;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Library\Services\Admin\Website\BenefitService;

class SettingsController extends Controller
{
    use ApiResponse;
    private $benefit_service;

    public function __construct(BenefitService $benefit_service)
    {
        $this->benefit_service = $benefit_service;
    }

    public function cookies()
    {
        return view('admin.pages.website.settings.cookies');
    }

    public function terms_and_conditions()
    {
        $data = [
            // (object)[   'title' => 'Seller Policy',
            //     'slug'          => 'seller_policy',
            // ],
            (object)[   'title' => 'Privacy Policy',
                'slug'          => 'privacy_policy',
            ],
            (object)[   'title' => 'Terms & Condition',
                'slug'          => 'terms_and_conditions',
            ],
        ];

        return view('admin.pages.website.settings.terms_and_condition', [
            'pages' => $data
        ]);
    }

    public function website_popup()
    {
        return view('admin.pages.website.settings.popup');
    }

    public function banners()
    {
        return view('admin.pages.website.settings.banners');
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if (! isset($data['customer_agreement'])) {
            $data['customer_agreement'] = '';
        }

        if (! isset($data['seller_agreement'])) {
            $data['seller_agreement'] = '';
        }

        if (isset($data['popup_image'])) {
            $data['popup_image'] = storeFile($data['popup_image'], Enum::POPUP_IMAGE_DIR);
        }

        if (isset($data['login_banner'])) {
            $data['login_banner'] = storeFile($data['login_banner'], Enum::POPUP_IMAGE_BANNER);
        }

        if (isset($data['signup_banner'])) {
            $data['signup_banner'] = storeFile($data['signup_banner'], Enum::POPUP_IMAGE_BANNER);
        }

        if (isset($data['forgot_password_banner'])) {
            $data['forgot_password_banner'] = storeFile($data['forgot_password_banner'], Enum::POPUP_IMAGE_BANNER);
        }

        if (isset($data['landing_banner'])) {
            $data['landing_banner'] = storeFile($data['landing_banner'], Enum::POPUP_IMAGE_BANNER);
        }

        $this->updateConfig($data);

        return back()->with('success', __('Successfully Updated'));
    }

    protected function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            // ✅ এটা ব্যবহার করুন
            Config::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Artisan::call('cache:clear');
    }

    protected function updateStatusConfig(string $key)
    {
        if ($key == 'full_payment') {
            Config::where('key', 'advance_shipping_cost')->first()->update(['value' => 0]);
        }

        $config = Config::where('key', $key)->first();
        $config->update(['value' => !$config->value]);

        Artisan::call('cache:clear');

        return back()->with('success', __('Successfully Updated'));
    }
}
