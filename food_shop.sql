/*
 Navicat Premium Data Transfer

 Source Server         : Tuaans
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : food_shop

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 01/01/2026 22:15:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for binhluan
-- ----------------------------
DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE `binhluan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `monan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `hoadon_id` bigint UNSIGNED NULL DEFAULT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `danhgia` int NOT NULL,
  `ngaytao` datetime NOT NULL DEFAULT current_timestamp,
  `trangthai` enum('Chờ duyệt','Đã duyệt','Bị ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ duyệt',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `binhluan_monan_id_foreign`(`monan_id` ASC) USING BTREE,
  INDEX `binhluan_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `binhluan_hoadon_id_foreign`(`hoadon_id` ASC) USING BTREE,
  CONSTRAINT `binhluan_hoadon_id_foreign` FOREIGN KEY (`hoadon_id`) REFERENCES `hoadon` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `binhluan_monan_id_foreign` FOREIGN KEY (`monan_id`) REFERENCES `monan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `binhluan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of binhluan
-- ----------------------------

-- ----------------------------
-- Table structure for chitiethoadon
-- ----------------------------
DROP TABLE IF EXISTS `chitiethoadon`;
CREATE TABLE `chitiethoadon`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hoadon_id` bigint UNSIGNED NULL DEFAULT NULL,
  `monan_id` bigint UNSIGNED NULL DEFAULT NULL,
  `soluong` int NULL DEFAULT NULL,
  `gia` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `chitiethoadon_hoadon_id_foreign`(`hoadon_id` ASC) USING BTREE,
  INDEX `chitiethoadon_monan_id_foreign`(`monan_id` ASC) USING BTREE,
  CONSTRAINT `chitiethoadon_hoadon_id_foreign` FOREIGN KEY (`hoadon_id`) REFERENCES `hoadon` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `chitiethoadon_monan_id_foreign` FOREIGN KEY (`monan_id`) REFERENCES `monan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chitiethoadon
-- ----------------------------

-- ----------------------------
-- Table structure for chitiethoadon_topping
-- ----------------------------
DROP TABLE IF EXISTS `chitiethoadon_topping`;
CREATE TABLE `chitiethoadon_topping`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `chitiethoadon_id` bigint UNSIGNED NOT NULL,
  `topping_id` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL DEFAULT 1,
  `gia` decimal(12, 0) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `chitiethoadon_topping_chitiethoadon_id_foreign`(`chitiethoadon_id` ASC) USING BTREE,
  INDEX `chitiethoadon_topping_topping_id_foreign`(`topping_id` ASC) USING BTREE,
  CONSTRAINT `chitiethoadon_topping_chitiethoadon_id_foreign` FOREIGN KEY (`chitiethoadon_id`) REFERENCES `chitiethoadon` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `chitiethoadon_topping_topping_id_foreign` FOREIGN KEY (`topping_id`) REFERENCES `topping` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chitiethoadon_topping
-- ----------------------------

-- ----------------------------
-- Table structure for danhmuc
-- ----------------------------
DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE `danhmuc`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_danhmuc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of danhmuc
-- ----------------------------
INSERT INTO `danhmuc` VALUES (1, '🥘 MÓN CHÍNH', NULL, '2025-12-31 01:08:49', '2025-12-31 01:08:49');
INSERT INTO `danhmuc` VALUES (2, '🍰 BÁNH & TRÁNG MIỆNG', NULL, '2025-12-31 01:08:58', '2025-12-31 01:08:58');
INSERT INTO `danhmuc` VALUES (3, '🧃 ĐỒ UỐNG – GIẢI KHÁT', NULL, '2025-12-31 01:09:07', '2025-12-31 01:09:07');
INSERT INTO `danhmuc` VALUES (4, '🍗 GÀ & MÓN CHIÊN', NULL, '2025-12-31 01:09:18', '2025-12-31 01:09:18');
INSERT INTO `danhmuc` VALUES (5, '🍔 ĐỒ ĂN NHANH', NULL, '2025-12-31 01:09:28', '2025-12-31 01:09:28');

-- ----------------------------
-- Table structure for giohang
-- ----------------------------
DROP TABLE IF EXISTS `giohang`;
CREATE TABLE `giohang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `monan_id` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL DEFAULT 1,
  `ngay_them` datetime NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `giohang_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `giohang_monan_id_foreign`(`monan_id` ASC) USING BTREE,
  CONSTRAINT `giohang_monan_id_foreign` FOREIGN KEY (`monan_id`) REFERENCES `monan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `giohang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of giohang
-- ----------------------------

-- ----------------------------
-- Table structure for giohang_topping
-- ----------------------------
DROP TABLE IF EXISTS `giohang_topping`;
CREATE TABLE `giohang_topping`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `giohang_id` bigint UNSIGNED NOT NULL,
  `topping_id` bigint UNSIGNED NOT NULL,
  `soluong` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `giohang_topping_giohang_id_foreign`(`giohang_id` ASC) USING BTREE,
  INDEX `giohang_topping_topping_id_foreign`(`topping_id` ASC) USING BTREE,
  CONSTRAINT `giohang_topping_giohang_id_foreign` FOREIGN KEY (`giohang_id`) REFERENCES `giohang` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `giohang_topping_topping_id_foreign` FOREIGN KEY (`topping_id`) REFERENCES `topping` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of giohang_topping
-- ----------------------------

-- ----------------------------
-- Table structure for gioithieu
-- ----------------------------
DROP TABLE IF EXISTS `gioithieu`;
CREATE TABLE `gioithieu`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tieude` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `thutu` int NOT NULL DEFAULT 0,
  `trangthai` enum('Hiện','Ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hiện',
  `ngaytao` datetime NOT NULL DEFAULT current_timestamp,
  `ngaycapnhat` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gioithieu
-- ----------------------------
INSERT INTO `gioithieu` VALUES (2, '🥘 GIỚI THIỆU CHUNG', '<p style=\"color:#333333\">\r\nCHÀO MỪNG BẠN ĐẾN VỚI <strong>PANTHER PINK</strong> – NƠI HỘI TỤ NHỮNG MÓN ĂN NGON, ĐẬM VỊ VÀ LUÔN ĐƯỢC CHẾ BIẾN TỪ NGUYÊN LIỆU TƯƠI MỚI MỖI NGÀY.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nCHÚNG TÔI MANG ĐẾN THỰC ĐƠN ĐA DẠNG TỪ MÓN ĂN VẶT, MÓN CHÍNH ĐẾN ĐỒ UỐNG GIẢI KHÁT, PHÙ HỢP CHO MỌI BỮA ĂN TRONG NGÀY.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\n<PANTHER PINK</strong> KHÔNG CHỈ BÁN ĐỒ ĂN, MÀ CÒN GỬI GẮM SỰ TẬN TÂM VÀ CHẤT LƯỢNG TRONG TỪNG MÓN. GHÉ THỬ MỘT LẦN, ĐẢM BẢO GHIỀN DÀI LÂU!\r\n</p>\r\n\r\n<p style=\"color:#555555\">\r\n📞 HOTLINE: <strong>0866 468 126</strong><br>\r\n📧 EMAIL: <strong>julyasiin@gmail.com</strong>\r\n</p>', 'about/about_695422b99e725.png', 1, 'Hiện', '2025-12-31 02:04:57', '2025-12-31 02:06:33', '2025-12-31 02:04:57', '2025-12-31 02:06:33');
INSERT INTO `gioithieu` VALUES (3, '🔥 THU HÚT KHÁCH HÀNG', '<p style=\"color:#333333\">\r\nBẠN ĐANG ĐÓI? ĐỪNG LO, <strong>PANTHER PINK</strong> ĐÃ SẴN SÀNG PHỤC VỤ! 🍔🍟\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nTẠI ĐÂY, BẠN SẼ TÌM THẤY NHỮNG MÓN ĂN NGON – NÓNG – CHUẨN VỊ, ĐƯỢC CHẾ BIẾN NHANH CHÓNG NHƯNG VẪN ĐẢM BẢO CHẤT LƯỢNG.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nGIÁ CẢ HỢP LÝ, KHẨU PHẦN ĐẦY ĐẶN, HƯƠNG VỊ DỄ ĂN – ĐÓ CHÍNH LÀ LÝ DO KHÁCH HÀNG LUÔN QUAY LẠI VỚI <strong>PANTHER PINK</strong>.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nĐẶT MÓN NGAY HÔM NAY ĐỂ CẢM NHẬN SỰ KHÁC BIỆT!\r\n</p>\r\n\r\n<p style=\"color:#555555\">\r\n📞 HOTLINE: <strong>0866 468 126</strong> | 📧 <strong>julyasiin@gmail.com</strong>\r\n</p>', 'about/about_695422ee42e5f.png', 2, 'Hiện', '2025-12-31 02:07:26', '2025-12-31 02:07:26', '2025-12-31 02:07:26', '2025-12-31 02:07:26');
INSERT INTO `gioithieu` VALUES (4, '💖 GẦN GŨI, THÂN THIỆN', '<p style=\"color:#333333\">\r\n<strong>PANTHER PINK</strong> RA ĐỜI VỚI MONG MUỐN MANG ĐẾN CHO BẠN NHỮNG BỮA ĂN NGON MIỆNG, TIỆN LỢI VÀ ĐẦY CẢM HỨNG.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nDÙ LÀ BỮA TRƯA VỘI VÀNG HAY BUỔI TỐI TỤ TẬP CÙNG BẠN BÈ, CHÚNG TÔI LUÔN CÓ NHỮNG MÓN ĂN PHÙ HỢP ĐỂ BẠN LỰA CHỌN.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nĂN NGON – ĂN VUI – ĂN LÀ NHỚ, ĐÓ CHÍNH LÀ TINH THẦN MÀ <strong>PANTHER PINK</strong> MUỐN GỬI ĐẾN BẠN MỖI NGÀY.\r\n</p>\r\n\r\n<p style=\"color:#555555\">\r\n📞 HOTLINE: <strong>0866 468 126</strong><br>\r\n📧 EMAIL: <strong>julyasiin@gmail.com</strong>\r\n</p>', 'about/about_6954230c68f71.png', 3, 'Hiện', '2025-12-31 02:07:56', '2025-12-31 02:07:56', '2025-12-31 02:07:56', '2025-12-31 02:07:56');

-- ----------------------------
-- Table structure for hoadon
-- ----------------------------
DROP TABLE IF EXISTS `hoadon`;
CREATE TABLE `hoadon`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `tongtien` decimal(12, 2) NULL DEFAULT NULL,
  `ghichu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `diachi_giaohang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` enum('Chờ xác nhận','Đã xác nhận','Đang giao','Hoàn tất','Đã hủy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ xác nhận',
  `ngaylap` datetime NOT NULL DEFAULT current_timestamp,
  `pttt_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ptvc_id` bigint UNSIGNED NULL DEFAULT NULL,
  `dathanhtoan` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Trạng thái thanh toán (0: chưa thanh toán, 1: đã thanh toán)',
  `ma_giaodich` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Mã giao dịch thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `hoadon_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `hoadon_pttt_id_foreign`(`pttt_id` ASC) USING BTREE,
  INDEX `hoadon_ptvc_id_foreign`(`ptvc_id` ASC) USING BTREE,
  CONSTRAINT `hoadon_pttt_id_foreign` FOREIGN KEY (`pttt_id`) REFERENCES `phuongthucthanhtoan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `hoadon_ptvc_id_foreign` FOREIGN KEY (`ptvc_id`) REFERENCES `phuongthucvanchuyen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `hoadon_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hoadon
-- ----------------------------

-- ----------------------------
-- Table structure for lichsudonhang
-- ----------------------------
DROP TABLE IF EXISTS `lichsudonhang`;
CREATE TABLE `lichsudonhang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hoadon_id` bigint UNSIGNED NOT NULL,
  `trang_thai_cu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `trang_thai_moi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_thay_doi` datetime NOT NULL DEFAULT current_timestamp,
  `nguoi_thay_doi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ghi_chu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `lichsudonhang_hoadon_id_foreign`(`hoadon_id` ASC) USING BTREE,
  CONSTRAINT `lichsudonhang_hoadon_id_foreign` FOREIGN KEY (`hoadon_id`) REFERENCES `hoadon` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lichsudonhang
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2024_01_01_000000_modify_users_table', 1);
INSERT INTO `migrations` VALUES (4, '2024_01_01_000001_create_danhmuc_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_01_01_000002_create_quantri_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_01_01_000003_create_phuongthucthanhtoan_table', 1);
INSERT INTO `migrations` VALUES (7, '2024_01_01_000004_create_phuongthucvanchuyen_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_01_01_000005_create_monan_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_01_01_000006_create_giohang_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_01_01_000007_create_hoadon_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_01_01_000008_create_chitiethoadon_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_01_01_000009_create_binhluan_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_01_01_000010_create_tintuc_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_01_01_000011_create_gioithieu_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_01_01_000012_create_thongtinthanhtoan_table', 1);
INSERT INTO `migrations` VALUES (16, '2024_01_01_000013_create_lichsudonhang_table', 1);
INSERT INTO `migrations` VALUES (17, '2024_01_01_000014_create_thongke_doanhthu_table', 1);
INSERT INTO `migrations` VALUES (18, '2025_12_07_191502_add_hoadon_id_to_binhluan_table', 1);
INSERT INTO `migrations` VALUES (19, '2025_12_27_000001_create_product_images_table', 1);
INSERT INTO `migrations` VALUES (20, '2025_12_30_085018_remove_hinhanh_from_danhmuc_table', 1);
INSERT INTO `migrations` VALUES (21, '2025_12_30_091612_add_remember_token_to_user_table', 1);
INSERT INTO `migrations` VALUES (22, '2025_12_30_110639_create_topping_table', 1);
INSERT INTO `migrations` VALUES (23, '2025_12_30_110718_create_monan_topping_table', 1);
INSERT INTO `migrations` VALUES (24, '2025_12_30_110735_create_chitiethoadon_topping_table', 1);
INSERT INTO `migrations` VALUES (25, '2025_12_30_120554_create_giohang_topping_table', 1);
INSERT INTO `migrations` VALUES (26, '2025_12_30_185000_update_quantri_social_links', 1);
INSERT INTO `migrations` VALUES (27, '2025_12_30_185830_add_tiktok_to_quantri', 1);
INSERT INTO `migrations` VALUES (28, '2025_12_31_012437_drop_hinhanh_from_monan_table', 2);
INSERT INTO `migrations` VALUES (29, '2024_12_31_000001_add_noibat_to_tintuc_table', 3);

-- ----------------------------
-- Table structure for monan
-- ----------------------------
DROP TABLE IF EXISTS `monan`;
CREATE TABLE `monan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tenmon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `gia` int NOT NULL,
  `giacu` int NULL DEFAULT NULL,
  `danhmuc_id` bigint UNSIGNED NULL DEFAULT NULL,
  `trangthai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Đang bán' COMMENT 'Trạng thái món ăn (Đang bán, Hết hàng, Ngừng kinh doanh)',
  `noibat` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Đánh dấu món ăn nổi bật (0: Không, 1: Có)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `monan_danhmuc_id_foreign`(`danhmuc_id` ASC) USING BTREE,
  CONSTRAINT `monan_danhmuc_id_foreign` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of monan
-- ----------------------------
INSERT INTO `monan` VALUES (1, 'Trà Đào Cam Sả', '<p style=\"color: #333333;\">TR&Agrave; Đ&Agrave;O CAM SẢ L&Agrave; THỨC UỐNG GIẢI KH&Aacute;T THANH M&Aacute;T VỚI KẾT CẤU TR&Agrave; TRONG VỊ, KẾT HỢP HƯƠNG THƠM TỰ NHI&Ecirc;N CỦA SẢ, VỊ CHUA NGỌT H&Agrave;I H&Ograve;A TỪ CAM TƯƠI V&Agrave; Đ&Agrave;O NG&Acirc;M, MANG LẠI CẢM GI&Aacute;C SẢNG KHO&Aacute;I, DỄ UỐNG, PH&Ugrave; HỢP CHO MỌI ĐỐI TƯỢNG TỪ HỌC SINH, NH&Acirc;N VI&Ecirc;N VĂN PH&Ograve;NG ĐẾN KH&Aacute;CH GIẢI NHIỆT NG&Agrave;Y NẮNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>HƯƠNG VỊ CHUA NGỌT DỄ UỐNG</strong></li>\r\n<li><strong>M&Ugrave;I SẢ THƠM TỰ NHI&Ecirc;N, DỄ CHỊU</strong></li>\r\n<li><strong>TR&Agrave; THANH, KH&Ocirc;NG GẮT</strong></li>\r\n<li><strong>GIẢI KH&Aacute;T HIỆU QUẢ</strong></li>\r\n<li><strong>PH&Ugrave; HỢP NHIỀU ĐỘ TUỔI</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>TR&Agrave; ĐEN HOẶC TR&Agrave; LỤC</td>\r\n<td>200 ML</td>\r\n</tr>\r\n<tr>\r\n<td>Đ&Agrave;O NG&Acirc;M</td>\r\n<td>40&ndash;50 G</td>\r\n</tr>\r\n<tr>\r\n<td>NƯỚC CAM TƯƠI</td>\r\n<td>20&ndash;30 ML</td>\r\n</tr>\r\n<tr>\r\n<td>SẢ TƯƠI ĐẬP DẬP</td>\r\n<td>1&ndash;2 C&Acirc;Y</td>\r\n</tr>\r\n<tr>\r\n<td>ĐƯỜNG HOẶC SYRUP</td>\r\n<td>20&ndash;25 ML</td>\r\n</tr>\r\n</tbody>\r\n</table>', 25000, 30000, 3, 'Đang bán', 0, '2025-12-31 01:11:51', '2025-12-31 01:14:56');
INSERT INTO `monan` VALUES (2, 'Trà Sữa', '<p style=\"color: #333333;\">TR&Agrave; SỮA L&Agrave; THỨC UỐNG ĐƯỢC Y&Ecirc;U TH&Iacute;CH RỘNG R&Atilde;I VỚI NỀN TR&Agrave; ĐẬM VỊ KẾT HỢP C&Ugrave;NG SỮA B&Eacute;O THƠM, VỊ NGỌT VỪA PHẢI, MỊN M&Agrave;NG DỄ UỐNG, MANG ĐẾN CẢM GI&Aacute;C THƯ GI&Atilde;N, NĂNG ĐỘNG, PH&Ugrave; HỢP CHO HỌC SINH, SINH VI&Ecirc;N, NH&Acirc;N VI&Ecirc;N VĂN PH&Ograve;NG V&Agrave; NHỮNG AI Y&Ecirc;U TH&Iacute;CH ĐỒ UỐNG NGỌT B&Eacute;O.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>VỊ B&Eacute;O NGỌT H&Agrave;I H&Ograve;A, DỄ UỐNG</strong></li>\r\n<li><strong>TR&Agrave; ĐẬM Đ&Agrave;, KH&Ocirc;NG GẮT</strong></li>\r\n<li><strong>SỮA THƠM, MỊN M&Agrave;NG</strong></li>\r\n<li><strong>C&Oacute; THỂ KẾT HỢP NHIỀU LOẠI TOPPING</strong></li>\r\n<li><strong>PH&Ugrave; HỢP NHIỀU ĐỘ TUỔI</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>TR&Agrave; ĐEN HOẶC TR&Agrave; LỤC</td>\r\n<td>180&ndash;200 ML</td>\r\n</tr>\r\n<tr>\r\n<td>SỮA TƯƠI HOẶC BỘT SỮA</td>\r\n<td>30&ndash;40 ML</td>\r\n</tr>\r\n<tr>\r\n<td>ĐƯỜNG HOẶC SYRUP</td>\r\n<td>20&ndash;25 ML</td>\r\n</tr>\r\n<tr>\r\n<td>TOPPING (TR&Acirc;N CH&Acirc;U, THẠCH&hellip;)</td>\r\n<td>T&Ugrave;Y CHỌN</td>\r\n</tr>\r\n</tbody>\r\n</table>', 30000, 35000, 3, 'Đang bán', 0, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `monan` VALUES (3, 'Trà Chanh', '<p style=\"color: #333333;\">TR&Agrave; CHANH L&Agrave; THỨC UỐNG GIẢI KH&Aacute;T PHỔ BIẾN VỚI NỀN TR&Agrave; THANH M&Aacute;T KẾT HỢP VỊ CHUA TƯƠI TỰ NHI&Ecirc;N TỪ CHANH, HẬU VỊ NGỌT NHẸ DỄ UỐNG, MANG LẠI CẢM GI&Aacute;C SẢNG KHO&Aacute;I, GIẢI NHIỆT TỨC TH&Igrave;, PH&Ugrave; HỢP CHO HỌC SINH, SINH VI&Ecirc;N, NH&Acirc;N VI&Ecirc;N VĂN PH&Ograve;NG V&Agrave; KH&Aacute;CH GIẢI KH&Aacute;T NG&Agrave;Y NẮNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>VỊ CHUA NGỌT THANH M&Aacute;T, DỄ UỐNG</strong></li>\r\n<li><strong>HƯƠNG CHANH TƯƠI TỰ NHI&Ecirc;N</strong></li>\r\n<li><strong>TR&Agrave; THANH, KH&Ocirc;NG ĐẮNG GẮT</strong></li>\r\n<li><strong>GIẢI KH&Aacute;T, GIẢI NHIỆT HIỆU QUẢ</strong></li>\r\n<li><strong>PH&Ugrave; HỢP NHIỀU ĐỘ TUỔI</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>TR&Agrave; ĐEN HOẶC TR&Agrave; LỤC</td>\r\n<td>200 ML</td>\r\n</tr>\r\n<tr>\r\n<td>NƯỚC CỐT CHANH TƯƠI</td>\r\n<td>20&ndash;30 ML</td>\r\n</tr>\r\n<tr>\r\n<td>ĐƯỜNG HOẶC SYRUP</td>\r\n<td>20&ndash;25 ML</td>\r\n</tr>\r\n<tr>\r\n<td>CHANH L&Aacute;T TRANG TR&Iacute;</td>\r\n<td>1&ndash;2 L&Aacute;T</td>\r\n</tr>\r\n</tbody>\r\n</table>', 15000, 20000, 3, 'Đang bán', 1, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `monan` VALUES (4, 'Bánh Bông Lan', '<p style=\"color: #333333;\">B&Aacute;NH B&Ocirc;NG LAN L&Agrave; M&Oacute;N B&Aacute;NH NGỌT MỀM XỐP, THƠM NHẸ M&Ugrave;I TRỨNG SỮA, KẾT CẤU B&Ocirc;NG NHẸ, TAN NHẸ TRONG MIỆNG, VỊ NGỌT VỪA PHẢI DỄ ĂN, PH&Ugrave; HỢP L&Agrave;M BỮA ĂN NHẸ, TR&Aacute;NG MIỆNG HOẶC D&Ugrave;NG K&Egrave;M TR&Agrave;, C&Agrave; PH&Ecirc; CHO MỌI ĐỘ TUỔI.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>KẾT CẤU MỀM XỐP, B&Ocirc;NG NHẸ</strong></li>\r\n<li><strong>VỊ NGỌT DỊU, DỄ ĂN</strong></li>\r\n<li><strong>M&Ugrave;I THƠM TRỨNG SỮA TỰ NHI&Ecirc;N</strong></li>\r\n<li><strong>KH&Ocirc;NG NG&Aacute;N, PH&Ugrave; HỢP MỌI LỨA TUỔI</strong></li>\r\n<li><strong>TH&Iacute;CH HỢP D&Ugrave;NG K&Egrave;M ĐỒ UỐNG</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>BỘT M&Igrave; ĐA DỤNG</td>\r\n<td>100 G</td>\r\n</tr>\r\n<tr>\r\n<td>TRỨNG G&Agrave;</td>\r\n<td>3&ndash;4 QUẢ</td>\r\n</tr>\r\n<tr>\r\n<td>ĐƯỜNG</td>\r\n<td>80&ndash;100 G</td>\r\n</tr>\r\n<tr>\r\n<td>SỮA TƯƠI HOẶC BƠ LẠT</td>\r\n<td>30&ndash;40 ML</td>\r\n</tr>\r\n</tbody>\r\n</table>', 25000, NULL, 2, 'Đang bán', 1, '2025-12-31 01:20:26', '2025-12-31 01:22:46');
INSERT INTO `monan` VALUES (5, 'Bánh Kem RosyLow', '<p style=\"color: #333333;\">B&Aacute;NH KEM ROSY LOW L&Agrave; D&Ograve;NG B&Aacute;NH KEM &Iacute;T NGỌT HIỆN ĐẠI VỚI CỐT B&Aacute;NH B&Ocirc;NG LAN MỀM MỊN KẾT HỢP LỚP KEM ROSY B&Eacute;O NHẸ, NGỌT DỊU, KH&Ocirc;NG G&Acirc;Y NG&Aacute;N, PH&Ugrave; HỢP CHO NGƯỜI ĂN KI&Ecirc;NG ĐƯỜNG NHẸ, TRẺ EM V&Agrave; NGƯỜI LỚN TUỔI, TH&Iacute;CH HỢP D&Ugrave;NG TRONG SINH NHẬT, TIỆC NHẸ HOẶC L&Agrave;M QU&Agrave; TẶNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>KEM &Iacute;T NGỌT, B&Eacute;O NHẸ DỄ ĂN</strong></li>\r\n<li><strong>CỐT B&Aacute;NH MỀM, ẨM MỊN</strong></li>\r\n<li><strong>HƯƠNG VỊ THANH NHẸ, KH&Ocirc;NG G&Acirc;Y NG&Aacute;N</strong></li>\r\n<li><strong>PH&Ugrave; HỢP NGƯỜI ĂN KI&Ecirc;NG ĐƯỜNG NHẸ</strong></li>\r\n<li><strong>TH&Iacute;CH HỢP NHIỀU DỊP SỬ DỤNG</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>CỐT B&Aacute;NH B&Ocirc;NG LAN</td>\r\n<td>1 LỚP</td>\r\n</tr>\r\n<tr>\r\n<td>KEM ROSY &Iacute;T NGỌT</td>\r\n<td>150&ndash;200 G</td>\r\n</tr>\r\n<tr>\r\n<td>ĐƯỜNG &Iacute;T CALO HOẶC ĐƯỜNG GIẢM</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n<tr>\r\n<td>TR&Aacute;I C&Acirc;Y TRANG TR&Iacute;</td>\r\n<td>T&Ugrave;Y CHỌN</td>\r\n</tr>\r\n</tbody>\r\n</table>', 45000, NULL, 2, 'Đang bán', 0, '2025-12-31 01:21:21', '2025-12-31 01:22:55');
INSERT INTO `monan` VALUES (6, 'Bún Bò Huế', '<p style=\"color: #333333;\">B&Uacute;N B&Ograve; HUẾ L&Agrave; M&Oacute;N ĂN ĐẶC SẢN NỔI TIẾNG VỚI NƯỚC D&Ugrave;NG ĐẬM Đ&Agrave;, CAY NHẸ ĐẶC TRƯNG, HẦM TỪ XƯƠNG B&Ograve; KẾT HỢP SẢ V&Agrave; MẮM RUỐC HUẾ, SỢI B&Uacute;N TO DAI MỀM, THỊT B&Ograve; V&Agrave; GI&Ograve; HEO THƠM NGỌT, MANG ĐẾN HƯƠNG VỊ MẠNH MẼ, K&Iacute;CH TH&Iacute;CH VỊ GI&Aacute;C, PH&Ugrave; HỢP CHO BỮA S&Aacute;NG HOẶC BỮA CH&Iacute;NH ĐẬM CHẤT ẨM THỰC MIỀN TRUNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>NƯỚC D&Ugrave;NG ĐẬM Đ&Agrave;, CAY NHẸ ĐẶC TRƯNG</strong></li>\r\n<li><strong>HƯƠNG SẢ V&Agrave; MẮM RUỐC HUẾ R&Otilde; N&Eacute;T</strong></li>\r\n<li><strong>SỢI B&Uacute;N TO, DAI MỀM</strong></li>\r\n<li><strong>THỊT B&Ograve;, GI&Ograve; HEO THƠM NGỌT</strong></li>\r\n<li><strong>M&Oacute;N ĂN TRUYỀN THỐNG ĐẬM CHẤT MIỀN TRUNG</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>B&Uacute;N SỢI TO</td>\r\n<td>200&ndash;250 G</td>\r\n</tr>\r\n<tr>\r\n<td>THỊT B&Ograve;</td>\r\n<td>80&ndash;100 G</td>\r\n</tr>\r\n<tr>\r\n<td>GI&Ograve; HEO</td>\r\n<td>1 KHOANH</td>\r\n</tr>\r\n<tr>\r\n<td>NƯỚC D&Ugrave;NG B&Uacute;N B&Ograve; HUẾ</td>\r\n<td>350&ndash;400 ML</td>\r\n</tr>\r\n<tr>\r\n<td>RAU SỐNG ĂN K&Egrave;M</td>\r\n<td>T&Ugrave;Y CHỌN</td>\r\n</tr>\r\n</tbody>\r\n</table>', 35000, 40000, 1, 'Đang bán', 1, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `monan` VALUES (7, 'Cơm Chiên Trứng', '<p style=\"color: #333333;\">CƠM CHI&Ecirc;N TRỨNG L&Agrave; M&Oacute;N ĂN ĐƠN GIẢN, PHỔ BIẾN VỚI HẠT CƠM TƠI RỜI, ĐƯỢC CHI&Ecirc;N V&Agrave;NG C&Ugrave;NG TRỨNG G&Agrave; B&Eacute;O THƠM, N&Ecirc;M NẾM VỪA MIỆNG, MANG ĐẾN HƯƠNG VỊ GẦN GŨI, DỄ ĂN, PH&Ugrave; HỢP CHO BỮA ĂN NHANH, BỮA TRƯA HOẶC BỮA TỐI H&Agrave;NG NG&Agrave;Y.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>HẠT CƠM TƠI RỜI, KH&Ocirc;NG NH&Atilde;O</strong></li>\r\n<li><strong>TRỨNG G&Agrave; B&Eacute;O THƠM, DỄ ĂN</strong></li>\r\n<li><strong>GIA VỊ VỪA MIỆNG, KH&Ocirc;NG NG&Aacute;N</strong></li>\r\n<li><strong>PH&Ugrave; HỢP BỮA ĂN NHANH</strong></li>\r\n<li><strong>DỄ KẾT HỢP TH&Ecirc;M NGUY&Ecirc;N LIỆU</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>CƠM TRẮNG</td>\r\n<td>200&ndash;250 G</td>\r\n</tr>\r\n<tr>\r\n<td>TRỨNG G&Agrave;</td>\r\n<td>2 QUẢ</td>\r\n</tr>\r\n<tr>\r\n<td>DẦU ĂN</td>\r\n<td>10&ndash;15 ML</td>\r\n</tr>\r\n<tr>\r\n<td>H&Agrave;NH L&Aacute;, GIA VỊ</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n</tbody>\r\n</table>', 35000, NULL, 1, 'Đang bán', 0, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `monan` VALUES (8, 'Cơm Chiên Hải Sản', '<p style=\"color: #333333;\">CƠM CHI&Ecirc;N HẢI SẢN L&Agrave; M&Oacute;N ĂN HẤP DẪN VỚI HẠT CƠM TƠI RỜI ĐƯỢC CHI&Ecirc;N V&Agrave;NG C&Ugrave;NG T&Ocirc;M, MỰC TƯƠI NGỌT, TRỨNG G&Agrave; B&Eacute;O THƠM V&Agrave; RAU CỦ TƯƠI, N&Ecirc;M NẾM ĐẬM Đ&Agrave; VỪA MIỆNG, MANG ĐẾN HƯƠNG VỊ BIỂN ĐẶC TRƯNG, PH&Ugrave; HỢP CHO BỮA ĂN CH&Iacute;NH NGON MIỆNG V&Agrave; ĐẦY ĐỦ DINH DƯỠNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>HẠT CƠM TƠI RỜI, CHI&Ecirc;N V&Agrave;NG ĐẸP</strong></li>\r\n<li><strong>HẢI SẢN TƯƠI NGỌT, KH&Ocirc;NG TANH</strong></li>\r\n<li><strong>TRỨNG G&Agrave; B&Eacute;O THƠM, DỄ ĂN</strong></li>\r\n<li><strong>GIA VỊ ĐẬM Đ&Agrave;, VỪA MIỆNG</strong></li>\r\n<li><strong>M&Oacute;N ĂN ĐỦ CHẤT, PH&Ugrave; HỢP BỮA CH&Iacute;NH</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>CƠM TRẮNG</td>\r\n<td>200&ndash;250 G</td>\r\n</tr>\r\n<tr>\r\n<td>T&Ocirc;M TƯƠI</td>\r\n<td>60&ndash;80 G</td>\r\n</tr>\r\n<tr>\r\n<td>MỰC TƯƠI</td>\r\n<td>50&ndash;70 G</td>\r\n</tr>\r\n<tr>\r\n<td>TRỨNG G&Agrave;</td>\r\n<td>1&ndash;2 QUẢ</td>\r\n</tr>\r\n<tr>\r\n<td>DẦU ĂN, GIA VỊ, RAU CỦ</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n</tbody>\r\n</table>', 35000, NULL, 1, 'Đang bán', 0, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `monan` VALUES (9, 'Cơm Chiên Bò', '<p style=\"color: #333333;\">CƠM CHI&Ecirc;N B&Ograve; L&Agrave; M&Oacute;N ĂN NGON MIỆNG VỚI HẠT CƠM TƠI RỜI ĐƯỢC CHI&Ecirc;N V&Agrave;NG C&Ugrave;NG THỊT B&Ograve; MỀM NGỌT, THƠM M&Ugrave;I TỎI PHI V&Agrave; GIA VỊ ĐẬM Đ&Agrave;, KẾT HỢP TRỨNG G&Agrave; B&Eacute;O THƠM V&Agrave; RAU CỦ TƯƠI, MANG ĐẾN BỮA ĂN CH&Iacute;NH ĐẦY ĐỦ DINH DƯỠNG, DỄ ĂN V&Agrave; KH&Ocirc;NG NG&Aacute;N.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>HẠT CƠM TƠI RỜI, CHI&Ecirc;N V&Agrave;NG ĐẸP</strong></li>\r\n<li><strong>THỊT B&Ograve; MỀM NGỌT, ĐẬM VỊ</strong></li>\r\n<li><strong>TRỨNG G&Agrave; B&Eacute;O THƠM, DỄ ĂN</strong></li>\r\n<li><strong>GIA VỊ N&Ecirc;M NẾM VỪA MIỆNG</strong></li>\r\n<li><strong>PH&Ugrave; HỢP CHO BỮA ĂN CH&Iacute;NH</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>CƠM TRẮNG</td>\r\n<td>200&ndash;250 G</td>\r\n</tr>\r\n<tr>\r\n<td>THỊT B&Ograve;</td>\r\n<td>80&ndash;100 G</td>\r\n</tr>\r\n<tr>\r\n<td>TRỨNG G&Agrave;</td>\r\n<td>1&ndash;2 QUẢ</td>\r\n</tr>\r\n<tr>\r\n<td>TỎI PHI, H&Agrave;NH L&Aacute;</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n<tr>\r\n<td>DẦU ĂN, GIA VỊ</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n</tbody>\r\n</table>', 35000, NULL, 1, 'Đang bán', 0, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `monan` VALUES (10, 'Hamburger', '<p style=\"color: #333333;\">HAMBURGER L&Agrave; M&Oacute;N ĂN NHANH PHỔ BIẾN VỚI PHẦN B&Aacute;NH M&Igrave; MỀM XỐP KẸP NH&Acirc;N THỊT &Aacute;P CHẢO THƠM NGỌT, PH&Ocirc; MAI B&Eacute;O NGẬY V&Agrave; RAU CỦ TƯƠI GI&Ograve;N, KẾT HỢP C&Aacute;C LOẠI SỐT ĐẬM Đ&Agrave;, MANG ĐẾN HƯƠNG VỊ HẤP DẪN, TIỆN LỢI, PH&Ugrave; HỢP CHO BỮA ĂN NHANH HOẶC D&Ugrave;NG K&Egrave;M ĐỒ UỐNG.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>B&Aacute;NH M&Igrave; MỀM, KH&Ocirc;NG KH&Ocirc;</strong></li>\r\n<li><strong>NH&Acirc;N THỊT THƠM NGỌT, ĐẬM VỊ</strong></li>\r\n<li><strong>PH&Ocirc; MAI B&Eacute;O NGẬY HẤP DẪN</strong></li>\r\n<li><strong>RAU CỦ TƯƠI GI&Ograve;N C&Acirc;N BẰNG VỊ</strong></li>\r\n<li><strong>TIỆN LỢI, DỄ ĂN, PH&Ugrave; HỢP MỌI ĐỘ TUỔI</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>B&Aacute;NH M&Igrave; HAMBURGER</td>\r\n<td>1 C&Aacute;I</td>\r\n</tr>\r\n<tr>\r\n<td>THỊT B&Ograve; HOẶC G&Agrave; &Aacute;P CHẢO</td>\r\n<td>1 MIẾNG</td>\r\n</tr>\r\n<tr>\r\n<td>PH&Ocirc; MAI L&Aacute;T</td>\r\n<td>1 L&Aacute;T</td>\r\n</tr>\r\n<tr>\r\n<td>RAU X&Agrave; L&Aacute;CH, C&Agrave; CHUA</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n<tr>\r\n<td>SỐT (MAYONNAISE, KETCHUP&hellip;)</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n</tbody>\r\n</table>', 25000, NULL, 5, 'Đang bán', 0, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `monan` VALUES (11, 'Đùi Gà Chiên', '<p style=\"color: #333333;\">Đ&Ugrave;I G&Agrave; CHI&Ecirc;N L&Agrave; M&Oacute;N ĂN HẤP DẪN VỚI LỚP VỎ NGO&Agrave;I GI&Ograve;N RỤM, V&Agrave;NG &Oacute;NG, B&Ecirc;N TRONG THỊT G&Agrave; MỀM NGỌT, GIỮ TRỌN ĐỘ ẨM, ĐƯỢC TẨM ƯỚP GIA VỊ ĐẬM Đ&Agrave;, MANG ĐẾN HƯƠNG VỊ THƠM NGON KH&Oacute; CƯỠNG, PH&Ugrave; HỢP D&Ugrave;NG L&Agrave;M M&Oacute;N ĂN CH&Iacute;NH HOẶC ĂN VẶT.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>LỚP VỎ GI&Ograve;N RỤM, KH&Ocirc;NG BỞ</strong></li>\r\n<li><strong>THỊT G&Agrave; MỀM NGỌT, KH&Ocirc;NG KH&Ocirc;</strong></li>\r\n<li><strong>GIA VỊ TẨM ƯỚP ĐẬM Đ&Agrave;</strong></li>\r\n<li><strong>HƯƠNG VỊ THƠM NGON, DỄ G&Acirc;Y NGHIỆN</strong></li>\r\n<li><strong>PH&Ugrave; HỢP L&Agrave;M M&Oacute;N ĂN VẶT HOẶC BỮA CH&Iacute;NH</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>Đ&Ugrave;I G&Agrave; TƯƠI</td>\r\n<td>1&ndash;2 C&Aacute;I</td>\r\n</tr>\r\n<tr>\r\n<td>BỘT CHI&Ecirc;N GI&Ograve;N</td>\r\n<td>50&ndash;70 G</td>\r\n</tr>\r\n<tr>\r\n<td>TRỨNG G&Agrave;</td>\r\n<td>1 QUẢ</td>\r\n</tr>\r\n<tr>\r\n<td>DẦU ĂN</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n<tr>\r\n<td>GIA VỊ TẨM ƯỚP</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n</tbody>\r\n</table>', 15000, NULL, 5, 'Đang bán', 1, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `monan` VALUES (12, 'Gà Nướng', '<p style=\"color: #333333;\">G&Agrave; NƯỚNG L&Agrave; M&Oacute;N ĂN THƠM NGON VỚI THỊT G&Agrave; ĐƯỢC TẨM ƯỚP GIA VỊ ĐẬM Đ&Agrave;, NƯỚNG CH&Iacute;N V&Agrave;NG ĐỀU, DA GI&Ograve;N NHẸ, THỊT B&Ecirc;N TRONG MỀM NGỌT, GIỮ TRỌN ĐỘ ẨM, MANG ĐẾN HƯƠNG VỊ HẤP DẪN, PH&Ugrave; HỢP CHO BỮA ĂN CH&Iacute;NH HOẶC D&Ugrave;NG TRONG C&Aacute;C BUỔI HỌP MẶT.</p>\r\n<ul style=\"color: #555555;\">\r\n<li><strong>THỊT G&Agrave; MỀM NGỌT, KH&Ocirc;NG KH&Ocirc;</strong></li>\r\n<li><strong>DA NƯỚNG V&Agrave;NG, THƠM GI&Ograve;N NHẸ</strong></li>\r\n<li><strong>GIA VỊ TẨM ƯỚP ĐẬM Đ&Agrave;, THẤM VỊ</strong></li>\r\n<li><strong>HƯƠNG THƠM ĐẶC TRƯNG KHI NƯỚNG</strong></li>\r\n<li><strong>PH&Ugrave; HỢP BỮA ĂN CH&Iacute;NH HOẶC TIỆC NHẸ</strong></li>\r\n</ul>\r\n<p style=\"text-align: center; color: #333333;\"><strong>TH&Agrave;NH PHẦN NGUY&Ecirc;N LIỆU</strong></p>\r\n<table style=\"width: 100%; border-collapse: collapse; color: #444444;\">\r\n<tbody>\r\n<tr style=\"background: #F2F2F2;\">\r\n<th>TH&Agrave;NH PHẦN</th>\r\n<th>ĐỊNH LƯỢNG</th>\r\n</tr>\r\n<tr>\r\n<td>G&Agrave; TƯƠI</td>\r\n<td>1/2&ndash;1 CON</td>\r\n</tr>\r\n<tr>\r\n<td>MẬT ONG HOẶC DẦU H&Agrave;O</td>\r\n<td>20&ndash;30 ML</td>\r\n</tr>\r\n<tr>\r\n<td>TỎI, SẢ, GIA VỊ ƯỚP</td>\r\n<td>VỪA ĐỦ</td>\r\n</tr>\r\n<tr>\r\n<td>DẦU ĂN</td>\r\n<td>10&ndash;15 ML</td>\r\n</tr>\r\n</tbody>\r\n</table>', 80000, 95000, 5, 'Đang bán', 1, '2025-12-31 01:33:59', '2026-01-01 22:11:56');

-- ----------------------------
-- Table structure for monan_topping
-- ----------------------------
DROP TABLE IF EXISTS `monan_topping`;
CREATE TABLE `monan_topping`  (
  `monan_id` bigint UNSIGNED NOT NULL,
  `topping_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`monan_id`, `topping_id`) USING BTREE,
  INDEX `monan_topping_topping_id_foreign`(`topping_id` ASC) USING BTREE,
  CONSTRAINT `monan_topping_monan_id_foreign` FOREIGN KEY (`monan_id`) REFERENCES `monan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `monan_topping_topping_id_foreign` FOREIGN KEY (`topping_id`) REFERENCES `topping` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of monan_topping
-- ----------------------------
INSERT INTO `monan_topping` VALUES (1, 5);
INSERT INTO `monan_topping` VALUES (1, 6);
INSERT INTO `monan_topping` VALUES (1, 7);
INSERT INTO `monan_topping` VALUES (1, 8);
INSERT INTO `monan_topping` VALUES (1, 9);
INSERT INTO `monan_topping` VALUES (1, 10);
INSERT INTO `monan_topping` VALUES (1, 11);
INSERT INTO `monan_topping` VALUES (1, 12);
INSERT INTO `monan_topping` VALUES (1, 13);
INSERT INTO `monan_topping` VALUES (1, 14);
INSERT INTO `monan_topping` VALUES (1, 15);
INSERT INTO `monan_topping` VALUES (1, 16);
INSERT INTO `monan_topping` VALUES (2, 4);
INSERT INTO `monan_topping` VALUES (2, 5);
INSERT INTO `monan_topping` VALUES (2, 6);
INSERT INTO `monan_topping` VALUES (2, 7);
INSERT INTO `monan_topping` VALUES (2, 8);
INSERT INTO `monan_topping` VALUES (2, 9);
INSERT INTO `monan_topping` VALUES (2, 10);
INSERT INTO `monan_topping` VALUES (2, 11);
INSERT INTO `monan_topping` VALUES (2, 12);
INSERT INTO `monan_topping` VALUES (2, 13);
INSERT INTO `monan_topping` VALUES (2, 14);
INSERT INTO `monan_topping` VALUES (2, 15);
INSERT INTO `monan_topping` VALUES (2, 16);
INSERT INTO `monan_topping` VALUES (3, 5);
INSERT INTO `monan_topping` VALUES (3, 6);
INSERT INTO `monan_topping` VALUES (3, 7);
INSERT INTO `monan_topping` VALUES (3, 8);
INSERT INTO `monan_topping` VALUES (3, 9);
INSERT INTO `monan_topping` VALUES (3, 10);
INSERT INTO `monan_topping` VALUES (3, 11);
INSERT INTO `monan_topping` VALUES (3, 12);
INSERT INTO `monan_topping` VALUES (3, 13);
INSERT INTO `monan_topping` VALUES (3, 14);
INSERT INTO `monan_topping` VALUES (3, 15);
INSERT INTO `monan_topping` VALUES (3, 16);
INSERT INTO `monan_topping` VALUES (4, 4);
INSERT INTO `monan_topping` VALUES (4, 5);
INSERT INTO `monan_topping` VALUES (4, 6);
INSERT INTO `monan_topping` VALUES (4, 7);
INSERT INTO `monan_topping` VALUES (4, 8);
INSERT INTO `monan_topping` VALUES (4, 9);
INSERT INTO `monan_topping` VALUES (5, 4);
INSERT INTO `monan_topping` VALUES (5, 5);
INSERT INTO `monan_topping` VALUES (5, 6);
INSERT INTO `monan_topping` VALUES (5, 7);
INSERT INTO `monan_topping` VALUES (5, 8);
INSERT INTO `monan_topping` VALUES (5, 9);
INSERT INTO `monan_topping` VALUES (6, 20);
INSERT INTO `monan_topping` VALUES (6, 22);
INSERT INTO `monan_topping` VALUES (6, 24);
INSERT INTO `monan_topping` VALUES (6, 25);
INSERT INTO `monan_topping` VALUES (7, 17);
INSERT INTO `monan_topping` VALUES (7, 18);
INSERT INTO `monan_topping` VALUES (7, 19);
INSERT INTO `monan_topping` VALUES (7, 22);
INSERT INTO `monan_topping` VALUES (8, 26);
INSERT INTO `monan_topping` VALUES (8, 27);
INSERT INTO `monan_topping` VALUES (8, 28);
INSERT INTO `monan_topping` VALUES (8, 29);
INSERT INTO `monan_topping` VALUES (8, 30);
INSERT INTO `monan_topping` VALUES (8, 31);
INSERT INTO `monan_topping` VALUES (8, 32);
INSERT INTO `monan_topping` VALUES (8, 33);
INSERT INTO `monan_topping` VALUES (8, 34);
INSERT INTO `monan_topping` VALUES (9, 24);
INSERT INTO `monan_topping` VALUES (9, 25);
INSERT INTO `monan_topping` VALUES (10, 1);
INSERT INTO `monan_topping` VALUES (10, 2);
INSERT INTO `monan_topping` VALUES (10, 20);
INSERT INTO `monan_topping` VALUES (10, 22);
INSERT INTO `monan_topping` VALUES (10, 23);
INSERT INTO `monan_topping` VALUES (10, 24);
INSERT INTO `monan_topping` VALUES (11, 1);
INSERT INTO `monan_topping` VALUES (11, 2);
INSERT INTO `monan_topping` VALUES (11, 3);
INSERT INTO `monan_topping` VALUES (12, 1);
INSERT INTO `monan_topping` VALUES (12, 2);
INSERT INTO `monan_topping` VALUES (12, 3);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for phuongthucthanhtoan
-- ----------------------------
DROP TABLE IF EXISTS `phuongthucthanhtoan`;
CREATE TABLE `phuongthucthanhtoan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_pttt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái phương thức thanh toán: 1-Hoạt động, 0-Tạm khóa',
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Mô tả chi tiết về phương thức thanh toán',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of phuongthucthanhtoan
-- ----------------------------
INSERT INTO `phuongthucthanhtoan` VALUES (1, 'Chuyển khoản ngân hàng', 1, '', NULL, NULL);
INSERT INTO `phuongthucthanhtoan` VALUES (2, 'Tiền mặt khi nhận hàng (COD)', 1, '', NULL, NULL);

-- ----------------------------
-- Table structure for phuongthucvanchuyen
-- ----------------------------
DROP TABLE IF EXISTS `phuongthucvanchuyen`;
CREATE TABLE `phuongthucvanchuyen`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_ptvc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia_vanchuyen` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `trangthai` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái phương thức vận chuyển: 1-Hoạt động, 0-Tạm khóa',
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Mô tả chi tiết về phương thức vận chuyển',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of phuongthucvanchuyen
-- ----------------------------
INSERT INTO `phuongthucvanchuyen` VALUES (1, 'Giao hàng tiết kiệm', 20000.00, 1, '', NULL, NULL);
INSERT INTO `phuongthucvanchuyen` VALUES (2, 'Giao hàng nhanh', 40000.00, 1, '', NULL, NULL);
INSERT INTO `phuongthucvanchuyen` VALUES (3, 'Khách Hàng Đến Lấy', 0.00, 1, '', NULL, NULL);

-- ----------------------------
-- Table structure for product_images
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `monan_id` bigint UNSIGNED NOT NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Hình ảnh chính hiển thị thumbnail',
  `sort_order` int NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp hình ảnh',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_images_monan_id_foreign`(`monan_id` ASC) USING BTREE,
  CONSTRAINT `product_images_monan_id_foreign` FOREIGN KEY (`monan_id`) REFERENCES `monan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_images
-- ----------------------------
INSERT INTO `product_images` VALUES (1, 1, 'products/product_695415e792039.png', 1, 0, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (2, 1, 'products/product_695415e794803.png', 0, 1, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (3, 1, 'products/product_695415e7953cb.png', 0, 2, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (4, 1, 'products/product_695415e795f65.png', 0, 3, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (5, 1, 'products/product_695415e7969bb.png', 0, 4, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (6, 1, 'products/product_695415e7973ee.png', 0, 5, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (7, 1, 'products/product_695415e797fae.png', 0, 6, '2025-12-31 01:11:51', '2026-01-01 22:04:54');
INSERT INTO `product_images` VALUES (8, 2, 'products/product_695416fd3116e.png', 1, 0, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (9, 2, 'products/product_695416fd3316b.png', 0, 1, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (10, 2, 'products/product_695416fd33b86.png', 0, 2, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (11, 2, 'products/product_695416fd3472a.png', 0, 3, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (12, 2, 'products/product_695416fd350e7.png', 0, 4, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (13, 2, 'products/product_695416fd35bdc.png', 0, 5, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (14, 2, 'products/product_695416fd3684b.png', 0, 6, '2025-12-31 01:16:29', '2026-01-01 22:04:27');
INSERT INTO `product_images` VALUES (15, 3, 'products/product_69541768b1fdd.png', 1, 0, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (16, 3, 'products/product_69541768b3a3d.png', 0, 1, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (17, 3, 'products/product_69541768b431b.png', 0, 2, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (18, 3, 'products/product_69541768b4e30.png', 0, 3, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (19, 3, 'products/product_69541768b5a57.png', 0, 4, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (20, 3, 'products/product_69541768b67f9.png', 0, 5, '2025-12-31 01:18:16', '2026-01-01 22:03:56');
INSERT INTO `product_images` VALUES (21, 4, 'products/product_695417ea57ddd.png', 0, 0, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (22, 4, 'products/product_695417ea59f0a.png', 0, 1, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (23, 4, 'products/product_695417ea5aa42.png', 1, 2, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (24, 4, 'products/product_695417ea5b508.png', 0, 3, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (25, 4, 'products/product_695417ea5bfa9.png', 0, 4, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (26, 4, 'products/product_695417ea5cb3b.png', 0, 5, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (27, 4, 'products/product_695417ea5d629.png', 0, 6, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (28, 4, 'products/product_695417ea5e468.png', 0, 7, '2025-12-31 01:20:26', '2026-01-01 22:14:13');
INSERT INTO `product_images` VALUES (29, 5, 'products/product_695418211af43.png', 0, 0, '2025-12-31 01:21:21', '2026-01-01 22:13:58');
INSERT INTO `product_images` VALUES (30, 5, 'products/product_695418211c862.png', 0, 1, '2025-12-31 01:21:21', '2026-01-01 22:13:58');
INSERT INTO `product_images` VALUES (31, 5, 'products/product_695418211d29f.png', 0, 2, '2025-12-31 01:21:21', '2026-01-01 22:13:58');
INSERT INTO `product_images` VALUES (32, 5, 'products/product_695418211e0ff.png', 0, 3, '2025-12-31 01:21:21', '2026-01-01 22:13:58');
INSERT INTO `product_images` VALUES (33, 5, 'products/product_695418211ee71.png', 1, 4, '2025-12-31 01:21:21', '2026-01-01 22:13:58');
INSERT INTO `product_images` VALUES (34, 6, 'products/product_695419baa9d4a.png', 1, 0, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (35, 6, 'products/product_695419baabccc.png', 0, 1, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (36, 6, 'products/product_695419baac6e1.png', 0, 2, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (37, 6, 'products/product_695419baad175.png', 0, 3, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (38, 6, 'products/product_695419baadd66.png', 0, 4, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (39, 6, 'products/product_695419baae82b.png', 0, 5, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (40, 6, 'products/product_695419baaf429.png', 0, 6, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (41, 6, 'products/product_695419baaff62.png', 0, 7, '2025-12-31 01:28:10', '2026-01-01 22:13:40');
INSERT INTO `product_images` VALUES (42, 7, 'products/product_69541a29593f8.png', 1, 0, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (43, 7, 'products/product_69541a295aea8.png', 0, 1, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (44, 7, 'products/product_69541a295b80c.png', 0, 2, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (45, 7, 'products/product_69541a295c2bf.png', 0, 3, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (46, 7, 'products/product_69541a295cc51.png', 0, 4, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (47, 7, 'products/product_69541a295d935.png', 0, 5, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (48, 7, 'products/product_69541a295e678.png', 0, 6, '2025-12-31 01:30:01', '2026-01-01 22:13:22');
INSERT INTO `product_images` VALUES (49, 8, 'products/product_69541a5570db6.png', 1, 0, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (50, 8, 'products/product_69541a5572ce1.png', 0, 1, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (51, 8, 'products/product_69541a5573723.png', 0, 2, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (52, 8, 'products/product_69541a55741b7.png', 0, 3, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (53, 8, 'products/product_69541a5574c1c.png', 0, 4, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (54, 8, 'products/product_69541a557566c.png', 0, 5, '2025-12-31 01:30:45', '2026-01-01 22:13:05');
INSERT INTO `product_images` VALUES (55, 9, 'products/product_69541a77a1c10.png', 1, 0, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (56, 9, 'products/product_69541a77a344e.png', 0, 1, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (57, 9, 'products/product_69541a77a3e1e.png', 0, 2, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (58, 9, 'products/product_69541a77a4807.png', 0, 3, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (59, 9, 'products/product_69541a77a532f.png', 0, 4, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (60, 9, 'products/product_69541a77a5da9.png', 0, 5, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (61, 9, 'products/product_69541a77a6784.png', 0, 6, '2025-12-31 01:31:19', '2026-01-01 22:12:49');
INSERT INTO `product_images` VALUES (62, 10, 'products/product_69541acf5b6be.png', 1, 0, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `product_images` VALUES (63, 10, 'products/product_69541acf5d6f0.png', 0, 1, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `product_images` VALUES (64, 10, 'products/product_69541acf5e009.png', 0, 2, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `product_images` VALUES (65, 10, 'products/product_69541acf5ea93.png', 0, 3, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `product_images` VALUES (66, 10, 'products/product_69541acf5f6ab.png', 0, 4, '2025-12-31 01:32:47', '2026-01-01 22:12:29');
INSERT INTO `product_images` VALUES (67, 11, 'products/product_69541af6959a9.png', 1, 0, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (68, 11, 'products/product_69541af69732a.png', 0, 1, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (69, 11, 'products/product_69541af697c3e.png', 0, 2, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (70, 11, 'products/product_69541af698509.png', 0, 3, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (71, 11, 'products/product_69541af6990ba.png', 0, 4, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (72, 11, 'products/product_69541af699c78.png', 0, 5, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (73, 11, 'products/product_69541af69a6fd.png', 0, 6, '2025-12-31 01:33:26', '2026-01-01 22:12:07');
INSERT INTO `product_images` VALUES (74, 12, 'products/product_69541b17dc9f1.png', 1, 0, '2025-12-31 01:33:59', '2026-01-01 22:11:56');
INSERT INTO `product_images` VALUES (75, 12, 'products/product_69541b17de4d2.png', 0, 1, '2025-12-31 01:33:59', '2026-01-01 22:11:56');
INSERT INTO `product_images` VALUES (76, 12, 'products/product_69541b17df033.png', 0, 2, '2025-12-31 01:33:59', '2026-01-01 22:11:56');
INSERT INTO `product_images` VALUES (77, 12, 'products/product_69541b17dfb4b.png', 0, 3, '2025-12-31 01:33:59', '2026-01-01 22:11:56');
INSERT INTO `product_images` VALUES (78, 12, 'products/product_69541b17e0798.png', 0, 4, '2025-12-31 01:33:59', '2026-01-01 22:11:56');
INSERT INTO `product_images` VALUES (79, 12, 'products/product_69541b17e13a5.png', 0, 5, '2025-12-31 01:33:59', '2026-01-01 22:11:56');

-- ----------------------------
-- Table structure for quantri
-- ----------------------------
DROP TABLE IF EXISTS `quantri`;
CREATE TABLE `quantri`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `website_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `shop_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `zalo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pinterest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `hotline` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of quantri
-- ----------------------------
INSERT INTO `quantri` VALUES (1, 'logo.png', 'panther_icon.ico', 'Food Shop - Chuyên cung cấp đồ ăn ngon, chất lượng', 'Panther Shop', 'https://facebook.com', 'https://twitter.com', 'https://instagram.com', '0866468126', 'https://pinterest.com', 'https://linkedin.com', 'https://tiktok.com', '0866 468 126', 'julyasiin@gmail.com', 'Đại Học Bách Khoa Hà Nội', '2025-12-31 01:03:52', '2025-12-31 01:03:52');

-- ----------------------------
-- Table structure for thongke_doanhthu
-- ----------------------------
DROP TABLE IF EXISTS `thongke_doanhthu`;
CREATE TABLE `thongke_doanhthu`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ngay` date NOT NULL,
  `so_donhang` int NOT NULL DEFAULT 0,
  `doanh_thu` decimal(15, 2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `thongke_doanhthu_ngay_unique`(`ngay` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of thongke_doanhthu
-- ----------------------------

-- ----------------------------
-- Table structure for thongtinthanhtoan
-- ----------------------------
DROP TABLE IF EXISTS `thongtinthanhtoan`;
CREATE TABLE `thongtinthanhtoan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pttt_id` bigint UNSIGNED NOT NULL,
  `ten_nganhang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `so_taikhoan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ten_chutaikhoan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `chi_nhanh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `noi_dung_mau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ma_nganhang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Mã ngân hàng cho VietQR (VCB, TCB, etc)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `thongtinthanhtoan_pttt_id_foreign`(`pttt_id` ASC) USING BTREE,
  CONSTRAINT `thongtinthanhtoan_pttt_id_foreign` FOREIGN KEY (`pttt_id`) REFERENCES `phuongthucthanhtoan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of thongtinthanhtoan
-- ----------------------------
INSERT INTO `thongtinthanhtoan` VALUES (3, 2, 'MB', '0866468126', 'NGUYEN DUC TUAN', 'Bắc Giang', 'FOODSHOP', 'MB', NULL, NULL);

-- ----------------------------
-- Table structure for tintuc
-- ----------------------------
DROP TABLE IF EXISTS `tintuc`;
CREATE TABLE `tintuc`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tieude` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tomtat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ngaydang` datetime NOT NULL DEFAULT current_timestamp,
  `ngaycapnhat` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `tacgia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `luotxem` int NOT NULL DEFAULT 0,
  `trangthai` enum('Công khai','Bản nháp','Ẩn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Công khai',
  `noibat` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tintuc
-- ----------------------------
INSERT INTO `tintuc` VALUES (1, '📰 PANTHER FOOD CHÍNH THỨC RA MẮT – SẴN SÀNG PHỤC VỤ KHÁCH HÀNG', '<h2 style=\"color:#222222\">🎉 PANTHER FOOD CHÍNH THỨC RA MẮT – SẴN SÀNG PHỤC VỤ KHÁCH HÀNG</h2>\r\n\r\n<p style=\"color:#333333\">\r\nSAU THỜI GIAN CHUẨN BỊ KỸ LƯỠNG VỀ Ý TƯỞNG, THỰC ĐƠN, NGUYÊN LIỆU VÀ QUY TRÌNH CHẾ BIẾN, <strong>PANTHER FOOD</strong> CHÍNH THỨC RA MẮT VÀ ĐI VÀO HOẠT ĐỘNG.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nPANTHER FOOD HƯỚNG ĐẾN VIỆC MANG LẠI NHỮNG MÓN ĂN NGON – DỄ ĂN – GIÁ HỢP LÝ, PHÙ HỢP VỚI NHIỀU ĐỐI TƯỢNG KHÁCH HÀNG NHƯ HỌC SINH, SINH VIÊN, NHÂN VIÊN VĂN PHÒNG VÀ GIA ĐÌNH.\r\n</p>\r\n\r\n<ul style=\"color:#555555\">\r\n  <li>NGUYÊN LIỆU TƯƠI MỚI NHẬP MỖI NGÀY</li>\r\n  <li>QUY TRÌNH CHẾ BIẾN ĐẢM BẢO VỆ SINH</li>\r\n  <li>PHỤC VỤ NHANH – ĐÚNG GIỜ</li>\r\n  <li>THỰC ĐƠN PHONG PHÚ, DỄ LỰA CHỌN</li>\r\n</ul>\r\n\r\n<table style=\"width:100%;border-collapse:collapse;color:#444444\">\r\n  <tr style=\"background:#F2F2F2\">\r\n    <th>NỘI DUNG</th>\r\n    <th>CHI TIẾT</th>\r\n  </tr>\r\n  <tr>\r\n    <td>NGÀY KHAI TRƯƠNG</td>\r\n    <td>CẬP NHẬT THEO THÔNG BÁO</td>\r\n  </tr>\r\n  <tr>\r\n    <td>HÌNH THỨC PHỤC VỤ</td>\r\n    <td>ĂN TẠI QUÁN – MANG ĐI – ĐẶT ONLINE</td>\r\n  </tr>\r\n  <tr>\r\n    <td>ĐỐI TƯỢNG PHỤC VỤ</td>\r\n    <td>MỌI KHÁCH HÀNG</td>\r\n  </tr>\r\n</table>\r\n', '📰 PANTHER FOOD CHÍNH THỨC RA MẮT – SẴN SÀNG PHỤC VỤ KHÁCH HÀNG', 'news/news_69554311b0988.png', '2025-12-31 22:36:50', '2025-12-31 22:48:12', NULL, 3, 'Công khai', 0, '2025-12-31 22:36:50', '2025-12-31 22:48:12');
INSERT INTO `tintuc` VALUES (2, '📰 PANTHER FOOD CẬP NHẬT THỰC ĐƠN MỚI VỚI NHIỀU MÓN HẤP DẪN', '<h2 style=\"color:#222222\">🍽️ CẬP NHẬT THỰC ĐƠN MỚI TẠI PANTHER FOOD</h2>\r\n\r\n<p style=\"color:#333333\">\r\nNHẰM MANG ĐẾN TRẢI NGHIỆM ĂN UỐNG TỐT HƠN, <strong>PANTHER FOOD</strong> ĐÃ LIÊN TỤC CẬP NHẬT VÀ BỔ SUNG THÊM NHIỀU MÓN ĂN MỚI VÀO THỰC ĐƠN.\r\n</p>\r\n\r\n<p style=\"color:#333333\">\r\nTHỰC ĐƠN ĐƯỢC XÂY DỰNG THEO TIÊU CHÍ DỄ ĂN, ĐẬM VỊ, PHÙ HỢP VỚI KHẨU VỊ NGƯỜI VIỆT, TỪ MÓN CHÍNH NO BỤNG ĐẾN CÁC MÓN ĂN VẶT VÀ ĐỒ UỐNG GIẢI KHÁT.\r\n</p>\r\n\r\n<table style=\"width:100%;border-collapse:collapse;color:#444444\">\r\n  <tr style=\"background:#F2F2F2\">\r\n    <th>NHÓM MÓN</th>\r\n    <th>VÍ DỤ MÓN TIÊU BIỂU</th>\r\n  </tr>\r\n  <tr>\r\n    <td>MÓN CƠM</td>\r\n    <td>CƠM CHIÊN TRỨNG, CƠM CHIÊN BÒ, CƠM CHIÊN HẢI SẢN</td>\r\n  </tr>\r\n  <tr>\r\n    <td>MÓN GÀ</td>\r\n    <td>GÀ CHIÊN, GÀ NƯỚNG, ĐÙI GÀ CHIÊN</td>\r\n  </tr>\r\n  <tr>\r\n    <td>ĐỒ ĂN NHANH</td>\r\n    <td>HAMBURGER, KHOAI TÂY CHIÊN</td>\r\n  </tr>\r\n  <tr>\r\n    <td>ĐỒ UỐNG</td>\r\n    <td>TRÀ SỮA, TRÀ CHANH, TRÀ ĐÀO</td>\r\n  </tr>\r\n</table>\r\n\r\n<p style=\"color:#333333\">\r\nKHÁCH HÀNG CÓ THỂ ĐẾN TRỰC TIẾP HOẶC ĐẶT MÓN ONLINE ĐỂ THƯỞNG THỨC THỰC ĐƠN MỚI MỖI NGÀY.\r\n</p>\r\n', '📰 PANTHER FOOD CẬP NHẬT THỰC ĐƠN MỚI VỚI NHIỀU MÓN HẤP DẪN', 'news/news_695545815f2a3.png', '2025-12-31 22:47:13', '2025-12-31 22:48:09', NULL, 1, 'Công khai', 0, '2025-12-31 22:47:13', '2025-12-31 22:48:09');
INSERT INTO `tintuc` VALUES (3, '📰 ƯU ĐÃI HẤP DẪN DÀNH CHO KHÁCH HÀNG TẠI PANTHER FOOD', '<h2 style=\"color:#222222\">🔥 CHƯƠNG TRÌNH KHUYẾN MÃI HẤP DẪN TẠI PANTHER FOOD</h2>\r\n\r\n<p style=\"color:#333333\">\r\nNHẰM TRI ÂN KHÁCH HÀNG ĐÃ LUÔN ỦNG HỘ, <strong>PANTHER FOOD</strong> TRIỂN KHAI NHIỀU CHƯƠNG TRÌNH KHUYẾN MÃI ĐẶC BIỆT TRONG THỜI GIAN TỚI.\r\n</p>\r\n\r\n<table style=\"width:100%;border-collapse:collapse;color:#444444\">\r\n  <tr style=\"background:#F2F2F2\">\r\n    <th>CHƯƠNG TRÌNH</th>\r\n    <th>NỘI DUNG ƯU ĐÃI</th>\r\n    <th>ĐỐI TƯỢNG</th>\r\n  </tr>\r\n  <tr>\r\n    <td>GIẢM GIÁ KHAI TRƯƠNG</td>\r\n    <td>GIẢM 10–20% TỔNG HÓA ĐƠN</td>\r\n    <td>TẤT CẢ KHÁCH HÀNG</td>\r\n  </tr>\r\n  <tr>\r\n    <td>COMBO TIẾT KIỆM</td>\r\n    <td>MUA COMBO GIÁ ƯU ĐÃI</td>\r\n    <td>KHÁCH ĂN THEO NHÓM</td>\r\n  </tr>\r\n  <tr>\r\n    <td>KHUNG GIỜ VÀNG</td>\r\n    <td>ƯU ĐÃI THEO GIỜ CỐ ĐỊNH</td>\r\n    <td>KHÁCH ĐẶT ONLINE</td>\r\n  </tr>\r\n</table>\r\n\r\n<p style=\"color:#333333\">\r\nCHƯƠNG TRÌNH CÓ THỂ THAY ĐỔI THEO TỪNG GIAI ĐOẠN, VUI LÒNG THEO DÕI WEBSITE HOẶC FANPAGE ĐỂ CẬP NHẬT THÔNG TIN MỚI NHẤT.\r\n</p>\r\n', '📰 ƯU ĐÃI HẤP DẪN DÀNH CHO KHÁCH HÀNG TẠI PANTHER FOOD', 'news/news_69554594eb1a0.png', '2025-12-31 22:47:32', '2025-12-31 22:48:14', NULL, 1, 'Công khai', 0, '2025-12-31 22:47:32', '2025-12-31 22:48:14');
INSERT INTO `tintuc` VALUES (4, '📰 THÔNG BÁO GIỜ MỞ CỬA HOẠT ĐỘNG CỦA PANTHER FOOD', '<h2 style=\"color:#222222\">⏰ THỜI GIAN HOẠT ĐỘNG VÀ QUY TRÌNH PHỤC VỤ</h2>\r\n\r\n<p style=\"color:#333333\">\r\n<strong>PANTHER FOOD</strong> HOẠT ĐỘNG TẤT CẢ CÁC NGÀY TRONG TUẦN NHẰM PHỤC VỤ NHU CẦU ĂN UỐNG CỦA KHÁCH HÀNG.\r\n</p>\r\n\r\n<ul style=\"color:#555555\">\r\n  <li>PHỤC VỤ NHANH CHÓNG, ĐÚNG GIỜ</li>\r\n  <li>ĐẢM BẢO CHẤT LƯỢNG MÓN ĂN</li>\r\n  <li>ĐÓNG GÓI GỌN GÀNG KHI MANG ĐI</li>\r\n</ul>\r\n\r\n<p style=\"color:#333333\">\r\nDÙ ĂN TẠI QUÁN HAY ĐẶT MÓN ONLINE, CHÚNG TÔI LUÔN CAM KẾT GIỮ NGUYÊN CHẤT LƯỢNG VÀ HƯƠNG VỊ.\r\n</p>\r\n', '📰 THÔNG BÁO GIỜ MỞ CỬA HOẠT ĐỘNG CỦA PANTHER FOOD', 'news/news_695547a9b7fe5.png', '2025-12-31 22:56:25', '2025-12-31 22:57:12', NULL, 1, 'Công khai', 0, '2025-12-31 22:56:25', '2025-12-31 22:57:12');
INSERT INTO `tintuc` VALUES (5, '📰 PANTHER FOOD CAM KẾT CHẤT LƯỢNG VÀ AN TOÀN THỰC PHẨM', '<h2 style=\"color:#222222\">✅ CAM KẾT CHẤT LƯỢNG & AN TOÀN THỰC PHẨM</h2>\r\n\r\n<p style=\"color:#333333\">\r\nTẠI <strong>PANTHER FOOD</strong>, CHẤT LƯỢNG VÀ SỰ AN TÂM CỦA KHÁCH HÀNG LUÔN ĐƯỢC ĐẶT LÊN HÀNG ĐẦU.\r\n</p>\r\n\r\n<table style=\"width:100%;border-collapse:collapse;color:#444444\">\r\n  <tr style=\"background:#F2F2F2\">\r\n    <th>TIÊU CHÍ</th>\r\n    <th>CAM KẾT</th>\r\n  </tr>\r\n  <tr>\r\n    <td>NGUYÊN LIỆU</td>\r\n    <td>TƯƠI MỚI – RÕ NGUỒN GỐC</td>\r\n  </tr>\r\n  <tr>\r\n    <td>CHẾ BIẾN</td>\r\n    <td>TRONG NGÀY – ĐÚNG QUY TRÌNH</td>\r\n  </tr>\r\n  <tr>\r\n    <td>BẢO QUẢN</td>\r\n    <td>ĐÚNG TIÊU CHUẨN AN TOÀN</td>\r\n  </tr>\r\n  <tr>\r\n    <td>PHỤC VỤ</td>\r\n    <td>TẬN TÂM – NHANH CHÓNG</td>\r\n  </tr>\r\n</table>\r\n\r\n<p style=\"color:#333333\">\r\nSỰ HÀI LÒNG CỦA KHÁCH HÀNG LÀ ĐỘNG LỰC ĐỂ PANTHER FOOD KHÔNG NGỪNG HOÀN THIỆN VÀ PHÁT TRIỂN BỀN VỮNG.\r\n</p>\r\n', '📰 PANTHER FOOD CAM KẾT CHẤT LƯỢNG VÀ AN TOÀN THỰC PHẨM', 'news/news_695547be6bcdf.png', '2025-12-31 22:56:46', '2025-12-31 22:58:15', NULL, 6, 'Công khai', 0, '2025-12-31 22:56:46', '2025-12-31 22:58:15');

-- ----------------------------
-- Table structure for topping
-- ----------------------------
DROP TABLE IF EXISTS `topping`;
CREATE TABLE `topping`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tentopping` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia` decimal(12, 0) NOT NULL DEFAULT 0,
  `hinhanh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of topping
-- ----------------------------
INSERT INTO `topping` VALUES (1, 'Sốt Wasabi', 5000, 'toppings/1767279531_wasabi.jpg', 1, '2026-01-01 21:58:51', '2026-01-01 21:58:51');
INSERT INTO `topping` VALUES (2, 'Sốt BBQ', 5000, 'toppings/1767279547_bbq.jpg', 1, '2026-01-01 21:59:07', '2026-01-01 21:59:07');
INSERT INTO `topping` VALUES (3, 'Muối Ớt', 5000, 'toppings/1767279563_muoiot.jpg', 1, '2026-01-01 21:59:23', '2026-01-01 21:59:23');
INSERT INTO `topping` VALUES (4, 'Kem Phủ', 5000, 'toppings/1767279580_kem.jpg', 1, '2026-01-01 21:59:40', '2026-01-01 21:59:40');
INSERT INTO `topping` VALUES (5, '0% Đường', 0, 'toppings/1767279595_duong.jpg', 1, '2026-01-01 21:59:55', '2026-01-01 21:59:55');
INSERT INTO `topping` VALUES (6, '25% Đường', 0, 'toppings/1767279608_duong.jpg', 1, '2026-01-01 22:00:08', '2026-01-01 22:00:08');
INSERT INTO `topping` VALUES (7, '50% Đường', 0, 'toppings/1767279625_duong.jpg', 1, '2026-01-01 22:00:25', '2026-01-01 22:00:25');
INSERT INTO `topping` VALUES (8, '75% Đường', 0, 'toppings/1767279643_duong.jpg', 1, '2026-01-01 22:00:43', '2026-01-01 22:00:43');
INSERT INTO `topping` VALUES (9, '100% Đường', 0, 'toppings/1767279664_duong.jpg', 1, '2026-01-01 22:01:04', '2026-01-01 22:01:04');
INSERT INTO `topping` VALUES (10, '25% Đá', 0, 'toppings/1767279677_da.jpg', 1, '2026-01-01 22:01:17', '2026-01-01 22:01:17');
INSERT INTO `topping` VALUES (11, '50% Đá', 0, 'toppings/1767279691_da.jpg', 1, '2026-01-01 22:01:31', '2026-01-01 22:01:31');
INSERT INTO `topping` VALUES (12, '75% Đá', 0, 'toppings/1767279705_da.jpg', 1, '2026-01-01 22:01:45', '2026-01-01 22:01:45');
INSERT INTO `topping` VALUES (13, 'Nha Đam', 5000, 'toppings/1767279722_nhadam.jpg', 1, '2026-01-01 22:02:02', '2026-01-01 22:02:02');
INSERT INTO `topping` VALUES (14, 'Thạch', 5000, 'toppings/1767279736_thach.jpg', 1, '2026-01-01 22:02:16', '2026-01-01 22:02:16');
INSERT INTO `topping` VALUES (15, 'Trân Châu Hoàng Kim', 7000, 'toppings/1767279752_tranchauhoangkim.jpg', 1, '2026-01-01 22:02:32', '2026-01-01 22:02:32');
INSERT INTO `topping` VALUES (16, 'Trân Châu Đen', 5000, 'toppings/1767279774_tranchauden.jpg', 1, '2026-01-01 22:02:54', '2026-01-01 22:02:54');
INSERT INTO `topping` VALUES (17, 'Trứng Chiên', 5000, 'toppings/1767279980_trungchien.jpg', 1, '2026-01-01 22:06:20', '2026-01-01 22:06:20');
INSERT INTO `topping` VALUES (18, 'Trứng Lòng Đào', 5000, 'toppings/1767280000_trunglongdao.jpg', 1, '2026-01-01 22:06:40', '2026-01-01 22:06:40');
INSERT INTO `topping` VALUES (19, 'Trứng Muối', 6000, 'toppings/1767280019_trungmuoi.jpg', 1, '2026-01-01 22:06:59', '2026-01-01 22:06:59');
INSERT INTO `topping` VALUES (20, 'Thịt Xông Khói', 6000, 'toppings/1767280041_thitxongkhoi.jpg', 1, '2026-01-01 22:07:21', '2026-01-01 22:07:21');
INSERT INTO `topping` VALUES (21, 'Xúc Xích', 7000, 'toppings/1767280061_xucxich.jpg', 1, '2026-01-01 22:07:41', '2026-01-01 22:07:41');
INSERT INTO `topping` VALUES (22, 'Jăm Bông', 5000, 'toppings/1767280089_jambong.jpg', 1, '2026-01-01 22:08:09', '2026-01-01 22:08:09');
INSERT INTO `topping` VALUES (23, 'Burger', 4000, 'toppings/1767280110_burger.jpg', 1, '2026-01-01 22:08:30', '2026-01-01 22:08:30');
INSERT INTO `topping` VALUES (24, 'Giò Bò', 3000, 'toppings/1767280128_giobo.jpg', 1, '2026-01-01 22:08:48', '2026-01-01 22:08:48');
INSERT INTO `topping` VALUES (25, 'Thịt Bò Lát Mỏng', 6000, 'toppings/1767280146_thitbolatmong.jpg', 1, '2026-01-01 22:09:06', '2026-01-01 22:09:06');
INSERT INTO `topping` VALUES (26, 'Tôm', 3000, 'toppings/1767280165_tom.jpg', 1, '2026-01-01 22:09:25', '2026-01-01 22:09:25');
INSERT INTO `topping` VALUES (27, 'Tôm Thẻ', 4000, 'toppings/1767280182_tomthe.jpg', 1, '2026-01-01 22:09:42', '2026-01-01 22:09:42');
INSERT INTO `topping` VALUES (28, 'Tôm Sú', 6000, 'toppings/1767280197_tomsu.jpg', 1, '2026-01-01 22:09:57', '2026-01-01 22:09:57');
INSERT INTO `topping` VALUES (29, 'Mực Ống', 5000, 'toppings/1767280212_mucong.jpg', 1, '2026-01-01 22:10:12', '2026-01-01 22:10:12');
INSERT INTO `topping` VALUES (30, 'Mực Cắt Khoanh', 5000, 'toppings/1767280228_muccatkhoanh.jpg', 1, '2026-01-01 22:10:28', '2026-01-01 22:10:28');
INSERT INTO `topping` VALUES (31, 'Mực', 10000, 'toppings/1767280244_muc.jpg', 1, '2026-01-01 22:10:44', '2026-01-01 22:10:44');
INSERT INTO `topping` VALUES (32, 'Bạch Tuộc', 11000, 'toppings/1767280260_bachtuoc.jpg', 1, '2026-01-01 22:11:00', '2026-01-01 22:11:00');
INSERT INTO `topping` VALUES (33, 'Cá Viên', 5000, 'toppings/1767280273_cavien.jpg', 1, '2026-01-01 22:11:13', '2026-01-01 22:11:13');
INSERT INTO `topping` VALUES (34, 'Chả Cá', 7000, 'toppings/1767280291_chaca.jpg', 1, '2026-01-01 22:11:31', '2026-01-01 22:11:31');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hoten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sdt` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `trangthai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hoạt động' COMMENT 'Trạng thái tài khoản (Hoạt động, Khóa)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Đức Tuấn', 'tuaansne@gmail.com', '0866468126', '$2y$10$s9RxNY86FDvwN1FKX2De6.SJgDf0kHiqw2Jk/nMGPgdqz6CVS9.Fm', 'avatars/avatar_6954144034496.jpg', 1, 'Hoạt động', '2025-12-31 01:04:32', '2025-12-31 01:04:48', NULL);

SET FOREIGN_KEY_CHECKS = 1;
