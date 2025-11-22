<?php
// Script to create admin user with proper password hash
session_start();

require_once 'includes/config.php';

// Define admin credentials
$username = 'admin';
$password = 'admin123';  // Plain text password
$nama = 'Admin Puskesmas';

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if admin user already exists
$stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->execute([$username]);
$existingAdmin = $stmt->fetch();

if ($existingAdmin) {
    echo "Admin user already exists.\n";
    echo "Username: $username\n";
    echo "Password: $password\n";
} else {
    // Insert new admin user
    $stmt = $pdo->prepare("INSERT INTO admin (username, password, nama) VALUES (?, ?, ?)");
    $result = $stmt->execute([$username, $hashedPassword, $nama]);
    
    if ($result) {
        echo "Admin user created successfully!\n";
        echo "Username: $username\n";
        echo "Password: $password\n";
    } else {
        echo "Failed to create admin user.\n";
    }
}
?>