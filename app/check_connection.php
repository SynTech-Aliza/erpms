<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($connection) {
    echo json_encode(['connected' => true]);
} else {
    echo json_encode(['connected' => false]);
}
?>