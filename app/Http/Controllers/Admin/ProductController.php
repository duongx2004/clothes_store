<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
    // Hiển thị form import
    public function importForm(Request $request)
    {
        if ($request->get('download') == 'sample') {
            // Tạo file mẫu
            $headers = ['name', 'slug', 'description', 'price', 'sale_price', 'discount_percent', 'stock', 'category', 'brand', 'image_url'];
            $sample = [
                ['Áo thun nam', 'ao-thun-nam', 'Chất liệu cotton thoáng mát', 199000, 150000, '', 50, 'Áo thun', 'ThugShaker', 'https://example.com/ao-thun.jpg'],
                ['Quần jean', 'quan-jean', 'Quần jean rách gối', 350000, '', 10, 20, 'Quần', 'Nike', '']
            ];
            $callback = function() use ($headers, $sample) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, $headers);
                foreach ($sample as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            };
            return response()->stream($callback, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="product_sample.csv"'
            ]);
        }
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle); // đọc dòng tiêu đề

        // Map các cột cần thiết
        $requiredColumns = ['name', 'price', 'stock', 'category'];
        $columnMap = [];
        foreach ($requiredColumns as $col) {
            $index = array_search($col, $headers);
            if ($index === false) {
                return redirect()->back()->with('error', "File CSV thiếu cột bắt buộc: $col");
            }
            $columnMap[$col] = $index;
        }
        // Các cột tuỳ chọn
        $optionalCols = ['slug', 'description', 'sale_price', 'discount_percent', 'brand', 'image_url'];
        foreach ($optionalCols as $col) {
            $idx = array_search($col, $headers);
            $columnMap[$col] = $idx !== false ? $idx : null;
        }

        $imported = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = [];
            // Lấy dữ liệu theo map
            foreach ($columnMap as $key => $idx) {
                if ($idx !== null && isset($row[$idx])) {
                    $data[$key] = trim($row[$idx]);
                } else {
                    $data[$key] = null;
                }
            }

            // Validate cơ bản
            if (empty($data['name']) || empty($data['price']) || !is_numeric($data['price']) || empty($data['stock']) || !is_numeric($data['stock']) || empty($data['category'])) {
                $errors[] = "Bỏ qua dòng: thiếu thông tin bắt buộc (name, price, stock, category) - " . json_encode($data);
                continue;
            }

            // Xử lý danh mục
            $category = Category::firstOrCreate(
                ['name' => $data['category']],
                ['slug' => Str::slug($data['category'])]
            );

            // Xử lý thương hiệu (nếu có)
            $brandId = null;
            if (!empty($data['brand'])) {
                $brand = Brand::firstOrCreate(
                    ['name' => $data['brand']],
                    ['slug' => Str::slug($data['brand'])]
                );
                $brandId = $brand->id;
            }

            // Chuẩn bị slug
            $slug = !empty($data['slug']) ? $data['slug'] : Str::slug($data['name']);
            // Đảm bảo slug unique
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            // Xử lý ảnh: nếu có URL, tải về và lưu vào public/images/products
            $imageName = null;
            if (!empty($data['image_url']) && filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
                try {
                    $imageContents = file_get_contents($data['image_url']);
                    if ($imageContents !== false) {
                        $ext = pathinfo(parse_url($data['image_url'], PHP_URL_PATH), PATHINFO_EXTENSION);
                        $ext = $ext ?: 'jpg';
                        $imageName = time() . '_' . uniqid() . '.' . $ext;
                        $savePath = public_path('images/products/' . $imageName);
                        file_put_contents($savePath, $imageContents);
                    }
                } catch (\Exception $e) {
                    $errors[] = "Không thể tải ảnh cho sản phẩm {$data['name']}: " . $e->getMessage();
                }
            }

            // Tạo sản phẩm
            try {
                Product::create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'] ?? null,
                    'price' => $data['price'],
                    'sale_price' => !empty($data['sale_price']) ? $data['sale_price'] : null,
                    'discount_percent' => !empty($data['discount_percent']) ? $data['discount_percent'] : null,
                    'stock' => $data['stock'],
                    'image' => $imageName,
                    'category_id' => $category->id,
                    'brand_id' => $brandId,
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Lỗi khi thêm sản phẩm {$data['name']}: " . $e->getMessage();
            }
        }

        fclose($handle);

        $message = "Import thành công $imported sản phẩm.";
        if (!empty($errors)) {
            $message .= ' Có ' . count($errors) . ' lỗi. Chi tiết: ' . implode('; ', array_slice($errors, 0, 10));
        }
        return redirect()->route('admin.products.index')->with('success', $message);
    }
}