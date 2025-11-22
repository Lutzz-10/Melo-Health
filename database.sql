-- Database: melo_health

CREATE DATABASE IF NOT EXISTS melo_health CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE melo_health;

-- Table: users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    nik VARCHAR(16) UNIQUE NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    foto_profile VARCHAR(255) DEFAULT 'default.jpg',
    status_konfirmasi ENUM('pending', 'confirmed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: admin
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: berita
CREATE TABLE berita (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    konten TEXT NOT NULL,
    gambar VARCHAR(255),
    tanggal_publish DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: dokter
CREATE TABLE dokter (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    spesialisasi ENUM('poli_gigi', 'poli_gizi', 'poli_umum', 'ugd') NOT NULL,
    foto VARCHAR(255),
    jadwal TEXT NOT NULL
);

-- Table: poli
CREATE TABLE poli (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_poli ENUM('poli_gigi', 'poli_gizi', 'poli_umum', 'ugd') NOT NULL,
    tipe_layanan TEXT NOT NULL,
    informasi_umum TEXT NOT NULL
);

-- Table: antrian
CREATE TABLE antrian (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    poli_id INT NOT NULL,
    nomor_antrian VARCHAR(10) NOT NULL,
    tanggal_antrian DATE NOT NULL,
    status ENUM('menunggu', 'sudah_digunakan', 'sudah_kadaluarsa') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (poli_id) REFERENCES poli(id)
);

-- Insert default admin user (username: admin, password: admin123)
-- The password 'admin123' hashed with password_hash(PASSWORD_DEFAULT)
INSERT INTO admin (username, password, nama) VALUES ('admin', '$2y$10$TKt3pdC6qW7mW2zHgjHw4.FG2wF4l3z5JZ8vP9n1Q3R0w2E4F5G6H', 'Admin Puskesmas');

-- Insert poli data
INSERT INTO poli (nama_poli, tipe_layanan, informasi_umum) VALUES 
('poli_gigi', 'Pemeriksaan Gigi Rutin, Pembersihan Karang Gigi, Penambalan Gigi, Pencabutan Gigi, Pembuatan Gigi Palsu, Perawatan Saluran Akar, Pemutihan Gigi, Pemeriksaan dan Pemasangan Behel', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
('poli_gizi', 'Assessment Status Gizi, Konsultasi Gizi untuk Ibu Hamil, Konsultasi Gizi untuk Anak-anak, Konsultasi Diet untuk Penderita Diabetes, Konsultasi Diet untuk Penderita Hipertensi, Konsultasi Diet Penurunan Berat Badan, Konsultasi Diet Peningkatan Berat Badan, Konsultasi Gizi untuk Lansia', 'Jam Operasional: Senin - Jumat: 08:00 - 15:00, Sabtu: 08:00 - 12:00'),
('poli_umum', 'Pemeriksaan Kesehatan Umum, Pengobatan Penyakit Ringan, Imunisasi, Deteksi Dini Penyakit, Pemeriksaan Tekanan Darah, Pemeriksaan Gula Darah, Konsultasi Kesehatan, Pemeriksaan Ibu Hamil', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
('ugd', 'Trauma dan Cedera, Serangan Jantung, Stroke, Sesak Napas Berat, Pingsan atau Kejang, Nyeri Dada Parah, Perdarahan Berat, Kelahiran Darurat', 'Jam Operasional: 24 Jam Sehari, 7 Hari Seminggu');

-- Insert sample doctors
INSERT INTO dokter (nama, spesialisasi, jadwal) VALUES 
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
INSERT INTO berita (judul, konten, tanggal_publish) VALUES 
('Gejala Diabetes yang Perlu Diwaspadai', 'Kenali gejala diabetes sejak dini agar bisa dilakukan penanganan yang tepat dan mencegah komplikasi serius...', '2025-11-15'),
('Pentingnya Vaksinasi untuk Anak', 'Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit berbahaya pada anak...', '2025-11-12'),
('Tips Menjaga Kesehatan di Musim Penghujan', 'Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan selama musim penghujan...', '2025-11-10'),
('Manfaat Olahraga Rutin bagi Kesehatan', 'Melakukan olahraga secara rutin memiliki banyak manfaat bagi kesehatan fisik dan mental...', '2025-11-08'),
('Pentingnya Asupan Nutrisi Seimbang', 'Asupan nutrisi yang seimbang sangat penting untuk menjaga kesehatan tubuh secara keseluruhan...', '2025-11-05');