<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sale_price', 'discount_percent',
        'stock', 'image', 'category_id', 'brand_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand() 
    { 
        return $this->belongsTo(Brand::class); 
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}