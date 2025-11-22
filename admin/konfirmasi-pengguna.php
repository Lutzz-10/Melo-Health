<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Process confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $user_id = (int)$_POST['user_id'];

    // Validate user exists before processing
    $user_check = $pdo->prepare("SELECT id, nama, nik FROM users WHERE id = ?");
    $user_check->execute([$user_id]);
    $user = $user_check->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_POST['action'] == 'confirm') {
            $stmt = $pdo->prepare("UPDATE users SET status_konfirmasi = 'confirmed' WHERE id = ?");
            $stmt->execute([$user_id]);
            $message = "Pengguna berhasil dikonfirmasi.";
            logSecurityEvent('user_confirmed', 'Admin: ' . $_SESSION['admin_nama'] . ', User ID: ' . $user_id . ', NIK: ' . $user['nik']);
        } elseif ($_POST['action'] == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $message = "Pengguna berhasil dihapus.";
            logSecurityEvent('user_deleted', 'Admin: ' . $_SESSION['admin_nama'] . ', User ID: ' . $user_id . ', NIK: ' . $user['nik']);
        }
    } else {
        $error = "Pengguna tidak ditemukan.";
    }
}

// Generate CSRF token for the forms
$csrf_token = generateCSRFToken();

// Get pending users
$stmt = $pdo->query("SELECT * FROM users WHERE status_konfirmasi = 'pending' ORDER BY created_at DESC");
$pending_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengguna - Admin Panel</title>
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
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Halo, <?php echo htmlspecialchars($_SESSION['admin_nama']); ?></span>
                <a href="../logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Logout</a>
            </div>
        </div>
    </nav>
    
    <!-- Admin Sidebar -->
    <div class="flex">
        <div class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="konfirmasi-pengguna.php" class="block px-4 py-2 text-green-600 font-medium bg-green-50 rounded-md">
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
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Konfirmasi Pengguna</h1>
            
            <?php if (isset($message)): ?>
                <div class="mb-6 p-3 bg-green-100 text-green-700 rounded-lg">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (count($pending_users) > 0): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($pending_users as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($user['nama']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($user['nik']); ?></td>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($user['alamat']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($user['no_hp']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo date('d-m-Y H:i', strtotime($user['created_at'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin mengkonfirmasi pengguna ini?');">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <input type="hidden" name="action" value="confirm">
                                            <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                <i class="fas fa-check"></i> Konfirmasi
                                            </button>
                                        </form>

                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak Ada Pengguna Menunggu Konfirmasi</h3>
                    <p class="text-gray-500">Semua pengguna yang mendaftar telah dikonfirmasi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../assets/js/script.js"></script>
</body>
</html>