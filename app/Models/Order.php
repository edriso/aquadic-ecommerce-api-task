<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    const STATUS = [
        'pending' => 'pending',
        'processing' => 'processing',
        'completed' => 'completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productDetails()
    {
        return $this->belongsToMany(ProductDetail::class, 'order_items')
            ->withPivot('quantity', 'paid_price')
            ->withTimestamps();
    }

    public static function calculateProductPaidPrice($productDetail, $quantity)
    {
        $discountedPrice = $productDetail->price - ($productDetail->discount_percentage / 100 * $productDetail->price);

        return round($discountedPrice * $quantity, 2);
    }
}
