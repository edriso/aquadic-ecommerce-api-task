<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'quantity',
        'color',
        'discount_percentage',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'paid_price')
            ->withTimestamps();
    }

    public function scopeFilterByProductIdAndColor($query, $productId, $color)
    {
        return $query->where('product_id', $productId)->where('color', $color);
    }
}