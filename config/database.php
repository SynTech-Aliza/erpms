<?php
$host_name = "localhost"; // Host Name
$host_username = "Trikee_Server"; // Host Username
$host_password = "@#Trikee_2023"; // Host Password
$db_name = "ualibertad_rpms"; // Database Name
// Disable mysqli exceptions (important in PHP 8+)
mysqli_report(MYSQLI_REPORT_OFF);

$connection = @mysqli_connect($host_name, $host_username, $host_password, $db_name);

// Get System Logo
$stmtSL = $connection->prepare("SELECT setting_Value FROM rpms_settings WHERE setting_Key = 'system_logo'");
$stmtSL->execute();
$resultSL = $stmtSL->get_result();
$systemlogo = $resultSL->fetch_assoc()['setting_Value'];
?>