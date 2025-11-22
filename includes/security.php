<?php
// Security helper functions for Melo Health

// Function to generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to validate CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to prevent SQL injection using prepared statements
function prepareStatement($sql) {
    global $pdo;
    return $pdo->prepare($sql);
}

// Function to sanitize user input
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to prevent XSS by escaping output
function escapeOutput($output) {
    return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
}

// Function to implement session security
function secureSession() {
    // Regenerate session ID periodically
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } else if (time() - $_SESSION['created'] > 1800) {
        // Session started more than 30 minutes ago
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

// Function to implement rate limiting (basic implementation)
function checkRateLimit($action, $maxRequests = 10, $timeWindow = 3600) {
    $key = 'rate_limit_' . $action . '_' . $_SERVER['REMOTE_ADDR'];

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 1, 'time' => time()];
        return true;
    }

    $data = $_SESSION[$key];

    if (time() - $data['time'] > $timeWindow) {
        // Reset after time window
        $_SESSION[$key] = ['count' => 1, 'time' => time()];
        return true;
    }

    if ($data['count'] >= $maxRequests) {
        return false; // Rate limit exceeded
    }

    $_SESSION[$key]['count']++;
    return true;
}

// Function to validate file uploads
function validateFileUpload($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'], $maxSize = 2097152) { // 2MB default
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    // Additional check with getimagesize for images
    if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $imageInfo = getimagesize($file['tmp_name']);
        if (!$imageInfo) {
            return false; // Not a valid image
        }
    }

    return true;
}

// Function to implement input length validation
function validateInputLength($input, $minLength = 1, $maxLength = 255) {
    $length = strlen($input);
    return ($length >= $minLength && $length <= $maxLength);
}

// Function to check for potentially dangerous content in inputs
function checkForDangerousContent($input) {
    $dangerousPatterns = [
        '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
        '/javascript:/i',
        '/vbscript:/i',
        '/on\w+\s*=/i',
        '/<iframe/i',
        '/<object/i',
        '/<embed/i',
        '/<form/i',
        '/<input/i'
    ];

    foreach ($dangerousPatterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return true; // Dangerous content found
        }
    }

    return false; // No dangerous content found
}

// Function to log security events
function logSecurityEvent($event, $details = '') {
    $logMessage = date('Y-m-d H:i:s') . " - Security Event: $event - IP: " . $_SERVER['REMOTE_ADDR'] . " - Details: $details\n";
    error_log($logMessage, 3, 'security.log');
}
?>