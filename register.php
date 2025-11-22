<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: user/profile.php");
    exit();
}

// Rate limiting for registration
if (!checkRateLimit('register', 5, 3600)) { // Max 5 registrations per hour
    $error = "Terlalu banyak permintaan registrasi. Silakan coba lagi nanti.";
} else {
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = sanitizeInput($_POST['nama']);
        $nik = sanitizeInput($_POST['nik']);
        $alamat = sanitizeInput($_POST['alamat']);
        $no_hp = sanitizeInput($_POST['no_hp']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        if (empty($nama) || empty($nik) || empty($alamat) || empty($no_hp) || empty($password) || empty($confirm_password)) {
            $error = "Semua field harus diisi.";
        } elseif (checkForDangerousContent($nama) || checkForDangerousContent($alamat)) {
            $error = "Input mengandung konten berbahaya.";
        } elseif (!isValidNik($nik)) {
            $error = "NIK harus terdiri dari 16 digit angka.";
        } elseif (isNikExists($nik)) {
            $error = "NIK sudah terdaftar. Gunakan NIK lain.";
        } elseif (!isValidPhone($no_hp)) {
            $error = "Nomor HP tidak valid.";
        } elseif ($password !== $confirm_password) {
            $error = "Kata sandi tidak cocok.";
        } elseif (strlen($password) < 6) {
            $error = "Kata sandi minimal 6 karakter.";
        } else {
            try {
                // Hash password
                $hashed_password = hashPassword($password);

                // Insert user into database
                $stmt = $pdo->prepare("INSERT INTO users (nama, nik, alamat, no_hp, password) VALUES (?, ?, ?, ?, ?)");
                $result = $stmt->execute([$nama, $nik, $alamat, $no_hp, $hashed_password]);

                if ($result) {
                    $success = "Registrasi berhasil! Silakan datang ke Puskesmas untuk konfirmasi akun.";
                } else {
                    $error = "Registrasi gagal. Silakan coba lagi.";
                }
            } catch (PDOException $e) {
                $error = "Registrasi gagal: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Melo Health</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-600">Melo Health</h1>
            <p class="text-gray-600 mt-2">Sistem Informasi dan Antrian Puskesmas</p>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Akun Baru</h2>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan nama lengkap Anda" required value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
            </div>

            <div class="mb-4">
                <label for="nik" class="block text-gray-700 font-medium mb-2">NIK (16 digit)</label>
                <input type="text" id="nik" name="nik" maxlength="16" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan NIK Anda" required value="<?php echo isset($_POST['nik']) ? htmlspecialchars($_POST['nik']) : ''; ?>">
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan alamat Anda" required><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
            </div>

            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 font-medium mb-2">Nomor HP</label>
                <input type="tel" id="no_hp" name="no_hp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan nomor HP Anda" required value="<?php echo isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan kata sandi Anda" required>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Ulangi kata sandi Anda" required>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Daftar
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-600 mb-4">
            Setelah mendaftar, silakan datang ke Puskesmas untuk konfirmasi akun.
        </div>

        <div class="text-center">
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="login.php" class="text-green-600 font-medium hover:underline">Masuk di sini</a>
            </p>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <a href="index.php" class="text-gray-600 hover:text-green-600 font-medium flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>