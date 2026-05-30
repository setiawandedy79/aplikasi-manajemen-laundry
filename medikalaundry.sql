/*
 Navicat Premium Data Transfer

 Source Server         : dbconan
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : medikalaundry

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 19/05/2026 14:02:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mutasi_sabun_masuk
-- ----------------------------
DROP TABLE IF EXISTS `mutasi_sabun_masuk`;
CREATE TABLE `mutasi_sabun_masuk`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sabun_id` int NOT NULL,
  `jumlah` decimal(10, 2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `user_id` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sabun_id`(`sabun_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `mutasi_sabun_masuk_ibfk_1` FOREIGN KEY (`sabun_id`) REFERENCES `sabun` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mutasi_sabun_masuk_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mutasi_sabun_masuk
-- ----------------------------
INSERT INTO `mutasi_sabun_masuk` VALUES (1, 1, 3.50, '2026-05-18', '', 1, '2026-05-18 13:49:59');
INSERT INTO `mutasi_sabun_masuk` VALUES (2, 2, 4500.00, '2026-05-19', '', 1, '2026-05-19 09:47:16');
INSERT INTO `mutasi_sabun_masuk` VALUES (3, 1, 5.00, '2026-05-19', '', 1, '2026-05-19 11:58:38');

-- ----------------------------
-- Table structure for pakaian
-- ----------------------------
DROP TABLE IF EXISTS `pakaian`;
CREATE TABLE `pakaian`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pakaian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kategori` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pakaian
-- ----------------------------
INSERT INTO `pakaian` VALUES (1, 'Kemeja', 'Atasan', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (2, 'Celana Panjang', 'Bawahan', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (3, 'Celana Pendek', 'Bawahan', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (4, 'Jaket', 'Outerwear', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (5, 'Gaun', 'Dress', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (6, 'Seprei', 'Bed Cover', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (7, 'Selimut', 'Bed Cover', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (8, 'Handuk', 'Aksesoris', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (9, 'Sprei', 'Bed Cover', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (10, 'Sarung Bantal', 'Bed Cover', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (11, 'Boneka', 'Lainnya', '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (12, 'Karpet', 'Lainnya', '2026-05-18 08:54:40');

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (1, 'Rama', 'RS Permata Medika', '136', '2026-05-18 14:27:05');

-- ----------------------------
-- Table structure for pemakaian_sabun
-- ----------------------------
DROP TABLE IF EXISTS `pemakaian_sabun`;
CREATE TABLE `pemakaian_sabun`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sabun_id` int NOT NULL,
  `jumlah` decimal(10, 2) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` enum('pagi','siang') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sabun_id`(`sabun_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `pemakaian_sabun_ibfk_1` FOREIGN KEY (`sabun_id`) REFERENCES `sabun` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pemakaian_sabun_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemakaian_sabun
-- ----------------------------
INSERT INTO `pemakaian_sabun` VALUES (1, 1, 3.50, '2026-05-18', 'pagi', 1, '', '2026-05-18 13:26:11');
INSERT INTO `pemakaian_sabun` VALUES (2, 2, 1500.00, '2026-05-18', 'siang', 1, '', '2026-05-18 14:15:07');
INSERT INTO `pemakaian_sabun` VALUES (3, 2, 1500.00, '2026-05-19', 'pagi', 1, '', '2026-05-19 12:49:47');

-- ----------------------------
-- Table structure for sabun
-- ----------------------------
DROP TABLE IF EXISTS `sabun`;
CREATE TABLE `sabun`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_sabun` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `satuan_id` int NULL DEFAULT NULL,
  `stok_awal` decimal(10, 2) NULL DEFAULT 0.00,
  `stok_akhir` decimal(10, 2) NULL DEFAULT 0.00,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `satuan_id`(`satuan_id` ASC) USING BTREE,
  CONSTRAINT `sabun_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_sabun` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sabun
-- ----------------------------
INSERT INTO `sabun` VALUES (1, 'Rinso', 1, 10.00, 15.00, '2026-05-18 13:25:37');
INSERT INTO `sabun` VALUES (2, 'Bayclean', 4, 5000.00, 6500.00, '2026-05-18 14:14:44');

-- ----------------------------
-- Table structure for satuan_sabun
-- ----------------------------
DROP TABLE IF EXISTS `satuan_sabun`;
CREATE TABLE `satuan_sabun`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satuan_sabun
-- ----------------------------
INSERT INTO `satuan_sabun` VALUES (1, 'Liter', '2026-05-18 08:54:40');
INSERT INTO `satuan_sabun` VALUES (2, 'Kg', '2026-05-18 08:54:40');
INSERT INTO `satuan_sabun` VALUES (3, 'Ml', '2026-05-18 08:54:40');
INSERT INTO `satuan_sabun` VALUES (4, 'Gram', '2026-05-18 08:54:40');

-- ----------------------------
-- Table structure for transaksi_detail
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_detail`;
CREATE TABLE `transaksi_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaksi_id` int NOT NULL,
  `pakaian_id` int NOT NULL,
  `ceklis` tinyint(1) NULL DEFAULT 0,
  `jumlah` int NULL DEFAULT 1,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transaksi_id`(`transaksi_id` ASC) USING BTREE,
  INDEX `pakaian_id`(`pakaian_id` ASC) USING BTREE,
  CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi_header` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`pakaian_id`) REFERENCES `pakaian` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_detail
-- ----------------------------
INSERT INTO `transaksi_detail` VALUES (1, 13, 12, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (2, 13, 11, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (3, 13, 10, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (4, 13, 9, 1, 3, '');
INSERT INTO `transaksi_detail` VALUES (5, 13, 8, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (6, 13, 7, 1, 2, '');
INSERT INTO `transaksi_detail` VALUES (7, 13, 6, 1, 1, '');
INSERT INTO `transaksi_detail` VALUES (8, 13, 5, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (9, 13, 4, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (10, 13, 3, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (11, 13, 2, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (12, 13, 1, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (13, 14, 12, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (14, 14, 11, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (15, 14, 10, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (16, 14, 9, 1, 2, '');
INSERT INTO `transaksi_detail` VALUES (17, 14, 8, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (18, 14, 7, 1, 3, '');
INSERT INTO `transaksi_detail` VALUES (19, 14, 6, 1, 4, '');
INSERT INTO `transaksi_detail` VALUES (20, 14, 5, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (21, 14, 4, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (22, 14, 3, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (23, 14, 2, 0, 0, '');
INSERT INTO `transaksi_detail` VALUES (24, 14, 1, 0, 0, '');

-- ----------------------------
-- Table structure for transaksi_header
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_header`;
CREATE TABLE `transaksi_header`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nama_pengirim` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_penerima` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pelanggan_id` int NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `shift` enum('pagi','siang') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `no_transaksi`(`no_transaksi` ASC) USING BTREE,
  INDEX `pelanggan_id`(`pelanggan_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `transaksi_header_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transaksi_header_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_header
-- ----------------------------
INSERT INTO `transaksi_header` VALUES (6, 'MLP202605180001', '2026-05-18', 'dedy', 'fajar', 1, 1, 'pagi', '2026-05-18 22:03:06');
INSERT INTO `transaksi_header` VALUES (13, 'MLP202605190001', '2026-05-19', 'edy', 'fajar', 1, 1, 'pagi', '2026-05-19 09:18:02');
INSERT INTO `transaksi_header` VALUES (14, 'MLP202605190002', '2026-05-19', 'candra', 'puji', 1, 1, 'pagi', '2026-05-19 12:49:04');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` enum('admin','kasir','operator') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'kasir',
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', '2026-05-16 13:17:20');
INSERT INTO `users` VALUES (3, 'kasir01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kasir Laundry', 'kasir', '2026-05-19 10:32:24');
INSERT INTO `users` VALUES (4, 'operator01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operator Sabun', 'operator', '2026-05-19 10:32:24');
INSERT INTO `users` VALUES (5, 'Riyanti', '$2y$10$nMtdMrHIPd1IEChSuBiyienLa2I8AuMuz4PWal9ixXblJs0F7Xk2m', 'Riyanti', 'operator', '2026-05-19 08:30:18');
INSERT INTO `users` VALUES (6, 'puji', '$2y$10$/Jz7y1YjLh225gshtWl0B.pB9XAV4crRWLoErUEz1m.poXqVJ9cIG', 'puji', 'kasir', '2026-05-19 08:30:57');

SET FOREIGN_KEY_CHECKS = 1;
