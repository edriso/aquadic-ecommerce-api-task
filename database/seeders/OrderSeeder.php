<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productDetail = ProductDetail::factory()->create();
        $order = Order::factory()->create();
        OrderItem::factory(3)->create([
            'order_id' => $order->id,
            'product_detail_id' => $productDetail->id,
        ]);

        OrderItem::factory(10)->create();
    }
}