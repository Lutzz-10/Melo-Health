<?php
// Debug script for user authentication
session_start();
require_once 'includes/config.php';

try {
    echo "<h3>User Authentication Debug</h3>";
    
    // Check if users table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($tableCheck->rowCount() == 0) {
        echo "❌ Users table does not exist<br>";
        exit;
    }
    
    echo "✓ Users table exists<br>";
    
    // Count total users
    $userCountStmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $userCountStmt->fetch(PDO::FETCH_ASSOC);
    echo "Total users in database: " . $userCount['count'] . "<br>";
    
    // Show sample users (first 5)
    $sampleUsersStmt = $pdo->query("SELECT id, nama, nik, status_konfirmasi FROM users LIMIT 5");
    $sampleUsers = $sampleUsersStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($sampleUsers) > 0) {
        echo "<h4>Sample Users:</h4>";
        foreach ($sampleUsers as $user) {
            echo "- ID: {$user['id']}, Nama: {$user['nama']}, NIK: {$user['nik']}, Status: {$user['status_konfirmasi']}<br>";
        }
    } else {
        echo "No users in database. You need to register a user first.<br>";
    }
    
    echo "<br><strong>Admin Login Credentials:</strong><br>";
    echo "- Username: admin<br>";
    echo "- Password: admin123<br>";
    echo "<br><strong>User Registration:</strong><br>";
    echo "Register a new user first via the registration page before attempting to login.<br>";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>