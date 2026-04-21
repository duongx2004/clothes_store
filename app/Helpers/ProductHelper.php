<?php

namespace App\Helpers;

use App\Models\Product;

class ProductHelper
{
    public static function getDisplayPrice(Product $product)
    {
        if ($product->sale_price) {
            return [
                'original' => $product->price,
                'sale' => $product->sale_price,
                'percent' => round((1 - $product->sale_price / $product->price) * 100)
            ];
        } elseif ($product->discount_percent) {
            $salePrice = $product->price * (1 - $product->discount_percent / 100);
            return [
                'original' => $product->price,
                'sale' => $salePrice,
                'percent' => $product->discount_percent
            ];
        }
        return [
            'original' => $product->price,
            'sale' => null,
            'percent' => 0
        ];
    }
}