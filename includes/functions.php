<?php
// Include database configuration
require_once 'config.php';

// Include security functions
require_once 'security.php';

// Function to hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Function to check if user is logged in
function isLoggedIn() {
    secureSession(); // Ensure session security
    return isset($_SESSION['user_id']);
}

// Function to check if user is confirmed
function isUserConfirmed() {
    return isset($_SESSION['user_confirmed']) && $_SESSION['user_confirmed'] == 'confirmed';
}

// Function to check if admin is logged in
function isAdminLoggedIn() {
    secureSession(); // Ensure session security
    return isset($_SESSION['admin_id']);
}

// Function to generate queue number
function generateQueueNumber($poliId, $date) {
    global $pdo;

    // Format date for query
    $formattedDate = date('Y-m-d', strtotime($date));

    // Get the highest queue number for this poli and date
    $stmt = $pdo->prepare("SELECT MAX(nomor_antrian) as max_number FROM antrian WHERE poli_id = ? AND tanggal_antrian = ?");
    $stmt->execute([$poliId, $formattedDate]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $lastNumber = $result['max_number'];

    if ($lastNumber) {
        // Extract the numeric part and increment it
        $number = intval(substr($lastNumber, 1)) + 1;
        $newNumber = 'A' . str_pad($number, 3, '0', STR_PAD_LEFT);
    } else {
        // If no records found for this poli and date, start from 001
        $newNumber = 'A' . str_pad(1, 3, '0', STR_PAD_LEFT);
    }

    return $newNumber;
}

// Function to get poli name by ID
function getPoliName($poliId) {
    global $pdo;

    $poliNames = [
        1 => 'poli_gigi',
        2 => 'poli_gizi',
        3 => 'poli_umum',
        4 => 'ugd'
    ];

    return isset($poliNames[$poliId]) ? $poliNames[$poliId] : 'Unknown';
}

// Function to check if NIK exists in users table
function isNikExists($nik) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE nik = ?");
    $stmt->execute([$nik]);

    return $stmt->fetchColumn() > 0;
}

// Function to get user details by NIK
function getUserByNik($nik) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE nik = ?");
    $stmt->execute([$nik]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to redirect user based on login status
function redirectBasedOnLogin() {
    // Only redirect if the user is on a page they shouldn't be on when logged in
    $current_page = basename($_SERVER['PHP_SELF']);

    if (isLoggedIn()) {
        if ($current_page === 'login.php' || $current_page === 'register.php') {
            if (isUserConfirmed()) {
                header("Location: index.php");
                exit();
            } else {
                // If user is not confirmed, show a message
                return "Akun Anda belum dikonfirmasi. Silakan datang ke Puskesmas untuk konfirmasi.";
            }
        }
    }
    return false;
}

// Function to validate NIK (16 digits)
function isValidNik($nik) {
    return preg_match('/^[0-9]{16}$/', $nik);
}

// Function to validate phone number
function isValidPhone($phone) {
    return preg_match('/^[\+]?[0-9]{10,15}$/', $phone);
}

// Function to update expired queues (cron job function)
function updateExpiredQueues() {
    global $pdo;

    $stmt = $pdo->prepare("UPDATE antrian SET status = 'sudah_kadaluarsa' WHERE status = 'menunggu' AND tanggal_antrian < CURDATE()");
    $stmt->execute();

    return $stmt->rowCount(); // Return number of updated records
}

// Function to validate and sanitize image upload
function validateAndSanitizeImage($file, $maxSize = 2097152) { // 2MB default
    // Validate the file
    if (!validateFileUpload($file, ['jpg', 'jpeg', 'png', 'gif'], $maxSize)) {
        return false;
    }

    // Sanitize the filename
    $fileName = basename($file['name']);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $newFileName = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $fileExtension;

    return $newFileName;
}

// Function to prevent brute force attacks
function checkLoginAttempts($username) {
    $key = 'login_attempts_' . $username;
    $maxAttempts = 5;
    $lockoutTime = 900; // 15 minutes

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'time' => time()];
    }

    $data = $_SESSION[$key];

    // Check if lockout period has passed
    if (time() - $data['time'] > $lockoutTime) {
        $_SESSION[$key] = ['count' => 0, 'time' => time()];
        return true;
    }

    // Check if max attempts reached
    if ($data['count'] >= $maxAttempts) {
        return false; // Account locked
    }

    return true; // Login allowed
}

// Function to record failed login attempt
function recordFailedLoginAttempt($username) {
    $key = 'login_attempts_' . $username;

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 1, 'time' => time()];
    } else {
        $_SESSION[$key]['count']++;
    }
}

// Function to reset login attempts
function resetLoginAttempts($username) {
    $key = 'login_attempts_' . $username;
    unset($_SESSION[$key]);
}

// Function to implement CSRF protection
function checkCSRFToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
            die('CSRF token validation failed');
        }
    }
}
?>