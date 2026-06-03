<?php

namespace App\Http\Requests\Seller\Advertise;

use App\Library\Enum;
use App\Models\AdvertiseLocation;
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
        $adLocation = AdvertiseLocation::where('location', Enum::AD_LOCATION_FLASH_SALE)->value('id');
        $requestLocation = (int) $this->advertise_location_id;

        $imageRule = $requestLocation !== $adLocation ? 'required' : 'nullable';
        $linkRule = $requestLocation !== $adLocation ? 'required' : 'nullable';
        $productIdsRule = $requestLocation === $adLocation ? 'required' : 'nullable';

        return [
            'advertise_location_id' => ['required'],
            'image' => [
                $imageRule,
                'file',
                'max:512',
                'mimes:png,jpg,jpeg,gif,webp',
                'dimensions:min_width=800, min_height=350',
            ],
            'link' => [
                $linkRule,
            ],
            'product_ids' => [
                $productIdsRule,
            ],
            'start_date'    => ['required'],
            'end_date'    => ['required'],
        ];
    }
}
