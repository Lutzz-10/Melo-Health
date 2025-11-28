<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $judul = sanitizeInput($_POST['judul']);
    $konten = $_POST['konten'];
    $tanggal_publish = sanitizeInput($_POST['tanggal_publish']);

    // Validate input
    if (empty($judul) || empty($konten) || empty($tanggal_publish)) {
        $error = "Semua field harus diisi.";
    } elseif (checkForDangerousContent($judul) || checkForDangerousContent($konten)) {
        $error = "Input mengandung konten berbahaya.";
    } elseif (strtotime($tanggal_publish) < strtotime('-1 year') || strtotime($tanggal_publish) > strtotime('+1 year')) {
        $error = "Tanggal publish tidak valid (harus dalam rentang 1 tahun dari sekarang).";
    } else {
        try {
            // Handle image upload
            $gambar = '';
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                // Validate file
                if (!validateFileUpload($_FILES['gambar'])) {
                    $error = "File upload tidak valid.";
                } else {
                    // Sanitize and generate new filename
                    $newFileName = validateAndSanitizeImage($_FILES['gambar']);
                    if ($newFileName) {
                        $target_dir = "../../assets/images/";
                        $target_file = $target_dir . $newFileName;

                        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                            $gambar = str_replace('../../', '', $target_file);
                        } else {
                            $error = "Gagal mengunggah gambar.";
                        }
                    } else {
                        $error = "Gagal memproses file gambar.";
                    }
                }
            }

            // Insert news if no error
            if (empty($error)) {
                $stmt = $pdo->prepare("INSERT INTO berita (judul, konten, gambar, tanggal_publish) VALUES (?, ?, ?, ?)");
                $result = $stmt->execute([$judul, $konten, $gambar, $tanggal_publish]);

                if ($result) {
                    logSecurityEvent('news_created', 'Admin: ' . $_SESSION['admin_nama'] . ', Title: ' . $judul);
                    $success = "Berita berhasil ditambahkan.";
                    // Clear form data
                    $judul = '';
                    $konten = '';
                    $tanggal_publish = '';
                } else {
                    $error = "Gagal menambahkan berita.";
                }
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
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
    <title>Tambah Berita - Admin Panel</title>
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
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Halo, <?php echo htmlspecialchars($_SESSION['admin_nama']); ?></span>
                <a href="../../logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition duration-300">Logout</a>
            </div>
        </div>
    </nav>
    
    <!-- Admin Sidebar -->
    <div class="flex">
        <div class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-4">
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
                        <a href="index.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>Atur Berita
                        </a>
                    </li>
                    <li>
                        <a href="../antrian.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-list-ol mr-3"></i>Antrian Poli
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Berita Baru</h1>
            
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
            
            <div class="bg-white rounded-lg shadow p-8">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <div class="mb-6">
                        <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Berita</label>
                        <input type="text" id="judul" name="judul" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan judul berita" value="<?php echo isset($_POST['judul']) ? escapeOutput($_POST['judul']) : ''; ?>" required>
                    </div>

                    <div class="mb-6">
                        <label for="tanggal_publish" class="block text-gray-700 font-medium mb-2">Tanggal Publish</label>
                        <input type="date" id="tanggal_publish" name="tanggal_publish" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="<?php echo isset($_POST['tanggal_publish']) ? escapeOutput($_POST['tanggal_publish']) : date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-6">
                        <label for="gambar" class="block text-gray-700 font-medium mb-2">Gambar Utama (Opsional)</label>
                        <input type="file" id="gambar" name="gambar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" accept="image/*">
                    </div>

                    <div class="mb-6">
                        <label for="konten" class="block text-gray-700 font-medium mb-2">Konten Berita</label>
                        <textarea id="konten" name="konten" rows="10" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Tulis konten berita di sini..." required><?php echo isset($_POST['konten']) ? escapeOutput($_POST['konten']) : ''; ?></textarea>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                            Simpan Berita
                        </button>

                        <a href="index.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 inline-block">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="../../assets/js/script.js"></script>
</body>
</html>