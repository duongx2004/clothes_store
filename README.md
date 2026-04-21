# 👕 AllainStore - Website bán quần áo trực tuyến (Laravel)

AllainStore là một website thương mại điện tử bán quần áo được xây dựng bằng **Laravel** (PHP framework) theo mô hình MVC, sử dụng **Eloquent ORM**, **Blade Template Engine**, **Bootstrap 5**, và hỗ trợ đầy đủ chức năng cho cả khách hàng (client) và quản trị viên (admin).

## ✨ Tính năng chính

### 👤 Dành cho khách hàng (Client)
- Đăng ký / Đăng nhập / Đăng xuất (Laravel Breeze)
- Quên mật khẩu – gửi link reset qua email
- **Trang chủ** riêng: banner, sản phẩm nổi bật, giới thiệu dịch vụ
- Xem danh sách sản phẩm với phân trang (9 sản phẩm/trang)
- Tìm kiếm sản phẩm theo tên (có gợi ý AJAX)
- Lọc sản phẩm theo: danh mục, thương hiệu, khoảng giá
- Sắp xếp sản phẩm: theo tên, giá, thương hiệu, danh mục (tăng/giảm)
- Xem chi tiết sản phẩm (ảnh phóng to, thông tin, sản phẩm cùng loại)
- Thêm sản phẩm vào giỏ hàng (dùng session)
- Xem giỏ hàng, xóa sản phẩm
- Thanh toán (yêu cầu đăng nhập) – tạo đơn hàng, lưu địa chỉ giao hàng
- Xem lịch sử đơn hàng
- **Quản lý thông tin cá nhân**: cập nhật họ tên, email, số điện thoại, địa chỉ
- **Đổi mật khẩu** (yêu cầu nhập mật khẩu cũ)

### 🔧 Dành cho quản trị viên (Admin)
- **Dashboard riêng** (giao diện tách biệt với client)
- Quản lý sản phẩm (CRUD): thêm, sửa, xóa, upload ảnh
- Quản lý đơn hàng: xem danh sách, cập nhật trạng thái (pending, processing, completed, cancelled)
- Phân quyền dựa trên middleware `admin` và cột `role` trong bảng `users`

### 🛠 Kỹ thuật sử dụng
- Laravel 10
- MySQL
- Eloquent ORM (quan hệ: User – Order – OrderItem – Product – Category – Brand)
- Blade template (kế thừa layout, partials header/footer)
- Bootstrap 5 (giao diện responsive)
- Session (giỏ hàng)
- Pagination (tự động, hỗ trợ query string)
- File upload (ảnh sản phẩm lưu vào `public/images/products`)
- AJAX (tìm kiếm gợi ý)
- Laravel Breeze (xác thực, quên mật khẩu)

## 📁 Cấu trúc thư mục quan trọng

```bash
clothes_store/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php (tuỳ chọn)
│   │   │   │   ├── OrderController.php
│   │   │   │   └── ProductController.php
│   │   │   ├── Auth/                      (Breeze)
│   │   │   ├── CartController.php
│   │   │   ├── ChangePasswordController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProductController.php      (client)
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Brand.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── OrderItem.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   └── images/
│       ├── logo/
│       │   └── allainstore.jpg
│       └── products/
│           └── (các file ảnh sản phẩm)
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Layout chính cho client
│       ├── partials/
│       │   ├── header.blade.php
│       │   └── footer.blade.php
│       ├── client/
│       │   ├── home.blade.php              # Trang chủ
│       │   ├── products/
│       │   │   ├── index.blade.php         # Danh sách sản phẩm
│       │   │   └── show.blade.php          # Chi tiết sản phẩm
│       │   ├── cart/
│       │   │   └── index.blade.php
│       │   ├── orders.blade.php
│       │   ├── profile.blade.php
│       │   ├── contact.blade.php
│       │   └── about.blade.php
│       ├── auth/                           # Các view auth (Breeze)
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── reset-password.blade.php
│       │   └── change-password.blade.php   # Đổi mật khẩu
│       └── admin/
│           ├── layouts/
│           │   └── app.blade.php           # Layout riêng cho admin
│           ├── dashboard.blade.php
│           ├── orders/
│           │   ├── index.blade.php
│           │   └── edit.blade.php
│           └── products/
│               ├── index.blade.php
│               ├── create.blade.php
│               └── edit.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
└── .env
```
## 🚀 Cài đặt và chạy dự án

### Yêu cầu
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (để build Breeze assets)

### Các bước

1. **Clone repository** (hoặc tạo mới từ source code)
   ```bash
   git clone https://github.com/duongx2004/clothes_store
   cd clothes_store
   
2. **Cài đặt dependencies PHP**
   ```bash
   composer install

3. **Cài đặt Breeze & frontend assets**
   ```bash
   php artisan breeze:install blade
   npm install && npm run build
   
4. **Tạo file .env và cấu hình database**
   ```bash
   cp .env.example .env
   ```
   Sửa các thông số trong .env:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=clothes_store
   DB_USERNAME=root
   DB_PASSWORD=

   MAIL_MAILER=log  # hoặc cấu hình SMTP thật.
   
5. **Tạo key**
   ```bash
   php artisan key:generate

6. **Chạy migration và seeder**
   ```bash
   php artisan migrate --seed

7. **Chạy server**
   ```bash
   php artisan serve
   
8. **Chạy server**
   http://127.0.0.1:8000

🔐 Tài khoản mặc định (sau khi seed)

Admin:
```bash
admin@example.com
```
```bash
123456
```
Customer:
```bash
user@example.com
```
```bash
123456
```
🧪 Hướng dẫn sử dụng
Khách hàng

Đăng ký tài khoản mới hoặc đăng nhập bằng tài khoản customer.

Trang chủ hiển thị banner, sản phẩm nổi bật.

Duyệt sản phẩm tại trang Products.

Sử dụng thanh tìm kiếm, bộ lọc (theo danh mục, thương hiệu, giá) và sắp xếp.

Click vào sản phẩm để xem chi tiết, thêm vào giỏ hàng.

Vào Cart để xem giỏ hàng, xóa sản phẩm.

Nhập địa chỉ giao hàng và click Thanh toán (bắt buộc đăng nhập).

Xem lịch sử đơn hàng tại Đơn hàng của tôi.

Cập nhật thông tin cá nhân và đổi mật khẩu trong dropdown tên người dùng.

Quản trị viên
Đăng nhập bằng tài khoản admin (tự động chuyển đến /admin/dashboard).

Giao diện admin riêng biệt, có sidebar menu.

Quản lý sản phẩm: thêm mới, sửa, xóa sản phẩm (upload ảnh).

Quản lý đơn hàng: xem danh sách, sửa trạng thái đơn hàng.

🖼 Ảnh sản phẩm
Tất cả ảnh sản phẩm được lưu trong public/images/products/.

Tên file ảnh được lưu trong cột image của bảng products.

Hiển thị trong view dùng asset('images/products/'.$product->image).

Hỗ trợ upload ảnh khi thêm/sửa sản phẩm (Admin).

📦 Các package chính
laravel/breeze – Authentication scaffolding

bootstrap – UI framework

mysql – Database

📝 Ghi chú
Giỏ hàng sử dụng session, không lưu database (dành cho khách chưa đăng nhập).

Khi thanh toán, nếu chưa đăng nhập sẽ chuyển hướng đến trang login.

Phân quyền admin dựa trên cột role trong bảng users (enum: admin, customer).

Middleware admin kiểm tra auth()->user()->role === 'admin'.

Giao diện admin nằm riêng trong thư mục views/admin, sử dụng layout riêng.

🐛 Xử lý lỗi thường gặp
Lỗi Class "Brand" not found: thêm use App\Models\Brand; vào controller hoặc seeder.

Lỗi 404 sau login: sửa redirect trong AuthenticatedSessionController hoặc RouteServiceProvider.

Ảnh không hiển thị: kiểm tra đường dẫn trong public/images/products/ và tên file trong database.

Lỗi middleware admin không hoạt động: đăng ký trong app/Http/Kernel.php (Laravel 10) hoặc bootstrap/app.php (Laravel 11).

Lỗi create() argument count: đảm bảo method create() trong RegisteredUserController không có tham số.

📝 Phân công việc:

Lê Nho Dương: Xây dựng các trang Auth, Admin và các chức năng cần thiết của trang

Hà Quang Nhuận: Xây dựng trang chủ chính và các Controller liên quan

Mai Đức Long: Xây dựng trang Cart và các Controller liên quan

Đăng Văn Minh: Xây dựng trang Product và các Controller liên quan
