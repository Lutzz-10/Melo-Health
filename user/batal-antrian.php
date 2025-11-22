<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in and confirmed
if (!isLoggedIn() || !isUserConfirmed()) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['queue_id'])) {
    $queue_id = (int)$_POST['queue_id'];
    $user_id = $_SESSION['user_id'];
    
    try {
        // Check if the queue belongs to this user and is still active
        $stmt = $pdo->prepare("SELECT * FROM antrian WHERE id = ? AND user_id = ? AND status = 'menunggu'");
        $stmt->execute([$queue_id, $user_id]);
        $queue = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($queue) {
            // Update the queue status to 'sudah_digunakan' to mark it as cancelled
            $stmt = $pdo->prepare("UPDATE antrian SET status = 'sudah_digunakan' WHERE id = ?");
            $result = $stmt->execute([$queue_id]);
            
            if ($result) {
                $_SESSION['message'] = "Antrian berhasil dibatalkan.";
            } else {
                $_SESSION['error'] = "Gagal membatalkan antrian.";
            }
        } else {
            $_SESSION['error'] = "Antrian tidak ditemukan atau sudah tidak aktif.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Redirect back to profile
header("Location: profile.php");
exit();
?>