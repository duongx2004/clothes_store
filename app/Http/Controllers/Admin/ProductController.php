<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = $filename;
        }

        // Xử lý giá khuyến mãi
        if ($request->filled('sale_price')) {
            $data['discount_percent'] = null;
        } elseif ($request->filled('discount_percent')) {
            $data['sale_price'] = null;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = $filename;
        }

        // Xử lý giá khuyến mãi
        if ($request->filled('sale_price')) {
            $data['discount_percent'] = null;
        } elseif ($request->filled('discount_percent')) {
            $data['sale_price'] = null;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Kiểm tra xem sản phẩm có đơn hàng liên kết không
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Không thể xóa sản phẩm này vì nó có liên kết với các đơn hàng. Vui lòng kiểm tra lại đơn hàng trước khi xóa.');
        }
        
        // Kiểm tra xem sản phẩm có trong giỏ hàng của user không
        if ($product->cartItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Không thể xóa sản phẩm này vì nó hiện đang trong giỏ hàng của người dùng. Vui lòng thử lại sau.');
        }
        
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}