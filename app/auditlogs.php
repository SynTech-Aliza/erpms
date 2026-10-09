<?php
    date_default_timezone_set('Asia/Manila');
    // Prevent browser caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect to auth/403.php if session is missing
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header("Location: 403"); // <-- correct relative path
        exit();
    }

    // Current page
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $user = $_SESSION['user'];

    // Get User Information
    $stmtUser = $connection->prepare(
        "SELECT * FROM rpms_users WHERE user_ID = ?"
    );
    $stmtUser->bind_param("i", $user);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    if ($userRow = $resultUser->fetch_assoc()) {
        $id = $userRow['user_ID'];
        $hashUser = hash('sha256', $userRow['user_ID'] . 'SECRET_KEY');
        $profile = $userRow['user_ProfilePicture'];
        $firstname = $userRow['user_FirstName'];
        $middlename = $userRow['user_MiddleName'];
        $lastname = $userRow['user_LastName'];
        $appointed = $userRow['user_Appointed'];
        $role = $userRow['user_Role'];
    }

    // Get System Logo
    $stmtSL = $connection->prepare("SELECT setting_Value FROM rpms_settings WHERE setting_Key = 'system_logo'");
    $stmtSL->execute();
    $resultSL = $stmtSL->get_result();
    $systemlogo = $resultSL->fetch_assoc()['setting_Value'];

    // Get Actions
    $getallactions = "SELECT userlogs_Action FROM `rpms_userlogs` GROUP BY `userlogs_Action`;";
    $resultallactions = mysqli_query($connection, $getallactions);

    // Get All Audit Logs
        $whereAuditLogs = "";
        if(isset($_GET['auditaction'])) {
            $auditaction = $_GET['auditaction'];
            $whereAuditLogs = "WHERE `userlogs_Action` = '$auditaction'";
        }

        $getallauditlogs = "SELECT * FROM `rpms_userlogs` LEFT JOIN rpms_users ON rpms_users.user_ID = rpms_userlogs.user_ID ORDER BY `userlogs_Created` DESC";
        $resultallauditlogs = mysqli_query($connection, $getallauditlogs);
    
?>