-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 06:50 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlydathang`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDonDH` int(6) UNSIGNED DEFAULT NULL,
  `MSHH` int(6) UNSIGNED DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `GiaDatHang` decimal(7,2) DEFAULT NULL,
  `GiamGia` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(4216, 35, 4, '60.00', '24.60'),
(483, 35, 5, '75.00', '66.75'),
(5354, 5, 1, '200.65', '132.43'),
(8142, 33, 2, '30.00', '11.10'),
(3004, 34, 1, '15.00', '6.45'),
(5426, 35, 1, '15.00', '7.05'),
(8308, 4, 5, '517.50', '93.15'),
(5215, 5, 1, '200.65', '60.20'),
(7420, 1, 3, '337.65', '128.31'),
(8081, 34, 12, '180.00', '108.00'),
(7887, 34, 3, '45.00', '35.10'),
(9863, 33, 5, '75.00', '39.75');

-- --------------------------------------------------------

--
-- Table structure for table `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(6) UNSIGNED NOT NULL,
  `MSKH` int(6) UNSIGNED DEFAULT NULL,
  `MSNV` int(6) UNSIGNED DEFAULT NULL,
  `NgayDH` timestamp NULL DEFAULT NULL,
  `NgayGH` timestamp NULL DEFAULT NULL,
  `Duyet` int(2) NOT NULL
) ;

--
-- Dumping data for table `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `Duyet`) VALUES
(144, 1, 1, '2021-06-07 07:17:17', '2021-06-07 07:18:29', 1),
(483, 1, 1, '2021-06-07 07:06:07', '2021-06-07 07:14:42', 1),
(1754, 33, 1, '2021-06-07 06:22:11', NULL, 0),
(3004, 33, 1, '2021-06-07 15:34:56', '2021-06-07 16:33:11', 1),
(4216, 33, 1, '2021-06-07 06:37:44', '2021-06-07 09:45:45', 1),
(4343, 33, 1, '2021-06-07 06:37:44', NULL, 0),
(5215, 1, 1, '2021-06-07 16:34:25', NULL, 0),
(5354, 1, 1, '2021-06-07 07:17:17', '2021-06-07 16:33:03', 1),
(5426, 33, 1, '2021-06-07 15:34:56', NULL, 0),
(7275, 1, 1, '2021-06-07 07:06:07', NULL, 0),
(7420, 34, 1, '2021-06-07 16:45:35', NULL, 0),
(7887, 34, 1, '2021-06-07 16:46:30', NULL, 0),
(8081, 34, 1, '2021-06-07 16:45:35', NULL, 0),
(8142, 33, 1, '2021-06-07 15:11:36', '2021-06-07 15:38:53', 1),
(8308, 1, 1, '2021-06-07 16:34:25', NULL, 0),
(9863, 34, 1, '2021-06-07 16:49:26', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `diachikh`
--

CREATE TABLE `diachikh` (
  `MaDC` int(6) UNSIGNED NOT NULL,
  `DiaChi` text DEFAULT NULL,
  `MSKH` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `diachikh`
--

INSERT INTO `diachikh` (`MaDC`, `DiaChi`, `MSKH`) VALUES
(1, 'So 25, Quan 1, HCM', 1),
(2, 'Cờ Đỏ, Cần Thơ', 33),
(3, '3/2, Xuân Khánh, Ninh Kiều, Cần Thơ.', 34);

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(6) UNSIGNED NOT NULL,
  `TenHH` varchar(50) NOT NULL,
  `HinhAnh` text DEFAULT NULL,
  `QuyCach` varchar(25) DEFAULT NULL,
  `Gia` decimal(7,2) DEFAULT NULL,
  `SoLuongHang` int(11) DEFAULT NULL,
  `MaLoaiHang` varchar(6) NOT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `HinhAnh`, `QuyCach`, `Gia`, `SoLuongHang`, `MaLoaiHang`, `GhiChu`) VALUES
(1, 'Utaha', 'utaha_01.jpg', '', '112.55', 22, '1/12', 'Nhân vật từ parody Saekano.\r\nChiều cao: 150cm. \r\nTrọng lượng: 255g.'),
(3, 'Asuka', 'asuka_01.jpg', '', '125.50', 2, '1/12', 'Nhân vật từ parody Neon Evangelion GenenisChiều cao: 100cm <br> Trọng lượng: 350g </p>'),
(4, 'Ayanami', 'ayanami_01.jpg', '', '103.50', 50, '1/7', '<p> Nhân vật từ parody Neon Evangelion Genenis <br> Chiều cao: 110cm <br> Trọng lượng: 325g </p>'),
(5, 'Arturia Pendragon', 'arturia_02.jpg', '', '200.65', 1, '1/12', '<p> Nhân vật từ parody Fate Stay Night <br> Chiều cao: 157cm <br> Trọng lượng: 250g </p>'),
(33, 'Kurumi 1/12', 'kurumi_02.jpg', NULL, '15.00', 10, '1/12', '<p> Nhân vật từ series Date A Live </p>'),
(34, '2B 1/12', '2b_02.jpg', NULL, '15.00', 0, '1/12', '<p> Nhân vật từ Nier Automata </p>'),
(35, 'Jeanne', 'jeanne_02.jpg', NULL, '15.00', 15, '1/12', '<p> Nhân vật từ series Fate </p>');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(6) UNSIGNED NOT NULL,
  `MatKhau` varchar(8) NOT NULL,
  `HoTenKH` varchar(50) DEFAULT NULL,
  `TenCongTy` varchar(50) DEFAULT NULL,
  `MaDC` int(6) UNSIGNED NOT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL,
  `Email` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `MatKhau`, `HoTenKH`, `TenCongTy`, `MaDC`, `SoDienThoai`, `Email`) VALUES
(1, '123456', 'Van A', 'TMA', 1, '0383171107', 'vana@gmail.com'),
(33, '123456', 'Le Trung Test', 'Test', 3, '0383171100', 'test@gmail.com'),
(34, '123456', 'Le Trung Test 1', 'Test 1', 2, '0383171100', 'test@gmail.com'),
(181097, 'b1506704', 'Lê Bảo Anh', 'CTU', 3, '0383171107', 'anhb1506704@student.ctu.e');

-- --------------------------------------------------------

--
-- Table structure for table `loaihanghoa`
--

CREATE TABLE `loaihanghoa` (
  `MaLoaiHang` varchar(6) NOT NULL,
  `TenLoaiHang` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loaihanghoa`
--

INSERT INTO `loaihanghoa` (`MaLoaiHang`, `TenLoaiHang`) VALUES
('1/1', 'Full scale'),
('1/12', '1/12 scale'),
('1/4', '1/4 scale'),
('1/7', '1/7 scale');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(6) UNSIGNED NOT NULL,
  `MatKhau` varchar(8) NOT NULL,
  `HoTenNV` varchar(50) DEFAULT NULL,
  `ChucVu` varchar(20) DEFAULT NULL,
  `DiaChi` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `MatKhau`, `HoTenNV`, `ChucVu`, `DiaChi`, `SoDienThoai`) VALUES
(1, '', 'Van B', 'Ke Toan', NULL, '0384222111'),
(2, '123456', 'Lê Bảo Anh', 'admin', '3/2, Xuân Khánh, Ninh Kiều, Cần Thơ. ', '0383171107');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD KEY `SoDonDH` (`SoDonDH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Indexes for table `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Indexes for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Indexes for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `MaLoaiHang` (`MaLoaiHang`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`),
  ADD KEY `MaDC` (`MaDC`);

--
-- Indexes for table `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  ADD PRIMARY KEY (`MaLoaiHang`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SoDonDH` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MaDC` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181098;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MSNV` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`),
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Constraints for table `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`),
  ADD CONSTRAINT `dathang_ibfk_2` FOREIGN KEY (`MSNV`) REFERENCES `nhanvien` (`MSNV`);

--
-- Constraints for table `diachikh`
--
ALTER TABLE `diachikh`
  ADD CONSTRAINT `diachikh_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`);

--
-- Constraints for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaLoaiHang`) REFERENCES `loaihanghoa` (`MaLoaiHang`);

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaDC`) REFERENCES `diachikh` (`MaDC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
