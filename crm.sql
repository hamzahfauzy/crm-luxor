-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2020 at 06:40 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(1, 'Kategori 1'),
(2, 'Kategori 2');

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `belum_dibaca` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konsultasi`
--

INSERT INTO `konsultasi` (`id`, `id_user`, `tipe`, `tanggal`, `belum_dibaca`, `updated_at`) VALUES
(1, 2, 2, '2020-07-04', 0, '2020-07-04 09:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi_item`
--

CREATE TABLE `konsultasi_item` (
  `id` int(11) NOT NULL,
  `id_konsultasi` int(11) NOT NULL,
  `konten` text NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konsultasi_item`
--

INSERT INTO `konsultasi_item` (`id`, `id_konsultasi`, `konten`, `tipe`, `tanggal`) VALUES
(1, 1, 'hello', '1', '2020-07-04 09:08:17'),
(2, 1, 'selamat siang', '1', '2020-07-04 09:18:49'),
(3, 1, 'siang', '2', '2020-07-04 09:37:35'),
(4, 1, 'saya mau tanya admin', '1', '2020-07-04 09:37:44'),
(5, 1, 'tanya aapa itu?', '2', '2020-07-04 09:37:50'),
(6, 1, 'ini tentang barang yang saya beli', '1', '2020-07-04 09:38:01'),
(7, 1, 'iya kenama', '2', '2020-07-04 09:38:14'),
(8, 1, '* kenapa maksudnya', '2', '2020-07-04 09:38:24'),
(9, 1, 'gapapa min', '1', '2020-07-04 09:38:32'),
(10, 1, 'lah tadi tanya', '2', '2020-07-04 09:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `kustomer`
--

CREATE TABLE `kustomer` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kustomer`
--

INSERT INTO `kustomer` (`id`, `id_pengguna`, `nama`, `alamat`, `jenis_kelamin`, `email`, `no_hp`) VALUES
(10, 0, 'Customer 1', 'kisaran', 'Laki-laki', 'customer1@gmail.com', '081234567890'),
(11, 2, 'Customer 2', 'Kisaran', 'Perempuan', 'customer2@gmail.com', '081234567890');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `username`, `password`, `level`) VALUES
(1, 'admin', 'admin@admin.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'Customer 2', 'customer2@gmail.com', 'customer2', '5ce4d191fd14ac85a1469fb8c29b7a7b', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `berat` varchar(100) NOT NULL,
  `harga_normal` varchar(100) NOT NULL,
  `harga_member` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_kategori`, `nama`, `deskripsi`, `berat`, `harga_normal`, `harga_member`, `jumlah`, `gambar`, `poin`) VALUES
(1, 1, 'Produk 1', 'ini deskripsi', '8', '10000', '9000', 100, 'http://localhost:8000/public/uploads/1593702511.png', 10),
(2, 2, 'Produk 2', 'ini deskripsinya', '1', '20000', '18000', 100, 'http://localhost:8000/public/uploads/1593702546.png', 10),
(3, 1, 'Produk 3', 'Ini produk 3', '1', '10000', '9000', 50, 'http://localhost:8000/public/uploads/1593750571.png', 10),
(4, 1, 'Produk 4', 'Ini produk 4', '1', '15000', '14000', 40, 'http://localhost:8000/public/uploads/1593750600.png', 10);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `nama`) VALUES
(1, 'Pulau Rakyat'),
(2, 'Rahuning'),
(3, 'Aek Kuasan');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_item`
--

CREATE TABLE `shipping_item` (
  `id` int(11) NOT NULL,
  `id_shipping` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga_kirim` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_item`
--

INSERT INTO `shipping_item` (`id`, `id_shipping`, `nama`, `harga_kirim`) VALUES
(1, 1, 'POS', '11000'),
(2, 1, 'JNE', '11000'),
(3, 1, 'JNT', '12000');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_kustomer` int(11) NOT NULL,
  `kode` varchar(8) NOT NULL,
  `status` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `bukti` varchar(100) NOT NULL,
  `resi` varchar(10) NOT NULL,
  `id_kurir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_kustomer`, `kode`, `status`, `tanggal`, `bukti`, `resi`, `id_kurir`) VALUES
(9, 10, '45C48CCE', 3, '2020-07-03', 'http://localhost:8000/public/uploads/1593842701.png', '1234567890', 1),
(10, 11, 'D3D94468', 4, '2020-07-04', 'http://localhost:8000/public/uploads/1593846449.png', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_item`
--

CREATE TABLE `transaksi_item` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `ulasan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_item`
--

INSERT INTO `transaksi_item` (`id`, `id_transaksi`, `id_produk`, `jumlah`, `rating`, `ulasan`) VALUES
(1, 9, 3, 2, 4, 'barang bagus'),
(2, 10, 4, 1, NULL, ''),
(3, 10, 3, 2, NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsultasi_item`
--
ALTER TABLE `konsultasi_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kustomer`
--
ALTER TABLE `kustomer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_item`
--
ALTER TABLE `shipping_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `konsultasi_item`
--
ALTER TABLE `konsultasi_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kustomer`
--
ALTER TABLE `kustomer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_item`
--
ALTER TABLE `shipping_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
