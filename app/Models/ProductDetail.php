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
}