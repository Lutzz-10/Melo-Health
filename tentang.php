<?php
session_start();
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Melo Health</title>
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

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Tentang Kami</h1>
            <p class="text-xl max-w-2xl mx-auto">Menyediakan layanan kesehatan terbaik untuk masyarakat dengan sistem informasi yang canggih dan mudah diakses.</p>
        </div>
    </section>

    <!-- Visi dan Misi -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Visi</h2>
                    <p class="text-lg text-gray-600 mb-10">Menjadi pusat layanan kesehatan primer yang unggul dan terpercaya dalam memberikan pelayanan kesehatan yang berkualitas, terjangkau, dan mudah diakses oleh seluruh lapisan masyarakat.</p>

                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Misi</h2>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                            <span>Memberikan pelayanan kesehatan yang paripurna, merata, dan terjangkau bagi seluruh masyarakat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                            <span>Meningkatkan kualitas sumber daya manusia di bidang kesehatan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                            <span>Menerapkan sistem informasi kesehatan yang efisien dan efektif</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                            <span>Menyediakan fasilitas kesehatan yang memadai dan terjangkau</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                            <span>Melaksanakan program promotif dan preventif secara terus-menerus</span>
                        </li>
                    </ul>
                </div>

                <div class="flex justify-center">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600" alt="Tim Kesehatan" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah Singkat -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Sejarah Singkat</h2>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-600 mb-4">Puskesmas Melo Health berdiri sejak tahun 2010 dengan tujuan untuk memberikan pelayanan kesehatan yang berkualitas dan terjangkau bagi masyarakat sekitar. Awal berdirinya, Puskesmas Melo Health hanya memiliki beberapa tenaga medis dan fasilitas yang terbatas.</p>

                <p class="text-gray-600 mb-4">Seiring berjalannya waktu, Puskesmas Melo Health terus berkembang dan memperluas layanannya. Pada tahun 2015, Puskesmas ini mulai menerapkan sistem informasi berbasis digital untuk memudahkan masyarakat dalam mengakses layanan kesehatan.</p>

                <p class="text-gray-600 mb-4">Pada tahun 2020, Puskesmas Melo Health meluncurkan sistem antrian online untuk mengurangi kerumunan dan memberikan kemudahan bagi pasien dalam mengakses layanan kesehatan, terutama di masa pandemi COVID-19.</p>

                <p class="text-gray-600">Hingga kini, Puskesmas Melo Health terus berkomitmen untuk memberikan layanan kesehatan terbaik bagi masyarakat, dengan dukungan tenaga medis yang profesional dan sistem pelayanan yang modern dan efisien.</p>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Fasilitas yang Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-stethoscope text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center text-gray-800">Peralatan Medis</h3>
                    <p class="text-gray-600 text-center">Dilengkapi dengan peralatan medis modern untuk mendukung proses diagnosis dan pengobatan.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-md  hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-procedures text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center text-gray-800">Ruangan Perawatan</h3>
                    <p class="text-gray-600 text-center">Ruangan perawatan yang nyaman dan steril untuk kenyamanan pasien selama perawatan.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-prescription-bottle text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center text-gray-800">Apotek</h3>
                    <p class="text-gray-600 text-center">Apotek lengkap dengan berbagai jenis obat yang tersedia selama 24 jam.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-x-ray text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center text-gray-800">Laboratorium</h3>
                    <p class="text-gray-600 text-center">Laboratorium lengkap untuk pemeriksaan laboratorium berbagai jenis tes.</p>
                </div>


                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 hover:-translate-y-2 transition-all duration-500 ease-in-out">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-bed text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center text-gray-800">Rawat Inap</h3>
                    <p class="text-gray-600 text-center">Fasilitas rawat inap untuk pasien yang membutuhkan perawatan intensif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Lokasi dan Kontak -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Lokasi Kami</h2>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.132041922982!2d106.82362031476976!3d-6.386109995373929!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ef05e2352be1%3A0xe00534f5c70a56a9!2sPuskesmas%20Kalideres!5e0!3m2!1sen!2sid!4v1632702003401!5m2!1sen!2sid"
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            class="rounded-lg"></iframe>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Hubungi Kami</h2>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-4 text-xl"></i>
                                <div>
                                    <h3 class="font-bold text-gray-800">Alamat</h3>
                                    <p class="text-gray-600">Jl. Kesehatan No. 123, Kecamatan Sehat, Kota Sehat, DKI Jakarta</p>
                                </div>
                            </li>

                            <li class="flex items-start">
                                <i class="fas fa-phone text-green-600 mt-1 mr-4 text-xl"></i>
                                <div>
                                    <h3 class="font-bold text-gray-800">Telepon</h3>
                                    <p class="text-gray-600">(021) 1234-5678</p>
                                </div>
                            </li>

                            <li class="flex items-start">
                                <i class="fas fa-envelope text-green-600 mt-1 mr-4 text-xl"></i>
                                <div>
                                    <h3 class="font-bold text-gray-800">Email</h3>
                                    <p class="text-gray-600">info@melhealth.com</p>
                                </div>
                            </li>

                            <li class="flex items-start">
                                <i class="fas fa-clock text-green-600 mt-1 mr-4 text-xl"></i>
                                <div>
                                    <h3 class="font-bold text-gray-800">Jam Operasional</h3>
                                    <p class="text-gray-600">Senin - Jumat: 07:00 - 16:00<br>
                                    Sabtu: 08:00 - 14:00</p>
                                </div>
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
                        <li><a href="layanan.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Layanan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Berita</a></li>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_confirmed'] == 'confirmed'): ?>
                        <li><a href="user/profile.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Profile</a></li>
                        <?php else: ?>
                        <li><a href="login.php" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-500 ease-in-out">Login</a></li>
                        <?php endif; ?>
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