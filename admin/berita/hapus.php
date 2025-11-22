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

// Delete the news
$stmt = $pdo->prepare("DELETE FROM berita WHERE id = ?");
$result = $stmt->execute([$news_id]);

if ($result) {
    // Delete image if it exists
    if ($berita['gambar'] && file_exists('../../' . $berita['gambar'])) {
        unlink('../../' . $berita['gambar']);
    }
    
    $_SESSION['message'] = "Berita berhasil dihapus.";
} else {
    $_SESSION['error'] = "Gagal menghapus berita.";
}

header("Location: index.php");
exit();
?>