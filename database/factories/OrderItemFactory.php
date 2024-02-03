<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_detail_id' => ProductDetail::factory(),
            'quantity' => $this->faker->randomNumber(1, true),
            'paid_price' => $this->faker->randomFloat(2, 10, 50),
        ];
    }
}