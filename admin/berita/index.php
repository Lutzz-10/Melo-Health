<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

// Get all news
$stmt = $pdo->query("SELECT * FROM berita ORDER BY tanggal_publish DESC");
$berita = $stmt->fetchAll(PDO::FETCH_ASSOC);

// For security logging
$action = $_GET['action'] ?? '';
if ($action === 'hapus' && isset($_GET['id'])) {
    $newsId = (int)$_GET['id'];
    logSecurityEvent('news_delete_attempt', 'Admin: ' . $_SESSION['admin_nama'] . ', News ID: ' . $newsId);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Berita - Admin Panel</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/images/melohealth.jpg">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
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
                    <a href="../../logout.php" class="ml-4 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Logout</a>
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
                        <a href="../dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="../konfirmasi-pengguna.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-user-check mr-3"></i>Konfirmasi Pengguna
                        </a>
                    </li>
                    <li>
                        <a href="index.php" class="block px-4 py-2 text-green-600 font-medium bg-green-50 rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>Atur Berita
                        </a>
                    </li>
                    <li>
                        <a href="../antrian.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-list-ol mr-3"></i>Antrian Poli
                        </a>
                    </li>
                    <li>
                        <a href="../poli_management.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-clinic-medical mr-3"></i>Manajemen Poli
                        </a>
                    </li>
                    <li>
                        <a href="../admin_management.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Atur Berita</h1>
                <a href="tambah.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Tambah Berita Baru
                </a>
            </div>

            <div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Mobile card view -->
                    <div class="block md:hidden">
                        <?php if (count($berita) > 0): ?>
                            <?php foreach ($berita as $b): ?>
                                <div class="border-b border-gray-200 p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium"><?php echo htmlspecialchars($b['judul']); ?></div>
                                            <div class="text-sm text-gray-600">Tanggal: <?php echo date('d-m-Y', strtotime($b['tanggal_publish'])); ?></div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="edit.php?id=<?php echo $b['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?php echo $b['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus berita ini?');">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-8 text-center text-gray-500">
                                Tidak ada berita ditemukan
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Desktop table view -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Publish</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($berita as $b): ?>
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($b['judul']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo date('d-m-Y', strtotime($b['tanggal_publish'])); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="edit.php?id=<?php echo $b['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="hapus.php?id=<?php echo $b['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus berita ini?');">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../../assets/js/script.js"></script>
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