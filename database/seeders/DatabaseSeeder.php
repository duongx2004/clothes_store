<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Customer',
            'email' => 'user@example.com',
            'password' => bcrypt('123456'),
            'role' => 'customer',
        ]);

        $category = Category::create(['name' => 'Áo thun', 'slug' => 'ao-thun']);
        $brand = Brand::create(['name' => 'ThugShaker', 'slug' => 'ThugShaker']);

        Product::create([
            'name' => 'Áo My NIGGA',
            'slug' => 'my-nigga',
            'description' => 'Chất liệu cotton cao cấp, thoáng mát',
            'price' => 150000,
            'stock' => 10,
            'image' => 'my-nigga.jpg',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);
    }
}