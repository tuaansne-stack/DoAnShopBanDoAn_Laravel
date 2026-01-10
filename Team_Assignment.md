# 👥 PHÂN CÔNG CÔNG VIỆC NHÓM - DỰ ÁN MYSHOP

> **Mục đích**: Tài liệu này giúp mỗi thành viên nắm rõ phần code mình phụ trách, có thể trả lời chính xác khi giảng viên hỏi về vị trí code, luồng xử lý và cách hoạt động của từng chức năng.

---

## 📌 Tổng Quan Phân Công

### Cách Chia Công Việc

Dự án được chia thành **4 module chính**, mỗi thành viên phụ trách một module riêng biệt:

| Thành viên | Module phụ trách | Phạm vi code |
|:----------:|------------------|--------------|
| **TV1** | Xác thực + Quản lý User + Cài đặt | Auth, Profile, User CRUD, Settings |
| **TV2** | Sản phẩm + Danh mục + Topping | Product, Category, Topping CRUD |
| **TV3** | Giỏ hàng + Đơn hàng + Giao diện + Thanh toán + Database | Cart, Checkout, Order, UI/UX, DB Design |
| **TV4** | Bình luận + Tin tức + Báo cáo | Comments, News, About, Dashboard |

### Trách Nhiệm Khi Được Hỏi

- Mỗi thành viên **CHỈ trả lời về phần code mình phụ trách**
- Phải nắm rõ: **Vị trí file → Luồng xử lý → Dữ liệu vào/ra**
- Khi bị hỏi chéo phần khác → chỉ định đúng thành viên phụ trách

---

## 🧑‍💻 Thành Viên 1: Xác Thực + User + Cài Đặt

### 🔹 Phần Code Phụ Trách

| Chức năng | Mô tả |
|-----------|-------|
| Đăng ký | Tạo tài khoản mới cho khách hàng |
| Đăng nhập | Xác thực user bằng email/password |
| Đăng xuất | Kết thúc phiên làm việc |
| Trang cá nhân | Xem/sửa thông tin, đổi mật khẩu |
| Quản lý User (Admin) | CRUD người dùng, phân quyền |
| Cài đặt Website | Logo, favicon, thông tin shop, mạng xã hội |

---

### 📂 Vị Trí Code Trong Dự Án

#### Thư mục chính:
```
app/
├── Http/Controllers/
│   ├── AuthController.php          ← Đăng ký/Đăng nhập/Đăng xuất
│   └── ProfileController.php       ← Trang cá nhân
├── Http/Controllers/Admin/
│   ├── AuthController.php          ← Đăng nhập Admin
│   ├── UserController.php          ← CRUD User
│   └── SettingController.php       ← Cài đặt website
├── Models/
│   ├── User.php                    ← Model người dùng
│   └── Settings.php                ← Model cài đặt
├── Http/Middleware/
│   └── AdminMiddleware.php         ← Kiểm tra quyền admin

resources/views/
├── auth/
│   ├── login.blade.php             ← Form đăng nhập
│   └── register.blade.php          ← Form đăng ký
├── profile/
│   └── index.blade.php             ← Trang cá nhân
├── admin/
│   ├── users/
│   │   ├── index.blade.php         ← Danh sách user
│   │   └── edit.blade.php          ← Form sửa user
│   └── settings/
│       └── index.blade.php         ← Trang cài đặt

routes/
├── web.php                         ← Route đăng ký/đăng nhập/profile (dòng 47-83)
└── admin.php                       ← Route admin users/settings (dòng 52-80)

database/migrations/
├── 2014_10_12_000000_create_users_table.php     ← Bảng users mặc định Laravel
├── 2024_01_01_000000_modify_users_table.php     ← Thêm cột cho bảng user
├── 2024_01_01_000002_create_quantri_table.php   ← Bảng cài đặt website
├── 2025_12_30_091612_add_remember_token_to_user_table.php ← Thêm remember token
└── 2025_12_30_185000_update_quantri_social_links.php      ← Cập nhật social links
```

---

### 🔄 Luồng Xử Lý Chức Năng

#### 1. Đăng ký tài khoản

```
[User] → GET /register
        ↓
routes/web.php (dòng 50)
        ↓
AuthController@showRegisterForm
        ↓
views/auth/register.blade.php (hiển thị form)
        ↓
[User nhập thông tin] → POST /register
        ↓
AuthController@register
        ↓
- Validate dữ liệu (hoten, email, password)
- Hash password bằng bcrypt
- Tạo record trong bảng `user`
- Tự động đăng nhập
        ↓
Redirect → Trang chủ
```

#### 2. Đăng nhập

```
[User] → GET /login
        ↓
AuthController@showLoginForm
        ↓
views/auth/login.blade.php
        ↓
[User nhập email/password] → POST /login
        ↓
AuthController@login
        ↓
- Auth::attempt(['email' => $email, 'password' => $password])
- Nếu thành công → tạo session
- Nếu thất bại → báo lỗi
        ↓
Redirect → Trang chủ hoặc trang trước đó
```

#### 3. Quản lý User (Admin)

```
[Admin] → GET /admin/users
        ↓
routes/admin.php (dòng 52, Route::resource)
        ↓
Admin\UserController@index
        ↓
- Query: User::paginate(10)
- Trả về danh sách user
        ↓
views/admin/users/index.blade.php
        ↓
[Thêm/Sửa] → Admin\UserController@store / @update
        ↓
- Validate dữ liệu
- Lưu vào bảng `user` với is_admin (0=Khách, 1=Admin, 2=Staff)
```

#### 4. Cài đặt Website

```
[Admin] → GET /admin/settings
        ↓
Admin\SettingController@index
        ↓
- Lấy dữ liệu từ bảng `quantri`
- Trả về view với thông tin hiện tại
        ↓
views/admin/settings/index.blade.php
        ↓
[Cập nhật logo] → POST /admin/settings/logo
        ↓
Admin\SettingController@updateLogo
        ↓
- Upload file vào thư mục public/uploads
- Cập nhật đường dẫn trong bảng `quantri`
```

---

### 📖 Giải Thích Chi Tiết Code

#### File `app/Http/Controllers/AuthController.php`

| Hàm | Mục đích | Input | Output |
|-----|----------|-------|--------|
| `showLoginForm()` | Hiển thị form đăng nhập | - | View login |
| `login(Request)` | Xử lý đăng nhập | email, password | Redirect |
| `showRegisterForm()` | Hiển thị form đăng ký | - | View register |
| `register(Request)` | Xử lý đăng ký | hoten, email, password | Redirect |
| `logout()` | Đăng xuất | - | Redirect login |

#### File `app/Models/User.php`

| Thuộc tính/Hàm | Mục đích |
|----------------|----------|
| `$table = 'user'` | Tên bảng trong database |
| `$fillable` | Các cột cho phép mass assignment: hoten, email, password, is_admin, trangthai |
| `isAdmin()` | Kiểm tra user là admin (is_admin == 1) |
| `isStaff()` | Kiểm tra user là nhân viên (is_admin == 2) |
| `hasPermission($permission)` | Kiểm tra quyền cụ thể |

#### File `app/Http/Controllers/Admin/SettingController.php`

| Hàm | Mục đích |
|-----|----------|
| `index()` | Hiển thị trang cài đặt |
| `updateLogo(Request)` | Upload và lưu logo/favicon |
| `updateSocial(Request)` | Cập nhật link mạng xã hội |
| `updatePayment(Request)` | Cập nhật phương thức thanh toán |
| `updateShipping(Request)` | Cập nhật phương thức vận chuyển |

---

### ⚙️ Hướng Dẫn Vận Hành & Kiểm Tra

#### Kiểm tra Đăng ký/Đăng nhập:
1. Truy cập: `http://localhost/MyShop/public/register`
2. Nhập thông tin → Đăng ký → Tự động đăng nhập
3. Click "Đăng xuất" → Quay về login
4. Đăng nhập lại với email/password đã tạo

#### Kiểm tra Quản lý User:
1. Đăng nhập tài khoản Admin
2. Truy cập: `http://localhost/MyShop/public/admin/users`
3. Thêm user mới → Kiểm tra trong database bảng `user`
4. Sửa quyền user → Kiểm tra cột `is_admin` thay đổi

#### Kiểm tra Cài đặt:
1. Truy cập: `http://localhost/MyShop/public/admin/settings`
2. Upload logo mới → Kiểm tra file trong `public/uploads`
3. Cập nhật thông tin shop → Xem trang chủ

#### Điểm cần lưu ý khi demo:
- Password được hash bằng `bcrypt` → không thể đọc trực tiếp
- Middleware `auth` bảo vệ các route cần đăng nhập
- Middleware `admin` kiểm tra quyền admin (is_admin = 1 hoặc 2)

---

## 🧑‍💻 Thành Viên 2: Sản Phẩm + Danh Mục + Topping

### 🔹 Phần Code Phụ Trách

| Chức năng | Mô tả |
|-----------|-------|
| Quản lý Danh mục | CRUD danh mục sản phẩm |
| Quản lý Sản phẩm | CRUD món ăn, upload nhiều hình |
| Quản lý Topping | CRUD topping cho món ăn |
| Trang Menu (Frontend) | Hiển thị sản phẩm, lọc, tìm kiếm |
| Chi tiết sản phẩm | Xem thông tin, gallery, chọn topping |
| Trang chủ | Hiển thị sản phẩm nổi bật |

---

### 📂 Vị Trí Code Trong Dự Án

```
app/
├── Http/Controllers/
│   ├── HomeController.php          ← Trang chủ (hiển thị SP nổi bật)
│   ├── ProductController.php       ← Menu + Chi tiết SP (Frontend)
│   └── SearchController.php        ← Tìm kiếm
├── Http/Controllers/Admin/
│   ├── CategoryController.php      ← CRUD Danh mục
│   ├── ProductController.php       ← CRUD Sản phẩm
│   └── ToppingController.php       ← CRUD Topping
├── Models/
│   ├── Category.php                ← Model danh mục
│   ├── Product.php                 ← Model sản phẩm (monan)
│   ├── ProductImage.php            ← Model hình ảnh SP
│   └── Topping.php                 ← Model topping

resources/views/
├── home.blade.php                  ← Trang chủ
├── products/
│   ├── index.blade.php             ← Trang menu
│   └── show.blade.php              ← Chi tiết sản phẩm
├── search.blade.php                ← Kết quả tìm kiếm
├── admin/
│   ├── categories/
│   │   ├── index.blade.php         ← Danh sách danh mục
│   │   ├── create.blade.php        ← Form thêm mới
│   │   ├── edit.blade.php          ← Form sửa
│   │   └── show.blade.php          ← Xem chi tiết
│   ├── products/
│   │   ├── index.blade.php         ← Danh sách sản phẩm
│   │   └── edit.blade.php          ← Form thêm/sửa (upload hình)
│   └── toppings/
│       ├── index.blade.php         ← Danh sách topping
│       ├── create.blade.php        ← Form thêm mới
│       └── edit.blade.php          ← Form sửa

routes/
├── web.php                         ← Route menu, product, search (dòng 27-45)
└── admin.php                       ← Route admin products/categories/toppings (dòng 37-65)

database/migrations/
├── 2024_01_01_000001_create_danhmuc_table.php          ← Bảng danh mục
├── 2024_01_01_000005_create_monan_table.php            ← Bảng sản phẩm
├── 2025_12_27_000001_create_product_images_table.php   ← Bảng hình ảnh SP
├── 2025_12_30_085018_remove_hinhanh_from_danhmuc_table.php ← Xóa cột hình danh mục
├── 2025_12_30_110639_create_topping_table.php          ← Bảng topping
├── 2025_12_30_110718_create_monan_topping_table.php    ← Bảng liên kết SP-Topping
└── 2025_12_31_012437_drop_hinhanh_from_monan_table.php ← Xóa cột hình monan
```

---

### 🔄 Luồng Xử Lý Chức Năng

#### 1. Hiển thị Trang Menu (Frontend)

```
[User] → GET /menu
        ↓
routes/web.php (dòng 30)
        ↓
ProductController@index
        ↓
- Lấy danh sách danh mục: Category::all()
- Lấy sản phẩm: Product::with('category', 'mainImage')
- Lọc theo danhmuc_id nếu có
- Paginate(12)
        ↓
views/products/index.blade.php
        ↓
Hiển thị grid sản phẩm với hình ảnh, giá, tên
```

#### 2. Chi tiết Sản phẩm

```
[User] → GET /product/{id}
        ↓
ProductController@show
        ↓
- Product::with('category', 'images', 'toppings', 'approvedComments')->find($id)
- Tăng lượt xem (nếu có)
        ↓
views/products/show.blade.php
        ↓
- Gallery hình ảnh (Swiper)
- Thông tin: tên, giá, mô tả
- Danh sách topping có thể chọn
- Bình luận đã duyệt
```

#### 3. Thêm Sản phẩm (Admin)

```
[Admin] → GET /admin/products/create
        ↓
Admin\ProductController@create
        ↓
views/admin/products/edit.blade.php
        ↓
[Nhập thông tin + upload hình] → POST /admin/products
        ↓
Admin\ProductController@store
        ↓
- Validate: tenmon, gia, danhmuc_id
- Tạo record trong bảng `monan`
- Loop qua các file hình ảnh:
  - Lưu vào public/uploads/products
  - Tạo record trong bảng `product_images`
  - Đánh dấu hình đầu tiên là `is_main = 1`
        ↓
Redirect → Danh sách sản phẩm
```

#### 4. Tìm kiếm Sản phẩm

```
[User] → GET /search?q=keyword
        ↓
SearchController@index
        ↓
- Product::where('tenmon', 'like', '%keyword%')
- Hoặc where('mota', 'like', '%keyword%')
- Paginate
        ↓
views/search.blade.php
```

---

### 📖 Giải Thích Chi Tiết Code

#### File `app/Models/Product.php`

| Thuộc tính/Hàm | Mục đích |
|----------------|----------|
| `$table = 'monan'` | Bảng sản phẩm |
| `category()` | Quan hệ N:1 với bảng `danhmuc` |
| `images()` | Quan hệ 1:N với bảng `product_images` |
| `mainImage()` | Lấy hình ảnh chính (is_main = 1) |
| `toppings()` | Quan hệ N:N với bảng `topping` qua `monan_topping` |
| `getDisplayImageAttribute()` | Accessor trả về URL hình ảnh chính |
| `scopeFeatured($query)` | Lọc sản phẩm nổi bật (noibat = 1) |
| `scopeActive($query)` | Lọc sản phẩm đang bán |

#### File `app/Http/Controllers/Admin/ProductController.php`

| Hàm | Mục đích |
|-----|----------|
| `index()` | Danh sách SP với tìm kiếm, lọc danh mục |
| `create()` | Form thêm mới |
| `store(Request)` | Lưu SP mới + upload hình |
| `edit($id)` | Form sửa với dữ liệu hiện tại |
| `update(Request, $id)` | Cập nhật SP + quản lý hình |
| `destroy($id)` | Xóa SP + xóa hình trong thư mục |
| `deleteImage($id)` | Xóa từng hình ảnh riêng lẻ |

---

### ⚙️ Hướng Dẫn Vận Hành & Kiểm Tra

#### Kiểm tra Danh mục:
1. Truy cập: `http://localhost/MyShop/public/admin/categories`
2. Thêm danh mục "Đồ uống" → Kiểm tra bảng `danhmuc`
3. Sửa, xóa danh mục → Kiểm tra ràng buộc với sản phẩm

#### Kiểm tra Sản phẩm:
1. Truy cập: `http://localhost/MyShop/public/admin/products`
2. Thêm sản phẩm với 3 hình ảnh
3. Kiểm tra: bảng `monan` và `product_images`
4. Xem frontend: `http://localhost/MyShop/public/menu`

#### Kiểm tra Topping:
1. Truy cập: `http://localhost/MyShop/public/admin/toppings`
2. Thêm topping "Trân châu" - giá 5000
3. Gán topping cho sản phẩm → Kiểm tra `monan_topping`

#### Điểm cần lưu ý:
- Hình ảnh lưu trong `public/uploads/products`
- Hình chính (`is_main = 1`) hiển thị ở thumbnail
- Quan hệ N:N với topping thông qua bảng trung gian

---

## 🧑‍💻 Thành Viên 3: Giỏ Hàng + Đơn Hàng + Giao Diện + Thanh Toán + Database

### 🔹 Phần Code Phụ Trách

| Chức năng | Mô tả |
|-----------|-------|
| **Giỏ hàng** | Thêm/sửa/xóa sản phẩm trong giỏ |
| **Checkout** | Chọn PTTT, PTVC, đặt hàng |
| **Đơn hàng của tôi** | Xem danh sách, chi tiết đơn |
| **Quản lý đơn (Admin)** | Xem, cập nhật trạng thái, in, xuất Excel |
| **Thiết kế Giao diện** | Layout, CSS, responsive design |
| **Thiết kế Hình ảnh** | Banner, logo, icon, assets |
| **Thiết kế Database** | ERD, migrations, quan hệ bảng |

---

### 📂 Vị Trí Code Trong Dự Án

#### A. Phần Giỏ hàng + Đơn hàng:
```
app/
├── Http/Controllers/
│   ├── CartController.php          ← Quản lý giỏ hàng
│   └── OrderController.php         ← Checkout + Đơn hàng (Frontend)
├── Http/Controllers/Admin/
│   └── OrderController.php         ← Quản lý đơn hàng (Admin)
├── Models/
│   ├── Cart.php                    ← Model giỏ hàng
│   ├── Order.php                   ← Model đơn hàng (hoadon)
│   ├── OrderItem.php               ← Model chi tiết đơn
│   ├── PaymentMethod.php           ← Model PTTT
│   └── ShippingMethod.php          ← Model PTVC

resources/views/
├── cart/
│   └── index.blade.php             ← Trang giỏ hàng
├── orders/
│   ├── checkout.blade.php          ← Trang thanh toán
│   ├── index.blade.php             ← Danh sách đơn hàng
│   └── show.blade.php              ← Chi tiết đơn hàng
├── admin/orders/
│   ├── index.blade.php             ← Danh sách đơn (Admin)
│   └── print.blade.php             ← Template in đơn
```

#### B. Phần Giao diện (UI/UX):
```
resources/views/
├── layouts/
│   └── app.blade.php               ← Layout chính (Header, Footer)
├── admin/layouts/
│   └── admin.blade.php             ← Layout Admin (Sidebar, Navbar)
├── components/                      ← Các component tái sử dụng

public/
├── css/
│   └── style.css                   ← CSS tùy chỉnh
├── js/
│   └── app.js                      ← JavaScript chính
├── uploads/                        ← Thư mục chứa hình ảnh upload
│   ├── products/                   ← Hình sản phẩm
│   ├── news/                       ← Hình tin tức
│   └── logo/                       ← Logo, favicon
```

#### C. Phần Database:
```
database/
├── migrations/                     ← TẤT CẢ 28 file migration
│   ├── 2014_10_12_000000_create_users_table.php        ← Bảng users Laravel
│   ├── 2024_01_01_000000_modify_users_table.php        ← Sửa bảng user
│   ├── 2024_01_01_000001_create_danhmuc_table.php       ← Bảng danh mục
│   ├── 2024_01_01_000002_create_quantri_table.php       ← Bảng cài đặt
│   ├── 2024_01_01_000003_create_phuongthucthanhtoan_table.php ← PTTT
│   ├── 2024_01_01_000004_create_phuongthucvanchuyen_table.php ← PTVC
│   ├── 2024_01_01_000005_create_monan_table.php         ← Bảng sản phẩm
│   ├── 2024_01_01_000006_create_giohang_table.php       ← Bảng giỏ hàng
│   ├── 2024_01_01_000007_create_hoadon_table.php        ← Bảng đơn hàng
│   ├── 2024_01_01_000008_create_chitiethoadon_table.php ← Chi tiết đơn
│   ├── 2024_01_01_000009_create_binhluan_table.php      ← Bình luận
│   ├── 2024_01_01_000010_create_tintuc_table.php        ← Tin tức
│   ├── 2024_01_01_000011_create_gioithieu_table.php     ← Giới thiệu
│   ├── 2024_01_01_000012_create_thongtinthanhtoan_table.php ← Ngân hàng
│   ├── 2024_01_01_000013_create_lichsudonhang_table.php ← Lịch sử đơn
│   ├── 2024_01_01_000014_create_thongke_doanhthu_table.php ← Thống kê
│   ├── 2024_12_31_000001_add_noibat_to_tintuc_table.php ← Tin nổi bật
│   ├── 2025_12_07_191502_add_hoadon_id_to_binhluan_table.php ← Liên kết bình luận-đơn
│   ├── 2025_12_27_000001_create_product_images_table.php ← Hình SP
│   ├── 2025_12_30_085018_remove_hinhanh_from_danhmuc_table.php
│   ├── 2025_12_30_091612_add_remember_token_to_user_table.php
│   ├── 2025_12_30_110639_create_topping_table.php       ← Bảng topping
│   ├── 2025_12_30_110718_create_monan_topping_table.php ← SP-Topping
│   ├── 2025_12_30_110735_create_chitiethoadon_topping_table.php ← Đơn-Topping
│   ├── 2025_12_30_120554_create_giohang_topping_table.php ← Giỏ-Topping
│   ├── 2025_12_30_185000_update_quantri_social_links.php
│   ├── 2025_12_30_185830_add_tiktok_to_quantri.php
│   └── 2025_12_31_012437_drop_hinhanh_from_monan_table.php
├── seeders/                        ← Dữ liệu mẫu
│   └── DatabaseSeeder.php
```

---

### 🔄 Luồng Xử Lý Chức Năng (CHI TIẾT)

#### 1. THÊM VÀO GIỎ HÀNG

**Điểm bắt đầu:** User click nút "Thêm vào giỏ" ở trang chi tiết sản phẩm

**File xử lý:** `app/Http/Controllers/CartController.php` → hàm `add()` (dòng 38-115)

```
BƯỚC 1: Request gửi đến server
─────────────────────────────────────────────────────────
URL: POST /cart/add
Dữ liệu gửi: { product_id, quantity, toppings[] }
Gửi bằng: AJAX (JavaScript)

BƯỚC 2: Middleware kiểm tra đăng nhập
─────────────────────────────────────────────────────────
File: CartController.php dòng 14-17
Code: $this->middleware('auth');
→ Nếu chưa đăng nhập → trả về lỗi 401

BƯỚC 3: Kiểm tra sản phẩm
─────────────────────────────────────────────────────────
File: CartController.php dòng 49-56
Code: $product = Product::findOrFail($request->product_id);
      if ($product->trangthai !== 'Đang bán') { ... }
→ Kiểm tra sản phẩm tồn tại và đang bán

BƯỚC 4: Kiểm tra SP đã có trong giỏ chưa (cùng topping)
─────────────────────────────────────────────────────────
File: CartController.php dòng 62-75
Code: $existingCart = Cart::where('user_id', Auth::id())
                         ->where('monan_id', $product->id)->get();
→ Tìm xem SP với cùng topping đã có chưa

BƯỚC 5: Thêm hoặc cập nhật giỏ hàng
─────────────────────────────────────────────────────────
File: CartController.php dòng 77-100
- Nếu đã có → cập nhật số lượng: $matchingCart->update(['soluong' => $newQuantity])
- Nếu chưa có → tạo mới: Cart::create([...])
- Lưu topping vào bảng giohang_topping

BƯỚC 6: Trả về response (JSON)
─────────────────────────────────────────────────────────
File: CartController.php dòng 110-114
Response: { status: 'success', message: '...', cart_count: X }
→ JavaScript nhận và cập nhật icon giỏ hàng
```

**Bảng dữ liệu liên quan:**
| Bảng | Thao tác | Dữ liệu |
|------|----------|---------|
| `giohang` | INSERT hoặc UPDATE | user_id, monan_id, soluong |
| `giohang_topping` | INSERT | giohang_id, topping_id, soluong |

---

#### 2. XEM GIỎ HÀNG

**Điểm bắt đầu:** User truy cập `/cart`

**File xử lý:** `CartController.php` → hàm `index()` (dòng 22-33)

```
BƯỚC 1: Route nhận request
─────────────────────────────────────────────────────────
File: routes/web.php dòng 56
Route: GET /cart → CartController@index

BƯỚC 2: Query lấy dữ liệu giỏ hàng
─────────────────────────────────────────────────────────
File: CartController.php dòng 24-26
Code: $cartItems = Cart::with(['product', 'toppings'])
                       ->where('user_id', Auth::id())->get();
→ Lấy tất cả item trong giỏ của user hiện tại
→ Eager load: thông tin sản phẩm + topping

BƯỚC 3: Tính tổng tiền
─────────────────────────────────────────────────────────
File: CartController.php dòng 28-30
Code: $cartTotal = $cartItems->sum(function($item) {
          return $item->total;  // Gọi accessor getTotalAttribute()
      });
→ Với mỗi item: giá SP × số lượng + giá topping × số lượng

BƯỚC 4: Trả về View
─────────────────────────────────────────────────────────
File: resources/views/cart/index.blade.php
Dữ liệu: compact('cartItems', 'cartTotal')
→ View hiển thị bảng sản phẩm, nút +/-, tổng tiền
```

---

#### 3. ĐẶT HÀNG (CHECKOUT)

**Điểm bắt đầu:** User click "Thanh toán" từ giỏ hàng

**File xử lý:** `app/Http/Controllers/OrderController.php`

```
BƯỚC 1: Hiển thị trang Checkout
─────────────────────────────────────────────────────────
File: OrderController.php → checkout() dòng 26-53
Route: GET /checkout

Code quan trọng:
- $cartItems = Cart::with(['product', 'toppings'])->where('user_id', Auth::id())->get();
- $paymentMethods = PaymentMethod::active()->get();
- $shippingMethods = ShippingMethod::active()->get();

View: resources/views/orders/checkout.blade.php
→ Hiển thị: form địa chỉ, dropdown PTTT, dropdown PTVC, bảng SP

BƯỚC 2: User submit form đặt hàng
─────────────────────────────────────────────────────────
Route: POST /orders
File: OrderController.php → store() dòng 58-133

BƯỚC 3: Validate dữ liệu
─────────────────────────────────────────────────────────
File: OrderController.php dòng 60-65
Code: $request->validate([
    'shipping_address' => 'required|string|max:255',
    'shipping_method' => 'required|exists:phuongthucvanchuyen,id',
    'payment_method' => 'required|exists:phuongthucthanhtoan,id',
]);

BƯỚC 4: Bắt đầu Transaction
─────────────────────────────────────────────────────────
File: OrderController.php dòng 76
Code: DB::beginTransaction();
→ Đảm bảo tất cả thao tác DB thành công hoặc rollback hết

BƯỚC 5: Tạo đơn hàng trong bảng hoadon
─────────────────────────────────────────────────────────
File: OrderController.php dòng 85-94
Code: $order = Order::create([
    'user_id' => Auth::id(),
    'tongtien' => $total,
    'diachi_giaohang' => $request->shipping_address,
    'trangthai' => 'Chờ xác nhận',
    'pttt_id' => $request->payment_method,
    'ptvc_id' => $request->shipping_method,
    'dathanhtoan' => false,
]);

BƯỚC 6: Tạo chi tiết đơn hàng
─────────────────────────────────────────────────────────
File: OrderController.php dòng 96-113
Code: foreach ($cartItems as $item) {
    $orderItem = OrderItem::create([
        'hoadon_id' => $order->id,
        'monan_id' => $item->monan_id,
        'soluong' => $item->soluong,
        'gia' => $item->product->gia,
    ]);
    // Lưu topping cho từng item
    foreach ($item->toppings as $topping) {
        DB::table('chitiethoadon_topping')->insert([...]);
    }
}

BƯỚC 7: Tạo lịch sử đơn hàng
─────────────────────────────────────────────────────────
File: OrderController.php dòng 115-121
Code: OrderHistory::create([
    'hoadon_id' => $order->id,
    'trang_thai_cu' => null,
    'trang_thai_moi' => 'Chờ xác nhận',
    'nguoi_thay_doi' => Auth::user()->hoten,
]);

BƯỚC 8: Xóa giỏ hàng và commit
─────────────────────────────────────────────────────────
File: OrderController.php dòng 123-125
Code: Cart::where('user_id', Auth::id())->delete();
      DB::commit();

BƯỚC 9: Redirect đến trang hoàn tất
─────────────────────────────────────────────────────────
Route: /orders/{id}/complete
View: resources/views/orders/complete.blade.php
```

**Bảng dữ liệu liên quan:**
| Bảng | Thao tác | Dữ liệu |
|------|----------|---------|
| `hoadon` | INSERT | user_id, tongtien, diachi, trangthai, pttt_id, ptvc_id |
| `chitiethoadon` | INSERT (nhiều) | hoadon_id, monan_id, soluong, gia |
| `chitiethoadon_topping` | INSERT | chitiethoadon_id, topping_id, gia |
| `lichsudonhang` | INSERT | hoadon_id, trang_thai_moi |
| `giohang` | DELETE | Xóa tất cả item của user |

---

#### 4. HỦY ĐƠN HÀNG

**File:** `OrderController.php` → `cancel()` (dòng 187-216)

```
BƯỚC 1: Kiểm tra quyền hủy
─────────────────────────────────────────────────────────
Code: if (!in_array($order->trangthai, ['Chờ xác nhận', 'Đã xác nhận'])) {
    return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này.');
}
→ Chỉ hủy được khi: Chờ xác nhận hoặc Đã xác nhận

BƯỚC 2: Cập nhật trạng thái
─────────────────────────────────────────────────────────
Code: $order->update(['trangthai' => 'Đã hủy']);
      OrderHistory::create([...]);
```

---

#### 5. QUẢN LÝ ĐƠN HÀNG (ADMIN)

**File:** `app/Http/Controllers/Admin/OrderController.php`

```
Danh sách đơn: GET /admin/orders → index()
Chi tiết đơn:  GET /admin/orders/{id} → show()
Cập nhật TT:   POST /admin/orders/{id}/status → updateStatus()
In đơn:        GET /admin/orders/{id}/print → print()
Xuất Excel:    GET /admin/orders-export → export()
```

---

### 📖 Giải Thích Chi Tiết Code

#### File `app/Models/Order.php`

| Thuộc tính/Hàm | Mục đích |
|----------------|----------|
| `$table = 'hoadon'` | Bảng đơn hàng |
| `user()` | Quan hệ N:1 với `user` |
| `orderItems()` | Quan hệ 1:N với `chitiethoadon` |
| `paymentMethod()` | Quan hệ N:1 với `phuongthucthanhtoan` |
| `shippingMethod()` | Quan hệ N:1 với `phuongthucvanchuyen` |
| `orderHistory()` | Quan hệ 1:N với `lichsudonhang` |

#### File `app/Http/Controllers/CartController.php`

| Hàm | Mục đích |
|-----|----------|
| `index()` | Hiển thị giỏ hàng |
| `add(Request)` | Thêm SP vào giỏ (AJAX) |
| `update(Request, $id)` | Cập nhật số lượng |
| `remove($id)` | Xóa item khỏi giỏ |
| `clear()` | Xóa toàn bộ giỏ |
| `getCount()` | Trả về số lượng item (AJAX) |

#### Trạng thái Đơn hàng

| Giá trị | Ý nghĩa | Cho phép |
|---------|---------|----------|
| `Chờ xác nhận` | Đơn mới tạo | User có thể hủy |
| `Đã xác nhận` | Admin đã xác nhận | Không thể hủy |
| `Đang giao` | Đang vận chuyển | - |
| `Hoàn tất` | Giao thành công | User có thể đánh giá |
| `Đã hủy` | Đơn bị hủy | - |

---

### ⚙️ Hướng Dẫn Vận Hành & Kiểm Tra

#### Kiểm tra Giỏ hàng:
1. Đăng nhập → Vào chi tiết sản phẩm
2. Click "Thêm vào giỏ" → Kiểm tra bảng `giohang`
3. Vào `/cart` → Thay đổi số lượng, xóa item

#### Kiểm tra Đặt hàng:
1. Từ giỏ hàng → Click "Thanh toán"
2. Nhập địa chỉ, chọn PTTT, PTVC → Đặt hàng
3. Kiểm tra: bảng `hoadon`, `chitiethoadon`
4. Giỏ hàng phải rỗng sau khi đặt

#### Kiểm tra Admin:
1. Truy cập: `/admin/orders`
2. Xem chi tiết đơn → Cập nhật trạng thái
3. Kiểm tra bảng `lichsudonhang`
4. In đơn hàng, xuất Excel

#### Kiểm tra Giao diện:
1. Mở website trên Desktop và Mobile → Kiểm tra responsive
2. Layout Header/Footer hiển thị đúng ở mọi trang
3. Admin Sidebar hoạt động, menu dropdown
4. Kiểm tra CSS: màu sắc, font, spacing nhất quán

#### Kiểm tra Database:
1. Chạy migration: `php artisan migrate:fresh`
2. Chạy seeder: `php artisan db:seed`
3. Kiểm tra quan hệ bảng trong phpMyAdmin
4. Giải thích được ERD và quan hệ 1:N, N:N

#### Điểm cần lưu ý:
- Giỏ hàng yêu cầu đăng nhập (middleware `auth`)
- Đơn hàng liên kết với PTTT và PTVC
- **Layout**: Nắm rõ cấu trúc `@extends`, `@section`, `@yield`
- **Database**: Nắm rõ các lệnh artisan migrate, quan hệ trong Model

---

### 🎨 GIẢI THÍCH CHI TIẾT: GIAO DIỆN (UI/UX)

#### A. Cấu trúc Layout Blade

```
resources/views/layouts/app.blade.php
─────────────────────────────────────────────────────────
Đây là file LAYOUT CHÍNH của website (Frontend)

Cấu trúc:
<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials.head')    ← CSS, meta tags
</head>
<body>
    @include('layouts.partials.header')  ← Header, menu
    
    <main>
        @yield('content')                ← NỘI DUNG TRANG (thay đổi)
    </main>
    
    @include('layouts.partials.footer')  ← Footer
    @stack('scripts')                    ← JavaScript
</body>
</html>

Cách sử dụng trong View con:
─────────────────────────────────────────────────────────
@extends('layouts.app')          ← Kế thừa layout

@section('title', 'Trang chủ')   ← Đặt title

@section('content')              ← Nội dung trang
    <h1>Đây là nội dung</h1>
@endsection
```

#### B. Layout Admin

```
resources/views/admin/layouts/admin.blade.php
─────────────────────────────────────────────────────────
Layout riêng cho Admin Panel

Cấu trúc:
<body>
    <div class="admin-wrapper">
        @include('admin.layouts.sidebar')  ← Sidebar menu
        
        <div class="main-content">
            @include('admin.layouts.navbar')  ← Top navbar
            
            <div class="content">
                @yield('content')             ← Nội dung admin
            </div>
        </div>
    </div>
</body>
```

#### C. File CSS chính

```
public/css/style.css
─────────────────────────────────────────────────────────
- Định nghĩa màu sắc, font, spacing
- Style cho Header, Footer, Sidebar
- Style cho các component (button, card, table)
- Responsive: @media queries cho mobile
```

---

### 🗄️ GIẢI THÍCH CHI TIẾT: DATABASE

#### A. Migration là gì?

```
database/migrations/
─────────────────────────────────────────────────────────
Migration = File PHP định nghĩa cấu trúc bảng

Ví dụ file: 2024_01_01_000005_create_monan_table.php

public function up()
{
    Schema::create('monan', function (Blueprint $table) {
        $table->id();                      // BIGINT, Primary Key
        $table->string('tenmon', 100);     // VARCHAR(100)
        $table->text('mota')->nullable();  // TEXT, cho phép NULL
        $table->integer('gia');            // INT
        $table->foreignId('danhmuc_id')    // Foreign Key
              ->constrained('danhmuc')     // Liên kết với bảng danhmuc
              ->onDelete('set null');      // Nếu xóa DM → set null
        $table->timestamps();              // created_at, updated_at
    });
}
```

#### B. Các lệnh Artisan quan trọng

```
Tạo database mới (XÓA HẾT dữ liệu cũ):
─────────────────────────────────────────────────────────
php artisan migrate:fresh
→ Drop tất cả bảng
→ Chạy lại tất cả migration từ đầu

Thêm dữ liệu mẫu:
─────────────────────────────────────────────────────────
php artisan db:seed
→ Chạy DatabaseSeeder.php
→ Insert dữ liệu mẫu vào các bảng

Chạy cả 2 cùng lúc:
─────────────────────────────────────────────────────────
php artisan migrate:fresh --seed
```

#### C. Quan hệ trong Model (Eloquent)

```
Quan hệ 1:N (One-to-Many)
─────────────────────────────────────────────────────────
File: app/Models/Order.php

// 1 Order có NHIỀU OrderItems
public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'hoadon_id');
}

File: app/Models/OrderItem.php

// 1 OrderItem thuộc về 1 Order
public function order()
{
    return $this->belongsTo(Order::class, 'hoadon_id');
}

Quan hệ N:N (Many-to-Many)
─────────────────────────────────────────────────────────
File: app/Models/Product.php

// 1 Product có NHIỀU Toppings, 1 Topping có trong NHIỀU Products
public function toppings()
{
    return $this->belongsToMany(Topping::class, 'monan_topping', 'monan_id', 'topping_id');
}
→ Bảng trung gian: monan_topping
```

#### D. Danh sách 20 bảng và quan hệ

| STT | Bảng | Mô tả | Quan hệ |
|:---:|------|-------|---------|
| 1 | `user` | Người dùng | 1:N → giohang, hoadon, binhluan |
| 2 | `danhmuc` | Danh mục | 1:N → monan |
| 3 | `monan` | Sản phẩm | N:N ↔ topping, 1:N → images |
| 4 | `product_images` | Hình SP | N:1 → monan |
| 5 | `topping` | Topping | N:N ↔ monan, giohang, chitiethoadon |
| 6 | `giohang` | Giỏ hàng | N:1 → user, monan |
| 7 | `giohang_topping` | Topping giỏ | Bảng trung gian N:N |
| 8 | `hoadon` | Đơn hàng | N:1 → user, PTTT, PTVC |
| 9 | `chitiethoadon` | Chi tiết đơn | N:1 → hoadon, monan |
| 10 | `chitiethoadon_topping` | Topping đơn | Bảng trung gian N:N |
| 11 | `binhluan` | Bình luận | N:1 → user, monan, hoadon |
| 12 | `tintuc` | Tin tức | Độc lập |
| 13 | `gioithieu` | Giới thiệu | Độc lập |
| 14 | `quantri` | Cài đặt | Độc lập |
| 15 | `phuongthucthanhtoan` | PTTT | 1:N → hoadon |
| 16 | `phuongthucvanchuyen` | PTVC | 1:N → hoadon |
| 17 | `thongtinthanhtoan` | Bank info | N:1 → PTTT |
| 18 | `lichsudonhang` | Lịch sử đơn | N:1 → hoadon |
| 19 | `thongke_doanhthu` | Thống kê | Table thống kê doanh thu |
| 20 | `monan_topping` | Liên kết | Bảng trung gian N:N |

---

## 🧑‍💻 Thành Viên 4: Bình Luận + Tin Tức + Báo Cáo

### 🔹 Phần Code Phụ Trách

| Chức năng | Mô tả |
|-----------|-------|
| Bình luận/Đánh giá | Viết review sản phẩm (sau khi mua) |
| Quản lý Bình luận | Duyệt, ẩn, xóa bình luận |
| Quản lý Tin tức | CRUD bài viết |
| Trang Tin tức | Hiển thị danh sách + chi tiết tin |
| Quản lý Giới thiệu | CRUD nội dung about |
| Dashboard | Thống kê tổng quan |
| Báo cáo | Thống kê doanh thu, biểu đồ |

---

### 📂 Vị Trí Code Trong Dự Án

```
app/
├── Http/Controllers/
│   ├── CommentController.php       ← Gửi bình luận (Frontend)
│   ├── NewsController.php          ← Xem tin tức (Frontend)
│   ├── AboutController.php         ← Trang giới thiệu
│   └── ContactController.php       ← Trang liên hệ
├── Http/Controllers/Admin/
│   ├── CommentController.php       ← Quản lý bình luận
│   ├── NewsController.php          ← CRUD tin tức
│   ├── AboutController.php         ← CRUD giới thiệu
│   ├── DashboardController.php     ← Thống kê tổng quan
│   └── ReportController.php        ← Báo cáo doanh thu
├── Models/
│   ├── Comment.php                 ← Model bình luận
│   ├── News.php                    ← Model tin tức
│   └── About.php                   ← Model giới thiệu

resources/views/
├── news/
│   ├── index.blade.php             ← Danh sách tin tức
│   └── show.blade.php              ← Chi tiết tin tức
├── about.blade.php                 ← Trang giới thiệu
├── contact.blade.php               ← Trang liên hệ
├── admin/
│   ├── dashboard.blade.php         ← Trang dashboard
│   ├── comments/
│   │   └── index.blade.php         ← Quản lý bình luận
│   ├── news/
│   │   ├── index.blade.php         ← Danh sách tin
│   │   └── edit.blade.php          ← Form sửa tin
│   ├── about/
│   │   ├── index.blade.php         ← Danh sách giới thiệu
│   │   └── edit.blade.php          ← Form sửa
│   └── reports/
│       └── index.blade.php         ← Báo cáo doanh thu

routes/
├── web.php                         ← Route news, about, contact, comments (dòng 33-76)
└── admin.php                       ← Route admin comments, news, about, reports (dòng 56-71)

database/migrations/
├── 2024_01_01_000009_create_binhluan_table.php         ← Bảng bình luận
├── 2024_01_01_000010_create_tintuc_table.php           ← Bảng tin tức
├── 2024_01_01_000011_create_gioithieu_table.php        ← Bảng giới thiệu
├── 2024_01_01_000014_create_thongke_doanhthu_table.php ← Bảng thống kê
├── 2024_12_31_000001_add_noibat_to_tintuc_table.php    ← Thêm cột nổi bật
└── 2025_12_07_191502_add_hoadon_id_to_binhluan_table.php ← Liên kết bình luận-đơn hàng
```

---

### 🔄 Luồng Xử Lý Chức Năng

#### 1. Gửi Bình luận (Frontend)

```
[User] → Ở trang chi tiết đơn hàng hoàn tất
        ↓
Form đánh giá: chọn sao + nhập nội dung
        ↓
POST /comments
        ↓
CommentController@store
        ↓
- Validate: monan_id, hoadon_id, danhgia (1-5), noidung
- Kiểm tra user đã mua sản phẩm này
- Tạo record: Comment::create([
    'monan_id' => $monan_id,
    'user_id' => Auth::id(),
    'hoadon_id' => $hoadon_id,
    'danhgia' => $danhgia,
    'noidung' => $noidung,
    'trangthai' => 'Chờ duyệt'
  ])
        ↓
Redirect back với thông báo
```

#### 2. Duyệt Bình luận (Admin)

```
[Admin] → GET /admin/comments
        ↓
Admin\CommentController@index
        ↓
- Comment::with('user', 'product')->orderBy('created_at', 'desc')
- Lọc theo trạng thái nếu có
        ↓
views/admin/comments/index.blade.php
        ↓
[Click Duyệt] → POST /admin/comments/{id}/status
        ↓
Admin\CommentController@updateStatus
        ↓
- Comment::find($id)->update(['trangthai' => 'Đã duyệt'])
```

#### 3. Dashboard Thống kê

```
[Admin] → GET /admin/dashboard
        ↓
Admin\DashboardController@index
        ↓
- Tổng đơn hàng: Order::count()
- Đơn hôm nay: Order::whereDate('created_at', today())
- Doanh thu: Order::where('trangthai', 'Hoàn tất')->sum('tongtien')
- User mới: User::whereMonth('created_at', now()->month)
- Đơn hàng mới nhất: Order::latest()->take(5)
        ↓
views/admin/dashboard.blade.php
        ↓
- Cards thống kê
- Bảng đơn hàng mới
- Biểu đồ doanh thu (Chart.js)
```

#### 4. Báo cáo Doanh thu

```
[Admin] → GET /admin/reports
        ↓
Admin\ReportController@index
        ↓
- Lấy doanh thu theo ngày/tuần/tháng
- Group by ngày: Order::selectRaw('DATE(created_at) as date, SUM(tongtien) as total')
                       ->where('trangthai', 'Hoàn tất')
                       ->groupBy('date')
        ↓
views/admin/reports/index.blade.php
        ↓
- Bảng doanh thu theo thời gian
- Biểu đồ Line/Bar (Chart.js)
```

---

### 📖 Giải Thích Chi Tiết Code

#### File `app/Models/Comment.php`

| Thuộc tính/Hàm | Mục đích |
|----------------|----------|
| `$table = 'binhluan'` | Bảng bình luận |
| `user()` | Quan hệ N:1 với `user` |
| `product()` | Quan hệ N:1 với `monan` |
| `order()` | Quan hệ N:1 với `hoadon` |
| Trạng thái | 'Chờ duyệt', 'Đã duyệt', 'Bị ẩn' |

#### File `app/Http/Controllers/Admin/DashboardController.php`

| Hàm | Mục đích |
|-----|----------|
| `index()` | Tính toán và trả về dữ liệu thống kê |

#### Trạng thái Bình luận

| Giá trị | Ý nghĩa |
|---------|---------|
| `Chờ duyệt` | Mới gửi, chưa hiển thị |
| `Đã duyệt` | Hiển thị ở trang sản phẩm |
| `Bị ẩn` | Bị admin ẩn (vi phạm) |

---

### ⚙️ Hướng Dẫn Vận Hành & Kiểm Tra

#### Kiểm tra Bình luận:
1. Đặt hàng → Admin xác nhận → Hoàn tất
2. Vào chi tiết đơn hàng → Viết đánh giá
3. Kiểm tra bảng `binhluan` (trangthai = 'Chờ duyệt')
4. Admin duyệt → Xem ở trang chi tiết sản phẩm

#### Kiểm tra Tin tức:
1. Admin: `/admin/news` → Thêm bài viết
2. Frontend: `/news` → Xem danh sách
3. Click vào bài → Xem chi tiết, tăng lượt xem

#### Kiểm tra Dashboard:
1. Truy cập: `/admin/dashboard`
2. Kiểm tra số liệu với database
3. Biểu đồ hiển thị đúng dữ liệu

#### Điểm cần lưu ý:
- Bình luận cần được duyệt mới hiển thị
- Chỉ user đã mua mới được đánh giá
- Dashboard tính doanh thu từ đơn "Hoàn tất"

---

## 🔗 Liên Kết Giữa Các Phần Code

### Sơ Đồ Phụ Thuộc Module

```
┌─────────────────────────────────────────────────────────────┐
│                         LAYOUT                              │
│  (TV1: Header, Footer, Admin Sidebar, Auth Middleware)      │
└─────────────────────┬───────────────────────────────────────┘
                      │
        ┌─────────────┼─────────────┐
        ▼             ▼             ▼
┌───────────┐  ┌───────────┐  ┌───────────┐
│ PRODUCTS  │  │  ORDERS   │  │  CONTENT  │
│   (TV2)   │◄─┤   (TV3)   │─►│   (TV4)   │
└─────┬─────┘  └─────┬─────┘  └───────────┘
      │              │
      └──────┬───────┘
             ▼
      ┌─────────────┐
      │ Giỏ hàng    │
      │ Đánh giá    │
      └─────────────┘
```

### Luồng Dữ Liệu Chính

| Từ Module | Đến Module | Dữ liệu |
|-----------|------------|---------|
| Products (TV2) | Cart (TV3) | Thông tin SP khi thêm giỏ |
| Cart (TV3) | Orders (TV3) | Chi tiết giỏ → Chi tiết đơn |
| Orders (TV3) | Comments (TV4) | Đơn hoàn tất → Cho phép đánh giá |
| Comments (TV4) | Products (TV2) | Bình luận hiển thị ở chi tiết SP |
| Orders (TV3) | Dashboard (TV4) | Dữ liệu thống kê doanh thu |

### Xử Lý Khi Có Lỗi

| Lỗi phát sinh | Thành viên xử lý |
|---------------|------------------|
| Không đăng nhập được | TV1 |
| Sản phẩm không hiển thị | TV2 |
| Không thêm được giỏ hàng | TV3 |
| Đặt hàng thất bại | TV3 |
| Bình luận không gửi được | TV4 |
| Dashboard sai số liệu | TV4 |

---

## 📌 Ghi Chú Phục Vụ Bảo Vệ Đồ Án

### Phân Chia Trách Nhiệm Trả Lời

| Câu hỏi về | Người trả lời |
|------------|---------------|
| Đăng ký, đăng nhập, phân quyền | **TV1** |
| Cấu trúc bảng `user`, middleware | **TV1** |
| Sản phẩm, danh mục, topping | **TV2** |
| Upload hình ảnh, tìm kiếm | **TV2** |
| Giỏ hàng, thanh toán, đơn hàng | **TV3** |
| Trạng thái đơn, PTTT, PTVC | **TV3** |
| Bình luận, đánh giá sản phẩm | **TV4** |
| Thống kê, báo cáo doanh thu | **TV4** |

### Những Điểm Trọng Tâm Khi Bị Hỏi

1. **Về Database**: Nắm rõ cấu trúc bảng mình phụ trách, quan hệ với bảng khác
2. **Về Route**: Biết URL và phương thức HTTP (GET/POST) của từng chức năng
3. **Về Controller**: Giải thích được luồng xử lý trong từng hàm
4. **Về Model**: Hiểu các quan hệ (1:N, N:N), accessor, scope
5. **Về View**: Biết dữ liệu được truyền từ controller như thế nào

### Lưu Ý Khi Trình Bày

- **Mở đúng file** khi được hỏi về code
- **Chỉ đúng dòng** khi giải thích logic
- **Demo thực tế** kết hợp với giải thích code
- **Không trả lời chung chung**, luôn gắn với file cụ thể
- Nếu hỏi phần người khác → **"Phần này bạn [tên] phụ trách, xin mời bạn ấy trả lời"**

---

<p align="center"><em>📝 Tài liệu phân công nhóm - Cập nhật: 10/01/2026</em></p>
