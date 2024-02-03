<?php

namespace App\Http\Requests;

use App\Models\ProductDetail;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => [
                'required',
                'array',
            ],
            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'products.*.color' => [
                'required',
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $productIdKey = explode('.', $attribute)[1];
                    $productColor = $this->input("products.$productIdKey.color");
                    $productId = $this->input("products.$productIdKey.product_id");
                    $productDetail = ProductDetail::filterByProductIdAndColor($productId, $productColor)->first();

                    if ($productColor && !$productDetail) {
                        $fail("The product ID $productId with color $productColor not found.");
                    }

                    $maxQuantity = $productDetail?->quantity;

                    if (!$maxQuantity) {
                        $fail("The product ID $productId is currently out of stock.");
                    } else if ($value > $maxQuantity) {
                        $fail("The quantity for product ID $productId cannot exceed $maxQuantity.");
                    }
                }
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'products.*.product_id' => 'product ID',
            'products.*.color' => 'product color',
            'products.*.quantity' => 'product quantity',
        ];
    }
}