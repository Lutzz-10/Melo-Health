<?php
// Script to directly insert admin user with known password hash
require_once 'includes/config.php';

// Define admin credentials
$username = 'admin';
$password = 'admin123';  // Plain text password
$nama = 'System Administrator';

// Hash the password using PHP's password_hash function
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    echo "<h3>Creating Admin User</h3>";
    
    // Check if admin user already exists
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $existingAdmin = $stmt->fetch();
    
    if ($existingAdmin) {
        echo "Admin user with username '$username' already exists!<br>";
        echo "Username: $username<br>";
        echo "Password: $password<br>";
        echo "No new admin created.<br>";
    } else {
        // Insert new admin user with proper hashed password
        $insertStmt = $pdo->prepare("INSERT INTO admin (username, password, nama) VALUES (?, ?, ?)");
        $result = $insertStmt->execute([$username, $hashedPassword, $nama]);
        
        if ($result) {
            echo "✅ Admin user created successfully!<br>";
            echo "Username: $username<br>";
            echo "Password: $password<br>";
            echo "Note: Password is securely hashed in the database.<br>";
        } else {
            echo "❌ Failed to create admin user.<br>";
        }
    }
    
    // Show all admin users after attempt
    echo "<hr><h4>All Admin Users in Database:</h4>";
    $allStmt = $pdo->query("SELECT id, username, nama FROM admin");
    $admins = $allStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($admins) > 0) {
        foreach ($admins as $admin) {
            echo "- ID: " . $admin['id'] . ", Username: " . $admin['username'] . ", Name: " . $admin['nama'] . "<br>";
        }
    } else {
        echo "No admin users found in database.<br>";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>