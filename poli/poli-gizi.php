<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poli Gizi - Melo Health</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-50">

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Poli Gizi</h1>
            <p class="text-xl max-w-2xl mx-auto">Konsultasi gizi dan program diet sehat untuk hidup lebih sehat dan bugar.</p>
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
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Assessment Status Gizi</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Gizi untuk Ibu Hamil</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Gizi untuk Anak-anak</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Diet untuk Penderita Diabetes</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Diet untuk Penderita Hipertensi</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Diet Penurunan Berat Badan</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Diet Peningkatan Berat Badan</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                    <span>Konsultasi Gizi untuk Lansia</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Informasi Umum</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold mb-3 text-gray-800">Jam Operasional</h3>
                            <p class="text-gray-600 mb-4">Senin - Jumat: 08:00 - 15:00<br>
                            Sabtu: 08:00 - 12:00<br>
                            Minggu: Libur</p>

                            <h3 class="text-xl font-bold mb-3 text-gray-800">Prosedur Pelayanan</h3>
                            <ol class="list-decimal pl-5 space-y-2 text-gray-600">
                                <li>Registrasi di meja pendaftaran</li>
                                <li>Mengisi formulir identitas dan keluhan</li>
                                <li>Penimbangan berat dan pengukuran tinggi badan</li>
                                <li>Menunggu panggilan nomor antrian</li>
                                <li>Konsultasi dengan ahli gizi</li>
                                <li>Pembuatan program diet sesuai kebutuhan</li>
                                <li>Pembayaran di kasir</li>
                            </ol>

                            <h3 class="text-xl font-bold mt-6 mb-3 text-gray-800">Tips Pola Makan Sehat</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Konsumsi makanan bergizi seimbang</li>
                                <li>• Makan makanan 4 sehat 5 sempurna</li>
                                <li>• Perbanyak konsumsi sayur dan buah</li>
                                <li>• Batasi makanan tinggi gula dan garam</li>
                                <li>• Minum air putih minimal 8 gelas per hari</li>
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
                                <img src="../assets/images/seli.png" alt="Ns. Seli" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Ns. Seli</h4>
                                    <p class="text-gray-600">Senin, Rabu, Jumat</p>
                                    <p class="text-gray-600">08:00 - 14:00</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <img src="../assets/images/egie.png" alt="Dr. Egie" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Dr. Egie</h4>
                                    <p class="text-gray-600">Selasa, Kamis</p>
                                    <p class="text-gray-600">08:00 - 14:00</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <img src="../assets/images/lutz.png" alt="Sst. Lutfi Maulida" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Sst. Lutfi Maulida</h4>
                                    <p class="text-gray-600">Sabtu</p>
                                    <p class="text-gray-600">08:00 - 12:00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ambil Antrian Button -->
                    <div class="bg-green-50 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Ambil Nomor Antrian</h3>
                        <p class="text-gray-600 mb-4">Dapatkan program diet sehat dan konseling gizi dari ahli profesional kami.</p>
                        <button onclick="ambilAntrian()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
                            Ambil Nomor Antrian
                        </button>
                    </div>

                    <!-- Info Penting -->
                    <div class="bg-blue-50 rounded-lg shadow-md p-6 mt-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Info Penting</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Bawa riwayat kesehatan jika ada</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Sebutkan alergi makanan jika ada</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Gunakan masker selama di dalam gedung</span>
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

    <!-- Modal -->
    <div id="antrianModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Konfirmasi Ambil Antrian</h3>
                    <button onclick="tutupModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <p class="text-gray-600 mb-2">Tanggal: <span id="tanggalAntrian" class="font-medium">22 November 2025</span></p>
                    <p class="text-gray-600">Poli: <span class="font-medium">Poli Gizi</span></p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="tutupModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button onclick="konfirmasiAntrian()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/script.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Ambil antrian function
        function ambilAntrian() {
            // Check if user is logged in
            <?php if (!isset($_SESSION['user_id']) || !$_SESSION['user_confirmed'] == 'confirmed'): ?>
                // Redirect to login if not logged in
                window.location.href = '../login.php';
            <?php else: ?>
                // Show confirmation modal
                document.getElementById('antrianModal').classList.remove('hidden');
            <?php endif; ?>
        }

        // Close modal function
        function tutupModal() {
            document.getElementById('antrianModal').classList.add('hidden');
        }

        // Konfirmasi antrian function
        function konfirmasiAntrian() {
            // Redirect to queue taking page with poli id
            window.location.href = '../user/ambil-antrian.php?poli_id=2';
        }

        // Set today's date in the modal
        const today = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('tanggalAntrian').textContent = today.toLocaleDateString('id-ID', options);
    </script>
</body>
</html>