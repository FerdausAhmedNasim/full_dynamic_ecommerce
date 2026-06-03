<?php

namespace Database\Factories;

use App\Models\User;
use App\Library\Enum;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->sentence($this->faker->numberBetween(5, 20));
        $seller = User::where('user_type', Enum::USER_TYPE_SELLER)->get()->random(1)->first();
        $category = Category::with('languages')->with('childrenCategories.childrenCategories')->get()->random(1)->first();

        return [
            'slug' => Str::slug($name),
            'category_id' => $category->id,
            'brand_id' => Brand::get()->random(1)->first()->id,
            'operator_id' => 1,
            'weight' => $this->faker->randomFloat(1, 0, 10),
            'unit' => 'kg',
            'seller_id' => $seller->id,
            'current_stock' => $this->faker->numberBetween(10, 100),
            'rating' => $this->faker->numberBetween(1, 5),
            'unit_price' => $this->faker->numberBetween(100, 5000),
            'minimum_order_quantity' => $this->faker->numberBetween(1, 10),
            'status' => Enum::PRODUCT_STATUS_PUBLISHED,
            'approved' => true,
            'featured' => true,
            // 'show_home_page' => $seller->id % 4 ? true : false,
            'cash_on_delivery' => true
        ];
    }
}
