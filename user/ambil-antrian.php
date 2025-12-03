<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in and confirmed
if (!isLoggedIn() || !isUserConfirmed()) {
    header("Location: ../login.php");
    exit();
}

    $error = '';
    $success = '';

    // Get poli information first to ensure it exists
    // Support both POST and GET for poli_id
    $poli_id = (int)($_POST['poli_id'] ?? $_GET['poli_id'] ?? 0);
    if ($poli_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM poli WHERE id = ?");
        $stmt->execute([$poli_id]);
        $poli = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$poli) {
            $error = "Poli tidak ditemukan.";
            $poli_id = 0; // Reset invalid poli_id
        }
    } else {
        $error = "Poli tidak ditemukan.";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $poli_id > 0) {
        // CSRF protection - only required for POST requests
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            die('CSRF token validation failed');
        }

        // Validate that the posted poli_id matches the one from URL to prevent tampering
        $posted_poli_id = (int)$_POST['poli_id'];
        if ($posted_poli_id !== $poli_id) {
            $error = "Data poli tidak valid.";
        } else {
            $tanggal_antrian = sanitizeInput($_POST['tanggal_antrian']);

            // Validate input
            if (empty($tanggal_antrian)) {
                $error = "Tanggal harus dipilih.";
            } elseif (strtotime($tanggal_antrian) < strtotime(date('Y-m-d'))) {
                $error = "Tanggal antrian tidak boleh sebelum hari ini.";
            } elseif (checkForDangerousContent($tanggal_antrian)) {
                $error = "Input mengandung konten berbahaya.";
            } else {
                try {
                    // Check if user already has an active queue for the same poli and date
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM antrian WHERE user_id = ? AND poli_id = ? AND tanggal_antrian = ? AND status = 'menunggu'");
                    $stmt->execute([$_SESSION['user_id'], $poli_id, $tanggal_antrian]);

                    if ($stmt->fetchColumn() > 0) {
                        $error = "Anda sudah memiliki antrian aktif untuk poli dan tanggal yang sama.";
                    } else {
                        // Generate queue number
                        $nomor_antrian = generateQueueNumber($poli_id, $tanggal_antrian);

                        // Insert new queue
                        $stmt = $pdo->prepare("INSERT INTO antrian (user_id, poli_id, nomor_antrian, tanggal_antrian) VALUES (?, ?, ?, ?)");
                        $result = $stmt->execute([$_SESSION['user_id'], $poli_id, $nomor_antrian, $tanggal_antrian]);

                        if ($result) {
                            $success = "Nomor antrian berhasil diambil: $nomor_antrian";
                        } else {
                            $error = "Gagal mengambil nomor antrian.";
                        }
                    }
                } catch (PDOException $e) {
                    $error = "Terjadi kesalahan: " . $e->getMessage();
                }
            }
        }
    }

// Generate CSRF token for the form
$csrf_token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Antrian - Melo Health</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/images/melohealth.jpg">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-50">
    <?php include '../includes/navbar.php'; ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-500 to-blue-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Ambil Antrian</h1>
            <p class="text-xl">Poli: <?php echo isset($poli) && $poli ? ucfirst(str_replace('_', ' ', $poli['nama_poli'])) : 'Tidak Diketahui'; ?></p>
        </div>
    </section>

    <!-- Poli Selection Bar -->
    <section class="bg-white py-4 shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <h3 class="text-lg font-medium text-gray-800 mb-2 md:mb-0">Pilih Poli Lain:</h3>
                <div class="w-full md:w-auto">
                    <select id="poliSelection" onchange="changePoli(this.value)" class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <?php
                        // Get all poli from database
                        try {
                            $stmt = $pdo->query("SELECT * FROM poli ORDER BY id ASC");
                            $poli_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($poli_list as $p) {
                                $p_display_name = ucfirst(str_replace(['poli_', '_'], ['Poli ', ' '], $p['nama_poli']));
                                $selected = ($p['id'] == $poli_id) ? 'selected' : '';
                                echo '<option value="' . $p['id'] . '" ' . $selected . '>' . $p_display_name . '</option>';
                            }
                        } catch (PDOException $e) {
                            echo '<option value="">Gagal memuat daftar poli</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Queue Form -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-2xl">
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-3 bg-red-100 text-red-700 rounded-lg">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="mb-6 p-3 bg-green-100 text-green-700 rounded-lg">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($error) && isset($poli) && $poli): ?>
                <div class="bg-gray-50 rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Konfirmasi Ambil Antrian</h2>

                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="hidden" name="poli_id" value="<?php echo $poli_id; ?>">

                        <div class="mb-6">
                            <label for="tanggal_antrian" class="block text-gray-700 font-medium mb-2">Tanggal</label>
                            <input type="date" id="tanggal_antrian" name="tanggal_antrian" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="<?php echo isset($_POST['tanggal_antrian']) ? htmlspecialchars($_POST['tanggal_antrian']) : date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="mb-6">
                            <label for="poli_nama" class="block text-gray-700 font-medium mb-2">Poli</label>
                            <input type="text" id="poli_nama" class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" value="<?php echo isset($poli) && $poli ? ucfirst(escapeOutput($poli['nama_poli'])) : 'Tidak Diketahui'; ?>" readonly>
                        </div>

                        <div class="mb-8">
                            <p class="text-gray-600">Pastikan Anda datang sesuai tanggal yang dipilih.</p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                                Ambil Antrian
                            </button>

                            <a href="../layanan.php?poli_id=<?php echo $poli_id; ?>" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 text-center inline-block">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
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
                        <li><a href="../layanan.php" class="text-gray-400 hover:text-white transition duration-300">Layanan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="../index.php" class="text-gray-400 hover:text-white transition duration-300">Beranda</a></li>
                        <li><a href="../tentang.php" class="text-gray-400 hover:text-white transition duration-300">Tentang</a></li>
                        <li><a href="../berita.php" class="text-gray-400 hover:text-white transition duration-300">Berita</a></li>
                        <li><a href="../logout.php" class="text-gray-400 hover:text-white transition duration-300">Logout</a></li>
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

        // Set minimum date to today
        document.getElementById('tanggal_antrian').min = new Date().toISOString().split('T')[0];

        // Change poli function
        function changePoli(poliId) {
            if (poliId) {
                // Redirect to the same page with new poli_id
                window.location.href = 'ambil-antrian.php?poli_id=' + poliId;
            }
        }
    </script>
</body>
</html>