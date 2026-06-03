<?php

namespace App\Http\Requests\Admin\Advertise;

use App\Library\Enum;
use App\Models\AdvertiseLocation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $location = AdvertiseLocation::where('id', (int) $this->advertise_location_id)->first();
        $adLocation = true;

        if ($location?->location == Enum::AD_LOCATION_FLASH_SALE || $location?->location == Enum::AD_LOCATION_TOP_SALE) {
            $adLocation = false;
        }

        $linkRule = $adLocation ? 'required' : 'nullable';
        $productIdsRule = !$adLocation ? 'required' : 'nullable';

        return [
            'advertise_location_id' => ['required'],
            'image' => [
                'nullable',
                'file',
                'max:512',
                'mimes:png,jpg,jpeg,gif',
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
