-- MySQL dump for Melo Health

CREATE DATABASE IF NOT EXISTS melo_health CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE melo_health;

-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL UNIQUE,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(255) DEFAULT 'default.jpg',
  `status_konfirmasi` enum('pending','confirmed') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `admin`
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `berita`
DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `dokter`
DROP TABLE IF EXISTS `dokter`;
CREATE TABLE `dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `spesialisasi` enum('poli_gigi','poli_gizi','poli_umum','ugd') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jadwal` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `poli`
DROP TABLE IF EXISTS `poli`;
CREATE TABLE `poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_poli` enum('poli_gigi','poli_gizi','poli_umum','ugd') NOT NULL,
  `tipe_layanan` text NOT NULL,
  `informasi_umum` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `antrian`
DROP TABLE IF EXISTS `antrian`;
CREATE TABLE `antrian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `poli_id` int(11) NOT NULL,
  `nomor_antrian` varchar(10) NOT NULL,
  `tanggal_antrian` date NOT NULL,
  `status` enum('menunggu','sudah_digunakan','sudah_kadaluarsa') DEFAULT 'menunggu',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`poli_id`) REFERENCES `poli`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `admin`
INSERT INTO `admin` (`username`, `password`, `nama`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin Puskesmas');

-- Insert poli data
INSERT INTO `poli` (`nama_poli`, `tipe_layanan`, `informasi_umum`) VALUES 
('poli_gigi', 'Pemeriksaan Gigi Rutin, Pembersihan Karang Gigi, Penambalan Gigi, Pencabutan Gigi, Pembuatan Gigi Palsu, Perawatan Saluran Akar, Pemutihan Gigi, Pemeriksaan dan Pemasangan Behel', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
('poli_gizi', 'Assessment Status Gizi, Konsultasi Gizi untuk Ibu Hamil, Konsultasi Gizi untuk Anak-anak, Konsultasi Diet untuk Penderita Diabetes, Konsultasi Diet untuk Penderita Hipertensi, Konsultasi Diet Penurunan Berat Badan, Konsultasi Diet Peningkatan Berat Badan, Konsultasi Gizi untuk Lansia', 'Jam Operasional: Senin - Jumat: 08:00 - 15:00, Sabtu: 08:00 - 12:00'),
('poli_umum', 'Pemeriksaan Kesehatan Umum, Pengobatan Penyakit Ringan, Imunisasi, Deteksi Dini Penyakit, Pemeriksaan Tekanan Darah, Pemeriksaan Gula Darah, Konsultasi Kesehatan, Pemeriksaan Ibu Hamil', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
('ugd', 'Trauma dan Cedera, Serangan Jantung, Stroke, Sesak Napas Berat, Pingsan atau Kejang, Nyeri Dada Parah, Perdarahan Berat, Kelahiran Darurat', 'Jam Operasional: 24 Jam Sehari, 7 Hari Seminggu');

-- Insert sample doctors
INSERT INTO `dokter` (`nama`, `spesialisasi`, `jadwal`) VALUES 
('Dr. Budi Santoso', 'poli_umum', 'Senin, Rabu, Jumat: 07:00 - 14:00'),
('Dr. Siti Aminah', 'poli_umum', 'Selasa, Kamis: 07:00 - 14:00'),
('Dr. Andi Pratama', 'poli_umum', 'Sabtu: 08:00 - 12:00'),
('Drg. Siti Aminah', 'poli_gigi', 'Senin, Rabu, Jumat: 07:00 - 14:00'),
('Drg. Budi Santoso', 'poli_gigi', 'Selasa, Kamis: 07:00 - 14:00'),
('Drg. Andi Pratama', 'poli_gigi', 'Sabtu: 08:00 - 12:00'),
('Ns. Rina Kartika', 'poli_gizi', 'Senin, Rabu, Jumat: 08:00 - 14:00'),
('Dr. Andi Pratama', 'poli_gizi', 'Selasa, Kamis: 08:00 - 14:00'),
('Sst. Maya Sari', 'poli_gizi', 'Sabtu: 08:00 - 12:00'),
('Dr. Ahmad Darurat', 'ugd', 'Shift Pagi: 06:00 - 14:00'),
('Dr. Siti Gawat', 'ugd', 'Shift Sore: 14:00 - 22:00'),
('Dr. Budi Kritis', 'ugd', 'Shift Malam: 22:00 - 06:00');

-- Insert sample news articles
INSERT INTO `berita` (`judul`, `konten`, `tanggal_publish`) VALUES 
('Gejala Diabetes yang Perlu Diwaspadai', 'Kenali gejala diabetes sejak dini agar bisa dilakukan penanganan yang tepat dan mencegah komplikasi serius...', '2025-11-15'),
('Pentingnya Vaksinasi untuk Anak', 'Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit berbahaya pada anak...', '2025-11-12'),
('Tips Menjaga Kesehatan di Musim Penghujan', 'Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan selama musim penghujan...', '2025-11-10'),
('Manfaat Olahraga Rutin bagi Kesehatan', 'Melakukan olahraga secara rutin memiliki banyak manfaat bagi kesehatan fisik dan mental...', '2025-11-08'),
('Pentingnya Asupan Nutrisi Seimbang', 'Asupan nutrisi yang seimbang sangat penting untuk menjaga kesehatan tubuh secara keseluruhan...', '2025-11-05');

COMMIT;