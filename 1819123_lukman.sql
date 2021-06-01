-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Jun 2021 pada 14.46
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1819123_lukman`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_akses`
--

CREATE TABLE `1819123_akses` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hak_akses` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `1819123_akses`
--

INSERT INTO `1819123_akses` (`username`, `password`, `hak_akses`) VALUES
('lukman123', '$2y$10$9/gVpNiPU1iK1cNsC9pHSOrPu3JzLRbG51JNSQ4LercJPVOKsS5oa', 'staff'),
('lukman_admin', '$2y$10$oCqfk5De5dQRf1QV4vvCmOwDJLJ0DUHGKHVO3nvOAJGoo3Krm4OLe', 'admin'),
('lukman_harun_admin', '$2y$10$zLmEVr7WAS3kLvEPgHzziOyX3./9DsoXV2WYwRusAcxOCF0vOdHAq', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_detail_pesan`
--

CREATE TABLE `1819123_detail_pesan` (
  `id` int(11) NOT NULL,
  `1819123_NoSP` varchar(50) NOT NULL,
  `1819123_KdJasa` char(6) NOT NULL,
  `1819123_JmlPesan` int(3) NOT NULL,
  `1819123_HrgPesan` double(9,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `1819123_detail_pesan`
--

INSERT INTO `1819123_detail_pesan` (`id`, `1819123_NoSP`, `1819123_KdJasa`, `1819123_JmlPesan`, `1819123_HrgPesan`) VALUES
(5, 'sp-2021-05-11609a34e4591e0', '6', 2, 50000),
(6, 'sp-2021-05-11609ad4622a3fc', '6', 5, 50000),
(10, 'sp-2021-05-11609ad48a1d03d', '6', 2, 500000),
(11, 'sp-2021-05-12609bfa744ff93', '6', 4, 50000),
(12, 'sp-sp-2021-05-12609bfa744ff93', '10', 1, 560000),
(13, 'sp-2021-05-11609ad4622a3fc', '6', 5, 50000),
(14, 'sp-2021-05-11609ad48a1d03d', '10', 5, 50000),
(15, 'sp-2021-05-14609e4a6d16145', '6', 2, 56000),
(16, 'sp-sp-2021-05-14609e4a6d16145', '6', 5, 50000),
(17, 'sp-sp-2021-05-14609e4a6d16145', '6', 2, 20000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_divisi`
--

CREATE TABLE `1819123_divisi` (
  `1819123_IdDivisi` int(11) NOT NULL,
  `1819123_NmDivisi` varchar(35) NOT NULL,
  `1819123_Alamat` varchar(255) NOT NULL,
  `1819123_NoTelp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `1819123_divisi`
--

INSERT INTO `1819123_divisi` (`1819123_IdDivisi`, `1819123_NmDivisi`, `1819123_Alamat`, `1819123_NoTelp`) VALUES
(2, 'pembelian', 'jalan gang teman 1 larangan utara kota tangerang ', '0895391895939'),
(3, 'penawarann', 'jalan gang teman 1 larangan utara kota tangerang rt 02 rw 04', '0895391895395'),
(4, 'penjualan', 'jalan gang teman 1 larangan utara kota tangerang rt 02 rw 04', '0895391895399');

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_jasa`
--

CREATE TABLE `1819123_jasa` (
  `1819123_KdJasa` int(11) NOT NULL,
  `1819123_NmJasa` varchar(35) NOT NULL,
  `1819123_LamaJasa` int(3) NOT NULL,
  `1819123_HrgJasa` double(8,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `1819123_jasa`
--

INSERT INTO `1819123_jasa` (`1819123_KdJasa`, `1819123_NmJasa`, `1819123_LamaJasa`, `1819123_HrgJasa`) VALUES
(6, 'Print Dokument', 1, 10000),
(10, 'mobil', 2, 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_mieayam_bakso`
--

CREATE TABLE `1819123_mieayam_bakso` (
  `1819123_id` int(11) NOT NULL,
  `1819123_jumlah_mieayam` int(11) NOT NULL,
  `1819123_jumlah_bakso` int(11) NOT NULL,
  `181923_total_harga` int(11) NOT NULL,
  `1819123_uang_pembayaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `1819123_mieayam_bakso`
--

INSERT INTO `1819123_mieayam_bakso` (`1819123_id`, `1819123_jumlah_mieayam`, `1819123_jumlah_bakso`, `181923_total_harga`, `1819123_uang_pembayaran`) VALUES
(11, 2, 2, 76000, 80000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `1819123_sp`
--

CREATE TABLE `1819123_sp` (
  `1819123_NoSP` varchar(50) NOT NULL,
  `1819123_IdDivisi` char(4) NOT NULL,
  `1819123_TglSP` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `1819123_sp`
--

INSERT INTO `1819123_sp` (`1819123_NoSP`, `1819123_IdDivisi`, `1819123_TglSP`) VALUES
('sp-2021-05-11609a34e4591e0', '2', '2021-05-11'),
('sp-2021-05-11609ad4622a3fc', '3', '2021-05-11'),
('sp-2021-05-11609ad48a1d03d', '3', '2021-05-11'),
('sp-sp-2021-05-12609bfa744ff93', '2', '2021-05-12'),
('sp-sp-2021-05-14609e4a6d16145', '3', '2021-05-14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `1819123_akses`
--
ALTER TABLE `1819123_akses`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `1819123_detail_pesan`
--
ALTER TABLE `1819123_detail_pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `1819123_divisi`
--
ALTER TABLE `1819123_divisi`
  ADD PRIMARY KEY (`1819123_IdDivisi`);

--
-- Indeks untuk tabel `1819123_jasa`
--
ALTER TABLE `1819123_jasa`
  ADD PRIMARY KEY (`1819123_KdJasa`);

--
-- Indeks untuk tabel `1819123_mieayam_bakso`
--
ALTER TABLE `1819123_mieayam_bakso`
  ADD PRIMARY KEY (`1819123_id`);

--
-- Indeks untuk tabel `1819123_sp`
--
ALTER TABLE `1819123_sp`
  ADD PRIMARY KEY (`1819123_NoSP`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `1819123_detail_pesan`
--
ALTER TABLE `1819123_detail_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `1819123_divisi`
--
ALTER TABLE `1819123_divisi`
  MODIFY `1819123_IdDivisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `1819123_jasa`
--
ALTER TABLE `1819123_jasa`
  MODIFY `1819123_KdJasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `1819123_mieayam_bakso`
--
ALTER TABLE `1819123_mieayam_bakso`
  MODIFY `1819123_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
