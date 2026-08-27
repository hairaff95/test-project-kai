-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2026 at 08:42 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_project_kai`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_number` varchar(100) NOT NULL,
  `asset_block_name` varchar(255) NOT NULL,
  `size_area` decimal(10,2) NOT NULL,
  `peruntukan` varchar(100) NOT NULL,
  `jenis_aset` varchar(100) NOT NULL,
  `stasiun` varchar(100) NOT NULL,
  `wilayah_aset` varchar(100) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contract_number` varchar(100) NOT NULL,
  `tenant_id` int NOT NULL,
  `asset_number` varchar(100) NOT NULL,
  `contract_date` date NOT NULL,
  `jenis_kontrak` varchar(100) NOT NULL,
  `area_kontrak` varchar(100) NOT NULL,
  `start_datetime` date NOT NULL,
  `end_datetime` date NOT NULL,
  `start_datetime_baru` date NOT NULL,
  `end_datetime_baru` date NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `spv` varchar(150) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_financials`
--

CREATE TABLE `contract_financials` (
  `id` int NOT NULL,
  `contract_number` varchar(100) NOT NULL,
  `jumlah_hari` int NOT NULL,
  `nilai_per_hari` decimal(15,2) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `hari_2026` int NOT NULL,
  `nilai_2026` decimal(15,2) NOT NULL,
  `nilai_backlog` decimal(15,2) NOT NULL,
  `nilai_backlog2` decimal(15,2) NOT NULL,
  `gl_account` varchar(50) NOT NULL,
  `form_rka` varchar(100) NOT NULL,
  `tahun_rka` int NOT NULL,
  `jenis_pendapatan` varchar(100) NOT NULL,
  `persentase` decimal(5,2) NOT NULL,
  `pencapaian` decimal(5,2) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_schedules`
--

CREATE TABLE `monthly_schedules` (
  `id` int NOT NULL,
  `contract_number` varchar(100) NOT NULL,
  `tahun` int NOT NULL,
  `invoice` varchar(100) NOT NULL,
  `januari` decimal(15,2) NOT NULL,
  `febuari` decimal(15,2) NOT NULL,
  `maret` decimal(15,2) NOT NULL,
  `april` decimal(15,2) NOT NULL,
  `mei` decimal(15,2) NOT NULL,
  `juni` decimal(15,2) NOT NULL,
  `juli` decimal(15,2) NOT NULL,
  `agustus` decimal(15,2) NOT NULL,
  `september` decimal(15,2) NOT NULL,
  `oktober` decimal(15,2) NOT NULL,
  `november` decimal(15,2) NOT NULL,
  `desember` decimal(15,2) NOT NULL,
  `jan_des` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyewa`
--

CREATE TABLE `penyewa` (
  `id` int NOT NULL,
  `fullnama` varchar(255) NOT NULL,
  `status_pelanggan` varchar(50) NOT NULL,
  `jenis_perusahaan` varchar(100) NOT NULL,
  `merek` varchar(150) NOT NULL,
  `dibuat_pada` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_number`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_number`),
  ADD UNIQUE KEY `asset_number` (`asset_number`),
  ADD UNIQUE KEY `asset_number_2` (`asset_number`),
  ADD UNIQUE KEY `asset_number_3` (`asset_number`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `asset_number_4` (`asset_number`);

--
-- Indexes for table `contract_financials`
--
ALTER TABLE `contract_financials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_number` (`contract_number`);

--
-- Indexes for table `monthly_schedules`
--
ALTER TABLE `monthly_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_number` (`contract_number`);

--
-- Indexes for table `penyewa`
--
ALTER TABLE `penyewa`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `penyewa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`asset_number`) REFERENCES `assets` (`asset_number`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `contract_financials`
--
ALTER TABLE `contract_financials`
  ADD CONSTRAINT `contract_financials_ibfk_1` FOREIGN KEY (`contract_number`) REFERENCES `contracts` (`contract_number`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `monthly_schedules`
--
ALTER TABLE `monthly_schedules`
  ADD CONSTRAINT `monthly_schedules_ibfk_1` FOREIGN KEY (`contract_number`) REFERENCES `contracts` (`contract_number`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
