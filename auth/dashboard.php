<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/config.php';
require_once SERVER_PATH . '/dashboard.php';
require_once VIEWS_PATH . '/dashboard.php';
?>