<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $pdo->query("SELECT COUNT(*) as pending FROM users WHERE status_konfirmasi = 'pending'");
$pending_users = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];

$stmt = $pdo->query("SELECT COUNT(*) as total_berita FROM berita");
$total_berita = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get today's queues by poli
$today = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT p.nama_poli, COUNT(a.id) as jumlah_antrian 
    FROM antrian a 
    JOIN poli p ON a.poli_id = p.id 
    WHERE a.tanggal_antrian = ? AND a.status = 'menunggu'
    GROUP BY p.id, p.nama_poli
");
$stmt->execute([$today]);
$today_queues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize counts for all poli
$poli_counts = [
    'poli_gigi' => 0,
    'poli_gizi' => 0,
    'poli_umum' => 0,
    'ugd' => 0
];

foreach ($today_queues as $queue) {
    $poli_counts[$queue['nama_poli']] = $queue['jumlah_antrian'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Melo Health</title>
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
                        <a href="dashboard.php" class="block px-4 py-2 text-green-600 font-medium bg-green-50 rounded-md">
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
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Admin</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Pengguna</p>
                            <p class="text-2xl font-bold"><?php echo $total_users; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full mr-4">
                            <i class="fas fa-user-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Belum Dikonfirmasi</p>
                            <p class="text-2xl font-bold"><?php echo $pending_users; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Berita</p>
                            <p class="text-2xl font-bold"><?php echo $total_berita; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <i class="fas fa-list-ol text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Antrian Hari Ini</p>
                            <p class="text-2xl font-bold">
                                <?php 
                                $total_today = array_sum($poli_counts);
                                echo $total_today; 
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Antrian Hari Ini by Poli -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Antrian Hari Ini per Poli</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="font-medium">Poli Gigi</p>
                        <p class="text-2xl font-bold text-green-600"><?php echo $poli_counts['poli_gigi']; ?></p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="font-medium">Poli Gizi</p>
                        <p class="text-2xl font-bold text-blue-600"><?php echo $poli_counts['poli_gizi']; ?></p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="font-medium">Poli Umum</p>
                        <p class="text-2xl font-bold text-yellow-600"><?php echo $poli_counts['poli_umum']; ?></p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="font-medium">UGD</p>
                        <p class="text-2xl font-bold text-red-600"><?php echo $poli_counts['ugd']; ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h2>
                <ul class="space-y-3">
                    <li class="flex items-center border-b pb-3">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <i class="fas fa-user-plus text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Pengguna baru mendaftar</p>
                            <p class="text-sm text-gray-500">5 menit yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-center border-b pb-3">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <i class="fas fa-newspaper text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Berita baru diterbitkan</p>
                            <p class="text-sm text-gray-500">1 jam yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-center border-b pb-3">
                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                            <i class="fas fa-list-ol text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Antrian baru diambil</p>
                            <p class="text-sm text-gray-500">2 jam yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-center">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                            <i class="fas fa-user-check text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Pengguna dikonfirmasi</p>
                            <p class="text-sm text-gray-500">3 jam yang lalu</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../assets/js/script.js"></script>
</body>
</html>