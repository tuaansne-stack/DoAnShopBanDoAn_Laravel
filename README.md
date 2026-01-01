<h1 align="center">🍜 MyShop - Hệ Thống Bán Đồ Ăn Online</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.x-FF2D20?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-7.3+-777BB4?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat-square&logo=bootstrap" alt="Bootstrap">
</p>

---

## 📋 Mục Lục

1. [Tổng Quan](#1-tổng-quan)
2. [Chức Năng Hệ Thống](#2-chức-năng-hệ-thống)
3. [Sơ Đồ Usecase](#3-sơ-đồ-usecase)
4. [Thiết Kế CSDL](#4-thiết-kế-csdl)
5. [Quan Hệ Giữa Các Bảng](#5-quan-hệ-giữa-các-bảng)
6. [Sơ Đồ ERD](#6-sơ-đồ-erd)

---

## 1. Tổng Quan

| Thông tin | Chi tiết |
|-----------|----------|
| **Tên dự án** | MyShop - Food Ordering System |
| **Mô tả** | Website đặt đồ ăn online với quản lý đơn hàng |
| **Framework** | Laravel 8.x |
| **Database** | MySQL (19 bảng) |
| **Phân hệ** | Frontend (Khách hàng) + Backend (Admin) |

---

## 2. Chức Năng Hệ Thống

### 2.1 Phân Hệ Khách Hàng

| Module | Chức năng |
|--------|-----------|
| **Xác thực** | Đăng ký, Đăng nhập, Đăng xuất |
| **Sản phẩm** | Xem menu, Chi tiết món, Tìm kiếm, Chọn topping |
| **Giỏ hàng** | Thêm/Xóa/Cập nhật sản phẩm |
| **Đơn hàng** | Checkout, Xem đơn, Hủy đơn, Đặt lại |
| **Đánh giá** | Viết bình luận, Đánh giá sao |
| **Tài khoản** | Cập nhật profile, Đổi mật khẩu |
| **Nội dung** | Xem tin tức, Giới thiệu, Liên hệ |

### 2.2 Phân Hệ Quản Trị

| Module | Chức năng |
|--------|-----------|
| **Dashboard** | Thống kê tổng quan, Biểu đồ doanh thu |
| **Sản phẩm** | CRUD món ăn, Quản lý hình ảnh, Sản phẩm nổi bật |
| **Danh mục** | CRUD danh mục |
| **Topping** | CRUD topping |
| **Đơn hàng** | Xem/Cập nhật trạng thái, In đơn, Xuất Excel |
| **Người dùng** | CRUD users, Phân quyền (Admin/Staff/Customer) |
| **Bình luận** | Duyệt/Ẩn/Xóa bình luận |
| **Tin tức** | CRUD bài viết |
| **Giới thiệu** | CRUD nội dung about |
| **Cài đặt** | Logo, Thông tin shop, Mạng xã hội, PTTT, PTVC |

---

## 3. Sơ Đồ Usecase

### 3.1 Tổng Quan Hệ Thống

```mermaid
flowchart LR
    subgraph Actors
        KH((Khách hàng))
        AD((Admin))
    end

    subgraph UC_KH[Khách hàng]
        UC1[Đăng ký/Đăng nhập]
        UC2[Xem sản phẩm]
        UC3[Quản lý giỏ hàng]
        UC4[Đặt hàng]
        UC5[Đánh giá sản phẩm]
        UC6[Quản lý tài khoản]
    end

    subgraph UC_AD[Quản trị viên]
        UC7[Quản lý sản phẩm]
        UC8[Quản lý đơn hàng]
        UC9[Quản lý người dùng]
        UC10[Quản lý nội dung]
        UC11[Xem báo cáo]
        UC12[Cài đặt hệ thống]
    end

    KH --> UC1 & UC2 & UC3 & UC4 & UC5 & UC6
    AD --> UC7 & UC8 & UC9 & UC10 & UC11 & UC12
```

### 3.2 Quy Trình Đặt Hàng

```mermaid
flowchart LR
    A[Xem menu] --> B[Chọn món]
    B --> C[Thêm giỏ hàng]
    C --> D[Checkout]
    D --> E[Xác nhận đơn]
    E --> F{Trạng thái}
    F -->|Xác nhận| G[Đang giao]
    G --> H[Hoàn tất]
    F -->|Hủy| I[Đã hủy]
    H --> J[Đánh giá]
```

---

## 4. Thiết Kế CSDL

### 4.1 Danh Sách Bảng

| STT | Tên bảng | Mô tả | Quan hệ chính |
|:---:|----------|-------|---------------|
| 1 | `user` | Người dùng | 1-N với giohang, hoadon, binhluan |
| 2 | `danhmuc` | Danh mục | 1-N với monan |
| 3 | `monan` | Sản phẩm | 1-N với images, N-N với topping |
| 4 | `product_images` | Hình ảnh SP | N-1 với monan |
| 5 | `topping` | Topping | N-N với monan, giohang, chitiethoadon |
| 6 | `giohang` | Giỏ hàng | N-1 với user, monan |
| 7 | `hoadon` | Đơn hàng | N-1 với user, 1-N với chitiethoadon |
| 8 | `chitiethoadon` | Chi tiết đơn | N-1 với hoadon, monan |
| 9 | `binhluan` | Bình luận | N-1 với user, monan |
| 10 | `tintuc` | Tin tức | Độc lập |
| 11 | `gioithieu` | Giới thiệu | Độc lập |
| 12 | `quantri` | Cài đặt | Độc lập |
| 13 | `phuongthucthanhtoan` | PTTT | 1-N với hoadon |
| 14 | `phuongthucvanchuyen` | PTVC | 1-N với hoadon |
| 15 | `thongtinthanhtoan` | Thông tin bank | N-1 với PTTT |
| 16 | `lichsudonhang` | Lịch sử đơn | N-1 với hoadon |

### 4.2 Cấu Trúc Bảng Chính

#### Bảng `user`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT PK | ID người dùng |
| hoten | VARCHAR(100) | Họ tên |
| email | VARCHAR(100) | Email (unique) |
| password | VARCHAR | Mật khẩu |
| is_admin | TINYINT | 0=Khách, 1=Admin, 2=Staff |
| trangthai | VARCHAR(50) | Hoạt động / Khóa |

#### Bảng `monan`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT PK | ID sản phẩm |
| tenmon | VARCHAR(100) | Tên món |
| gia | INT | Giá hiện tại |
| giacu | INT | Giá cũ |
| danhmuc_id | BIGINT FK | ID danh mục |
| trangthai | VARCHAR(50) | Đang bán / Hết hàng |
| noibat | BOOLEAN | Sản phẩm nổi bật |

#### Bảng `hoadon`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT PK | ID đơn hàng |
| user_id | BIGINT FK | ID khách hàng |
| tongtien | DECIMAL(12,2) | Tổng tiền |
| diachi_giaohang | VARCHAR(255) | Địa chỉ giao |
| trangthai | ENUM | Chờ xác nhận → Hoàn tất / Đã hủy |
| pttt_id | BIGINT FK | Phương thức thanh toán |
| ptvc_id | BIGINT FK | Phương thức vận chuyển |
| dathanhtoan | BOOLEAN | Đã thanh toán |

#### Bảng `chitiethoadon`
| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | BIGINT PK | ID chi tiết |
| hoadon_id | BIGINT FK | ID đơn hàng |
| monan_id | BIGINT FK | ID sản phẩm |
| soluong | INT | Số lượng |
| gia | DECIMAL(10,2) | Đơn giá |

---

## 5. Sơ Đồ Quan Hệ Giữa Các Bảng

### 5.1 Sơ Đồ Quan Hệ (Crow's Foot Notation)

```mermaid
erDiagram
    USER ||--o{ GIOHANG : "1:N có"
    USER ||--o{ HOADON : "1:N đặt"
    USER ||--o{ BINHLUAN : "1:N viết"

    DANHMUC ||--o{ MONAN : "1:N chứa"

    MONAN ||--o{ PRODUCT_IMAGES : "1:N có"
    MONAN ||--o{ GIOHANG : "1:N trong"
    MONAN ||--o{ CHITIETHOADON : "1:N trong"
    MONAN ||--o{ BINHLUAN : "1:N có"
    MONAN }o--o{ TOPPING : "N:N thêm"

    HOADON ||--o{ CHITIETHOADON : "1:N gồm"
    HOADON ||--o{ LICHSUDONHANG : "1:N có"

    PHUONGTHUCTHANHTOAN ||--o{ HOADON : "1:N dùng"
    PHUONGTHUCTHANHTOAN ||--o{ THONGTINTHANHTOAN : "1:N có"
    PHUONGTHUCVANCHUYEN ||--o{ HOADON : "1:N dùng"

    GIOHANG }o--o{ TOPPING : "N:N chọn"
    CHITIETHOADON }o--o{ TOPPING : "N:N có"
```

> **Chú thích ký hiệu:**
> - `||--o{` = Quan hệ **1:N** (One-to-Many)
> - `}o--o{` = Quan hệ **N:N** (Many-to-Many)

### 5.2 Sơ Đồ Chi Tiết Theo Nhóm

```mermaid
erDiagram
    %% === USER MODULE ===
    USER {
        bigint id PK
        varchar hoten
        varchar email UK
        varchar password
        tinyint is_admin
    }

    %% === PRODUCT MODULE ===
    DANHMUC {
        bigint id PK
        varchar ten_danhmuc
    }

    MONAN {
        bigint id PK
        varchar tenmon
        int gia
        bigint danhmuc_id FK
        boolean noibat
    }

    TOPPING {
        bigint id PK
        varchar tentopping
        decimal gia
    }

    %% === ORDER MODULE ===
    GIOHANG {
        bigint id PK
        bigint user_id FK
        bigint monan_id FK
        int soluong
    }

    HOADON {
        bigint id PK
        bigint user_id FK
        decimal tongtien
        enum trangthai
        bigint pttt_id FK
        bigint ptvc_id FK
    }

    CHITIETHOADON {
        bigint id PK
        bigint hoadon_id FK
        bigint monan_id FK
        int soluong
        decimal gia
    }

    %% === RELATIONSHIPS ===
    USER ||--o{ GIOHANG : "has"
    USER ||--o{ HOADON : "places"
    DANHMUC ||--o{ MONAN : "contains"
    MONAN ||--o{ GIOHANG : "in"
    MONAN ||--o{ CHITIETHOADON : "ordered"
    MONAN }o--o{ TOPPING : "has"
    HOADON ||--o{ CHITIETHOADON : "includes"
    GIOHANG }o--o{ TOPPING : "selects"
    CHITIETHOADON }o--o{ TOPPING : "with"
```

---

## 6. Sơ Đồ ERD

### 6.1 Sơ Đồ Quan Hệ Tổng Thể

```mermaid
erDiagram
    user ||--o{ giohang : "1:N"
    user ||--o{ hoadon : "1:N"
    user ||--o{ binhluan : "1:N"

    danhmuc ||--o{ monan : "1:N"

    monan ||--o{ product_images : "1:N"
    monan ||--o{ giohang : "1:N"
    monan ||--o{ chitiethoadon : "1:N"
    monan ||--o{ binhluan : "1:N"
    monan }o--o{ topping : "N:N"

    hoadon ||--o{ chitiethoadon : "1:N"
    hoadon ||--o{ lichsudonhang : "1:N"
    hoadon }o--|| phuongthucthanhtoan : "N:1"
    hoadon }o--|| phuongthucvanchuyen : "N:1"

    phuongthucthanhtoan ||--o{ thongtinthanhtoan : "1:N"

    giohang }o--o{ topping : "N:N"
    chitiethoadon }o--o{ topping : "N:N"

    user {
        bigint id PK
        string hoten
        string email
        string password
        int is_admin
    }

    danhmuc {
        bigint id PK
        string ten_danhmuc
    }

    monan {
        bigint id PK
        string tenmon
        int gia
        bigint danhmuc_id FK
    }

    hoadon {
        bigint id PK
        bigint user_id FK
        decimal tongtien
        enum trangthai
        bigint pttt_id FK
        bigint ptvc_id FK
    }

    chitiethoadon {
        bigint id PK
        bigint hoadon_id FK
        bigint monan_id FK
        int soluong
    }

    binhluan {
        bigint id PK
        bigint monan_id FK
        bigint user_id FK
        int danhgia
    }

    topping {
        bigint id PK
        string tentopping
        decimal gia
    }
```

### 6.2 Sơ Đồ Nhóm Theo Module

```mermaid
graph TB
    subgraph USER["👤 User Module"]
        A[user]
    end

    subgraph PRODUCT["🍕 Product Module"]
        B[danhmuc]
        C[monan]
        D[product_images]
        E[topping]
    end

    subgraph ORDER["📦 Order Module"]
        F[giohang]
        G[hoadon]
        H[chitiethoadon]
        I[lichsudonhang]
    end

    subgraph PAYMENT["💳 Payment Module"]
        J[phuongthucthanhtoan]
        K[phuongthucvanchuyen]
        L[thongtinthanhtoan]
    end

    subgraph CONTENT["📰 Content Module"]
        M[binhluan]
        N[tintuc]
        O[gioithieu]
        P[quantri]
    end

    A -->|1:N| F
    A -->|1:N| G
    A -->|1:N| M

    B -->|1:N| C
    C -->|1:N| D
    C -->|N:N| E
    C -->|1:N| F
    C -->|1:N| H
    C -->|1:N| M

    G -->|1:N| H
    G -->|1:N| I
    G -->|N:1| J
    G -->|N:1| K

    J -->|1:N| L
```

---

## 7. Công Nghệ

| Thành phần | Công nghệ |
|------------|-----------|
| Backend | Laravel 8, PHP 7.3+ |
| Database | MySQL 5.7+ |
| Frontend | Blade, Bootstrap 5 |
| Charts | Chart.js |
| Server | Apache (XAMPP) |

---

<p align="center"><em>📝 Tài liệu cập nhật: 01/01/2026</em></p>
