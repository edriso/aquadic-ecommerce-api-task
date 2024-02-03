<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_detail_id' => $this->id,
            'product' => new ProductResource($this->product),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'discount_percentage' => $this->discount_percentage,
        ];
    }
}
