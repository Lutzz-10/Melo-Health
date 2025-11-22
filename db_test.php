<?php
// Database connection script
require_once 'includes/config.php';

try {
    echo "<h3>Database Connection Test</h3>";
    
    // Test connection
    $pdo->query("SELECT 1");
    echo "✓ Database connection successful<br>";
    
    // Check if admin table exists
    $tablesStmt = $pdo->query("SHOW TABLES LIKE 'admin'");
    if ($tablesStmt->rowCount() > 0) {
        echo "✓ Admin table exists<br>";
        
        // Count admin users
        $countStmt = $pdo->query("SELECT COUNT(*) as count FROM admin");
        $count = $countStmt->fetch(PDO::FETCH_ASSOC);
        echo "✓ Admin records count: " . $count['count'] . "<br>";
        
        // Show admin users if any exist
        $stmt = $pdo->query("SELECT id, username, nama FROM admin");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($admins) > 0) {
            echo "<h4>Existing Admin Users:</h4>";
            foreach ($admins as $admin) {
                echo "- ID: " . $admin['id'] . ", Username: " . $admin['username'] . ", Name: " . $admin['nama'] . "<br>";
            }
        } else {
            echo "No admin users found in database<br>";
        }
    } else {
        echo "✗ Admin table does not exist<br>";
    }
    
    // Check if users table exists
    $usersTableStmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($usersTableStmt->rowCount() > 0) {
        echo "✓ Users table exists<br>";
    } else {
        echo "✗ Users table does not exist<br>";
    }
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>