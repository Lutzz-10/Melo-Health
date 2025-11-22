<?php
session_start();
require_once '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Gawat Darurat - Melo Health</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-50">
    <?php include '../includes/navbar.php'; ?>
    
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
    <section class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Unit Gawat Darurat</h1>
            <p class="text-xl max-w-2xl mx-auto">Pelayanan darurat 24 jam untuk kondisi medis kritis dan memerlukan penanganan segera.</p>
        </div>
    </section>
    
    <!-- Poli Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Tipe Layanan</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Trauma dan Cedera</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Serangan Jantung</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Stroke</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Sesak Napas Berat</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Pingsan atau Kejang</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Nyeri Dada Parah</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Perdarahan Berat</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-red-600 mt-1 mr-3"></i>
                                    <span>Kelahiran Darurat</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Informasi Umum</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-3 text-gray-800">Jam Operasional</h3>
                            <p class="text-gray-600 mb-4">24 Jam Sehari<br>
                            7 Hari Seminggu</p>
                            
                            <h3 class="text-xl font-bold mb-3 text-gray-800">Prosedur Pelayanan</h3>
                            <ol class="list-decimal pl-5 space-y-2 text-gray-600">
                                <li>Masuk ke Unit Gawat Darurat</li>
                                <li>Triage (penilaian awal kondisi pasien)</li>
                                <li>Pendaftaran dan identifikasi</li>
                                <li>Pemeriksaan dokter sesuai prioritas</li>
                                <li>Tindakan medis sesuai kebutuhan</li>
                                <li>Rawat inap atau pulang (jika stabil)</li>
                            </ol>
                            
                            <h3 class="text-xl font-bold mt-6 mb-3 text-gray-800">Kapan Harus Datang ke UGD?</h3>
                            <p class="text-gray-600 mb-3">Datang ke UGD ketika kondisi mengancam jiwa atau membutuhkan penanganan segera:</p>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Kesulitan bernapas berat</li>
                                <li>• Nyeri dada parah</li>
                                <li>• Kehilangan kesadaran</li>
                                <li>• Pendarahan parah</li>
                                <li>• Cedera kepala berat</li>
                                <li>• Reaksi alergi berat</li>
                            </ul>
                            
                            <h3 class="text-xl font-bold mt-6 mb-3 text-gray-800">Nomor Penting</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li>• UGD: (021) 1234-5678 ext. 911</li>
                                <li>• Ambulans: 119</li>
                                <li>• Polisi: 110</li>
                                <li>• Pemadam Kebakaran: 113</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div>
                    <!-- Jadwal Dokter -->
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Jadwal Dokter</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1559839734-2b71ea811ec6?auto=format&fit=crop&w=100" alt="Dr. Ahmad Darurat" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Dr. Ahmad Darurat</h4>
                                    <p class="text-gray-600">Shift Pagi</p>
                                    <p class="text-gray-600">06:00 - 14:00</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=100" alt="Dr. Siti Gawat" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Dr. Siti Gawat</h4>
                                    <p class="text-gray-600">Shift Sore</p>
                                    <p class="text-gray-600">14:00 - 22:00</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=100" alt="Dr. Budi Kritis" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Dr. Budi Kritis</h4>
                                    <p class="text-gray-600">Shift Malam</p>
                                    <p class="text-gray-600">22:00 - 06:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ambil Antrian Button -->
                    <div class="bg-red-50 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Panggilan Darurat</h3>
                        <p class="text-gray-600 mb-4">Jika dalam kondisi darurat, segera hubungi petugas medis atau hubungi nomor darurat.</p>
                        <button onclick="panggilDarurat()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
                            Hubungi UGD Sekarang
                        </button>
                    </div>
                    
                    <!-- Info Penting -->
                    <div class="bg-yellow-50 rounded-lg shadow-md p-6 mt-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Info Penting</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                                <span>UGD hanya untuk kondisi darurat</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                                <span>Bawa kartu identitas dan kartu BPJS</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                                <span>Siapkan riwayat penyakit dan obat yang diminum</span>
                            </li>
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
    <script src="../assets/js/script.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Panggil darurat function
        function panggilDarurat() {
            alert('Anda akan dihubungkan ke unit gawat darurat. Mohon tunggu sebentar...');
            // In a real application, this would make a call to the UGD
        }
    </script>
</body>
</html>