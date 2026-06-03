<?php

use App\Models\User;
use App\Library\Enum;
use App\Models\Color;
use App\Models\Order;
use App\Models\Config;
use App\Library\Helper;
use App\Models\Category;
use App\Models\Location;
use App\Models\Attachment;
use App\Models\OrderReturn;
use Illuminate\Support\Arr;
use App\Models\AttributeValue;
use App\Models\CommonLanguage;
use Rmunate\Utilities\SpellNumber;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\Library\Services\Admin\ConfigService;

/**
 * Fetch config data by key
 *
 * @param  $key
 *
 * @return mixed
 */
function settings($key)
{
    static $config;

    if (is_null($config)) {
        $config = Cache::remember('config', 24 * 60, function () {
            return Config::pluck('value', 'key')->toArray();
        });
    }

    $config = Config::pluck('value', 'key')->toArray();

    return (is_array($key)) ? Arr::only($config, $key) : $config[$key];
}

/**
 * Update env file
 *
 * @param  $data - key value pair data
 *  key is the key of env file
 *  and the value is associated value of the key
 *
 * @return mixed
 */
function updateEnv(array $data)
{
    foreach ($data as $key => $value) {
        $key = strtoupper($key);
        $updatedEnvData = str_replace($key . '="' . env($key) . '"', $key . '="' . $value . '"', file_get_contents(app()->environmentFilePath()));

        file_put_contents(app()->environmentFilePath(), $updatedEnvData);
    }
}

/**
 * Delete file
 *
 * @param  $path
 *
 * @return void
 */
function deleteFile($path)
{
    $paths = is_array($path) ? $path : [$path];

    foreach ($paths as $item) {
        if (File::exists(public_path($item))) {
            File::delete(public_path($item));
        }
    }
}

/**
 *
 * @param  $key
 *
 * @return mixed
 */
function getDropdown(string $key)
{
    return ConfigService::getDropdown($key);
}

function getLocations()
{
    return Location::orderBy('name')->get();
}

function formatPrice($price)
{
    // Format the price with 2 decimal places and a comma as the thousands separator
    $formattedPrice = number_format($price, 2, '.', ',');

    // Add a dollar sign to the beginning of the formatted price
    $formattedPrice = settings('currency_symbol') != '' ? settings('currency_symbol') . $formattedPrice : config('app.currency_sign') . $formattedPrice;

    return $formattedPrice;
}

function getFormattedAmount($amount)
{
    $symbol = settings('currency_symbol') ? settings('currency_symbol') : '৳';
    $position = settings('currency_position') ? settings('currency_position') : "left";
    $decimalSeparator = settings('decimal_separator') ? settings('decimal_separator') : '.';
    $thousandSeparator = settings('thousand_separator') ? settings('thousand_separator') : 'comma';
    $numberOfDecimal = settings('number_of_decimal') ? settings('number_of_decimal') : '0';

    if ($thousandSeparator == 'comma') {
        $thousandSeparator = ',';
    } else {
        $thousandSeparator = ' ';
    }

    $formattedAmount = number_format($amount, $numberOfDecimal, $decimalSeparator, $thousandSeparator);

    // set currency position
    if ($position == 'left') {
        $formattedAmount = $symbol . $formattedAmount;
    } else {
        $formattedAmount = $formattedAmount . $symbol;
    }

    return $formattedAmount;
}

function generateInvoiceId()
{
    $invoice_prefix = settings('invoice_prefix') ? settings('invoice_prefix') : '';
    $invoice_start_from = settings('invoice_start_from') ? settings('invoice_start_from') : 0; //1000

    // $order = Order::latest()->first();
    $order = Order::orderBy('id', 'desc')->first();

    if ($order) {
        return $invoice_prefix ? ($invoice_prefix . '-' . ($order->id + 1) + abs($invoice_start_from)) : ($order->id + 1 + abs($invoice_start_from));
    }

    return $invoice_prefix ? ($invoice_prefix . '-' . abs($invoice_start_from) + 1) : (abs($invoice_start_from) + 1);
}

function generateQuotationId()
{
    $invoice_prefix = settings('invoice_prefix') ? settings('invoice_prefix') : '';
    $invoice_start_from = settings('invoice_start_from') ? settings('invoice_start_from') : 0; //1000

    // $order = Order::latest()->first();
    $order = Order::orderBy('id', 'desc')->first();

    if ($order) {
        return $invoice_prefix ? ($invoice_prefix . '-' . ($order->id + 1) + abs($invoice_start_from)) : ($order->id + 1 + abs($invoice_start_from));
    }

    return $invoice_prefix ? ($invoice_prefix . '-' . abs($invoice_start_from) + 1) : (abs($invoice_start_from) + 1);
}

function generateReturnInvoiceId()
{
    $invoice_prefix = settings('return_invoice_prefix') ? settings('return_invoice_prefix') : '';
    $invoice_start_from = settings('return_invoice_start_from') ? settings('return_invoice_start_from') : 0; //1000

    // $order = Order::latest()->first();
    $orderReturn = OrderReturn::orderBy('id', 'desc')->first();

    if ($orderReturn) {
        return $invoice_prefix ? ($invoice_prefix . '-' . ($orderReturn->id + 1) + abs($invoice_start_from)) : ($orderReturn->id + 1 + abs($invoice_start_from));
    }

    return $invoice_prefix ? ($invoice_prefix . '-' . abs($invoice_start_from) + 1) : (abs($invoice_start_from) + 1);
}

function authId()
{
    return auth()->id();
}

function authUser()
{
    return auth()->user();
}

function getCompanyAddress()
{
    $fullAddress = '';

    if(settings('address') && settings('address') != '') {
        $fullAddress .= settings('address') . ',';
    }

    if(settings('state') && settings('state') != '') {
        $fullAddress .= settings('state') . ', ';
    }

    if(settings('city') && settings('city') != '') {
        $fullAddress .= settings('city') . ', ';
    }

    if(settings('country') && settings('country') != '') {
        $fullAddress .= settings('country') . ', ';
    }

    if(settings('zip_code') && settings('zip_code') != '') {
        $fullAddress .= settings('zip_code') . '.';
    }

    return $fullAddress != '' ? $fullAddress : 'Dhaka, Bangladesh';
}

function numberToWord($number = 0)
{
    return ucwords(SpellNumber::value($number)->toLetters());
}

function generateUniqueSlug($title, $model, $id = null, $column = 'slug', $separator = '-')
{
    $slug = Str::slug($title, $separator);
    $query = $model::where($column, 'like', '%' . $slug . '%');

    if($id) {
        $query->where('id', '!=', $id);
    }

    $count = $query->count();

    return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
}


function attachmentStore($file, $model, $path = null, $attachment_for = null, $w = null, $h = null)
{
    $file_path = storeFile($file, $path, $w, $h);

    $attachment = new Attachment();
    $attachment->attachment = $file_path;
    $attachment->mime_type = 'webp'; // $file->getClientOriginalExtension();
    $attachment->for = $attachment_for;

    return $model->attachments()->save($attachment);
}


function attachmentCloneStore($attachment, $model)
{
    $attach = new Attachment();
    $attach->attachment = $attachment->attachment;
    $attach->attachable_type = $attachment->attachable_type;
    $attach->attachable_id = $model->id;
    $attach->mime_type = $attachment->mime_type;
    $attach->for = $attachment->for;

    return $model->attachments()->save($attach);
}

function storeFile($file, $path, $w = null, $h = null)
{
    $file_extension = $file->getClientOriginalExtension();

    if ($file_extension == 'pdf' || $file_extension == 'svg') {
        return Helper::uploadFile($file, $path);
    }

    return Helper::uploadImage($file, $path, $w, $h);
}


function has_key($array, $in_array)
{
    foreach ($array as $key => $value) {
        if ($in_array->has($value)) :
            return true;
        endif;
    }

    return false;
}

function languageStore($title, $model, $local = Enum::LANGUAGE_TYPE_ENGLISH, $meta_title = null, $meta_description = null)
{
    $common_lan = new CommonLanguage();
    $common_lan->title = $title;
    $common_lan->meta_title = $meta_title;
    $common_lan->meta_description = $meta_description;
    $common_lan->local = $local;

    return $model->languages()->save($common_lan);
}

function languageUpdate(array $data, $model, $local = Enum::LANGUAGE_TYPE_ENGLISH, $meta_title = null, $meta_description = null)
{
    return $model->languages->where('local', $local)->first()->update($data);
}

function getVariant(array $data)
{
    $variant = '';

    foreach($data as $key => $attribute) {
        if($key == 0) {
            $variant .= $attribute['value'];
        } else {
            $variant .= ('-' . $attribute['value']);
        }
    }

    return $variant;
}

function getPercentageRatting(int $totalRatting, int $rating)
{
    if($rating > 0 && $totalRatting > 0) {
        return ((float)$rating / (float)$totalRatting) * 100 ;
    } else {
        return 0;
    }
}

// Get the seller id.
function sellerId()
{
    return 2;
}

// Get the seller based on the user type.
function authSeller()
{
    $user = auth()->user();

    if ($user->user_type === 'seller') {
        return $user;
    } elseif ($user->user_type === 'moderator' && $user->parent_id !== null) {
        return User::where('id', $user->parent_id)->first();
    }

    return null;
}

// Get the seller ID based on the user type.
function authSellerId()
{
    $user = auth()->user();

    if ($user->user_type === 'seller') {
        return $user->id;
    } elseif ($user->user_type === 'moderator' && $user->parent_id !== null) {
        return $user->parent_id;
    }

    return null;
}

function getOrderStatus($status)
{
    $statusClasses = [
        Enum::ORDER_STATUS_TYPE_PENDING => 'bg-warning',
        Enum::ORDER_STATUS_TYPE_CANCELED => 'bg-danger',
        Enum::ORDER_STATUS_TYPE_PROCESSING => 'bg-primary',
        Enum::ORDER_STATUS_TYPE_SHIPPED => 'bg-success',
        Enum::ORDER_STATUS_TYPE_DELIVERED => 'bg-success',
        Enum::ORDER_STATUS_TYPE_NOT_RECEIVED => 'bg-danger',
        Enum::ORDER_STATUS_TYPE_RETURNED => 'bg-danger',
        Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED => 'bg-danger',
    ];

    $class = $statusClasses[$status] ?? 'bg-warning';

    return '<div class="badge ' . $class . '" style="color: #fff;">' . Enum::getOrderStatusType($status) . '</div>';
}

function getOrderPaymentStatus($status)
{
    $statusClasses = [
        Enum::ORDER_PAYMENT_STATUS_UNPAID => 'bg-danger',
        Enum::ORDER_PAYMENT_STATUS_PARTIAL => 'bg-warning',
        Enum::ORDER_PAYMENT_STATUS_PAID => 'bg-success',
        Enum::ORDER_PAYMENT_STATUS_REFUNDED => 'bg-secondary',
    ];

    $class = $statusClasses[$status] ?? 'bg-warning';

    return '<div class="badge ' . $class . '" style="color: #fff;">' . Enum::getPaymentStatusType($status) . '</div>';
}

function getProductApprovedStatus($status)
{
    if (!$status) {
        return '<div class="badge bg-warning" style="color: #fff;">Unapproved</div>';
    }

    return '<div class="badge bg-success" style="color: #fff;">Approved</div>';
}

function getProductVariantValue($variant)
{
    $attributes = '';
    $variantArray = explode('-', $variant);

    foreach ($variantArray as $key => $value) {
        if (empty($value)) {
            continue;
        }

        if ($key == 0) {
            $attributes .= 'Color Family: ' . Color::find($value)?->name;
            continue;
        }

        $attributeValue = AttributeValue::find($value);

        $attributes .= ', ' . $attributeValue?->attribute?->name . ': ' . $attributeValue?->value;
    }

    return $attributes;
}

function getUnitPrice($product)
{
    if (! $product->has_variant) {
        return $product->unit_price;
    }

    return $product->load('variants')->variants->first()?->unit_price;
}

function parentCategory($categoryId)
{
    $category = Category::find($categoryId);

    // Traverse up to the root category if necessary
    while ($category && $category->parent) {
        $category = $category->parent;
    }

    return $category;
}

function childCategories($categoryId)
{
    $category = Category::find($categoryId);

    $children = $category->childrenCategories;

    $allChildIds = collect($children->pluck('id'))->merge(collect([$category->id]));

    foreach ($children as $child) {
        $allChildIds = $allChildIds->merge($child->load('childrenCategories')->childrenCategories->pluck('id'));
    }

    return $allChildIds->toArray();
}

function setDefaultColor()
{
    $colors = [
        'btn_primary' => '#4ACE8B',
        'btn_primary_text' => '#ffffff',
        'btn_primary_hover' => '#0dbb62',
        'btn_primary_text_hover' => '#ffffff',
        'text_heading' => '#005C2D',
        'general_text' => '#000000',
        'tab_color' => '#ebfff1',
        'bg_color' => '#F5F7FF',
        'card_heading' => '#4ACE8B',
        'card_bg' => '#ffffff',
        'card_heading_text' => '#ffffff',
        'table_heading' => '#ebfff1',
        'table_heading_text' => '#005C2D',
        'table_btn' => '#f0f9f3',
        'table_btn_hover' => '#C1FCD3',
    ];

    return $colors;
}

function setFrontendDefaultColor()
{
    $colors = [
        'primary_color' => '#f2128e',
        'secondary_color' => '#f2128e',
        'accent_color' => '#f77016',
        'background_color' => '#fdedf5',
        'breadcrumb_bg_color' => '#fdc9e3',
        'footer_color' => '#fdedf5',
        'general_color' => '#ffe0f0',
        'heading_text' => '#000000',
        'secondary_text' => '#000000',
        'card_color' => '#fb60b5',
        'card_hover_color' => '#e5de94',
    ];

    return $colors;
}