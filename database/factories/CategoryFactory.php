<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->company;
        $slug = Str::slug($name);

        return [
            'slug' => $slug,
            'order' => $this->faker->numberBetween(1, 30),
            'active' => 1,
            'featured' => 1,
            'operator_id' => 1,
        ];
    }
}
