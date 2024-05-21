-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Bulan Mei 2024 pada 17.02
-- Versi server: 10.3.39-MariaDB-cll-lve
-- Versi PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estimasiregresil_tina`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_prediksi`
--

CREATE TABLE `hasil_prediksi` (
  `tahun` int(11) NOT NULL,
  `Bulan` varchar(255) DEFAULT NULL,
  `hari` int(11) NOT NULL,
  `hasil_prediksi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_prediksi`
--

INSERT INTO `hasil_prediksi` (`tahun`, `Bulan`, `hari`, `hasil_prediksi`) VALUES
(2023, '1', 49, '4667.2310638298'),
(2023, '2', 50, '4669.9690409249'),
(2023, '3', 51, '4672.70701802'),
(2023, '4', 52, '4675.4449951151'),
(2023, '7', 55, '4683.6589264003'),
(2023, '8', 56, '4686.3969034954'),
(2023, '9', 57, '4689.1348805905'),
(2023, '12', 60, '4697.3488118758'),
(2024, '1', 61, '4700.0867889709'),
(2024, '4', 64, '4708.3007202562'),
(2024, '5', 65, '4711.0386973513'),
(2025, '1', 73, '4732.942514112');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampah`
--

CREATE TABLE `sampah` (
  `id` int(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `Bulan` varchar(255) DEFAULT NULL,
  `hari` int(11) DEFAULT NULL,
  `timbulan_sampah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sampah`
--

INSERT INTO `sampah` (`id`, `tahun`, `Bulan`, `hari`, `timbulan_sampah`) VALUES
(1, 2019, '1', 1, '4359.27'),
(2, 2019, '2', 2, '4326.86'),
(3, 2019, '3', 3, '4200.98'),
(4, 2019, '4', 4, '5336.79'),
(5, 2019, '5', 5, '5081.01'),
(6, 2019, '6', 6, '4638.01'),
(7, 2019, '7', 7, '4361.98'),
(8, 2019, '8', 8, '4625.97'),
(9, 2019, '9', 9, '4520.46'),
(10, 2019, '10', 10, '4562.11'),
(11, 2019, '11', 11, '5459.93'),
(12, 2019, '12', 12, '5548.36'),
(13, 2020, '1', 13, '4043.43'),
(14, 2020, '2', 14, '4200.63'),
(15, 2020, '3', 15, '3840.39'),
(16, 2020, '4', 16, '4928.96'),
(17, 2020, '5', 17, '4727.24'),
(18, 2020, '6', 18, '4605.12'),
(19, 2020, '7', 19, '5260.96'),
(20, 2020, '8', 20, '3894.88'),
(21, 2020, '9', 21, '4473.84'),
(22, 2020, '10', 22, '4185.64'),
(23, 2020, '11', 23, '5927.04'),
(24, 2020, '12', 24, '4633.57'),
(25, 2021, '1', 25, '4151.02'),
(26, 2021, '2', 26, '3673.22'),
(27, 2021, '3', 27, '3840.39'),
(28, 2021, '4', 28, '3938.01'),
(29, 2021, '5', 29, '4727.24'),
(30, 2021, '6', 30, '4605.12'),
(31, 2021, '7', 31, '5260.96'),
(32, 2021, '8', 32, '3894.88'),
(33, 2021, '9', 33, '4473.84'),
(34, 2021, '10', 34, '4185.64'),
(35, 2021, '11', 35, '4185.64'),
(36, 2021, '12', 36, '4633.57'),
(37, 2022, '1', 37, '3451.45'),
(38, 2022, '2', 38, '4776.76'),
(39, 2022, '3', 39, '4964.38'),
(40, 2022, '4', 40, '4321.53'),
(41, 2022, '5', 41, '5666.72'),
(42, 2022, '6', 42, '4276.89'),
(43, 2022, '7', 43, '5415.2'),
(44, 2022, '8', 44, '5019.36'),
(45, 2022, '9', 45, '4657.94'),
(46, 2022, '10', 46, '5817.83'),
(47, 2022, '11', 47, '4305.61'),
(48, 2022, '12', 48, '4820.6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$gkHR5XLWRJBdDj9iJrqpweQscZnz9pj87mM9QvNt6YcVIZu6w90eK'),
(12, 'tina', '$2y$10$zf.FUr/pK/NHm0EGPx3D9uL.BqGts54QlukADYCdcPrOG4GweI1TC'),
(13, 'anjas', '$2y$10$EJEKQH5IwENvagi349RuxuYCA7IznOHaRDbqZBr7ptzyXqHQ25SOC'),
(14, 'beca', '$2y$10$C0xVYXiniTPrAedbCEnIi.hjomky8BlL9rjO.j0pniVCGMI9gV93O');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `hasil_prediksi`
--
ALTER TABLE `hasil_prediksi`
  ADD PRIMARY KEY (`hari`),
  ADD UNIQUE KEY `tahun` (`tahun`,`Bulan`);

--
-- Indeks untuk tabel `sampah`
--
ALTER TABLE `sampah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
