-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2016 at 08:36 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homestead`
--
CREATE DATABASE IF NOT EXISTS homestead;

USE homestead;
-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `nomor_registrasi` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `kelurahan` varchar(25) NOT NULL,
  `rw` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`nomor_registrasi`, `nama`, `kelurahan`, `rw`) VALUES
('BS001', 'Mawar', 'Sadang Serang', '15'),
('BS002', 'Raflesia', 'Tamansari', '2'),
('BS003', 'Anggrek', 'Dago', '12'),
('BS004', 'Lili', 'Tamansari', '9');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`nama`) VALUES
('Emberan'),
('Kaleng'),
('Pakaian'),
('Plastik');

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE `jual` (
  `id` int(11) NOT NULL,
  `id_cabang` varchar(5) NOT NULL,
  `pengepul` varchar(25) DEFAULT NULL,
  `nama_item` varchar(25) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`id`, `id_cabang`, `pengepul`, `nama_item`, `berat`, `harga`, `tanggal`) VALUES
(1, 'BS001', 'Jiko', 'Pakaian', 78, 100, '2016-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `nomor_induk` int(10) NOT NULL,
  `id_cabang` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`nomor_induk`, `id_cabang`, `nama`) VALUES
(123, 'BS001', 'Bunga'),
(2, 'BS002', 'Lilo'),
(3, 'BS002', 'Mahar'),
(5, 'BS002', 'Puji'),
(4, 'BS003', 'Budi'),
(0, 'BS003', 'Rudi'),
(6, 'BS004', 'Joni');

-- --------------------------------------------------------

--
-- Table structure for table `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `id_cabang` varchar(5) NOT NULL,
  `nama_nasabah` varchar(25) NOT NULL,
  `nama_item` varchar(25) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setor`
--

INSERT INTO `setor` (`id`, `id_cabang`, `nama_nasabah`, `nama_item`, `berat`, `harga`, `tanggal`) VALUES
(5, 'BS002', 'Lilo', 'Plastik', 62, 15000, '2016-04-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`nomor_registrasi`),
  ADD KEY `id` (`nomor_registrasi`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`nama`);

--
-- Indexes for table `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`id`,`id_cabang`,`nama_item`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `nama_item` (`nama_item`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_cabang`,`nama`);

--
-- Indexes for table `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`,`id_cabang`,`nama_nasabah`,`nama_item`),
  ADD KEY `nama_item` (`nama_item`),
  ADD KEY `setor_ibfk_1` (`id_cabang`,`nama_nasabah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jual`
--
ALTER TABLE `jual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `jual`
--
ALTER TABLE `jual`
  ADD CONSTRAINT `jual_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`nomor_registrasi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jual_ibfk_2` FOREIGN KEY (`nama_item`) REFERENCES `item` (`nama`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`nomor_registrasi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `setor`
--
ALTER TABLE `setor`
  ADD CONSTRAINT `setor_constraint1` FOREIGN KEY (`nama_item`) REFERENCES `item` (`nama`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `setor_constraint2` FOREIGN KEY (`id_cabang`) REFERENCES `nasabah` (`id_cabang`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
