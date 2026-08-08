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

    // Get All Seniors
        // Count Seniors Entries
        $getcountseniors = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) >= 60");
        $resultcountseniors = mysqli_fetch_assoc($getcountseniors);
        $totalseniorsentries = $resultcountseniors['total'];

        // Get All Seniors
        $getallseniorcitizens = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) >= 60 ORDER BY `resident_Registered` ASC";
        $resultallseniorcitizens = mysqli_query($connection, $getallseniorcitizens);

    // Get All PWD
        // Count PWD Entries
        $getcountspwd = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND `resident_PWD` = 1");
        $resultcountpwd = mysqli_fetch_assoc($getcountspwd);
        $totalpwdentries = $resultcountpwd['total'];

        // Get All PWD
        $getallpwd = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND `resident_PWD` = 1 ORDER BY `resident_Registered` ASC";
        $resultallpwd = mysqli_query($connection, $getallpwd);

    // Count 4Ps Entries
        $getcounts4ps = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND `resident_Fourps` = 1");
        $resultcounts4ps = mysqli_fetch_assoc($getcounts4ps);
        $total4psentries = $resultcounts4ps['total'];

        // Get All 4Ps
        $getall4ps = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND `resident_Fourps` = 1 ORDER BY `resident_Registered` ASC";
        $resultall4ps = mysqli_query($connection, $getall4ps);

    // Count Indigenous People Entries
        $getcountsindigenouspeople = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND `resident_Indigenous` = 1");
        $resultcountsindigenouspeople = mysqli_fetch_assoc($getcountsindigenouspeople);
        $totalindigenouspeopleentries = $resultcountsindigenouspeople['total'];

        // Get All Indigenous People
        $getallindigenouspeople = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND `resident_Indigenous` = 1 ORDER BY `resident_Registered` ASC";
        $resultallindigenouspeople = mysqli_query($connection, $getallindigenouspeople);

    // Get All Solo Parents
        // Count Solo Parents Entries
        $getcountssp = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND `resident_ParentStatus` = 'YES'");
        $resultcountssp = mysqli_fetch_assoc($getcountssp);
        $totalspentries = $resultcountssp['total'];

        // Get All Solo Parents
        $getallsp = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND `resident_ParentStatus` = 'YES' ORDER BY `resident_Registered` ASC";
        $resultallsp = mysqli_query($connection, $getallsp);

    // Get All Voters
        // Count Voters Entries
        $getcountsvoters = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents WHERE resident_Barangay = '$appointed' AND `resident_VoterStatus` = 'REGISTERED'");
        $resultcountsvoters = mysqli_fetch_assoc($getcountsvoters);
        $totalvotersentries = $resultcountsvoters['total'];

        // Get All Voters
        $getallsp = "SELECT * FROM `rpms_residents` WHERE resident_Barangay = '$appointed' AND `resident_VoterStatus` = 'REGISTERED' ORDER BY `resident_Registered` ASC";
        $resultallsp = mysqli_query($connection, $getallsp);
        
?>