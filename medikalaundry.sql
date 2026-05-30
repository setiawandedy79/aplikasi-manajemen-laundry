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

 Date: 30/05/2026 12:57:53
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
  `berat_kotor` decimal(10, 2) NULL DEFAULT 0.00,
  `berat_bersih` decimal(10, 2) NULL DEFAULT 0.00,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 68 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pakaian
-- ----------------------------
INSERT INTO `pakaian` VALUES (1, 'Alas Timbangan', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (2, 'Baju Bayi', 'Bantal', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (3, 'Baju Pasien', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (4, 'Baju Pengunjung', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (5, 'Baju Perawat/Dokter', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (6, 'Bando', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (7, 'Bantal Bayi', 'Bantal', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (8, 'Bantal Dewasa', 'Bantal', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (9, 'Bantal Dewasa PERLAK ', 'Bantal', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (10, 'Bed Cover', 'Bed', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (11, 'Bedong Pink/Biru', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (12, 'Celana Bayi', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (13, 'Celana Perawat/Dokter', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (14, 'Celemek', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (15, 'Drum Jarum Kotak', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (16, 'Drum Jarum Panjang', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (17, 'Duk Belah', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (18, 'Duk Lubang Besar', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (19, 'Duk Lubang Kecil', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (20, 'Duk Lubang Sedang', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (21, 'Duk Segi Empat', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (22, 'Gantungan Kaki', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (23, 'Guling  Kecil', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (24, 'Guling Besar', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (25, 'Gurita Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (26, 'Handuk', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (27, 'Jas Operasi Besar', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (28, 'Jas Perawat', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (29, 'Kaos Kaki', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (30, 'Kaos Tangan', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (31, 'Kasur / Bed', 'Bed', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (32, 'Kelambu Hitam /Putih', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (33, 'Kerudung', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (34, 'Keset', 'Keset', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (35, 'Kordyn', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (36, 'Lap handuk gantung', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (37, 'Lap kotak', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (38, 'Lurik Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (39, 'Masker Kain', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (40, 'Mukena', 'Baju', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (41, 'Penutup Mata', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (42, 'Perlak Besar', 'Perlak', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (43, 'Perlak Dikubitus', 'Perlak', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (44, 'Perlak Kecil', 'Perlak', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (45, 'Perlak Sedang', 'Perlak', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (46, 'Popok Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (47, 'Sarung Bantal Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (48, 'Sarung Bantal Besar', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (49, 'Sarung Guling Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (50, 'Sarung Guling Besar', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (51, 'Sarung Bantal Pasir', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (52, 'Scort', 'Scort', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (53, 'Seketsel', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (54, 'Selimut', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (55, 'Serbet', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (56, 'Sprei Bayi', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (57, 'Sprei Dewasa', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (58, 'Sprei Inkubator', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (59, 'Stick Laken', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (60, 'Taplak', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (61, 'Tempat HandScoen', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (62, 'Topi Pasien / Topi Perawat', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (63, 'Tutup Alat', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (64, 'Tutup Belibed', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (65, 'Tutup Kulkas', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (66, 'Tutup O2', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');
INSERT INTO `pakaian` VALUES (67, 'Waslap', 'Linen', 0.00, 0.00, '2026-05-18 08:54:40');

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
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (1, 'Rama', 'RS Permata Medika', '136', '2026-05-18 14:27:05');
INSERT INTO `pelanggan` VALUES (2, 'Dewi Kunthi', 'RS Permata Medika', '130', '2026-05-20 14:14:20');
INSERT INTO `pelanggan` VALUES (3, 'Arimbi', 'RS Permata Medika', '131', '2026-05-20 14:14:39');
INSERT INTO `pelanggan` VALUES (4, 'Laboratorium', 'RS Permata Medika', '123', '2026-05-20 14:15:14');
INSERT INTO `pelanggan` VALUES (5, 'Poliklinik', 'RS Permata Medika', '164', '2026-05-20 14:15:37');
INSERT INTO `pelanggan` VALUES (6, 'Fisioterapi', 'RS Permata Medika', '124', '2026-05-20 14:16:00');
INSERT INTO `pelanggan` VALUES (7, 'Radiologi', 'RS Permata Medika', '125', '2026-05-20 14:16:19');
INSERT INTO `pelanggan` VALUES (8, 'Hemodialisa', 'RS Permata Medika', '122', '2026-05-20 14:16:57');
INSERT INTO `pelanggan` VALUES (9, 'IGD', 'RS Permata Medika', '106', '2026-05-20 14:17:32');
INSERT INTO `pelanggan` VALUES (10, 'IBS', 'RS Permata Medika', '304', '2026-05-20 14:17:57');
INSERT INTO `pelanggan` VALUES (11, 'IKB', 'RS Permata Medika', '305', '2026-05-20 14:18:15');
INSERT INTO `pelanggan` VALUES (12, 'Peristi', 'RS Permata Medika', '127', '2026-05-20 14:18:31');
INSERT INTO `pelanggan` VALUES (13, 'ICU', 'RS Permata Medika', '126', '2026-05-20 14:18:46');

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
  `supplier_id` int NULL DEFAULT NULL,
  `stok_awal` decimal(10, 2) NULL DEFAULT 0.00,
  `stok_akhir` decimal(10, 2) NULL DEFAULT 0.00,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `satuan_id`(`satuan_id` ASC) USING BTREE,
  INDEX `fk_sabun_supplier`(`supplier_id` ASC) USING BTREE,
  CONSTRAINT `fk_sabun_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `sabun_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_sabun` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sabun
-- ----------------------------
INSERT INTO `sabun` VALUES (1, 'ALKALIN ( BOOST )', 3, 1, 10.00, 15.00, '2026-05-18 13:25:37');
INSERT INTO `sabun` VALUES (2, 'DETERGEN ( WASH )', 3, 1, 5000.00, 6500.00, '2026-05-18 14:14:44');
INSERT INTO `sabun` VALUES (3, 'OXYGENT BLEACH (OXI- BRITE )', 3, 1, NULL, NULL, '2026-05-18 14:14:44');
INSERT INTO `sabun` VALUES (4, 'NEUTRALIZER ( SOUR )', 3, 1, NULL, NULL, '2026-05-18 14:14:44');
INSERT INTO `sabun` VALUES (5, 'SOFTENER ( FLUFI )', 3, 1, NULL, NULL, '2026-05-18 14:14:44');

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
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kontak` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 'Ecolab', 'adi', 'semarang', '123456789', '2026-05-22 11:17:42');

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
  `jumlah_kg` decimal(10, 2) NULL DEFAULT 0.00,
  `jumlah_diserahkan` int NULL DEFAULT 0,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transaksi_id`(`transaksi_id` ASC) USING BTREE,
  INDEX `pakaian_id`(`pakaian_id` ASC) USING BTREE,
  CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi_header` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`pakaian_id`) REFERENCES `pakaian` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 217 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_detail
-- ----------------------------
INSERT INTO `transaksi_detail` VALUES (1, 13, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (2, 13, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (3, 13, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (4, 13, 9, 1, 3, 0.00, 3, '');
INSERT INTO `transaksi_detail` VALUES (5, 13, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (6, 13, 7, 1, 2, 0.00, 2, '');
INSERT INTO `transaksi_detail` VALUES (7, 13, 6, 1, 1, 0.00, 1, '');
INSERT INTO `transaksi_detail` VALUES (8, 13, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (9, 13, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (10, 13, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (11, 13, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (12, 13, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (13, 14, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (14, 14, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (15, 14, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (16, 14, 9, 1, 2, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (17, 14, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (18, 14, 7, 1, 3, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (19, 14, 6, 1, 4, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (20, 14, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (21, 14, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (22, 14, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (23, 14, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (24, 14, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (85, 15, 12, 1, 3, 5.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (86, 15, 11, 1, 2, 2.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (87, 15, 10, 0, 0, 0.00, 0, '0');
INSERT INTO `transaksi_detail` VALUES (88, 15, 9, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (89, 15, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (90, 15, 7, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (91, 15, 6, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (92, 15, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (93, 15, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (94, 15, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (95, 15, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (96, 15, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (109, 17, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (110, 17, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (111, 17, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (112, 17, 9, 1, 1, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (113, 17, 8, 1, 2, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (114, 17, 7, 1, 3, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (115, 17, 6, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (116, 17, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (117, 17, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (118, 17, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (119, 17, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (120, 17, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (157, 18, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (158, 18, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (159, 18, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (160, 18, 9, 1, 2, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (161, 18, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (162, 18, 7, 1, 3, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (163, 18, 6, 1, 1, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (164, 18, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (165, 18, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (166, 18, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (167, 18, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (168, 18, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (169, 16, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (170, 16, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (171, 16, 10, 1, 1, 0.00, 1, '');
INSERT INTO `transaksi_detail` VALUES (172, 16, 9, 1, 2, 0.00, 2, '');
INSERT INTO `transaksi_detail` VALUES (173, 16, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (174, 16, 7, 1, 3, 0.00, 3, '');
INSERT INTO `transaksi_detail` VALUES (175, 16, 6, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (176, 16, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (177, 16, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (178, 16, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (179, 16, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (180, 16, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (181, 19, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (182, 19, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (183, 19, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (184, 19, 9, 1, 2, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (185, 19, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (186, 19, 7, 1, 3, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (187, 19, 6, 1, 4, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (188, 19, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (189, 19, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (190, 19, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (191, 19, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (192, 19, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (193, 20, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (194, 20, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (195, 20, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (196, 20, 9, 1, 2, 0.00, 1, ' 1 rusak');
INSERT INTO `transaksi_detail` VALUES (197, 20, 8, 1, 2, 0.00, 2, '');
INSERT INTO `transaksi_detail` VALUES (198, 20, 7, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (199, 20, 6, 1, 3, 0.00, 3, '');
INSERT INTO `transaksi_detail` VALUES (200, 20, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (201, 20, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (202, 20, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (203, 20, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (204, 20, 1, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (205, 21, 12, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (206, 21, 11, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (207, 21, 10, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (208, 21, 9, 1, 3, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (209, 21, 8, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (210, 21, 7, 1, 1, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (211, 21, 6, 1, 2, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (212, 21, 5, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (213, 21, 4, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (214, 21, 3, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (215, 21, 2, 0, 0, 0.00, 0, '');
INSERT INTO `transaksi_detail` VALUES (216, 21, 1, 0, 0, 0.00, 0, '');

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
  `nama_pengambil` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pelanggan_id` int NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `shift` enum('pagi','siang') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis_laundry` enum('Infeksius','Non Infeksius') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Non Infeksius',
  `status_serah` enum('belum','diserahkan') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'belum',
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `no_transaksi`(`no_transaksi` ASC) USING BTREE,
  INDEX `pelanggan_id`(`pelanggan_id` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `transaksi_header_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `transaksi_header_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_header
-- ----------------------------
INSERT INTO `transaksi_header` VALUES (6, 'MLP202605180001', '2026-05-18', 'dedy', 'fajar', 'arman', 1, 1, 'pagi', 'Non Infeksius', 'diserahkan', '2026-05-18 22:03:06');
INSERT INTO `transaksi_header` VALUES (13, 'MLP202605190001', '2026-05-19', 'edy', 'fajar', 'adi', 1, 1, 'pagi', 'Non Infeksius', 'diserahkan', '2026-05-19 09:18:02');
INSERT INTO `transaksi_header` VALUES (14, 'MLP202605190002', '2026-05-19', 'candra', 'puji', NULL, 1, 1, 'pagi', 'Non Infeksius', 'belum', '2026-05-19 12:49:04');
INSERT INTO `transaksi_header` VALUES (15, 'MLP202605190003', '2026-05-19', 'P. Rama', 'HK', NULL, 1, 1, 'pagi', 'Non Infeksius', 'belum', '2026-05-19 14:20:48');
INSERT INTO `transaksi_header` VALUES (16, 'MLP202605250001', '2026-05-25', 'dedy', 'HK', 'ida', 9, 1, 'siang', 'Infeksius', 'diserahkan', '2026-05-25 12:08:58');
INSERT INTO `transaksi_header` VALUES (17, 'MLP202605250002', '2026-05-25', 'P. Rama', 'fajar', NULL, 12, 1, 'pagi', 'Non Infeksius', 'belum', '2026-05-25 12:11:15');
INSERT INTO `transaksi_header` VALUES (18, 'MLP202605250003', '2026-05-25', 'dedy', 'fajar', NULL, 11, 1, 'pagi', 'Infeksius', 'belum', '2026-05-25 12:35:33');
INSERT INTO `transaksi_header` VALUES (19, 'MLP202605250004', '2026-05-25', 'Eko', 'Nana', NULL, 6, 1, 'siang', 'Non Infeksius', 'belum', '2026-05-25 12:56:19');
INSERT INTO `transaksi_header` VALUES (20, 'MLP202605250005', '2026-05-25', 'candra', 'HK', 'vita', 5, 1, 'siang', 'Non Infeksius', 'diserahkan', '2026-05-25 14:28:05');
INSERT INTO `transaksi_header` VALUES (21, 'MLP202605250006', '2026-05-25', 'dedy', 'HK', NULL, 9, 1, 'siang', 'Infeksius', 'belum', '2026-05-25 14:28:46');

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', '2026-05-16 13:17:20');
INSERT INTO `users` VALUES (3, 'kasir01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kasir Laundry', 'kasir', '2026-05-19 10:32:24');
INSERT INTO `users` VALUES (4, 'operator01', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Operator Sabun', 'operator', '2026-05-19 10:32:24');
INSERT INTO `users` VALUES (5, 'Riyanti', '$2y$10$nMtdMrHIPd1IEChSuBiyienLa2I8AuMuz4PWal9ixXblJs0F7Xk2m', 'Riyanti', 'operator', '2026-05-19 08:30:18');
INSERT INTO `users` VALUES (6, 'puji', '$2y$10$/Jz7y1YjLh225gshtWl0B.pB9XAV4crRWLoErUEz1m.poXqVJ9cIG', 'puji', 'kasir', '2026-05-19 08:30:57');
INSERT INTO `users` VALUES (7, 'fajar4561', '$2y$10$QaM2D6IvYC3hIDn/6rgViOYNx8pFME6YGsL3mCNQfa5LTqVHHcEl.', '123456', 'operator', '2026-05-19 09:23:59');

SET FOREIGN_KEY_CHECKS = 1;
