<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Order;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('productDetails')->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = auth()->user()->orders()->create([
            'status' => Order::STATUS['pending'],
        ]);

        foreach ($request->products as $product) {
            $quantity = $product['quantity'];
            $productDetail = ProductDetail::filterByProductIdAndColor($product['product_id'], $product['color'])->first();

            $order->productDetails()->attach($productDetail->id, [
                'quantity' => $quantity,
                'paid_price' => Order::calculateProductPaidPrice($productDetail, $quantity),
            ]);

            $productDetail->decrement('quantity', $quantity);
        }

        $order->load('productDetails');

        return response()->json(['order' => new OrderResource($order)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('productDetails');

        return new OrderResource($order);
    }
}