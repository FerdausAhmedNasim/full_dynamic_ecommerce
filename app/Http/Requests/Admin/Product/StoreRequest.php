<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Product Table Data
            'category_id'            => ['required', 'integer'],
            'brand_id'               => ['nullable', 'integer'],
            'unit'                   => ['nullable', 'string', 'max:255'],
            'unit_price'             => ['nullable', 'numeric'],
            'purchase_price'         => ['nullable', 'numeric'],
            'weight'                 => ['required', 'numeric'],
            'barcode'                => ['nullable', 'string', 'max:255'],
            'has_variant'            => ['nullable', 'boolean'],
            'minimum_order_quantity' => ['nullable', 'numeric', 'min:1'],
            'stock_notification'     => ['nullable', 'numeric'],
            'low_stock_to_notify'    => ['nullable', 'numeric', 'min:0'],
            'stock_visibility'       => ['nullable', 'string', 'max:255'],
            'featured'               => ['nullable', 'boolean'],
            'refundable'             => ['nullable', 'boolean'],
            'show_home_page'         => ['nullable', 'boolean'],
            'has_discount'           => ['nullable', 'boolean'],
            // 'cash_on_delivery'       => ['nullable', 'boolean'],

            // Product Language
            'title'             => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description'       => ['nullable', 'string'],
            'shipping_note'     => ['nullable', 'string'],
            'meta_title'        => ['nullable', 'string'],
            'meta_description'  => ['nullable', 'string'],
            'meta_keywords.*'   => ['nullable'],
            'tags.*'            => ['nullable'],

            // Product Stock
            'sku'           => ['nullable', 'required_without:has_variant', 'string', 'max:255', 'unique:product_stocks,sku'],
            'current_stock' => ['nullable', 'required_without:has_variant', 'numeric'],

            // Product Variant
            'colors.*'             => ['nullable'],
            'attribute_sets.*'     => ['nullable'],
            'variant_name.*'       => ['nullable'],
            'variant_ids.*'        => ['nullable'],
            'variant_price.*'      => ['nullable'],
            'variant_sku.*'        => ['nullable', 'required_if:has_variant,1|distinct|unique:product_stocks,sku'],
            'variant_stock.*'      => ['nullable'],

            // Product Details
            // 'shipping_type'                   => ['required', 'string', 'max:255'],
            // 'shipping_fee'                    => ['nullable', 'required_if:shipping_type,flat_rate', 'numeric'],
            // 'shipping_fee_depend_on_quantity' => ['nullable', 'boolean'],
            // 'shipping_fee_depend_on_weight'   => ['nullable', 'boolean'],
            'estimated_shipping_days'         => ['required', 'string'],
            'discount_type'                   => ['nullable', 'required_with:has_discount', 'string', 'max:255'],
            'discount'                        => ['nullable', 'required_with:has_discount', 'string', 'max:255'],
            'discount_start'                  => ['nullable', 'required_with:has_discount', 'date_format:Y-m-d H:i:s', 'before:discount_end'],
            'discount_end'                    => ['nullable', 'required_with:has_discount', 'date_format:Y-m-d H:i:s', 'after:discount_start'],
            'discount_period'                 => ['nullable'],

            // Image/Media/Attachment
            'product_thumbnail'   => ['required', 'file', 'max:512', 'mimes:png,jpg,jpeg,webp,gif', 'dimensions:width=750, height=750'],
            'images.*'            => ['nullable', 'file', 'max:512', 'mimes:png,jpg,jpeg,webp,gif', 'dimensions:width=750, height=750'],
            'variant_image.*'     => ['nullable', 'file', 'max:512', 'mimes:png,jpg,jpeg,webp,gif', 'dimensions:min_width=750, min_height=750'],
            'description_image'   => ['nullable', 'file', 'max:512', 'mimes:png,jpg,jpeg,webp,gif',],
            'meta_image'          => ['nullable', 'file', 'max:512', 'mimes:png,jpg,jpeg,webp,gif',],

            // Product Service
            'product_service_title.*'     => ['required'],
            'product_service_sub_title.*' => ['required'],
            'product_service_order.*'     => ['required'],

            // Product Service
            'length'  => ['nullable',],
            'width'   => ['nullable',],
            'height'  => ['nullable',],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Product name is required',
        ];
    }
}
