<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Pagination configuration
$items_per_page = 8;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure page is at least 1
$offset = ($current_page - 1) * $items_per_page;

// Get selected poli filter
$selected_poli = isset($_GET['poli']) ? $_GET['poli'] : 'all';

// Ensure $selected_poli is either 'all' or a valid integer
// Only cast to integer if it's not the 'all' keyword
if ($selected_poli !== 'all' && $selected_poli !== '') {
    $selected_poli = (int)$selected_poli;
} else {
    $selected_poli = 'all';
}

// Get search NIK parameter
$search_nik = isset($_GET['search_nik']) ? trim($_GET['search_nik']) : '';

// Query untuk menghitung total antrian berdasarkan filter dan search
if ($selected_poli === 'all') {
    if (!empty($search_nik)) {
        $count_stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.tanggal_antrian = CURDATE() AND a.status = 'menunggu' AND u.nik LIKE ?
        ");
        $search_param = '%' . $search_nik . '%';
        $count_stmt->execute([$search_param]);
    } else {
        $count_stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.tanggal_antrian = CURDATE() AND a.status = 'menunggu'
        ");
        $count_stmt->execute();
    }
} else {
    if (!empty($search_nik)) {
        $count_stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.poli_id = ? AND a.tanggal_antrian = CURDATE() AND a.status = 'menunggu' AND u.nik LIKE ?
        ");
        $search_param = '%' . $search_nik . '%';
        $count_stmt->execute([$selected_poli, $search_param]);
    } else {
        $count_stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.poli_id = ? AND a.tanggal_antrian = CURDATE() AND a.status = 'menunggu'
        ");
        $count_stmt->execute([$selected_poli]);
    }
}

$total_items = $count_stmt->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Get today's queues based on filter, search, and pagination
if ($selected_poli === 'all') {
    if (!empty($search_nik)) {
        // Search by NIK with pagination
        $stmt = $pdo->prepare("
            SELECT a.*, p.nama_poli, u.nama as user_nama, u.nik
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.tanggal_antrian = CURDATE() AND a.status = 'menunggu' AND u.nik LIKE ?
            ORDER BY a.id ASC
            LIMIT :limit OFFSET :offset
        ");
        $search_param = '%' . $search_nik . '%';
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute([$search_param]);
    } else {
        $stmt = $pdo->prepare("
            SELECT a.*, p.nama_poli, u.nama as user_nama, u.nik
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.tanggal_antrian = CURDATE() AND a.status = 'menunggu'
            ORDER BY a.id ASC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }
} else {
    if (!empty($search_nik)) {
        // Search by NIK with poli filter and pagination
        $stmt = $pdo->prepare("
            SELECT a.*, p.nama_poli, u.nama as user_nama, u.nik
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.poli_id = ? AND a.tanggal_antrian = CURDATE() AND a.status = 'menunggu' AND u.nik LIKE ?
            ORDER BY a.id ASC
            LIMIT :limit OFFSET :offset
        ");
        $search_param = '%' . $search_nik . '%';
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute([$selected_poli, $search_param]);
    } else {
        $stmt = $pdo->prepare("
            SELECT a.*, p.nama_poli, u.nama as user_nama, u.nik
            FROM antrian a
            JOIN poli p ON a.poli_id = p.id
            JOIN users u ON a.user_id = u.id
            WHERE a.poli_id = ? AND a.tanggal_antrian = CURDATE() AND a.status = 'menunggu'
            ORDER BY a.id ASC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute([$selected_poli]);
    }
}

$today_queues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get poli list for filter
$stmt = $pdo->query("SELECT id, nama_poli FROM poli");
$poli_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process queue completion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'complete') {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $queue_id = (int)$_POST['queue_id'];

    // Validate that the queue exists
    $queue_check = $pdo->prepare("SELECT a.id, a.nomor_antrian, u.nama as user_nama FROM antrian a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
    $queue_check->execute([$queue_id]);
    $queue = $queue_check->fetch(PDO::FETCH_ASSOC);

    if ($queue) {
        $stmt = $pdo->prepare("UPDATE antrian SET status = 'sudah_digunakan' WHERE id = ?");
        $result = $stmt->execute([$queue_id]);

        if ($result) {
            logSecurityEvent('queue_completed', 'Admin: ' . $_SESSION['admin_nama'] . ', Queue ID: ' . $queue_id . ', Number: ' . $queue['nomor_antrian'] . ', User: ' . $queue['user_nama']);
            $message = "Status antrian berhasil diperbarui.";
        } else {
            $error = "Gagal memperbarui status antrian.";
        }
    } else {
        $error = "Antrian tidak ditemukan.";
    }
}

// Generate CSRF token for the forms
$csrf_token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Poli - Admin Panel</title>
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
                        <a href="antrian.php" class="block px-4 py-2 text-green-600 font-medium bg-green-50 rounded-md">
                            <i class="fas fa-list-ol mr-3"></i>Antrian Poli
                        </a>
                    </li>
                    <li>
                        <a href="poli_management.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Antrian Poli</h1>

            <?php if (isset($message)): ?>
                <div class="mb-6 p-3 bg-green-100 text-green-700 rounded-lg">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="mb-6 p-3 bg-red-100 text-red-700 rounded-lg">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Filter and Search Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex flex-wrap items-center">
                    <div class="w-full md:w-auto mb-4 md:mb-0 md:mr-4">
                        <label for="poli_filter" class="block text-sm font-medium text-gray-700 mb-1">Filter Poli</label>
                        <select id="poli_filter" onchange="filterByPoli()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="all" <?php echo $selected_poli === 'all' ? ' selected' : ''; ?>>Semua Poli</option>
                            <?php foreach ($poli_list as $poli): ?>
                                <option value="<?php echo $poli['id']; ?>" <?php echo $selected_poli == $poli['id'] ? ' selected' : ''; ?>>
                                    <?php echo ucfirst(str_replace('_', ' ', $poli['nama_poli'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="w-full md:w-auto mb-4 md:mb-0 md:mr-4">
                        <label for="search_nik" class="block text-sm font-medium text-gray-700 mb-1">Cari Berdasarkan NIK</label>
                        <div class="flex">
                            <input type="text" id="search_nik" placeholder="Masukkan NIK" class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-64" value="<?php echo isset($_GET['search_nik']) ? htmlspecialchars($_GET['search_nik']) : ''; ?>">
                            <button onclick="searchByNIK()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-r-lg">Cari</button>
                        </div>
                    </div>

                    <div class="w-full md:w-auto">
                        <p class="text-gray-700">Tanggal: <strong><?php echo date('d-m-Y'); ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- Queues Table -->
            <div class="overflow-x-auto lg:overflow-visible">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Mobile card view -->
                    <div class="block md:hidden">
                        <?php if (count($today_queues) > 0): ?>
                            <?php foreach ($today_queues as $queue): ?>
                                <div class="border-b border-gray-200 p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="text-lg font-bold text-green-600"><?php echo htmlspecialchars($queue['nomor_antrian']); ?></div>
                                            <div class="font-medium"><?php echo htmlspecialchars($queue['user_nama']); ?></div>
                                            <div class="text-sm text-gray-600">NIK: <?php echo htmlspecialchars($queue['nik']); ?></div>
                                            <div class="text-sm text-gray-600">Poli: <?php echo ucfirst(str_replace('_', ' ', $queue['nama_poli'])); ?></div>
                                            <div class="text-sm text-gray-600">Tanggal: <?php echo date('d-m-Y', strtotime($queue['tanggal_antrian'])); ?></div>
                                            <div class="mt-2">
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs"><?php echo ucfirst(str_replace('_', ' ', $queue['status'])); ?></span>
                                            </div>
                                        </div>
                                        <div>
                                            <form method="POST" onsubmit="return confirm('Yakin pasien ini telah selesai dilayani?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="queue_id" value="<?php echo $queue['id']; ?>">
                                                <input type="hidden" name="action" value="complete">
                                                <button type="submit" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-check"></i> Selesai
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-8 text-center text-gray-500">
                                Tidak ada antrian untuk tanggal <?php echo date('d-m-Y'); ?> dan filter yang dipilih
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Desktop table view -->
                    <table class="hidden md:table min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Antrian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($today_queues) > 0): ?>
                                <?php foreach ($today_queues as $queue): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-green-600"><?php echo htmlspecialchars($queue['nomor_antrian']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($queue['user_nama']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($queue['nik']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo ucfirst(str_replace('_', ' ', $queue['nama_poli'])); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo date('d-m-Y', strtotime($queue['tanggal_antrian'])); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs"><?php echo ucfirst(str_replace('_', ' ', $queue['status'])); ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin pasien ini telah selesai dilayani?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="queue_id" value="<?php echo $queue['id']; ?>">
                                                <input type="hidden" name="action" value="complete">
                                                <button type="submit" class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-check"></i> Selesai
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada antrian untuk tanggal <?php echo date('d-m-Y'); ?> dan filter yang dipilih
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="mt-8">
            <nav class="flex items-center justify-between">
                <div class="flex-1 flex items-center">
                    <span class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium"><?php echo $offset + 1; ?></span>
                        hingga
                        <span class="font-medium"><?php echo min($offset + $items_per_page, $total_items); ?></span>
                        dari
                        <span class="font-medium"><?php echo $total_items; ?></span>
                        antrian
                    </span>
                </div>
                <div class="flex space-x-2">
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>&poli=<?php echo $selected_poli; ?><?php echo !empty($search_nik) ? '&search_nik=' . urlencode($search_nik) : ''; ?>"
                           class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Sebelumnya
                        </a>
                    <?php else: ?>
                        <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-md cursor-not-allowed">Sebelumnya</span>
                    <?php endif; ?>

                    <!-- Page numbers -->
                    <?php
                    $start = max(1, $current_page - 2);
                    $end = min($total_pages, $current_page + 2);
                    ?>

                    <?php if ($start > 1): ?>
                        <a href="?page=1&poli=<?php echo $selected_poli; ?><?php echo !empty($search_nik) ? '&search_nik=' . urlencode($search_nik) : ''; ?>"
                           class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            1
                        </a>
                        <?php if ($start > 2): ?>
                            <span class="px-3 py-2 text-gray-500">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span class="px-3 py-2 bg-green-600 text-white rounded-md"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>&poli=<?php echo $selected_poli; ?><?php echo !empty($search_nik) ? '&search_nik=' . urlencode($search_nik) : ''; ?>"
                               class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($end < $total_pages): ?>
                        <?php if ($end < $total_pages - 1): ?>
                            <span class="px-3 py-2 text-gray-500">...</span>
                        <?php endif; ?>
                        <a href="?page=<?php echo $total_pages; ?>&poli=<?php echo $selected_poli; ?><?php echo !empty($search_nik) ? '&search_nik=' . urlencode($search_nik) : ''; ?>"
                           class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            <?php echo $total_pages; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>&poli=<?php echo $selected_poli; ?><?php echo !empty($search_nik) ? '&search_nik=' . urlencode($search_nik) : ''; ?>"
                           class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Berikutnya
                        </a>
                    <?php else: ?>
                        <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-md cursor-not-allowed">Berikutnya</span>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        <?php endif; ?>
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

        // Function to search by NIK
        function searchByNIK() {
            const searchNik = document.getElementById('search_nik').value;
            const poliFilter = document.getElementById('poli_filter').value;

            // Parse the current URL to maintain other parameters
            const url = new URL(window.location.href);

            // Update search parameter
            if (searchNik) {
                url.searchParams.set('search_nik', searchNik);
            } else {
                url.searchParams.delete('search_nik');
            }

            // If we're not on the 'all' poli view, preserve the poli filter
            if (!poliFilter.includes('poli=all')) {
                // Extract poli parameter from the dropdown value
                const params = new URLSearchParams(poliFilter.split('?')[1]);
                const selectedPoli = params.get('poli');
                if (selectedPoli) {
                    url.searchParams.set('poli', selectedPoli);
                }
            } else {
                url.searchParams.set('poli', 'all');
            }

            // Redirect to the new URL
            window.location.href = url.toString();
        }

        // Function to filter by poli while maintaining search parameters
        function filterByPoli() {
            const selectedPoli = document.getElementById('poli_filter').value;
            const searchNik = document.getElementById('search_nik').value;

            // Build URL with both poli and search parameters
            let url = '?poli=';

            // If 'all' option is selected (value is 'all'), use 'all', otherwise use the poli ID
            if (selectedPoli === 'all' || selectedPoli === '') {
                url += 'all';
            } else {
                url += selectedPoli;
            }

            if (searchNik) {
                url += '&search_nik=' + encodeURIComponent(searchNik);
            }

            window.location.href = url;
        }

        // Allow searching by pressing Enter in the NIK input field
        document.getElementById('search_nik').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchByNIK();
            }
        });
    </script>
</body>

</html>