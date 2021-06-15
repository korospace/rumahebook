-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2021 at 10:02 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rumahebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `adminname` varchar(100) DEFAULT NULL,
  `pasword` varchar(120) DEFAULT NULL,
  `adminfoto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminname`, `pasword`, `adminfoto`) VALUES
(7, 'tes', '$2y$10$DL4inXcitu3LzKK6yIfrluIifa4LOpt9Io1b7ILaLbH1Dpf5/.og6', '609b824ebb1d9.png'),
(15, 'ss xx', '$2y$10$CVRW0KYIbPdYpGLFLw1DUuzQi2FftQIKlepz0s2UkcBood15037.q', '609b82386bc17.png');

-- --------------------------------------------------------

--
-- Table structure for table `ebook`
--

CREATE TABLE `ebook` (
  `uploader` varchar(100) DEFAULT NULL,
  `judulbuku` varchar(200) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(200) DEFAULT NULL,
  `tglterbit` varchar(100) DEFAULT NULL,
  `fotobuku` varchar(100) DEFAULT NULL,
  `fileebook` varchar(220) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `sinopsis` varchar(10000) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `linkgdrive` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ebook`
--

INSERT INTO `ebook` (`uploader`, `judulbuku`, `penulis`, `penerbit`, `tglterbit`, `fotobuku`, `fileebook`, `kategori`, `sinopsis`, `id`, `linkgdrive`) VALUES
('koro1234', 'William', 'Risa Saraswati', 'Bukune', 'Mei 2017', '609b6d498e2de.png', 'William - Risa Saraswati.pdf', 'Novel', 'William Van Kemmen adalah seorang anak kecil yang tampan, apalagi dengan biola yang selalu menemaninya. Namun, dalam hatinya ia merasa kesepian. Setelah kematian menyapa, barulah dia merasa bahagia.', 1, ''),
('koro1234', 'Rasuk', 'Risa Saraswati', 'Bukune', 'Agustus 2015', '609a3915c6287.png', 'Rasuk.pdf', 'Novel', 'Semenjak kepergian Sang Ayah, Langgir Janaka-seorang gadis remaja kesepian-merasa tidak ada satu hal pun dalam hidupnya berjalan dengan baik. Hari-harinya dpenuhi rutukan bagi nasib buruk. Kalimat &quot;Tuhan Tidak Adil&quot; seolah menjadi mantra dalam batinnya.', 3, ''),
('tes 1', 'Ananta Prahadi', 'Risa Saraswati', 'Rak Buku', 'Mei 2014', '609a3900a1d38.png', 'Ananta Prahadi.pdf', 'Novel', 'Aku Tania, perempuan biasa . . .tapi mereka bilang aku ini Alien.\r\n\r\nNama saya Ananta Prahadi, panggil saja Anta. Hobi bersih-bersih rumah, makan Lontong kari dan sangat menjunjung tinggi pelestarian makhluk langka. ', 9, ''),
('tes 1', 'Ivanna Van Dijk xx', 'Risa Saraswati ', '----', 'Maret, 2018', '609b8414a1f6a.png', '', 'Novel', 'Hantu belanda berambut pirang itu selalu terlihat marah, gusar dan mengusir siapapun yang datang kerumah yang dia huni.', 10, 'https://drive.google.com/file/d/1cAEPuSB-INNxtMPhMiMN7I-547xJxYGc/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `kritik`
--

CREATE TABLE `kritik` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `pesan` varchar(2000) DEFAULT NULL,
  `tglkritik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kritik`
--
ALTER TABLE `kritik`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ebook`
--
ALTER TABLE `ebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kritik`
--
ALTER TABLE `kritik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
