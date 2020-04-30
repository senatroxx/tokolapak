-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2020 at 03:17 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokolapak`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `username`, `password`) VALUES
(1, 'Athhar Kautsar', 'athharkautsar14@gmail.com', 'senatroxx', '$2y$10$v1TEswsmh.dXTqjQmxZROeWrYPjn3mLV9h84oY91Xbcc2ZFe6N1n6');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `prodID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `memberID`, `prodID`, `nama`, `harga`, `jumlah`, `total`, `note`) VALUES
(22, 1, 3, 'Acer Predator Helios 700', 67960000, 1, 67960000, '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `namaktg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `namaktg`) VALUES
(8, 'Notebook');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `telp` varchar(14) NOT NULL,
  `address` text NOT NULL,
  `profil` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nama`, `username`, `password`, `email`, `telp`, `address`, `profil`) VALUES
(1, 'Athhar Kautsar', 'senatroxx', '$2y$10$b6YJ48UGsytqeHeLuvKet.i/nI.Bsh2boPKADtNhQ.bYPtEHwkq/i', 'athharkautsar14@gmail.com', '081385155383', 'Rumah', '80senatroxx.jpg'),
(8, 'Rick Grimmes', 'rick', '$2y$10$IZ/rWoadasQAmH/iqtMC5eBm.5TK6NBqKbx1xHUV1aMtJNON9g0mC', 'rickgrimmes@gmail.com', '08123647284', 'Atlanta', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `bayarID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `prodID` int(11) NOT NULL,
  `transCode` int(16) NOT NULL,
  `tglOrder` date NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `note` text NOT NULL,
  `bukti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`bayarID`, `memberID`, `prodID`, `transCode`, `tglOrder`, `nama`, `harga`, `jumlah`, `total`, `note`, `bukti`) VALUES
(1, 1, 1, 0, '2019-11-26', 'Vietnam Drip w/ Handle - 30ml', 45000, 1, 45000, '', '18O0OX1EZ9CHNHF3.jpg'),
(2, 1, 2, 0, '2019-11-26', 'Delter - Coffee Press', 540000, 1, 540000, '', '18O0OX1EZ9CHNHF3.jpg'),
(3, 1, 1, 0, '2019-11-26', 'Vietnam Drip w/ Handle - 30ml', 45000, 1, 45000, '', '18O0OX1EZ9CHNHF3.jpg'),
(4, 1, 2, 0, '2019-11-26', 'Delter - Coffee Press', 540000, 1, 540000, '', '18O0OX1EZ9CHNHF3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `poto` text NOT NULL,
  `namaprod` varchar(255) NOT NULL,
  `deskprod` text NOT NULL,
  `hargabrg` bigint(11) NOT NULL,
  `jumlahbrg` int(11) NOT NULL,
  `kategori` int(11) NOT NULL,
  `upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `poto`, `namaprod`, `deskprod`, `hargabrg`, `jumlahbrg`, `kategori`, `upload`) VALUES
(3, '85-67960000-200.png', 'Acer Predator Helios 700', 'Intel Core i9-9980HK, RAM 64GB, HDD 2TB, SSD 1TB, Nvidia GeForce RTX 2080 8GB, 17.3&#34; FHD 144Hz G-SYNC, Win 10', 67960000, 200, 8, '2020-04-27'),
(4, '32-3430000-100.jpg', 'Acer Aspire 3 (A314)', 'AMD Dual Core A4-9120, RAM 4GB, HDD 500GB, 14&#34;, AMD Radeon R3 Graphics, Win 10', 3430000, 100, 8, '2020-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `prodID` int(11) NOT NULL,
  `transCode` varchar(11) NOT NULL,
  `tglTrans` datetime NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `note` text NOT NULL DEFAULT '-',
  `bukti` text NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'Unverified'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `namaktg` (`namaktg`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`bayarID`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `bayarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
