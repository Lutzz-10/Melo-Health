<?php
session_start();
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - Melo Health</title>
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
    
    <!-- Artikel Detail -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="mb-6">
                <a href="berita.php" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Berita
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://images.unsplash.com/photo-1516559828984-fb3b99548b21?auto=format&fit=crop&w=1200" alt="Gejala Diabetes" class="w-full h-96 object-cover">
                
                <div class="p-8">
                    <div class="flex items-center text-gray-500 mb-4">
                        <span>15 November 2025</span>
                        <span class="mx-2">•</span>
                        <span>Kesehatan Umum</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gejala Diabetes yang Perlu Diwaspadai</h1>
                    
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        <p class="mb-4">Diabetes adalah penyakit kronis yang terjadi ketika tubuh tidak dapat memproduksi cukup insulin atau tidak dapat menggunakan insulin secara efektif. Kondisi ini menyebabkan kadar gula darah (glukosa) meningkat, yang dapat menyebabkan komplikasi serius jika tidak ditangani dengan baik.</p>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">Gejala Umum Diabetes</h2>
                        
                        <p class="mb-4">Gejala diabetes bisa berkembang secara perlahan atau mendadak tergantung pada jenis diabetes yang diderita. Berikut adalah gejala umum yang perlu diwaspadai:</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">1. Sering Merasa Haus</h3>
                        <p class="mb-4">Sering merasa haus (polidipsia) adalah salah satu gejala awal diabetes. Kadar gula darah yang tinggi menyebabkan ginjal bekerja lebih keras untuk menyaring dan menyerap kelebihan glukosa. Ketika ginjal tidak mampu menahan semua glukosa, gula berlebih ini dibuang ke dalam urine, bersama dengan cairan dari jaringan tubuh.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">2. Sering Buang Air Kecil</h3>
                        <p class="mb-4">Peningkatan produksi urine (poliuria) terjadi karena ginjal mencoba mengeluarkan kelebihan gula dari darah. Kondisi ini sering kali meningkatkan frekuensi buang air kecil, terutama pada malam hari.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">3. Sering Merasa Lapar</h3>
                        <p class="mb-4">Sering merasa lapar (polifagia) terjadi karena tubuh tidak dapat menggunakan glukosa sebagai sumber energi secara efektif. Meskipun sudah makan, tubuh mungkin merasa lemah karena sel-sel tidak mendapatkan glukosa yang dibutuhkan.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">4. Penurunan Berat Badan Secara Tidak Disengaja</h3>
                        <p class="mb-4">Penurunan berat badan yang tidak disengaja terjadi karena tubuh mulai memecah otot dan lemak untuk mendapatkan energi ketika tidak dapat menggunakan glukosa. Ini biasanya terjadi pada diabetes tipe 1.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">5. Kelelahan dan Lemas</h3>
                        <p class="mb-4">Karena sel-sel tidak menerima glukosa yang cukup untuk produksi energi, penderita diabetes sering merasa lelah dan lemas secara terus menerus.</p>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">Jenis-Jenis Diabetes</h2>
                        
                        <p class="mb-4">Terdapat beberapa jenis diabetes, masing-masing dengan karakteristik dan penyebab yang berbeda:</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Diabetes Tipe 1</h3>
                        <p class="mb-4">Diabetes tipe 1 biasanya berkembang pada anak-anak dan remaja, meskipun bisa terjadi pada usia berapa pun. Pada kondisi ini, sistem kekebalan tubuh menyerang dan menghancurkan sel-sel pankreas yang menghasilkan insulin. Penderita diabetes tipe 1 perlu suntik insulin setiap hari untuk bertahan hidup.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Diabetes Tipe 2</h3>
                        <p class="mb-4">Diabetes tipe 2 adalah bentuk paling umum dari diabetes. Pada diabetes tipe 2, tubuh menghasilkan insulin tetapi tidak dapat menggunakannya secara efektif (resistensi insulin). Kondisi ini biasanya berkembang secara perlahan dan sering kali terkait dengan gaya hidup tidak sehat dan obesitas.</p>
                        
                        <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Diabetes Gestasional</h3>
                        <p class="mb-4">Diabetes gestasional terjadi selama kehamilan ketika tubuh tidak dapat menghasilkan cukup insulin untuk mengatasi lonjakan gula darah yang meningkat. Kondisi ini biasanya hilang setelah melahirkan, tetapi meningkatkan risiko diabetes tipe 2 di masa depan.</p>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">Pencegahan dan Penanganan</h2>
                        
                        <p class="mb-4">Pencegahan diabetes tipe 2 sangat penting dan bisa dilakukan dengan:</p>
                        
                        <ul class="list-disc pl-6 mb-4 space-y-2">
                            <li>Mengontrol berat badan</li>
                            <li>Rutin berolahraga</li>
                            <li>Makan makanan seimbang</li>
                            <li>Hindari merokok dan minum alkohol</li>
                            <li>Rutin memeriksakan kesehatan</li>
                        </ul>
                        
                        <p class="mb-4">Jika Anda mengalami salah satu atau lebih gejala di atas, segeralah berkonsultasi dengan dokter untuk mendapatkan pemeriksaan dan penanganan yang tepat. Deteksi dini sangat penting untuk mencegah komplikasi serius seperti penyakit jantung, stroke, gagal ginjal, dan kebutaan.</p>
                        
                        <p class="mb-4">Ingat, diabetes adalah kondisi yang bisa dikendalikan dengan pengobatan dan gaya hidup yang sehat. Jangan menunda-nunda kunjungan ke fasilitas kesehatan jika Anda merasa gejala tersebut muncul.</p>
                    </div>
                    
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Bagikan Artikel Ini</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fab fa-facebook-f mr-2"></i>
                                Facebook
                            </a>
                            <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                WhatsApp
                            </a>
                            <a href="#" class="bg-blue-400 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 bg-gray-50 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-bold text-gray-800 mb-2">Pentingnya Vaksinasi untuk Anak</h4>
                        <p class="text-sm text-gray-600">Vaksinasi merupakan langkah penting dalam mencegah berbagai penyakit berbahaya pada anak.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-bold text-gray-800 mb-2">Tips Menjaga Kesehatan di Musim Penghujan</h4>
                        <p class="text-sm text-gray-600">Berikut beberapa tips yang bisa Anda lakukan untuk menjaga kesehatan selama musim penghujan.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-bold text-gray-800 mb-2">Manfaat Olahraga Rutin bagi Kesehatan</h4>
                        <p class="text-sm text-gray-600">Melakukan olahraga secara rutin memiliki banyak manfaat bagi kesehatan fisik dan mental.</p>
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