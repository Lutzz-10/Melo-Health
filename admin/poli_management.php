<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

// Handle poli operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // CSRF protection
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            die('CSRF token validation failed');
        }

        if ($_POST['action'] == 'add') {
            $nama_poli = strtolower(sanitizeInput($_POST['nama_poli']));
            $tipe_layanan = sanitizeInput($_POST['tipe_layanan']);
            $informasi_umum = sanitizeInput($_POST['informasi_umum']);

            // Validate inputs
            if (empty($nama_poli) || empty($tipe_layanan) || empty($informasi_umum)) {
                $error = "Semua field harus diisi.";
            } elseif (strlen($nama_poli) > 100) {
                $error = "Nama poli terlalu panjang.";
            } else {
                // Validation for poli name format (alphanumeric, underscore, and hyphen only)
                if (!preg_match('/^[a-z0-9_-]+$/', $nama_poli)) {
                    $error = "Nama poli hanya boleh berisi huruf kecil, angka, underscore, dan tanda hubung.";
                } else {
                    // Check if poli already exists
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM poli WHERE nama_poli = ?");
                    $stmt->execute([$nama_poli]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = "Poli dengan nama tersebut sudah ada.";
                    } else {
                        // Insert new poli
                        $stmt = $pdo->prepare("INSERT INTO poli (nama_poli, tipe_layanan, informasi_umum) VALUES (?, ?, ?)");
                        $result = $stmt->execute([$nama_poli, $tipe_layanan, $informasi_umum]);

                        if ($result) {
                            $success = "Poli berhasil ditambahkan.";
                        } else {
                            $error = "Gagal menambahkan poli.";
                        }
                    }
                }
            }
        } elseif ($_POST['action'] == 'update') {
            $poli_id = (int)$_POST['poli_id'];
            $nama_poli = strtolower(sanitizeInput($_POST['nama_poli']));
            $tipe_layanan = sanitizeInput($_POST['tipe_layanan']);
            $informasi_umum = sanitizeInput($_POST['informasi_umum']);

            // Validate inputs
            if (empty($poli_id) || empty($tipe_layanan) || empty($informasi_umum)) {
                $error = "Semua field harus diisi.";
            } else {
                // Validation for poli name format (alphanumeric, underscore, and hyphen only)
                if (!preg_match('/^[a-z0-9_-]+$/', $nama_poli)) {
                    $error = "Nama poli hanya boleh berisi huruf kecil, angka, underscore, dan tanda hubung.";
                } else {
                    // Update poli - don't update nama_poli as it's read-only in the edit form
                    $stmt = $pdo->prepare("UPDATE poli SET tipe_layanan = ?, informasi_umum = ? WHERE id = ?");
                    $result = $stmt->execute([$tipe_layanan, $informasi_umum, $poli_id]);

                    if ($result) {
                        $success = "Poli berhasil diperbarui.";
                        // Refresh the poli list after update
                        $stmt = $pdo->query("SELECT * FROM poli ORDER BY id ASC");
                        $poli_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $error = "Gagal memperbarui poli.";
                    }
                }
            }
        } elseif ($_POST['action'] == 'delete') {
            $poli_id = (int)$_POST['poli_id'];
            
            if (!empty($poli_id)) {
                // Check if there are any queues associated with this poli
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM antrian WHERE poli_id = ?");
                $stmt->execute([$poli_id]);
                $queue_count = $stmt->fetchColumn();

                if ($queue_count > 0) {
                    $error = "Tidak dapat menghapus poli karena masih memiliki antrian.";
                } else {
                    // Delete poli
                    $stmt = $pdo->prepare("DELETE FROM poli WHERE id = ?");
                    $result = $stmt->execute([$poli_id]);

                    if ($result) {
                        $success = "Poli berhasil dihapus.";
                    } else {
                        $error = "Gagal menghapus poli.";
                    }
                }
            }
        }
    }
}

// Get all poli
$stmt = $pdo->query("SELECT * FROM poli ORDER BY id ASC");
$poli_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate CSRF token for the forms
$csrf_token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Poli - Admin Panel</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/images/melohealth.jpg">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100">
    <!-- Admin Navbar -->
    <nav class="bg-white shadow-md">
        <div class="px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-green-600">Admin Panel - Melo Health</h1>
            </div>

            <div class="flex items-center">
                <div class="hidden md:block">
                    <span class="text-gray-700">Halo, <?php echo htmlspecialchars($_SESSION['admin_nama']); ?></span>
                    <a href="../logout.php" class="ml-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Logout</a>
                </div>
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 ml-4">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Admin Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-white shadow-md min-h-screen fixed top-0 right-0 md:static z-40 transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-green-600">Admin Panel</h2>
                    <button id="close-sidebar" class="md:hidden text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="konfirmasi-pengguna.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-user-check mr-3"></i>Konfirmasi Pengguna
                        </a>
                    </li>
                    <li>
                        <a href="berita/index.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>Atur Berita
                        </a>
                    </li>
                    <li>
                        <a href="antrian.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-list-ol mr-3"></i>Antrian Poli
                        </a>
                    </li>
                    <li>
                        <a href="poli_management.php" class="block px-4 py-2 text-green-600 font-medium bg-green-50 rounded-md">
                            <i class="fas fa-clinic-medical mr-3"></i>Manajemen Poli
                        </a>
                    </li>
                    <li>
                        <a href="admin_management.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-user-cog mr-3"></i>Manajemen Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sidebar Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 z-30 hidden transition-opacity duration-300 ease-in-out"></div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Poli</h1>

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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add/Edit Poli Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Poli Baru</h2>

                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            
                            <div class="mb-4">
                                <label for="nama_poli" class="block text-gray-700 font-medium mb-2">Nama Poli</label>
                                <input type="text" id="nama_poli" name="nama_poli" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: poli_mata, poli_jantung, dll" required>
                                <p class="text-sm text-gray-500 mt-1">Gunakan format snake_case (huruf kecil dengan underscore), misalnya: poli_mata, poli_jantung</p>
                            </div>

                            <div class="mb-4">
                                <label for="tipe_layanan" class="block text-gray-700 font-medium mb-2">Tipe Layanan</label>
                                <textarea id="tipe_layanan" name="tipe_layanan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Tambahkan tipe layanan, pisahkan dengan koma"></textarea>
                            </div>

                            <div class="mb-6">
                                <label for="informasi_umum" class="block text-gray-700 font-medium mb-2">Informasi Umum</label>
                                <textarea id="informasi_umum" name="informasi_umum" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Tambahkan informasi umum tentang poli ini"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                                Tambah Poli
                            </button>
                        </form>
                    </div>
                    
                    <!-- Help Section -->
                    <div class="bg-blue-50 rounded-lg shadow p-6 mt-6">
                        <h3 class="text-lg font-bold mb-3 text-gray-800">Petunjuk Penggunaan</h3>
                        <p class="text-sm text-gray-700 mb-3">Format nama poli yang diperbolehkan:</p>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li>Huruf kecil (a-z)</li>
                            <li>Angka (0-9)</li>
                            <li>Underscore (_) dan tanda hubung (-)</li>
                            <li>Maksimal 100 karakter</li>
                        </ul>
                        <p class="text-xs text-gray-500 mt-3">Contoh: poli_mata, poli_jantung, poli_anak, ugd, poli_kulit</p>
                    </div>
                </div>

                <!-- Existing Poli List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Poli</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-3 px-4 border-b text-left">ID</th>
                                        <th class="py-3 px-4 border-b text-left">Nama Poli</th>
                                        <th class="py-3 px-4 border-b text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($poli_list) > 0): ?>
                                        <?php foreach ($poli_list as $poli): ?>
                                        <tr>
                                            <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($poli['id']); ?></td>
                                            <td class="py-3 px-4 border-b"><?php echo ucfirst(str_replace('_', ' ', $poli['nama_poli'])); ?></td>
                                            <td class="py-3 px-4 border-b">
                                                <div class="flex space-x-2">
                                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus poli ini?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                        <input type="hidden" name="poli_id" value="<?php echo $poli['id']; ?>">
                                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="py-3 px-4 border-b text-center text-gray-500">Tidak ada poli tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Poli Details Section -->
                    <div class="bg-white rounded-lg shadow p-6 mt-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Detail Poli</h2>
                        
                        <?php if (count($poli_list) > 0): ?>
                            <div class="space-y-6">
                                <?php foreach ($poli_list as $poli): ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800"><?php echo ucfirst(str_replace('_', ' ', $poli['nama_poli'])); ?></h3>
                                            <p class="text-gray-600"><strong>ID:</strong> <?php echo htmlspecialchars($poli['id']); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p class="text-gray-700"><strong>Tipe Layanan:</strong></p>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($poli['tipe_layanan']); ?></p>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p class="text-gray-700"><strong>Informasi Umum:</strong></p>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($poli['informasi_umum']); ?></p>
                                    </div>
                                    <div class="flex space-x-2 mt-4">
                                        <a href="edit_poli.php?id=<?php echo $poli['id']; ?>" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center">Tidak ada poli untuk ditampilkan</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <!-- JavaScript -->
    <script src="../assets/js/script.js"></script>
    <script>
        // Mobile menu toggle for admin dashboard
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeSidebarButton = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (mobileMenuButton && sidebar && overlay) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show sidebar
                    sidebar.classList.remove('translate-x-full');
                    sidebar.classList.add('translate-x-0');

                    // Show overlay
                    overlay.classList.remove('hidden');
                    setTimeout(() => {
                        overlay.classList.remove('opacity-0');
                        overlay.classList.add('opacity-50');
                    }, 10);
                });

                function closeSidebar() {
                    // Hide sidebar
                    sidebar.classList.add('translate-x-full');
                    sidebar.classList.remove('translate-x-0');

                    // Hide overlay
                    overlay.classList.remove('opacity-50');
                    setTimeout(() => {
                        overlay.classList.add('opacity-0');
                        overlay.classList.add('hidden');
                    }, 300);
                }

                // Close sidebar when clicking on overlay
                overlay.addEventListener('click', closeSidebar);

                // Close sidebar when clicking on close button
                if (closeSidebarButton) {
                    closeSidebarButton.addEventListener('click', closeSidebar);
                }
            }
        });
    </script>
</body>
</html>