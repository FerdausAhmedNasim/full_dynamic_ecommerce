<?php

namespace App\Http\Requests\Admin\CourierPricingPlan;

use App\Rules\UniqueDeliveryRoute;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maxAllowedWeight = settings('extra_charge_after_weight');

        return [
            'pickup_location'   => ['required', 'string', 'max:255'],
            'delivery_location' => ['required', 'string', 'max:255'],
            'min_weight'        => ['required', 'numeric', 'lt:max_weight', 'max:' . $maxAllowedWeight],
            'max_weight'        => ['required', 'numeric', 'gt:min_weight', 'max:' . $maxAllowedWeight],
            'price'             => ['required', 'numeric'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('courierPricingPlan');

            $uniqueRule = new UniqueDeliveryRoute(
                $this->pickup_location,
                $this->delivery_location,
                $this->min_weight,
                $this->max_weight,
                $id->id
            );

            if (!$uniqueRule->passes(null, null)) {
                session()->flash('error', $uniqueRule->message());
                $validator->errors()->add('unique_route', $uniqueRule->message());
            }
        });
    }

    public function messages()
    {
        return [
            'unique_route'   => 'This delivery route already exists.',
            'min_weight.lt'  => 'The minimum weight must be less than the maximum weight.',
            'max_weight.gt'  => 'The maximum weight must be greater than the minimum weight.',
            'min_weight.max' => 'The minimum weight must not exceed :max.',
            'max_weight.max' => 'The maximum weight must not exceed :max.',
        ];
    }
}