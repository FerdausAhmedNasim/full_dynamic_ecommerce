<?php

namespace App\Rules;

use App\Models\CourierPricingPlan;
use Illuminate\Contracts\Validation\Rule;

class UniqueDeliveryRoute implements Rule
{
    private $pickup_location;
    private $delivery_location;
    private $min_weight;
    private $max_weight;
    private $id;

    public function __construct($pickup_location, $delivery_location, $min_weight, $max_weight, $id = null)
    {
        $this->pickup_location = $pickup_location;
        $this->delivery_location = $delivery_location;
        $this->min_weight = $min_weight;
        $this->max_weight = $max_weight;
        $this->id = $id;
    }

    public function passes($attribute, $value)
    {
        $query = CourierPricingPlan::where('pickup_location', $this->pickup_location)
            ->where('delivery_location', $this->delivery_location)
            ->where('min_weight', $this->min_weight)
            ->where('max_weight', $this->max_weight);

        if ($this->id) {
            $query->where('id', '!=', $this->id);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'This delivery route already exists.';
    }
}