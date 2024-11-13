-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2023 at 09:42 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usahajaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga_per_satuan` double DEFAULT NULL,
  `stok_kuantitas` int(11) DEFAULT NULL,
  `jenis_satuan` enum('Unit','Kilogram (kg)','Gram (g)','Liter (L)','Mililiter (mL)','Meter (m)','Sentimeter (cm)','Buah (pcs)','Gulung (roll)','Meter Persegi (m^2)','Meter Kubik (m^3)','Ton') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id`, `nama`, `harga_per_satuan`, `stok_kuantitas`, `jenis_satuan`, `created_at`, `updated_at`) VALUES
(1, 'Kain Katun Polos', 22000, 1000, 'Meter (m)', '2023-12-12 05:13:26', '2023-12-12 05:13:26'),
(2, 'Kancing', 500, 1000, 'Unit', '2023-12-12 05:17:37', '2023-12-12 05:17:37'),
(3, 'Benang Jahit', 1500, 1000, 'Buah (pcs)', '2023-12-12 05:19:20', '2023-12-12 05:19:20'),
(4, 'Resleting', 11000, 0, 'Meter (m)', '2023-12-15 00:51:25', '2023-12-15 00:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku_supplier`
--

CREATE TABLE `bahan_baku_supplier` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `bahan_baku_id` int(11) NOT NULL,
  `harga_supplier` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_bahan_baku_produk`
--

CREATE TABLE `detail_bahan_baku_produk` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `bahan_baku_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `biaya_tambahan` double DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Berhenti','Selesai','Dibatalkan','Sedang Produksi') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Atasan', 'Baju yang yang khusus untuk menutupi badan bagian atas saja', '2023-12-12 04:17:20', '2023-12-12 05:57:41'),
(2, 'Bawahan', 'Baju yang yang khusus untuk menutupi badan bagian bawah saja', '2023-12-12 04:34:03', '2023-12-12 05:58:08'),
(3, 'Lain-lain', 'Baju yang berupa aksesoris / pakaian tambahan', '2023-12-12 06:05:43', '2023-12-12 06:05:43'),
(6, 'Aksesoris', 'Pelengkap pada pakaian', '2023-12-14 14:09:49', '2023-12-14 14:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `produk_ukuran_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `peran`
--

CREATE TABLE `peran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peran`
--

INSERT INTO `peran` (`id`, `nama`, `deskripsi`, `kode`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Memiliki hak akses istimewa kepada semua data pada database', 'ADMN', '2023-12-15 01:08:45', '2023-12-15 01:14:48'),
(2, 'Karyawan Pembelanjaan', 'Memiliki hak akses istimewa kepada pembelanjaan perusahaan', 'KBLJ', '2023-12-15 01:12:29', '2023-12-15 01:13:14'),
(3, 'Karyawan Keuangan', 'Memiliki hak akses istimewa kepada keuangan perusahaan', 'KKEU', '2023-12-15 01:14:34', '2023-12-15 01:14:34'),
(4, 'Karyawan Produksi', 'Memiliki hak akses istimewa kepada proses produksi perusahaan ', 'KPROD', '2023-12-15 01:16:21', '2023-12-15 01:16:21'),
(5, 'Pelanggan', 'Pengguna sistem, dapat melakukan pembelian dan pemesanan produk', 'CUST', '2023-12-15 01:19:02', '2023-12-15 01:19:02');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `alamat_pengiriman` varchar(255) DEFAULT NULL,
  `metode_pembayaran` enum('Kartu Kredit','Transfer','COD') NOT NULL,
  `total_harga` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `kode`, `tanggal`, `alamat_pengiriman`, `metode_pembayaran`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2023-12-15 06:44:30', 'Kedung Lumbu, Pasar Kliwon, Surakarta City, Central Java 57133', 'COD', 400000, '2023-12-15 05:48:35', '2023-12-15 05:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `gambar`, `deskripsi`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, 'T-Shirt Katun Polos Lengan Pendek', 'image/produk1.jpeg', 'Kaus T-Shirt terbuat dari katun, Polos', 1, '2023-12-12 04:17:34', '2023-12-15 07:00:53'),
(2, 'Celana Chino Pendek', 'image/produk2.jpeg', 'Celana chino pendek polos', 2, '2023-12-12 04:36:17', '2023-12-15 07:40:09'),
(17, 'Celana Panjang Jeans Denim', 'image/jeansdenim.jpeg', 'Celana Penjang Jeans Denim, produk jadi dari bahan denim yang diproduksi menjadi celana jeans', 2, '2023-12-14 07:11:21', '2023-12-15 07:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `produk_ukuran`
--

CREATE TABLE `produk_ukuran` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `ukuran_id` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk_ukuran`
--

INSERT INTO `produk_ukuran` (`id`, `produk_id`, `ukuran_id`, `harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 60000, '2023-12-15 07:26:59', '2023-12-15 07:26:59'),
(2, 1, 2, 60000, '2023-12-15 07:27:13', '2023-12-15 07:27:13'),
(3, 1, 3, 60000, '2023-12-15 07:27:45', '2023-12-15 07:27:45'),
(4, 1, 4, 60000, '2023-12-15 07:28:07', '2023-12-15 07:28:07'),
(5, 1, 5, 70000, '2023-12-15 07:30:14', '2023-12-15 07:30:14'),
(6, 1, 6, 80000, '2023-12-15 07:30:30', '2023-12-15 07:30:30'),
(7, 2, 2, 35000, '2023-12-15 07:33:56', '2023-12-15 07:33:56'),
(8, 2, 3, 35000, '2023-12-15 07:34:07', '2023-12-15 07:34:07'),
(9, 2, 4, 35000, '2023-12-15 07:34:19', '2023-12-15 07:34:19'),
(10, 2, 5, 35000, '2023-12-15 07:34:40', '2023-12-15 07:34:40'),
(11, 2, 6, 35000, '2023-12-15 07:34:50', '2023-12-15 07:34:50'),
(12, 2, 7, 35000, '2023-12-15 07:35:04', '2023-12-15 07:35:04'),
(13, 17, 1, 50000, '2023-12-15 07:46:11', '2023-12-15 07:46:11'),
(14, 17, 5, 50000, '2023-12-15 07:46:33', '2023-12-15 07:46:33'),
(15, 17, 6, 50000, '2023-12-15 07:46:46', '2023-12-15 07:46:46'),
(16, 17, 7, 50000, '2023-12-15 07:47:15', '2023-12-15 07:47:15'),
(17, 17, 8, 50000, '2023-12-15 07:47:27', '2023-12-15 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `nomor_telepon`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Pt. Asia GarmentS Accessories (Charisma Solo)', 'Jl. Yos Sudarso No.350, Serengan, Surakarta (Solo)', '(0271) 639 355', 'asia_garment_id@yahoo.com', '2023-12-15 03:57:30', '2023-12-15 03:57:30'),
(2, 'Dunia Sandang ONE STOP GARMENT SUPPLIER', 'Jl. Terusan Pasirkoja No. 250, Bandung', '+62 812-2277-6523', 'cs@duniasandang.com', '2023-12-15 04:44:53', '2023-12-15 04:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `bahan_baku_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` double DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  `metode_pembayaran` enum('COD','Kartu Kredit','Transfer') DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT NULL,
  `cara_pengiriman` varchar(255) DEFAULT NULL,
  `catatan_tambahan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'S', '2023-12-15 07:25:08', '2023-12-15 07:25:08'),
(2, 'M', '2023-12-15 07:25:13', '2023-12-15 07:25:13'),
(3, 'L', '2023-12-15 07:25:20', '2023-12-15 07:25:20'),
(4, 'XL', '2023-12-15 07:25:48', '2023-12-15 07:25:48'),
(5, 'XXL', '2023-12-15 07:25:53', '2023-12-15 07:25:53'),
(6, '3XL', '2023-12-15 07:25:58', '2023-12-15 07:25:58'),
(7, '4XL', '2023-12-15 07:32:32', '2023-12-15 07:32:32'),
(8, '5XL', '2023-12-15 07:45:15', '2023-12-15 07:45:15'),
(9, '6XL', '2023-12-15 08:19:52', '2023-12-15 08:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `peran_id` int(11) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `alamat`, `password`, `gambar`, `peran_id`, `nomor_telepon`, `email`, `tanggal_bergabung`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Jl. Srikandi IV No. 16, Bandung, Jawa Barat 43210', '$2y$10$D/GoGMrbOjolCTV38zFoKegTkpn2l.FRfMdV7mSVxVqa8fSd1GlYC', 'admin/profile/admin.jpeg', 1, '089123456789', 'admin1234@gmail.com', '2023-12-15', '2023-12-15 01:29:12', '2023-12-15 01:29:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_baku_supplier`
--
ALTER TABLE `bahan_baku_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `bahan_baku_id` (`bahan_baku_id`);

--
-- Indexes for table `detail_bahan_baku_produk`
--
ALTER TABLE `detail_bahan_baku_produk`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_bahan_baku_has_produk_produk_idx` (`produk_id`),
  ADD KEY `fk_bahan_baku_has_produk_bahan_baku_idx` (`bahan_baku_id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_pesanan_pesanan_idx` (`pesanan_id`),
  ADD KEY `fk_detail_pesanan_produk_idx` (`produk_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_ukuran_id` (`produk_ukuran_id`);

--
-- Indexes for table `peran`
--
ALTER TABLE `peran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesanan_user` (`user_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produk_kategori1_idx` (`kategori_id`);

--
-- Indexes for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `ukuran_id` (`ukuran_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `idx_kode_transaksi` (`kode_transaksi`),
  ADD KEY `fk_transaksi_bahan_baku1_idx` (`bahan_baku_id`),
  ADD KEY `fk_transaksi_karyawan1_idx` (`user_id`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_karyawan_jabatan1_idx` (`peran_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bahan_baku_supplier`
--
ALTER TABLE `bahan_baku_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_bahan_baku_produk`
--
ALTER TABLE `detail_bahan_baku_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peran`
--
ALTER TABLE `peran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan_baku_supplier`
--
ALTER TABLE `bahan_baku_supplier`
  ADD CONSTRAINT `bahan_baku_supplier_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  ADD CONSTRAINT `bahan_baku_supplier_ibfk_2` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`);

--
-- Constraints for table `detail_bahan_baku_produk`
--
ALTER TABLE `detail_bahan_baku_produk`
  ADD CONSTRAINT `fk_bahan_baku_has_produk_bahan_baku` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bahan_baku_has_produk_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_pesanan_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detail_pesanan_produk` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`produk_ukuran_id`) REFERENCES `produk_ukuran` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_kategori1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  ADD CONSTRAINT `produk_ukuran_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_ukuran_ibfk_2` FOREIGN KEY (`ukuran_id`) REFERENCES `ukuran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_bahan_baku1` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transaksi_karyawan1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_karyawan_jabatan1` FOREIGN KEY (`peran_id`) REFERENCES `peran` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
