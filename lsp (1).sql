-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 07:59 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `1819123_detail_pesan`
--

CREATE TABLE `1819123_detail_pesan` (
  `1819123_NoSP` char(6) NOT NULL,
  `1819123_KdJasa` char(6) NOT NULL,
  `1819123_JmlJual` int(3) NOT NULL,
  `1819123_HrgJual` double(9,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1819123_divisi`
--

CREATE TABLE `1819123_divisi` (
  `1819123_IdDivisi` char(4) NOT NULL,
  `1819123_NmDivisi` varchar(35) NOT NULL,
  `1819123_Lantai` int(2) NOT NULL,
  `1819123_NoTelp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1819123_jasa`
--

CREATE TABLE `1819123_jasa` (
  `1819123_KdJasa` char(6) NOT NULL,
  `1819123_NmJasa` varchar(35) NOT NULL,
  `1819123_LamaJasa` int(3) NOT NULL,
  `1819123_HrgJasa` double(8,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `1819123_sp`
--

CREATE TABLE `1819123_sp` (
  `1819123_NoSP` char(6) NOT NULL,
  `1819123_IdDivisi` char(4) NOT NULL,
  `1819123_TglSP` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `1819123_detail_pesan`
--
ALTER TABLE `1819123_detail_pesan`
  ADD PRIMARY KEY (`1819123_NoSP`);

--
-- Indexes for table `1819123_divisi`
--
ALTER TABLE `1819123_divisi`
  ADD PRIMARY KEY (`1819123_IdDivisi`);

--
-- Indexes for table `1819123_jasa`
--
ALTER TABLE `1819123_jasa`
  ADD PRIMARY KEY (`1819123_KdJasa`);

--
-- Indexes for table `1819123_sp`
--
ALTER TABLE `1819123_sp`
  ADD PRIMARY KEY (`1819123_NoSP`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
