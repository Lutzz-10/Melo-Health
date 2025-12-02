<?php

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Update expired queues
$updatedCount = updateExpiredQueues();

// Log the result if needed
error_log("Expired queues updated: $updatedCount entries");

// Return JSON response for possible AJAX calls
header('Content-Type: application/json');
echo json_encode(['success' => true, 'updated' => $updatedCount]);
?>