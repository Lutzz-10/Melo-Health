<?php
session_start();
require_once 'includes/functions.php';

// No redirect should happen on the homepage for logged-in users

// Ambil 3 berita terbaru dari database
try {
    $stmt = $pdo->prepare("SELECT * FROM berita ORDER BY tanggal_publish DESC LIMIT 3");
    $stmt->execute();
    $latest_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $latest_news = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melo Health - Sistem Informasi dan Antrian Puskesmas</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/melohealth.jpg">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Layanan Kesehatan Terbaik untuk Anda</h1>
                <p class="text-xl mb-8">Melo Health menyediakan sistem informasi dan antrian Puskesmas yang efisien dan mudah diakses.</p>
                <div class="flex space-x-4">
                    <a href="register.php" class="bg-white text-green-600 hover:bg-gray-100 hover:scale-105 font-bold py-3 px-6 rounded-md transition-all duration-500 ease-in-out">Daftar Sekarang</a>
                    <a href="#layanan" class="bg-transparent border-2 border-white hover:bg-white/10 hover:scale-105 font-bold py-3 px-6 rounded-md transition-all duration-500 ease-in-out">Lihat Layanan</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-8 max-w-md w-full">
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=500" alt="Kesehatan" class="rounded-lg w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Unggulan -->
    <section id="layanan" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Layanan Unggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <a href="poli/poli-gigi.php" class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out flex flex-col items-center text-center cursor-pointer">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-tooth text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Gigi</h3>
                    <p class="text-gray-600">Pelayanan kesehatan gigi dan mulut yang komprehensif.</p>
                </a>

                <a href="poli/poli-gizi.php" class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out flex flex-col items-center text-center cursor-pointer">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-utensils text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Gizi</h3>
                    <p class="text-gray-600">Konsultasi gizi dan program diet sehat.</p>
                </a>

                <a href="poli/poli-umum.php" class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out flex flex-col items-center text-center cursor-pointer">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-md text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Umum</h3>
                    <p class="text-gray-600">Pemeriksaan kesehatan umum dan pengobatan dasar.</p>
                </a>

            </div>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Berita Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php if (!empty($latest_news)): ?>
                    <?php foreach ($latest_news as $news): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                            <img src="<?php echo !empty($news['gambar']) ? $news['gambar'] : 'https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=500'; ?>"
                                 alt="<?php echo htmlspecialchars($news['judul']); ?>"
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <span class="text-sm text-gray-500"><?php echo date('d F Y', strtotime($news['tanggal_publish'])); ?></span>
                                <h3 class="text-xl font-bold mt-2 mb-3 text-gray-800"><?php echo htmlspecialchars($news['judul']); ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo substr(htmlspecialchars(strip_tags($news['konten'])), 0, 100) . '...'; ?></p>
                                <a href="detail-berita.php?id=<?php echo $news['id']; ?>"
                                   class="text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback jika tidak ada berita -->
                    <div class="col-span-3 text-center py-10">
                        <p class="text-gray-600">Belum ada berita terbaru.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-10">
                <a href="berita.php" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-md transition duration-300">Lihat Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Melo Health</h3>
                    <p class="text-gray-400">Sistem informasi dan antrian Puskesmas yang efisien dan mudah diakses oleh masyarakat.</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="poli/poli-gigi.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Gigi</a></li>
                        <li><a href="poli/poli-gizi.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Gizi</a></li>
                        <li><a href="poli/poli-umum.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Poli Umum</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Berita</a></li>
                        <li><a href="login.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Kesehatan No. 123, Kota Sehat</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>info@melhealth.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400">
                <p>&copy; 2025 Melo Health. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>
</html>