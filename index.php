<?php
session_start();
require_once 'includes/functions.php';

// No redirect should happen on the homepage for logged-in users
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melo Health - Sistem Informasi dan Antrian Puskesmas</title>
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
                    <a href="register.php" class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-6 rounded-md transition duration-300">Daftar Sekarang</a>
                    <a href="#layanan" class="bg-transparent border-2 border-white hover:bg-white/10 font-bold py-3 px-6 rounded-md transition duration-300">Lihat Layanan</a>
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
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-tooth text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Gigi</h3>
                    <p class="text-gray-600">Pelayanan kesehatan gigi dan mulut yang komprehensif.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-utensils text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Gizi</h3>
                    <p class="text-gray-600">Konsultasi gizi dan program diet sehat.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-md text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Poli Umum</h3>
                    <p class="text-gray-600">Pemeriksaan kesehatan umum dan pengobatan dasar.</p>
                </div>
                
            </div>
        </div>
    </section>
    
    <!-- Berita Terbaru -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Berita Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=500" alt="Berita 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-gray-500">15 November 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3 text-gray-800">Tips Menjaga Kesehatan di Musim Penghujan</h3>
                        <p class="text-gray-600 mb-4">Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan...</p>
                        <a href="detail-berita.php?id=1" class="text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=500" alt="Berita 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-gray-500">12 November 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3 text-gray-800">Pentingnya Vaksinasi untuk Anak</h3>
                        <p class="text-gray-600 mb-4">Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit...</p>
                        <a href="detail-berita.php?id=2" class="text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=500" alt="Berita 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-sm text-gray-500">10 November 2025</span>
                        <h3 class="text-xl font-bold mt-2 mb-3 text-gray-800">Gejala Diabetes yang Perlu Diwaspadai</h3>
                        <p class="text-gray-600 mb-4">Kenali gejala diabetes sejak dini agar bisa dilakukan penanganan...</p>
                        <a href="detail-berita.php?id=3" class="text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
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
                        <li><a href="poli/poli-gigi.php" class="text-gray-400 hover:text-white transition duration-300">Poli Gigi</a></li>
                        <li><a href="poli/poli-gizi.php" class="text-gray-400 hover:text-white transition duration-300">Poli Gizi</a></li>
                        <li><a href="poli/poli-umum.php" class="text-gray-400 hover:text-white transition duration-300">Poli Umum</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition duration-300">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white transition duration-300">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white transition duration-300">Berita</a></li>
                        <li><a href="login.php" class="text-gray-400 hover:text-white transition duration-300">Login</a></li>
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
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>