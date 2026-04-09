# 👕 AllainStore - Website bán quần áo trực tuyến (Laravel)

AllainStore là một website thương mại điện tử bán quần áo được xây dựng bằng **Laravel** (PHP framework) theo mô hình MVC, sử dụng **Eloquent ORM**, **Blade Template Engine**, **Bootstrap 5**, và hỗ trợ đầy đủ chức năng cho cả khách hàng (client) và quản trị viên (admin).

## ✨ Tính năng chính

### 👤 Dành cho khách hàng (Client)
- Đăng ký / Đăng nhập / Đăng xuất (Laravel Breeze)
- Quên mật khẩu – gửi link reset qua email
- Xem danh sách sản phẩm với phân trang (9 sản phẩm/trang)
- Tìm kiếm sản phẩm theo tên (có gợi ý AJAX)
- Lọc sản phẩm theo: danh mục, thương hiệu, khoảng giá
- Sắp xếp sản phẩm: theo tên, giá, thương hiệu, danh mục (tăng/giảm)
- Xem chi tiết sản phẩm (ảnh phóng to, thông tin, sản phẩm cùng loại)
- Thêm sản phẩm vào giỏ hàng (dùng session)
- Xem giỏ hàng, cập nhật số lượng, xóa sản phẩm
- Thanh toán (yêu cầu đăng nhập) – tạo đơn hàng, lưu địa chỉ giao hàng
- Xem lịch sử đơn hàng của mình

### 🔧 Dành cho quản trị viên (Admin)
- Trang quản trị riêng (prefix `/admin`) với middleware phân quyền
- Quản lý sản phẩm (CRUD): thêm, sửa, xóa, upload ảnh
- Quản lý đơn hàng: xem danh sách, cập nhật trạng thái (pending, processing, completed, cancelled)
- Phân biệt menu dựa trên role (`admin` / `customer`)

### 🛠 Kỹ thuật sử dụng
- Laravel 10
- MySQL
- Eloquent ORM (quan hệ: User – Order – OrderItem – Product – Category – Brand)
- Blade template (kế thừa layout, partials header/footer)
- Bootstrap 5 (giao diện responsive)
- Session (giỏ hàng)
- Pagination (tự động, hỗ trợ query string)
- File upload (ảnh sản phẩm lưu vào `public/images/products`)
- AJAX (tìm kiếm gợi ý, thêm giỏ hàng không reload trang)
- Laravel Breeze (xác thực, quên mật khẩu)

## 📁 Cấu trúc thư mục quan trọng
