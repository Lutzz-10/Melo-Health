<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Redirect if already logged in as admin
if (isAdminLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);

    if (!checkLoginAttempts($username)) {
        $error = "Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.";
    } else {
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $error = "Username dan password harus diisi.";
            recordFailedLoginAttempt($username);
        } else {
            try {
                // Check if admin exists
                $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin && password_verify($password, $admin['password'])) {
                    // Set session variables
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_nama'] = $admin['nama'];

                    // Reset login attempts
                    resetLoginAttempts($username);

                    // Redirect to dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Username atau password salah.";
                    recordFailedLoginAttempt($username);
                }
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan: " . $e->getMessage();
                recordFailedLoginAttempt($username);
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
    <title>Login Admin - Melo Health</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-600">Melo Health</h1>
            <p class="text-gray-600 mt-2">Sistem Informasi dan Antrian Puskesmas</p>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login Admin</h2>
        
        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan username Anda" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan password Anda" required>
            </div>
            
            <div class="mb-6">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                    Login
                </button>
            </div>
        </form>
        
        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <a href="../index.php" class="text-gray-600 hover:text-green-600 font-medium flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>