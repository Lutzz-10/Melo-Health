-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2025 at 03:57 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

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
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `poli_id` int NOT NULL,
  `nomor_antrian` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_antrian` date NOT NULL,
  `status` enum('menunggu','sudah_digunakan','sudah_kadaluarsa') COLLATE utf8mb4_general_ci DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id`, `user_id`, `poli_id`, `nomor_antrian`, `tanggal_antrian`, `status`, `created_at`) VALUES
(1, 3, 1, 'A001', '2025-11-28', 'sudah_digunakan', '2025-11-28 07:18:27'),
(2, 3, 2, 'A001', '2025-11-28', 'sudah_digunakan', '2025-11-28 07:18:53'),
(3, 4, 2, 'A002', '2025-11-28', 'sudah_kadaluarsa', '2025-11-28 09:31:31'),
(4, 3, 1, 'A001', '2025-12-02', 'sudah_kadaluarsa', '2025-12-02 05:07:48'),
(5, 3, 1, 'A001', '2025-12-03', 'sudah_digunakan', '2025-12-03 12:59:38'),
(6, 3, 3, 'U001', '2025-12-03', 'sudah_digunakan', '2025-12-03 15:13:26'),
(7, 3, 2, 'GZ001', '2025-12-03', 'sudah_digunakan', '2025-12-03 15:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `konten` text COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `konten`, `gambar`, `tanggal_publish`, `created_at`) VALUES
(6, 'Peningkatan Kesadaran Gizi Kunci Mencegah Stunting pada Anak', 'Jakarta – Kasus stunting, kondisi gagal tumbuh akibat kekurangan gizi kronis, masih menjadi perhatian serius di Indonesia. Data terbaru Kementerian Kesehatan (Kemenkes) menunjukkan adanya tren penurunan, namun upaya edukasi dan intervensi gizi di tingkat akar rumput perlu terus diperkuat untuk mencapai target bebas stunting nasional.\r\n\r\nFokus pada 1.000 Hari Pertama Kehidupan\r\nPakar Gizi Masyarakat dari Universitas Indonesia, Dr. Rina Kusuma, M.Gizi, menekankan bahwa periode 1.000 hari pertama kehidupan (HPK), yang dimulai sejak masa kehamilan hingga anak berusia dua tahun, adalah jendela kritis yang menentukan perkembangan optimal anak.\r\n\r\n\"Asupan gizi yang adekuat, terutama protein hewani, zat besi, dan asam folat, pada ibu hamil sangat penting. Setelah bayi lahir, pemberian Air Susu Ibu (ASI) eksklusif selama enam bulan, diikuti dengan Makanan Pendamping ASI (MP-ASI) yang bergizi seimbang, adalah pertahanan utama kita melawan stunting,\" ujar Dr. Rina dalam seminar daring hari Rabu lalu.\r\n\r\nPeran Aktif Keluarga dan Posyandu\r\nKemenkes mengapresiasi peran aktif kader Posyandu dan tenaga kesehatan di Puskesmas yang menjadi garda terdepan dalam memantau tumbuh kembang anak. Penimbangan rutin dan pengukuran panjang/tinggi badan balita setiap bulan merupakan langkah deteksi dini yang tidak boleh terlewatkan.\r\n\r\nSelain itu, edukasi kepada orang tua mengenai variasi dan kualitas makanan yang diberikan kepada anak juga menjadi kunci. Banyak kasus stunting terjadi bukan hanya karena minimnya kuantitas makanan, tetapi juga rendahnya kualitas gizi. Protein hewani, seperti telur, ikan, dan daging, terbukti sangat efektif dalam mendukung pertumbuhan linier.\r\n\r\nInovasi Program Pemerintah\r\nPemerintah terus meluncurkan berbagai inovasi, termasuk penyediaan tablet tambah darah bagi remaja putri dan ibu hamil untuk mengatasi anemia, serta fortifikasi bahan pangan lokal.\r\n\r\n\"Kami menargetkan semua pihak, mulai dari pemerintah daerah hingga keluarga, mengambil tanggung jawab bersama. Kesehatan anak hari ini adalah investasi masa depan bangsa,\" tambah Kepala Pusat Data dan Informasi Kemenkes, dr. Budi Santoso.\r\n\r\nKesadaran akan pentingnya gizi seimbang, sanitasi yang baik, dan akses ke layanan kesehatan yang optimal adalah tiga pilar utama yang harus terus disosialisasikan agar Indonesia benar-benar dapat terbebas dari ancaman stunting', 'assets/images/69298a1e41f81_bd6188f4b543fb60.jpg', '2025-11-28', '2025-11-28 11:40:14'),
(7, 'Mengatasi Zoom Fatigue : Strategi Menjaga Kesehatan Mental di Era Kerja Jarak Jauh', 'Bandung – Fenomena \'Zoom Fatigue\' atau kelelahan akibat terlalu banyak berinteraksi melalui video conference kini menjadi tantangan kesehatan mental yang nyata bagi para pekerja jarak jauh. Meskipun menawarkan fleksibilitas, transisi digital yang cepat ini membawa beban kognitif yang signifikan.\r\n\r\nPenyebab Utama Kelelahan Digital\r\nMenurut hasil studi terbaru dari Asosiasi Psikolog Indonesia (API), kelelahan digital disebabkan oleh beberapa faktor utama:\r\n\r\nKontak Mata Intensif: Di layar, kita merasa harus mempertahankan kontak mata yang lebih intens dan lama, yang secara alami memicu respons stres.\r\n\r\nKeterbatasan Gerakan: Terpaksa duduk di satu posisi dalam waktu lama, mengurangi sinyal non-verbal yang penting untuk komunikasi yang lancar.\r\n\r\nKekhawatiran Penampilan Diri: Terus-menerus melihat diri sendiri di layar (self-view) dapat meningkatkan kecemasan dan menguras energi mental.\r\n\r\n\"Otak kita bekerja lebih keras untuk memproses isyarat non-verbal yang hilang atau terdistorsi dalam panggilan video, membuat setiap pertemuan terasa lebih melelahkan daripada pertemuan tatap muka,\" jelas Dr. Santi Dewi, seorang psikolog klinis dari Universitas Padjadjaran.\r\n\r\nStrategi Efektif untuk Mengurangi Beban\r\nPara ahli menyarankan beberapa strategi praktis untuk mengatasi kelelahan ini:\r\n\r\nBatasi Durasi dan Jumlah Rapat: Prioritaskan pertemuan yang benar-benar memerlukan video. Pertimbangkan untuk menggunakan panggilan telepon tradisional atau email untuk pembaruan yang sifatnya informatif.\r\n\r\nJadwalkan \'Jeda Mata\': Terapkan aturan 20-20-20 (setiap 20 menit, lihatlah objek sejauh 20 kaki selama 20 detik) untuk mengurangi ketegangan mata.\r\n\r\nMatikan Fitur Self-View: Sembunyikan jendela video diri Anda sendiri. Hal ini dapat mengurangi fokus berlebihan pada penampilan dan membantu Anda lebih fokus pada pembicara lain.\r\n\r\nTerapkan Audio-Only: Dorong tim untuk sesekali mematikan kamera, terutama saat mendengarkan presentasi atau dalam rapat yang tidak memerlukan interaksi visual intensif.\r\n\r\nKeseimbangan Kerja dan Hidup\r\nPenting juga bagi perusahaan untuk mendorong budaya kerja yang mendukung keseimbangan. Pemberian batas waktu kerja yang jelas dan penekanan pada waktu istirahat sangat penting. Kesehatan mental yang baik bukan hanya tanggung jawab individu, tetapi juga tanggung jawab institusi.\r\n\r\nDengan penyesuaian yang bijak dan kesadaran akan efek digitalisasi, kita dapat memanfaatkan teknologi tanpa mengorbankan kesejahteraan mental.', 'assets/images/6929a2961a60c_62fb42001f98a593.jpg', '2025-11-28', '2025-11-28 13:24:38'),
(8, 'Pentingnya Kualitas Tidur: Bukan Hanya Soal Durasi, Tapi Juga Peran dalam Imunitas Tubuh', 'Yogyakarta – Tidur seringkali dianggap sebagai waktu istirahat pasif, namun para ahli kesehatan menegaskan bahwa tidur adalah proses aktif dan vital yang sangat memengaruhi fungsi kekebalan tubuh (imunitas), metabolisme, dan kesehatan mental. Kurang tidur yang kronis kini diidentifikasi sebagai faktor risiko utama berbagai penyakit, jauh melampaui sekadar kelelahan.\r\n\r\nHubungan Tidur dan Sistem Kekebalan\r\nSaat kita tidur, tubuh melepaskan protein yang disebut sitokin, yang sangat penting untuk melawan infeksi dan peradangan. Jika seseorang kurang tidur, produksi sitokin dan sel-T (sel pembunuh kuman) akan menurun drastis.\r\n\r\nDr. Ayu Paramita, Sp.P (K), seorang ahli pulmonologi dan spesialis tidur, menjelaskan bahwa tidur adalah waktu \"pembersihan\" bagi tubuh. \"Saat tidur nyenyak, terutama pada tahap Non-Rapid Eye Movement (NREM) yang dalam, tubuh kita memperbaiki sel, memproduksi antibodi, dan menyusun ulang memori. Kurang dari 7 jam tidur secara konsisten dapat membuat tubuh rentan terhadap flu, bahkan mengurangi efektivitas vaksin,\" jelas Dr. Ayu.\r\n\r\nDampak pada Kesehatan Metabolik dan Mental\r\nSelain imunitas, kualitas tidur yang buruk juga berdampak langsung pada hormon yang mengatur nafsu makan, yaitu leptin (penghambat nafsu makan) dan ghrelin (perangsang nafsu makan). Kekurangan tidur meningkatkan ghrelin dan menurunkan leptin, yang dapat memicu makan berlebihan dan risiko obesitas serta diabetes tipe 2.\r\n\r\nDi sisi mental, tidur yang tidak memadai dapat memperburuk kondisi stres, kecemasan, dan depresi, karena mengganggu kemampuan otak untuk mengatur suasana hati dan memproses emosi secara efektif.\r\n\r\nTips Mencapai \'Tidur Higienis\'\r\nUntuk meningkatkan kualitas tidur, para ahli menyarankan penerapan Higiene Tidur yang ketat:\r\n\r\nJadwal Tidur Konsisten: Tidur dan bangun pada waktu yang sama setiap hari, termasuk akhir pekan.\r\n\r\nHindari Kafein dan Alkohol: Jangan konsumsi minuman ini beberapa jam sebelum tidur.\r\n\r\nOptimalkan Lingkungan Tidur: Pastikan kamar tidur gelap, tenang, dan sejuk.\r\n\r\nBatasi Paparan Layar: Jauhi ponsel, tablet, atau TV minimal satu jam sebelum tidur, karena cahaya biru menghambat produksi hormon tidur, melatonin.\r\n\r\nRelaksasi Rutin: Lakukan kegiatan yang menenangkan seperti membaca atau mandi air hangat sebelum tidur.\r\n\r\nDengan memprioritaskan tidur sebagai pilar kesehatan, sama pentingnya dengan nutrisi dan olahraga, individu dapat memperkuat sistem imun dan meningkatkan kualitas hidup secara keseluruhan.', 'assets/images/6929a352519f8_06695d3c5db969e7.jpg', '2025-11-28', '2025-11-28 13:26:45'),
(9, 'Manfaat Latihan Kekuatan: Bukan Hanya untuk Otot, Kunci Kesehatan Jangka Panjang', 'Denpasar – Selama ini, banyak orang fokus pada latihan kardio seperti lari atau bersepeda untuk menjaga kesehatan jantung. Namun, pakar kebugaran kini semakin gencar menyosialisasikan pentingnya latihan kekuatan (resistance training), seperti angkat beban atau latihan berat badan, sebagai fondasi kesehatan jangka panjang, terutama untuk mencegah penyakit yang berkaitan dengan usia.\r\n\r\nMengapa Kekuatan Otot Menjadi Krusial?\r\nSeiring bertambahnya usia, tubuh manusia secara alami kehilangan massa otot, sebuah kondisi yang dikenal sebagai sarkopenia. Kondisi ini tidak hanya mengurangi kekuatan fisik tetapi juga memperlambat metabolisme, meningkatkan risiko cedera akibat jatuh, dan memperburuk kondisi kronis seperti osteoporosis dan diabetes.\r\n\r\nDr. Putu Dharma, Sp.KO, seorang dokter spesialis kedokteran olahraga, menjelaskan bahwa latihan kekuatan adalah penangkal terbaik terhadap sarkopenia.\r\n\r\n\"Latihan beban merangsang pertumbuhan otot baru, yang tidak hanya membuat kita lebih kuat, tetapi juga meningkatkan kepadatan tulang. Untuk wanita pasca-menopause dan lansia, ini adalah investasi penting untuk mobilitas dan kualitas hidup di masa tua,\" ungkap Dr. Putu.\r\n\r\nManfaat Lebih dari Sekadar Estetika\r\nSelain membangun otot, latihan kekuatan juga memberikan manfaat kesehatan metabolisme yang signifikan:\r\n\r\nMeningkatkan Sensitivitas Insulin: Otot yang lebih besar mampu menyerap glukosa dari darah lebih efisien, membantu mengelola dan mencegah diabetes tipe 2.\r\n\r\nMeningkatkan Metabolisme: Jaringan otot membakar lebih banyak kalori saat istirahat (metabolisme basal) dibandingkan jaringan lemak, sehingga membantu pengelolaan berat badan.\r\n\r\nMencegah Osteoporosis: Tekanan mekanis dari latihan beban merangsang sel-sel pembentuk tulang, menjadikannya lebih kuat dan padat.\r\n\r\nPanduan Memulai dengan Aman\r\nBagi pemula, penting untuk memulai secara bertahap dan dengan teknik yang benar. Disarankan untuk berkonsultasi dengan profesional kebugaran atau dokter spesialis kedokteran olahraga sebelum memulai program angkat beban, terutama jika memiliki riwayat cedera.\r\n\r\nRekomendasi Umum:\r\n\r\nFrekuensi: Lakukan latihan kekuatan 2–3 kali seminggu, dengan jeda istirahat antar sesi untuk pemulihan otot.\r\n\r\nFokus Bentuk: Utamakan teknik yang benar daripada beban yang berat di awal. Gerakan dasar seperti squat, push-up (atau modifikasinya), dan row sudah cukup.\r\n\r\nProgresif: Tingkatkan beban atau repetisi secara bertahap seiring waktu.\r\n\r\nDengan memasukkan latihan kekuatan ke dalam rutinitas mingguan, masyarakat tidak hanya akan memiliki penampilan yang lebih bugar, tetapi juga membangun fondasi tubuh yang kokoh dan sehat untuk menghadapi tantangan usia.', 'assets/images/6929a394644c0_7b87fd6064d625a4.jpg', '2025-11-28', '2025-11-28 13:28:52'),
(10, 'Kesehatan Mata di Era Digital: Waspada Sindrom Mata Kering dan Kelelahan Digital', 'Medan – Penggunaan gawai dan komputer yang masif, terutama sejak era kerja dan belajar jarak jauh, telah memicu peningkatan drastis pada kasus gangguan kesehatan mata. Dua masalah utama yang kini merajalela adalah Sindrom Mata Kering (SMK) dan Kelelahan Mata Digital (Digital Eye Strain).\r\n\r\nAncaman di Balik Layar Biru\r\nMenurut data Perhimpunan Dokter Spesialis Mata Indonesia (PERDAMI), frekuensi kedipan mata seseorang dapat berkurang hingga 50% saat fokus menatap layar. Ini adalah penyebab utama Sindrom Mata Kering, di mana air mata menguap terlalu cepat, menyebabkan mata terasa perih, merah, dan berpasir.\r\n\r\nDr. Fauzi Rahman, Sp.M, seorang spesialis mata dari Rumah Sakit Mata Cipta Waras, menjelaskan bahwa intensitas cahaya biru yang dipancarkan oleh layar juga menjadi kontributor signifikan.\r\n\r\n\"Cahaya biru berenergi tinggi dapat menyebabkan ketegangan pada otot mata dan mengganggu siklus tidur karena menekan produksi melatonin. Ini bukan hanya soal penglihatan kabur, tetapi juga sakit kepala dan leher akibat postur tubuh saat menatap layar,\" kata Dr. Fauzi.\r\n\r\nMengenali dan Mengatasi Gejala\r\nGejala umum Kelelahan Mata Digital meliputi:\r\n\r\nMata terasa kering atau berair.\r\n\r\nPandangan ganda atau kabur.\r\n\r\nSakit kepala di area dahi atau pelipis.\r\n\r\nSensitivitas terhadap cahaya (fotofobia).\r\n\r\nPencegahan terbaik terletak pada perubahan kebiasaan saat menggunakan perangkat.\r\n\r\nTerapkan Aturan 20-20-20 dan Posisi Ergonomis\r\nPara ahli sangat merekomendasikan penerapan Aturan 20-20-20 untuk memberikan jeda bagi mata:\r\n\r\nSetiap 20 menit\r\n\r\nAlihkan pandangan ke objek sejauh 20 kaki (sekitar 6 meter)\r\n\r\nSelama 20 detik\r\n\r\nSelain itu, penting untuk memastikan ergonomi kerja:\r\n\r\nJarak Layar: Layar harus berjarak sekitar 50-70 cm dari wajah.\r\n\r\nPosisi Layar: Bagian atas layar sejajar atau sedikit di bawah mata.\r\n\r\nPencahayaan: Gunakan pencahayaan ruangan yang cukup, hindari cahaya yang langsung memantul ke layar.\r\n\r\nDengan disiplin dalam mengatur waktu layar dan menerapkan ergonomi yang benar, risiko gangguan mata di era digital dapat diminimalisir, memastikan mata tetap sehat dan produktif.', 'assets/images/6929a3c9c391d_fd3077907666e082.jpg', '2025-11-28', '2025-11-28 13:29:45'),
(11, 'Pentingnya Higiene Tangan: Senjata Utama Melawan Penyakit Menular Harian', 'Makassar – Dalam menghadapi ancaman berkelanjutan dari berbagai penyakit menular, mulai dari flu biasa, diare, hingga infeksi yang lebih serius, para ahli kesehatan terus menekankan satu langkah pencegahan yang paling sederhana namun paling efektif: mencuci tangan dengan benar.\r\n\r\nTangan Sebagai Gerbang Penyebaran Kuman\r\nTangan kita berfungsi sebagai perantara utama dalam penyebaran kuman. Kita menyentuh banyak permukaan—pegangan pintu, keyboard, uang—yang terkontaminasi oleh bakteri, virus, dan parasit. Ketika kita menyentuh wajah, mata, hidung, atau mulut, kuman-kuman ini dengan mudah memasuki tubuh, menyebabkan penyakit.\r\n\r\nDr. Susi Indah Sari, Sp.PD, seorang dokter spesialis penyakit dalam, menyatakan bahwa cuci tangan yang tepat dapat mengurangi kasus diare hingga 50% dan infeksi saluran pernapasan hingga 25%.\r\n\r\n\"Mencuci tangan dengan sabun dan air mengalir adalah vaksin termurah yang kita miliki. Bukan hanya menghilangkan kotoran, tetapi juga merusak membran lemak kuman, termasuk virus tertentu,\" ujar Dr. Susi dalam kampanye kesehatan masyarakat baru-baru ini.\r\n\r\nKesalahan Umum dalam Mencuci Tangan\r\nMeskipun banyak yang mengklaim rutin mencuci tangan, banyak orang tidak melakukannya dengan durasi atau teknik yang benar. Kesalahan umum meliputi:\r\n\r\nDurasi yang Terlalu Singkat: Mencuci tangan harus dilakukan minimal selama 20 detik—setara dengan menyanyikan lagu \"Selamat Ulang Tahun\" dua kali.\r\n\r\nMengabaikan Area Penting: Seringkali area punggung tangan, sela-sela jari, dan di bawah kuku terlewatkan.\r\n\r\nTidak Menggunakan Sabun: Hanya membilas dengan air tidak cukup untuk mengangkat lemak dan minyak tempat kuman bersembunyi.\r\n\r\nLima Momen Kritis Cuci Tangan\r\nKementerian Kesehatan mengimbau masyarakat untuk menjadikan mencuci tangan sebagai kebiasaan pada lima momen penting:\r\n\r\nSebelum makan.\r\n\r\nSebelum menyiapkan makanan.\r\n\r\nSetelah menggunakan toilet.\r\n\r\nSetelah batuk atau bersin.\r\n\r\nSetelah menyentuh hewan atau menangani sampah.\r\n\r\nPenerapan praktik higienis ini secara konsisten, baik di rumah, sekolah, maupun tempat kerja, adalah investasi kolektif dalam kesehatan masyarakat yang dapat memutus rantai penularan penyakit dan mengurangi beban sistem kesehatan nasional.', 'assets/images/6929a4032395d_470198bb7eb0d8fc.jpg', '2025-11-28', '2025-11-28 13:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int NOT NULL,
  `nama_poli` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_layanan` text COLLATE utf8mb4_general_ci NOT NULL,
  `informasi_umum` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `tipe_layanan`, `informasi_umum`) VALUES
(1, 'poli_gigi', 'Pemeriksaan Gigi Rutin, Pembersihan Karang Gigi, Penambalan Gigi, Pencabutan Gigi, Pembuatan Gigi Palsu, Perawatan Saluran Akar, Pemutihan Gigi, Pemeriksaan dan Pemasangan Behel', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
(2, 'poli_gizi', 'Assessment Status Gizi, Konsultasi Gizi untuk Ibu Hamil, Konsultasi Gizi untuk Anak-anak, Konsultasi Diet untuk Penderita Diabetes, Konsultasi Diet untuk Penderita Hipertensi, Konsultasi Diet Penurunan Berat Badan, Konsultasi Diet Peningkatan Berat Badan, Konsultasi Gizi untuk Lansia', 'Jam Operasional: Senin - Jumat: 08:00 - 15:00, Sabtu: 08:00 - 12:00'),
(3, 'poli_umum', 'Pemeriksaan Kesehatan Umum, Pengobatan Penyakit Ringan, Imunisasi, Deteksi Dini Penyakit, Pemeriksaan Tekanan Darah, Pemeriksaan Gula Darah, Konsultasi Kesehatan, Pemeriksaan Ibu Hamil', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00'),
(5, 'poli_mata', 'Pemeriksaan Mata, Terapi Mata, Operasi Lasik', 'Jam Operasional: Senin dan Kamis: 09:00 - 14:00'),
(6, 'poli_kulit', 'Pengecekan Kulit, Perawatan Kulit, Konsultasi Permasalahan Kulit, Laser Wajah', 'Jam Operasional: Senin - Jumat: 07:00 - 16:00, Sabtu: 08:00 - 14:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_profile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  `status_konfirmasi` enum('pending','confirmed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nik`, `alamat`, `no_hp`, `password`, `foto_profile`, `status_konfirmasi`, `created_at`) VALUES
(2, 'Alwan Lutfi Maulida`', '1234567812345678', 'Candiwulan', '082134378295', '$2y$10$Hv80DgwuL1e7d1EMpYufaO34ycSXOfOIxSVjZ5OFHVYlrtoNpJF/S', 'default.jpg', 'confirmed', '2025-11-22 07:52:54'),
(3, 'Egie Hariansyah', '3301231231231234', 'Warung Nyamleng - Bawang', '085865580124', '$2y$10$Yq4m8RnRg3za6XE/SKUpK.wfM2CGnU5ECkWnixlBvhHXD0FDmIsGi', 'default.jpg', 'confirmed', '2025-11-28 06:59:44'),
(4, 'Lutfi Maulida', '1111111111111111', 'Candiwulan', '082134378295', '$2y$10$4h08ZcnI3ecs4efV0Hqra.NvN620xgXjPFq4fvs4ZsfiLHoTHRoFS', 'default.jpg', 'confirmed', '2025-11-28 09:30:25');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
