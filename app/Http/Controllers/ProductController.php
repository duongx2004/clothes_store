<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('name', $request->brand);
            });
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Search by product name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $allowedSorts = ['name', 'price', 'brand_name', 'category_name'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy == 'brand_name') {
                $query->join('brands', 'products.brand_id', '=', 'brands.id')
                      ->orderBy('brands.name', $sortOrder)
                      ->select('products.*');
            } elseif ($sortBy == 'category_name') {
                $query->join('categories', 'products.category_id', '=', 'categories.id')
                      ->orderBy('categories.name', $sortOrder)
                      ->select('products.*');
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(9)->appends($request->query());

        // Get distinct brands and categories for filter dropdowns
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('client.products.index', compact('products', 'brands', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // Lấy 4 sản phẩm cùng danh mục, không bao gồm sản phẩm hiện tại
        $relatedProducts = Product::with(['brand', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        return view('client.products.show', compact('product', 'relatedProducts'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'slug', 'category_id']);
        return response()->json($products);
    }
}