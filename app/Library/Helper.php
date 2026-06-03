<?php

namespace App\Library;

use Image;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Address;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Models\CourierPricingPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Helper
{
    public static function generateQrCode(string $code)
    {
        $dir = Enum::QRCODE_DIR;
        $path = public_path($dir);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file_name = time() . rand(111, 999) . '.png';
        QrCode::format('png')
            ->merge('/resources/images/logo.png', 0.3)
            ->color(6, 131, 103)
            ->size(200)
            ->generate($code, $path . $file_name);

        return $dir . $file_name;
    }

    public static function hasAuthRolePermission($permission)
    {
        return in_array($permission, config('auth.role_permissions'));
    }

    public static function log($error)
    {
        Log::error($error);
    }

    public static function uploadImage($image, $path, $w = null, $h = null)
    {
        $file_name = time() . rand(111, 999) . '.webp'; //. $image->getClientOriginalExtension(); // 'webp'
        $destination_path = public_path($path);

        if (!is_dir($destination_path)) {
            mkdir($destination_path, 0777, true);
        }

        $image_file = Image::make($image->getRealPath())->encode('webp', 90);

        if ($w && $h) {
            $image_file->resize($w, $h, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $image_file->save($destination_path . '/' . $file_name);

        return $path . '/' . $file_name;
    }

    public static function getPublicUrl($url)
    {
        return url($url);
    }

    public static function getClientIp()
    {
        $ipaddress = '';

        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function getGeoInfo()
    {
        $ip = self::getClientIp();

        if ($ip == '::1') {
            $data = @unserialize(file_get_contents('http://ip-api.com/php/'));
        } else {
            $data = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        }

        if ($data && $data['status'] == 'success') {
            return $data;
        }

        return false;
    }

    public static function uploadFile($requested_file, $path)
    {
        if (!empty($requested_file) && $requested_file != 'null') :
            $extension = $requested_file->getClientOriginalExtension();
            $originalFile = date('YmdHis') . "_original_" . rand(1, 500) . '.' . $extension;
            $directory = $path . '/';
            File::ensureDirectoryExists($directory, 0777, true);
            $originalFileUrl = $directory . $originalFile;
            $requested_file->move($directory, $originalFile);

            return $originalFileUrl;
        else :
            return false;
        endif;
    }

    public static function prepareMessage(string $key, $data)
    {
        $email_setting = EmailTemplate::where('key', $key)->first();

        $subject = $email_setting->subject;
        $message = $email_setting->message;

        $shortcodes = explode(',', $email_setting->shortcodes);
        $shortcode_values = [];

        foreach ($shortcodes as $shortcode) {
            switch ($shortcode) {
                case 'post_type':
                    $shortcode_values['post_type'] = $data->type;

                    break;
                case 'post_title':
                    $shortcode_values['post_title'] = $data->title;

                    break;
                default:
            }
        }

        $message = Helper::replaceMessageWithShortcodes($message, $shortcode_values);

        $data = [
            'subject' => $subject,
            'message' => $message,
        ];

        return $data;
    }

    public static function replaceMessageWithShortcodes(string $message, array $shortcodes = [])
    {
        $shortcodes['current_date'] = now()->format('y-m-d');
        $shortcodes['current_datetime'] = now()->format("F j, Y, g:i a");
        $shortcodes['current_time'] = now()->format("g:i a");
        $shortcodes['system_url'] = settings('copyright_url');
        $shortcodes['app_name'] = settings('app_title');

        if (count($shortcodes)) {
            foreach ($shortcodes as $code => $value) {
                $regex = "/{(\s*)$code(\s*)}/";
                $message = preg_replace($regex, $value, $message);
            }
        }
        $shortcodes = Enum::systemShortcodesWithValues();

        foreach ($shortcodes as $code => $value) {
            $regex = "/{(\s*)$code(\s*)}/";
            $message = preg_replace($regex, $value, $message);
        }

        return $message;
    }

    public static function replaceWithUrl(string $text)
    {
        $p = "/(http|https|ftp|ftps)/";

        if (preg_match($p, $text, $url)) {
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        } else {
            $text = preg_replace("/www\./", "http://www.", $text);
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        }

        if (preg_match($reg_exUrl, $text, $url)) {
            echo preg_replace($reg_exUrl, '<a target=\"_blank\" href="' . $url[0] . '" rel="nofollow">' . $url[0] . '</a>', $text);
        } else {
            echo $text;
        }
    }

    /**
     * Create activity log
     *
     * @param string $action
     * @param string $subject
     * @param string $difference
     * @param string $ip
     * @param string $browser
     *
     * @return void
     */
    public static function createActivityLog($action, $subject, $record_id, $difference, $ip, $browser, $note = null, $status = null)
    {
        ActivityLog::create([
            'action_by' => auth()->check() ? auth()->id() : null,
            'log_time'  => now(),
            'action'    => $action,
            'subject'   => $subject,
            'record_id' => $record_id,
            'changes'   => $difference,
            'note'      => $note,
            'status'    => $status,
            'ip'        => $ip,
            'browser'   => $browser
        ]);
    }

    public static function getCountries()
    {
        return Cache::remember('employees', 60 * 60 * 24, function () {
            return include(__DIR__ . '/../Files/Countries.php');
        });
    }

    public static function getCountryName($country_short_name)
    {
        $countries = Helper::getCountries();

        return $countries[$country_short_name]['name'] ?? '';
    }

    public static function getTimeZones()
    {
        return include(__DIR__ . '/../Files/TimeZones.php');
    }

    /**
     * Format given date
     *
     * @param mixed $date
     * @param string $format
     *
     * @return static
     */
    public static function getDateFormat($date, $format)
    {
        return Carbon::parse($date)->format($format);
    }

    public static function getBgColorClass($status)
    {
        $statusList = [
            'Active'    => 'card-dark-blue',
            'Approved'  => 'card-dark-blue',
            'Completed' => 'card-dark-blue',
            'Inactive'  => 'card-light-blue',
            'Pending'   => 'card-tale',
            'Declined'  => 'card-light-danger',
            'Suspended' => 'card-light-danger',
            'Hold'      => 'card-light-blue',
            'Closed'    => 'card-dark-blue',
            'Open'      => 'card-tale',
        ];

        return $statusList[$status] ? $statusList[$status] : '';
    }

    public static function getColorClass($status)
    {
        $statusList = [
            'Active'    => 'primary',
            'Approved'  => 'success',
            'Completed' => 'success',
            'Enrolled'  => 'success',
            'Inactive'  => 'secondary',
            'Pending'   => 'warning',
            'Declined'  => 'danger',
            'Discharge' => 'danger',
            'Suspended' => 'danger',
            'Hold'      => 'warning',
            'Closed'    => 'success',
            'Open'      => 'primary',
            'Notes'     => 'success',
            'Private'   => 'danger',
            'Whanau'    => 'secondary',
            'Group'     => 'primary',
            'New'       => 'secondary',
        ];

        return $statusList[$status] ? $statusList[$status] : '';
    }

    public static function getDifference($model, $update = false, $created = false)
    {
        if ($created) {
            return json_encode([
                'before' => $model,
                'after'  => ''
            ], true);
        }

        if ($update) {
            $changed = $model->getDirty();

            return json_encode([
                'before' => array_intersect_key($model->getOriginal(), $changed),
                'after'  => $changed
            ], true);
        }

        return json_encode([
            'before' => $model->id,
            'after'  => ''
        ], true);
    }

    public static function encrypt(string $str)
    {
        $ciphering = "AES-256-CBC";
        $encryption_iv = '5254565455885545';
        $encryption_key = 'SERfuGpy+LB+SUwAIFQwU6NKaEcpf455sdfsdewrSDF';

        return openssl_encrypt($str, $ciphering, $encryption_key, 0, $encryption_iv);
    }

    // public static function uniqueId(string $key)
    // {
    //     $stockId = Stock::latest('id')->first();

    //     if ($stockId) :
    //         $id = $stockId->id + 1;
    //     else :
    //         $id = 1;
    //     endif;
    //     $u_id = $key . '-' . str_pad($id, 4, "0", STR_PAD_LEFT);

    //     return $u_id;
    // }

    // public static function createFamilyId(string $key)
    // {
    //     $totalFamilyID = ClientFamilyTree::select('family_id', DB::raw('count(*) as total'))
    //         ->groupBy('family_id')
    //         ->pluck('total')
    //         ->count();

    //     if ($totalFamilyID) :
    //         $id = $totalFamilyID + 1;
    //     else :
    //         $id = 1;
    //     endif;
    //     $u_id = $key . '-' . str_pad($id, 4, "0", STR_PAD_LEFT);

    //     return $u_id;
    // }

    public static function isImage($name)
    {
        return (explode('.', $name))[1] == 'pdf' ? false : true;
    }

    public static function dateRange($fromTime, $toTime)
    {
        return Carbon::parse($fromTime)->format(outputDateFormat()) . ' - ' . Carbon::parse($toTime)->format(outputDateFormat());
    }

    public static function getAvailableReferralStatus(string $status)
    {
        $arr = [
            Enum::REFERRAL_STATUS_PENDING  => "Pending",
            Enum::REFERRAL_STATUS_ENROLLED => "Enrolled",
            Enum::REFERRAL_STATUS_DECLINED => "Declined",
        ];

        if ($status == Enum::REFERRAL_STATUS_ENROLLED) {
            $arr = [
                Enum::REFERRAL_STATUS_ENROLLED  => "Enrolled",
                Enum::REFERRAL_STATUS_DISCHARGE => "Discharge",
            ];
        }

        return $arr;
    }

    public static function userName(string $name, $types)
    {
        if ($types == 'employee') {
            $uId = Employee::latest('id')->first();
        } elseif ($types == 'member') {
            $uId = Member::latest('id')->first();
        } else {
            $uId = '';
        }

        if ($uId) :
            $id = $uId->id + 1;
        else :
            $id = 1;
        endif;
        $u_id = $name . $id;

        return $u_id;
    }

    public function getSubscriptionExpDate()
    {
        return now()->startOfYear()->addMonths(5)->lastOfMonth();
    }

    public static function sku($prefix)
    {
        $separator = config('sku_separator') ? config('sku_separator') : '-';

        $prefix = Str::limit($prefix, 3, '');

        $sku = "";
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for ($i = 0; $i < 10; $i++) {
            $sku .= $string[rand(0, strlen($string) - 1)];
        }

        $result = implode($separator, [strtoupper($prefix), $sku]);

        return $result;
    }

    // ======================================= Start Calculate Shipping Cost ======================================= //
    public static function calculateShippingCost()
    {
        $cartIdentifier = request()->cookie('cart_identifier');
        $cartItemsGroupedBySeller = Cart::with(['product.seller'])
                                    ->where('cart_identifier', $cartIdentifier)
                                    ->get()
                                    ->groupBy('product.seller.id');

        // Calculate the sum of product weights for each seller
        $sellerShippingDetails = $cartItemsGroupedBySeller->map(function ($items, $sellerId) {
            $totalWeight = $items->sum(function ($item) {
                return $item->product->weight * $item->quantity;
            });

            $sellerAddress = Address::where('user_id', $sellerId)->first();
            $customerAddress = Address::where('user_id', auth()->id())->where('primary', true)->first();

            // if (!$sellerAddress) {
            //     session()->flash('error', 'Opps! something went wrong!');
            // }

            $extra_cost = 0;

            if ($customerAddress?->location == Enum::INSIDE_DHAKA) {
                $extra_cost = settings('extra_charge_for_inside_dhaka');
            } elseif ($customerAddress?->location == Enum::OUTSIDE_DHAKA) {
                $extra_cost = settings('extra_charge_for_outside_dhaka');
            } elseif ($customerAddress?->location == Enum::SUBURBS) {
                $extra_cost = settings('extra_charge_for_sub_dhaka');
            }

            return [
                'seller_id'         => $sellerId,
                'pickup_location'   => $sellerAddress?->location,
                'delivery_location' => $customerAddress?->location,
                'total_weight'      => $totalWeight,
                'extra_cost'        => $extra_cost,
            ];

        });

        $totalShippingCost = 0;

        foreach ($sellerShippingDetails as $cartItem) {
            $totalWeight = $cartItem['total_weight'];
            $pickupLocation = $cartItem['pickup_location'];
            $deliveryLocation = $cartItem['delivery_location'];
            $extra_cost = $cartItem['extra_cost'];

            $pricingPlan = CourierPricingPlan::where('pickup_location', $pickupLocation)
                ->where('delivery_location', $deliveryLocation)
                ->where('active', true)
                ->where(function($query) use ($totalWeight) {
                    $query->where('min_weight', '<=', $totalWeight)
                          ->where('max_weight', '>=', $totalWeight)
                          ->orWhere('max_weight', '<', $totalWeight);  // This line to include max_weight case
                })
                ->orderBy('max_weight', 'desc')
                ->first();

            if ($pricingPlan) {
                if ($totalWeight <= $pricingPlan->max_weight) {
                    $shippingCost = $pricingPlan->price;
                } else {
                    // Calculate the additional cost for weights over max_weight
                    $extraWeight = $totalWeight - $pricingPlan->max_weight;
                    $extraCost = (float) $extraWeight * (float) $extra_cost;
                    $shippingCost = $pricingPlan->price + $extraCost;
                }

                $totalShippingCost += $shippingCost;
            }
        }

        return $totalShippingCost;
    }
    // ======================================= End Calculate Shipping Cost ======================================= //
}
