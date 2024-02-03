<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetail>
 */
class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->randomNumber(2),
            'color' => $this->faker->unique()->colorName(),
            'discount_percentage' => $this->faker->randomFloat(2, 0, 20),
        ];
    }
}