<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get all poli from database
try {
    $stmt = $pdo->query("SELECT * FROM poli ORDER BY id ASC");
    $poli_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no poli exist, redirect to home
    if (empty($poli_list)) {
        header("Location: index.php");
        exit();
    }
    
    // Set default poli to the first one
    $selected_poli = $poli_list[0];
    if (isset($_GET['poli_id'])) {
        $requested_poli_id = (int)$_GET['poli_id'];
        foreach ($poli_list as $p) {
            if ($p['id'] == $requested_poli_id) {
                $selected_poli = $p;
                break;
            }
        }
    }
} catch (PDOException $e) {
    header("Location: index.php");
    exit();
}

// Sanitize and format the poli name for display
$poli_name_display = ucfirst(str_replace(['poli_', '_'], ['Poli ', ' '], $selected_poli['nama_poli']));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - Melo Health</title>
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
            <h1 class="text-4xl font-bold mb-4">Layanan Kami</h1>
            <p class="text-xl max-w-2xl mx-auto">Pilihan layanan kesehatan yang tersedia di Puskesmas Melo Health.</p>
        </div>
    </section>

    <!-- Poli Selection Bar -->
    <section class="bg-white py-4 shadow-md sticky top-[70px] z-40">
        <div class="container mx-auto px-4">
            <div class="flex overflow-x-auto space-x-2 pb-2 scrollbar-hide">
                <?php foreach ($poli_list as $p): ?>
                    <?php
                    $p_display_name = ucfirst(str_replace(['poli_', '_'], ['Poli ', ' '], $p['nama_poli']));
                    $is_active = ($p['id'] == $selected_poli['id']) ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200';
                    ?>
                    <a href="layanan.php?poli_id=<?php echo $p['id']; ?>" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors duration-300 <?php echo $is_active; ?>">
                        <?php echo htmlspecialchars($p_display_name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Poli Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800"><?php echo htmlspecialchars($poli_name_display); ?> - Tipe Layanan</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <?php
                            $layanan_list = explode(',', $selected_poli['tipe_layanan']);
                            ?>
                            <ul class="space-y-3">
                                <?php foreach ($layanan_list as $layanan): ?>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                        <span><?php echo htmlspecialchars(trim($layanan)); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Informasi Umum</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <?php echo nl2br(htmlspecialchars($selected_poli['informasi_umum'])); ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Ambil Antrian Button -->
                    <div class="bg-green-50 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Ambil Nomor Antrian</h3>
                        <p class="text-gray-600 mb-4">Lakukan pemeriksaan secara rutin untuk menjaga kesehatan Anda.</p>
                        <button onclick="ambilAntrian(<?php echo $selected_poli['id']; ?>)" class="w-full bg-green-600 hover:bg-green-700 hover:scale-105 text-white font-bold py-3 px-4 rounded-md transition-all duration-500 ease-in-out">
                            Ambil Nomor Antrian
                        </button>
                    </div>

                    <!-- Info Penting -->
                    <div class="bg-blue-50 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Info Penting</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Bawa kartu identitas saat kunjungan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Gunakan masker selama di dalam gedung</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mt-1 mr-2"></i>
                                <span>Datang sesuai waktu yang ditentukan</span>
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
                        <li><a href="layanan.php" class="text-gray-400 hover:text-white transition duration-300">Layanan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition duration-300">Beranda</a></li>
                        <li><a href="tentang.php" class="text-gray-400 hover:text-white transition duration-300">Tentang</a></li>
                        <li><a href="berita.php" class="text-gray-400 hover:text-white transition duration-300">Berita</a></li>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_confirmed'] == 'confirmed'): ?>
                        <li><a href="user/profile.php" class="text-gray-400 hover:text-white transition duration-300">Profile</a></li>
                        <?php else: ?>
                        <li><a href="login.php" class="text-gray-400 hover:text-white transition duration-300">Login</a></li>
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
    <script>

        // Ambil antrian function - langsung redirect ke halaman ambil antrian
        <?php if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_confirmed']) && $_SESSION['user_confirmed'] != 'confirmed')): ?>
            function ambilAntrian(poliId) {
                <?php if (!isset($_SESSION['user_id'])): ?>
                    alert("Anda perlu login terlebih dahulu");
                    window.location.href = 'login.php';
                <?php else: ?>
                    alert('Akun Anda belum dikonfirmasi. Silakan datang ke Puskesmas untuk konfirmasi.');
                    window.location.href = 'login.php';
                <?php endif; ?>
            }
        <?php else: ?>
            function ambilAntrian(poliId) {
                window.location.href = 'user/ambil-antrian.php?poli_id=' + poliId;
            }
        <?php endif; ?>

        // Mobile menu toggle only (removing the duplicate event listener for ambil antrian button)
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                if (mobileMenuButton) {
                    mobileMenuButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        const menu = document.getElementById('mobile-menu');
                        if (menu) {
                            menu.classList.toggle('hidden');
                        }
                    });
                }
            } catch (error) {
                console.error('Error setting up mobile menu:', error);
            }
        });
    </script>
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Tambahkan margin negatif untuk mengatasi gap */
        .sticky-nav-offset {
            margin-top: -4px;
        }
    </style>
</body>
</html>