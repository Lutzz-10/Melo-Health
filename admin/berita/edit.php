<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/functions.php';

// Check if admin is logged in
if (!isAdminLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$news_id = (int)$_GET['id'];
if (!$news_id) {
    header("Location: index.php");
    exit();
}

// Get news details
$stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
$stmt->execute([$news_id]);
$berita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$berita) {
    header("Location: index.php");
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
            $gambar = $berita['gambar']; // Keep existing image by default

            // Handle image upload if provided
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

                            // Delete old image if it exists
                            if ($berita['gambar'] && file_exists('../../' . $berita['gambar'])) {
                                unlink('../../' . $berita['gambar']);
                            }
                        } else {
                            $error = "Gagal mengunggah gambar.";
                        }
                    } else {
                        $error = "Gagal memproses file gambar.";
                    }
                }
            }

            // Update news if no error
            if (empty($error)) {
                $stmt = $pdo->prepare("UPDATE berita SET judul = ?, konten = ?, gambar = ?, tanggal_publish = ? WHERE id = ?");
                $result = $stmt->execute([$judul, $konten, $gambar, $tanggal_publish, $news_id]);

                if ($result) {
                    logSecurityEvent('news_updated', 'Admin: ' . $_SESSION['admin_nama'] . ', News ID: ' . $news_id . ', Title: ' . $judul);
                    $success = "Berita berhasil diperbarui.";
                    // Refresh the data
                    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
                    $stmt->execute([$news_id]);
                    $berita = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $error = "Gagal memperbarui berita.";
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
    <title>Edit Berita - Admin Panel</title>
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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Berita</h1>
            
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
                        <input type="text" id="judul" name="judul" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan judul berita" value="<?php echo escapeOutput($berita['judul']); ?>" required>
                    </div>

                    <div class="mb-6">
                        <label for="tanggal_publish" class="block text-gray-700 font-medium mb-2">Tanggal Publish</label>
                        <input type="date" id="tanggal_publish" name="tanggal_publish" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="<?php echo $berita['tanggal_publish']; ?>" required>
                    </div>

                    <div class="mb-6">
                        <label for="gambar" class="block text-gray-700 font-medium mb-2">Gambar Utama (Opsional)</label>
                        <?php if ($berita['gambar']): ?>
                            <div class="mb-3">
                                <img src="../../<?php echo escapeOutput($berita['gambar']); ?>" alt="Gambar Berita" class="w-32 h-24 object-cover rounded">
                            </div>
                        <?php endif; ?>
                        <input type="file" id="gambar" name="gambar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" accept="image/*">
                        <p class="text-gray-500 text-sm mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                    </div>

                    <div class="mb-6">
                        <label for="konten" class="block text-gray-700 font-medium mb-2">Konten Berita</label>
                        <textarea id="konten" name="konten" rows="10" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Tulis konten berita di sini..." required><?php echo escapeOutput($berita['konten']); ?></textarea>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                            Simpan Perubahan
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