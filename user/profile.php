<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in and confirmed
if (!isLoggedIn() || !isUserConfirmed()) {
    header("Location: ../login.php");
    exit();
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: ../login.php");
    exit();
}

// Update user profile if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $nama = sanitizeInput($_POST['nama']);
    $alamat = sanitizeInput($_POST['alamat']);
    $no_hp = sanitizeInput($_POST['no_hp']);

    // Additional validation
    if (checkForDangerousContent($nama) || checkForDangerousContent($alamat)) {
        $error = "Input mengandung konten berbahaya.";
    } elseif (!isValidPhone($no_hp)) {
        $error = "Nomor HP tidak valid.";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET nama = ?, alamat = ?, no_hp = ? WHERE id = ?");
        $result = $stmt->execute([$nama, $alamat, $no_hp, $_SESSION['user_id']]);

        if ($result) {
            $_SESSION['user_nama'] = $nama;
            $success = "Profil berhasil diperbarui.";
        } else {
            $error = "Gagal memperbarui profil.";
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
    <title>Profil Saya - Melo Health</title>
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
            <h1 class="text-4xl font-bold mb-4">Profil Saya</h1>
            <p class="text-xl">Selamat datang, <?php echo htmlspecialchars($_SESSION['user_nama']); ?>!</p>
        </div>
    </section>
    
    <!-- Profile Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Info -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-lg shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Informasi Profile</h2>
                        
                        <?php if (!empty($success)): ?>
                            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error)): ?>
                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nik" class="block text-gray-700 font-medium mb-2">NIK</label>
                                    <input type="text" id="nik" class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg" value="<?php echo escapeOutput($user['nik']); ?>" readonly>
                                </div>

                                <div>
                                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                                    <input type="text" id="nama" name="nama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="<?php echo escapeOutput($user['nama']); ?>" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required><?php echo escapeOutput($user['alamat']); ?></textarea>
                                </div>

                                <div>
                                    <label for="no_hp" class="block text-gray-700 font-medium mb-2">Nomor HP</label>
                                    <input type="tel" id="no_hp" name="no_hp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="<?php echo escapeOutput($user['no_hp']); ?>" required>
                                </div>

                                <div>
                                    <label for="status_konfirmasi" class="block text-gray-700 font-medium mb-2">Status Konfirmasi</label>
                                    <input type="text" id="status_konfirmasi" class="w-full px-4 py-3 bg-green-100 border border-gray-300 rounded-lg" value="<?php echo ucfirst(escapeOutput($user['status_konfirmasi'])); ?>" readonly>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-md transition duration-300">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Active Queues -->
                    <div class="bg-gray-50 rounded-lg shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Antrian Aktif</h2>
                        
                        <?php
                        // Get active queues (status: menunggu)
                        $stmt = $pdo->prepare("
                            SELECT a.*, p.nama_poli 
                            FROM antrian a 
                            JOIN poli p ON a.poli_id = p.id 
                            WHERE a.user_id = ? AND a.status = 'menunggu'
                            ORDER BY a.tanggal_antrian DESC
                        ");
                        $stmt->execute([$_SESSION['user_id']]);
                        $active_queues = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        
                        <?php if (count($active_queues) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="py-3 px-4 border-b text-left">Nomor Antrian</th>
                                            <th class="py-3 px-4 border-b text-left">Poli</th>
                                            <th class="py-3 px-4 border-b text-left">Tanggal</th>
                                            <th class="py-3 px-4 border-b text-left">Status</th>
                                            <th class="py-3 px-4 border-b text-left">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($active_queues as $queue): ?>
                                            <tr>
                                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($queue['nomor_antrian']); ?></td>
                                                <td class="py-3 px-4 border-b"><?php echo ucfirst(str_replace('_', ' ', $queue['nama_poli'])); ?></td>
                                                <td class="py-3 px-4 border-b"><?php echo date('d-m-Y', strtotime($queue['tanggal_antrian'])); ?></td>
                                                <td class="py-3 px-4 border-b">
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs"><?php echo ucfirst(str_replace('_', ' ', $queue['status'])); ?></span>
                                                </td>
                                                <td class="py-3 px-4 border-b">
                                                    <form method="POST" action="batal-antrian.php" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                                        <input type="hidden" name="queue_id" value="<?php echo $queue['id']; ?>">
                                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                                            <i class="fas fa-trash-alt"></i> Batal
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-600">Tidak ada antrian aktif.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Queue History -->
                    <div class="bg-gray-50 rounded-lg shadow-md p-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Antrian</h2>
                        
                        <?php
                        // Get queue history (status: sudah_digunakan or sudah_kadaluarsa)
                        $stmt = $pdo->prepare("
                            SELECT a.*, p.nama_poli 
                            FROM antrian a 
                            JOIN poli p ON a.poli_id = p.id 
                            WHERE a.user_id = ? AND (a.status = 'sudah_digunakan' OR a.status = 'sudah_kadaluarsa')
                            ORDER BY a.tanggal_antrian DESC
                            LIMIT 10
                        ");
                        $stmt->execute([$_SESSION['user_id']]);
                        $queue_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        
                        <?php if (count($queue_history) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="py-3 px-4 border-b text-left">Nomor Antrian</th>
                                            <th class="py-3 px-4 border-b text-left">Poli</th>
                                            <th class="py-3 px-4 border-b text-left">Tanggal</th>
                                            <th class="py-3 px-4 border-b text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($queue_history as $queue): ?>
                                            <tr>
                                                <td class="py-3 px-4 border-b"><?php echo htmlspecialchars($queue['nomor_antrian']); ?></td>
                                                <td class="py-3 px-4 border-b"><?php echo ucfirst(str_replace('_', ' ', $queue['nama_poli'])); ?></td>
                                                <td class="py-3 px-4 border-b"><?php echo date('d-m-Y', strtotime($queue['tanggal_antrian'])); ?></td>
                                                <td class="py-3 px-4 border-b">
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs"><?php echo ucfirst(str_replace('_', ' ', $queue['status'])); ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-600">Tidak ada riwayat antrian.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div>
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 mb-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($user['nama']); ?></h3>
                                <p class="text-gray-600"><?php echo htmlspecialchars($user['nik']); ?></p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-start text-gray-600">
                                <i class="fas fa-envelope mt-1 mr-3"></i>
                                <span class="break-words"><?php echo htmlspecialchars($user['nik']); ?>@melohealth.com</span>
                            </div>

                            <div class="flex items-start text-gray-600">
                                <i class="fas fa-phone mt-1 mr-3"></i>
                                <span><?php echo htmlspecialchars($user['no_hp']); ?></span>
                            </div>

                            <div class="flex items-start text-gray-600">
                                <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                                <span class="break-words"><?php echo htmlspecialchars($user['alamat']); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold mb-3 text-gray-800">Info Akun</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex justify-between">
                                <span>Tanggal Daftar:</span>
                                <span><?php echo date('d-m-Y', strtotime($user['created_at'])); ?></span>
                            </li>
                            <li class="flex justify-between">
                                <span>Status:</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs"><?php echo ucfirst($user['status_konfirmasi']); ?></span>
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
    </script>
</body>
</html>