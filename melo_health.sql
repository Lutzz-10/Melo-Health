-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 08:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melo_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `created_at`) VALUES
(1, 'admin', '$2y$10$lzCXjXROpvlizTN1mllE6ecIl6EYj9lkSav2WJqFJueki8Wszw1Qi', 'Admin Puskesmas', '2025-11-22 06:04:57'),
(4, 'ethan', '$2y$10$H/RqYFpJvRscwz4kvaf.oudyJCisel0SLZ8q4FFk11.9qcfbNanPa', 'Ethan Timm', '2025-11-22 08:02:48'),
(5, 'marsel', '$2y$10$i5I4.5HeFoudlDwvyrUnLeuq3RlkxqiqwsrzkOU2MSqV3WtR7u06.', 'Marselino', '2025-11-28 07:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `nomor_antrian` varchar(10) NOT NULL,
  `tanggal_antrian` date NOT NULL,
  `status` enum('menunggu','sudah_digunakan','sudah_kadaluarsa') DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id`, `user_id`, `poli_id`, `nomor_antrian`, `tanggal_antrian`, `status`, `created_at`) VALUES
(1, 3, 1, 'A001', '2025-11-28', 'sudah_digunakan', '2025-11-28 07:18:27'),
(2, 3, 2, 'A001', '2025-11-28', 'sudah_digunakan', '2025-11-28 07:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `konten`, `gambar`, `tanggal_publish`, `created_at`) VALUES
(1, 'Gejala Diabetes yang Perlu Diwaspadai', 'Kenali gejala diabetes sejak dini agar bisa dilakukan penanganan yang tepat dan mencegah komplikasi serius...', NULL, '2025-11-15', '2025-11-22 06:04:57'),
(2, 'Pentingnya Vaksinasi untuk Anak', 'Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit berbahaya pada anak...', NULL, '2025-11-12', '2025-11-22 06:04:57'),
(3, 'Tips Menjaga Kesehatan di Musim Penghujan', 'Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan selama musim penghujan...', NULL, '2025-11-10', '2025-11-22 06:04:57'),
(4, 'Manfaat Olahraga Rutin bagi Kesehatan', 'Melakukan olahraga secara rutin memiliki banyak manfaat bagi kesehatan fisik dan mental...', NULL, '2025-11-08', '2025-11-22 06:04:57'),
(5, 'Pentingnya Asupan Nutrisi Seimbang', 'Asupan nutrisi yang seimbang sangat penting untuk menjaga kesehatan tubuh secara keseluruhan...', NULL, '2025-11-05', '2025-11-22 06:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `spesialisasi` enum('poli_gigi','poli_gizi','poli_umum','ugd') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jadwal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `spesialisasi`, `foto`, `jadwal`) VALUES
(1, 'Dr. Budi Santoso', 'poli_umum', NULL, 'Senin, Rabu, Jumat: 07:00 - 14:00'),
(2, 'Dr. Siti Aminah', 'poli_umum', NULL, 'Selasa, Kamis: 07:00 - 14:00'),
(3, 'Dr. Andi Pratama', 'poli_umum', NULL, 'Sabtu: 08:00 - 12:00'),
(4, 'Drg. Siti Aminah', 'poli_gigi', NULL, 'Senin, Rabu, Jumat: 07:00 - 14:00'),
(5, 'Drg. Budi Santoso', 'poli_gigi', NULL, 'Selasa, Kamis: 07:00 - 14:00'),
(6, 'Drg. Andi Pratama', 'poli_gigi', NULL, 'Sabtu: 08:00 - 12:00'),
(7, 'Ns. Rina Kartika', 'poli_gizi', NULL, 'Senin, Rabu, Jumat: 08:00 - 14:00'),
(8, 'Dr. Andi Pratama', 'poli_gizi', NULL, 'Selasa, Kamis: 08:00 - 14:00'),
(9, 'Sst. Maya Sari', 'poli_gizi', NULL, 'Sabtu: 08:00 - 12:00');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` enum('poli_gigi','poli_gizi','poli_umum','ugd') NOT NULL,
  `tipe_layanan` text NOT NULL,
  `informasi_umum` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `tipe_layanan`, `informasi_umum`) VALUES
(1, 'poli_gigi', 'Pemeriksaan Gigi Rutin, Pembersihan Karang Gigi, Penambalan Gigi, Pencabutan Gigi, Pembuatan Gigi Palsu, Perawatan Saluran Akar, Pemutihan Gigi, Pemeriksaan dan Pemasangan Behel', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
(2, 'poli_gizi', 'Assessment Status Gizi, Konsultasi Gizi untuk Ibu Hamil, Konsultasi Gizi untuk Anak-anak, Konsultasi Diet untuk Penderita Diabetes, Konsultasi Diet untuk Penderita Hipertensi, Konsultasi Diet Penurunan Berat Badan, Konsultasi Diet Peningkatan Berat Badan, Konsultasi Gizi untuk Lansia', 'Jam Operasional: Senin - Jumat: 08:00 - 15:00, Sabtu: 08:00 - 12:00'),
(3, 'poli_umum', 'Pemeriksaan Kesehatan Umum, Pengobatan Penyakit Ringan, Imunisasi, Deteksi Dini Penyakit, Pemeriksaan Tekanan Darah, Pemeriksaan Gula Darah, Konsultasi Kesehatan, Pemeriksaan Ibu Hamil', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(255) DEFAULT 'default.jpg',
  `status_konfirmasi` enum('pending','confirmed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nik`, `alamat`, `no_hp`, `password`, `foto_profile`, `status_konfirmasi`, `created_at`) VALUES
(2, 'Alwan Lutfi Maulida`', '1234567812345678', 'Candiwulan', '082134378295', '$2y$10$Hv80DgwuL1e7d1EMpYufaO34ycSXOfOIxSVjZ5OFHVYlrtoNpJF/S', 'default.jpg', 'confirmed', '2025-11-22 07:52:54'),
(3, 'Egie Hariansyah', '3301231231231234', 'Warung Nyamleng - Bawang', '085865580124', '$2y$10$Yq4m8RnRg3za6XE/SKUpK.wfM2CGnU5ECkWnixlBvhHXD0FDmIsGi', 'default.jpg', 'confirmed', '2025-11-28 06:59:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `poli_id` (`poli_id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `antrian_ibfk_2` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
