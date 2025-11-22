<?php
session_start();
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Kesehatan - Melo Health</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50">
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg absolute w-full z-40">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="index.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Beranda</a>
            <a href="tentang.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Tentang</a>
            <div class="pl-3 border-l-2 border-green-500">
                <a href="poli/poli-gigi.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Gigi</a>
                <a href="poli/poli-gizi.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Gizi</a>
                <a href="poli/poli-umum.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">Poli Umum</a>
                <a href="poli/ugd.php" class="block px-3 py-2 text-gray-800 hover:bg-green-100">UGD</a>
            </div>
            <a href="berita.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Berita</a>
            <a href="login.php" class="block px-3 py-2 rounded-md text-gray-800 hover:bg-green-100">Login</a>
        </div>
    </div>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Berita & Artikel Kesehatan</h1>
            <p class="text-xl max-w-2xl mx-auto">Informasi terkini seputar kesehatan, tips hidup sehat, dan perkembangan dunia medis.</p>
        </div>
    </section>
    
    <!-- Berita Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Artikel List -->
                <div class="md:w-2/3">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Artikel Terbaru</h2>
                        
                        <div class="grid grid-cols-1 gap-8">
                            <!-- Artikel 1 -->
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:shrink-0">
                                        <img src="https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=400" alt="Gejala Diabetes" class="h-48 w-full md:w-48 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm text-gray-500 mb-2">15 November 2025</div>
                                        <h3 class="text-xl font-bold mb-3 text-gray-800">Gejala Diabetes yang Perlu Diwaspadai</h3>
                                        <p class="text-gray-600 mb-4">Kenali gejala diabetes sejak dini agar bisa dilakukan penanganan yang tepat dan mencegah komplikasi serius.</p>
                                        <a href="detail-berita.php?id=1" class="inline-block text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Artikel 2 -->
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:shrink-0">
                                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=400" alt="Vaksinasi Anak" class="h-48 w-full md:w-48 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm text-gray-500 mb-2">12 November 2025</div>
                                        <h3 class="text-xl font-bold mb-3 text-gray-800">Pentingnya Vaksinasi untuk Anak</h3>
                                        <p class="text-gray-600 mb-4">Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit berbahaya pada anak.</p>
                                        <a href="detail-berita.php?id=2" class="inline-block text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Artikel 3 -->
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:shrink-0">
                                        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=400" alt="Tips Kesehatan" class="h-48 w-full md:w-48 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm text-gray-500 mb-2">10 November 2025</div>
                                        <h3 class="text-xl font-bold mb-3 text-gray-800">Tips Menjaga Kesehatan di Musim Penghujan</h3>
                                        <p class="text-gray-600 mb-4">Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan selama musim penghujan.</p>
                                        <a href="detail-berita.php?id=3" class="inline-block text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Artikel 4 -->
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:shrink-0">
                                        <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=400" alt="Olahraga" class="h-48 w-full md:w-48 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm text-gray-500 mb-2">8 November 2025</div>
                                        <h3 class="text-xl font-bold mb-3 text-gray-800">Manfaat Olahraga Rutin bagi Kesehatan</h3>
                                        <p class="text-gray-600 mb-4">Melakukan olahraga secara rutin memiliki banyak manfaat bagi kesehatan fisik dan mental.</p>
                                        <a href="detail-berita.php?id=4" class="inline-block text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Artikel 5 -->
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:shrink-0">
                                        <img src="https://images.unsplash.com/photo-1581595219310-9a100d1d5e04?auto=format&fit=crop&w=400" alt="Nutrisi" class="h-48 w-full md:w-48 object-cover">
                                    </div>
                                    <div class="p-6">
                                        <div class="text-sm text-gray-500 mb-2">5 November 2025</div>
                                        <h3 class="text-xl font-bold mb-3 text-gray-800">Pentingnya Asupan Nutrisi Seimbang</h3>
                                        <p class="text-gray-600 mb-4">Asupan nutrisi yang seimbang sangat penting untuk menjaga kesehatan tubuh secara keseluruhan.</p>
                                        <a href="detail-berita.php?id=5" class="inline-block text-green-600 font-medium hover:underline">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-10 flex justify-center">
                            <nav class="flex items-center space-x-2">
                                <a href="#" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">Previous</a>
                                <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-md">1</a>
                                <a href="#" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">2</a>
                                <a href="#" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">3</a>
                                <a href="#" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">Next</a>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="md:w-1/3">
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Berita Populer</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm">1</span>
                                <a href="detail-berita.php?id=1" class="text-gray-800 hover:text-green-600">Gejala Diabetes yang Perlu Diwaspadai</a>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm">2</span>
                                <a href="detail-berita.php?id=2" class="text-gray-800 hover:text-green-600">Pentingnya Vaksinasi untuk Anak</a>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm">3</span>
                                <a href="detail-berita.php?id=3" class="text-gray-800 hover:text-green-600">Tips Menjaga Kesehatan di Musim Penghujan</a>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm">4</span>
                                <a href="detail-berita.php?id=4" class="text-gray-800 hover:text-green-600">Manfaat Olahraga Rutin bagi Kesehatan</a>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 mt-1 text-sm">5</span>
                                <a href="detail-berita.php?id=5" class="text-gray-800 hover:text-green-600">Pentingnya Asupan Nutrisi Seimbang</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Kategori Berita</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Kesehatan Umum</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">12</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Gaya Hidup Sehat</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">8</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Nutrisi</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">5</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Pola Makan</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">7</span>
                            </a></li>
                            <li><a href="#" class="flex justify-between text-gray-800 hover:text-green-600">
                                <span>Olahraga</span>
                                <span class="bg-gray-200 text-gray-800 text-xs rounded-full px-2 py-1">6</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
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
                        <li><a href="poli/ugd.php" class="text-gray-400 hover:text-white transition duration-300">Unit Gawat Darurat</a></li>
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