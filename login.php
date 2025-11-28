<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    if (isUserConfirmed()) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Akun Anda belum dikonfirmasi. Silakan datang ke Puskesmas untuk konfirmasi.";
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check login attempts to prevent brute force
    $nik = sanitizeInput($_POST['nik']);

    if (!checkLoginAttempts($nik)) {
        $error = "Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.";
    } else {
        $nik = sanitizeInput($_POST['nik']);
        $password = $_POST['password'];

        if (empty($nik) || empty($password)) {
            $error = "NIK dan kata sandi harus diisi.";
            recordFailedLoginAttempt($nik);
        } else {
            // Check if user exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE nik = ?");
            $stmt->execute([$nik]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && verifyPassword($password, $user['password'])) {
                if ($user['status_konfirmasi'] == 'confirmed') {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_nik'] = $user['nik'];
                    $_SESSION['user_nama'] = $user['nama'];
                    $_SESSION['user_confirmed'] = $user['status_konfirmasi'];

                    // Reset login attempts
                    resetLoginAttempts($nik);

                    // Redirect to homepage
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Akun Anda belum dikonfirmasi. Silakan datang ke Puskesmas untuk konfirmasi.";
                    recordFailedLoginAttempt($nik);
                }
            } else {
                $error = "NIK atau kata sandi salah.";
                recordFailedLoginAttempt($nik);
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
    <title>Login - Melo Health</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/melohealth.jpg">
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

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun Anda</h2>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="mb-4 p-3 bg-yellow-100 text-yellow-700 rounded-lg">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="nik" class="block text-gray-700 font-medium mb-2">NIK</label>
                <input type="text" id="nik" name="nik" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan NIK Anda" required value="<?php echo isset($_POST['nik']) ? htmlspecialchars($_POST['nik']) : ''; ?>">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan kata sandi Anda" required>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 hover:scale-105 text-white font-bold py-3 px-4 rounded-lg transition-all duration-500 ease-in-out">
                    Masuk
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-gray-600">
                Belum punya akun?
                <a href="register.php" class="text-green-600 font-medium hover:underline">Daftar di sini</a>
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