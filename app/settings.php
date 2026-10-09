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

    // Current page
    $current_page = basename($_SERVER['PHP_SELF']);

    // Add New Barangay
    if(isset($_POST['submit'])){
        $registered = date("Y-m-d H:i:s");
        $name = strtoupper(trim($_POST['name']));
        
        // Check Barangay Name
        $stmtCheck = $connection->prepare("SELECT * FROM rpms_barangays WHERE barangay_Name = ?");
        $stmtCheck->bind_param("s", $name);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        if($resultCheck->num_rows > 0){
            header("Location: createnewbarangay?notification=barangaynameexist");
            exit();
        }else{
            // Auto Increment Table
            $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_barangays");
            $row = $stmtCheck->fetch_assoc();
            if ($row['checktable'] == 0) {
                $connection->query("ALTER TABLE rpms_barangays AUTO_INCREMENT = 1");
            }
            // Insert Barangay
            $stmtInsert = $connection->prepare("
                INSERT INTO `rpms_barangays`(`barangay_Registered`, `barangay_Name`)
                VALUES (?, ?)
            ");
            $stmtInsert->bind_param(
                "ss", 
                $registered, 
                $name,);
            if($stmtInsert->execute()){
                $barangaylastid = $connection->insert_id;
                // Create User Logs
                $userid = $id;
                $action = "CREATE";
                $module = "BARANGAY MANAGEMENT";
                $recordid = $barangaylastid;
                $description = "USER CREATED A NEW BARANGAY {$name}";
                $ip = $_SERVER['REMOTE_ADDR'];
                if($ip == '::1'){
                    $ipaddress = "LOCALHOST";
                }else{
                    $ipaddress = $ip;
                }
                $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                $created = date("Y-m-d H:i:s");

                // Auto Increment Table
                $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                $row = $stmtCheck->fetch_assoc();
                if ($row['checktable'] == 0) {
                    $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                }
                // Insert User Logs
                $stmtInsert = $connection->prepare("
                    INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmtInsert->bind_param(
                    "ississss", 
                    $userid, 
                    $action, 
                    $module,   
                    $recordid, 
                    $description, 
                    $ipaddress, 
                    $useragent, 
                    $created);
                $stmtInsert->execute();
                $stmtInsert->close();

                header("Location: createnewbarangay?notification=barangaycreated");
                exit();
            }else{
                header("Location: createnewbarangay?notification=barangayerror");
                exit();
            }
            $stmtInsert->close();
        }
        $stmtCheck->close();
    }

    // Barangay
    $barangaylimit = 10; // Number of records per page
    $barangaypage = isset($_GET['barangaypage']) ? (int)$_GET['barangaypage'] : 1;
    if ($barangaypage < 1) $barangaypage = 1;
    $barangaystart = ($barangaypage - 1) * $barangaylimit;

    $whereBarangay = "";
    if (isset($_POST['barangayname']) && !empty($_POST['barangayname'])) {
        $barangayname = mysqli_real_escape_string($connection, $_POST['barangayname']);
        $whereBarangay = "WHERE `barangay_Name` = '$barangayname'";
    }

    // Count Barangay Entries
    $getcountbarangay = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_barangays $whereBarangay");
    $resultcountbarangay = mysqli_fetch_assoc($getcountbarangay);
    $totalbarangayentries = $resultcountbarangay['total'];
    $totalbarangaypages = ceil($totalbarangayentries / $barangaylimit);

    // Get All Barangay
    $getallbarangays = "SELECT * FROM rpms_barangays $whereBarangay ORDER BY `barangay_Registered` ASC LIMIT $barangaystart, $barangaylimit";
    $resultallbarangays = mysqli_query($connection, $getallbarangays);

    // Get Barangay Information
    if(isset($_GET['b'])){
        $hashFromURL = $_GET['b'];
        $sql = "SELECT * FROM rpms_barangays";
        $result = mysqli_query($connection, $sql);
        $userID = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['barangay_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $barangay = $row['barangay_ID'];

                // Get Barangay Details
                $stmtBarangay = $connection->prepare(
                    "SELECT * FROM rpms_barangays WHERE barangay_ID = ?"
                );
                $stmtBarangay->bind_param("i", $barangay);
                $stmtBarangay->execute();
                $resultBarangay = $stmtBarangay->get_result();
                if ($barangayRow = $resultBarangay->fetch_assoc()) {
                    $bid = $barangayRow['barangay_ID'];
                    $hashID = hash('sha256', $row['barangay_ID'] . 'SECRET_KEY');
                    $bName = $barangayRow['barangay_Name'];
                }

                // Update Barangay Details
                if (isset($_POST['updateinformation'])) {
                    $name = strtoupper(trim($_POST['name']));

                    // Check Barangay Name
                    $stmtCheck = $connection->prepare("SELECT * FROM rpms_barangays WHERE barangay_Name = ?");
                    $stmtCheck->bind_param("s", $name);
                    $stmtCheck->execute();
                    $resultCheck = $stmtCheck->get_result();
                    if($resultCheck->num_rows > 1){
                        header("Location: viewbarangay?b=$hashID&notification=barangaynameexist");
                        exit();
                    }else{
                        $stmtUpdate = $connection->prepare(
                        "UPDATE `rpms_barangays` SET `barangay_Name`= ? WHERE `barangay_ID` = ?");
                        $stmtUpdate->bind_param(
                            "si", 
                            $name,
                            $bid);
                        if ($stmtUpdate->execute()) {
                            // Create User Logs
                            $userid = $id;
                            $action = "UPDATE";
                            $module = "BARANGAY MANAGEMENT";
                            $recordid = $bid;
                            $description = "USER UPDATED DETAILS FOR BARANGAY {$name}";
                            $ip = $_SERVER['REMOTE_ADDR'];
                            if($ip == '::1'){
                                $ipaddress = "LOCALHOST";
                            }else{
                                $ipaddress = $ip;
                            }
                            $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                            $created = date("Y-m-d H:i:s");

                            // Auto Increment Table
                            $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                            $row = $stmtCheck->fetch_assoc();
                            if ($row['checktable'] == 0) {
                                $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                            }
                            // Insert User Logs
                            $stmtInsert = $connection->prepare("
                                INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                            ");
                            $stmtInsert->bind_param(
                                "ississss", 
                                $userid, 
                                $action, 
                                $module,   
                                $recordid, 
                                $description, 
                                $ipaddress, 
                                $useragent, 
                                $created);
                            $stmtInsert->execute();
                            $stmtInsert->close();

                            header("Location: viewbarangay?b=$hashID&notification=barangaydetailsupdated");
                            exit();
                        } else {
                            header("Location: viewbarangay?b=$hashID&notification=barangaydetailserror");
                            exit();
                        }
                        $stmtUpdate->close();
                    }
                    $stmtCheck->close();
                }
            }
        }
    }

    // Delete Barangay
    if (isset($_GET['deletebarangay'])) {
        $hashFromURL = $_GET['deletebarangay'];
        $sql = "SELECT * FROM rpms_barangays";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['barangay_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $barangay = $row['barangay_ID'];

                // Get Barangay Details
                $stmtBarangay = $connection->prepare(
                    "SELECT * FROM rpms_barangays WHERE barangay_ID = ?"
                );
                $stmtBarangay->bind_param("i", $barangay);
                $stmtBarangay->execute();
                $resultBarangay = $stmtBarangay->get_result();
                if ($barangayRow = $resultBarangay->fetch_assoc()) {
                    $bid = $barangayRow['barangay_ID'];
                    $hashID = hash('sha256', $row['barangay_ID'] . 'SECRET_KEY');
                    $bName = $barangayRow['barangay_Name'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM rpms_barangays WHERE barangay_ID = ?"
                );
                $stmtDelete->bind_param("i", $barangay);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                        $userid = $id;
                        $action = "DELETE";
                        $module = "BARANGAY MANAGEMENT";
                        $recordid = $bid;
                        $description = "USER DELETED BARANGAY NAME {$bName}";
                        $ip = $_SERVER['REMOTE_ADDR'];
                        if($ip == '::1'){
                            $ipaddress = "LOCALHOST";
                        }else{
                            $ipaddress = $ip;
                        }
                        $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                        $created = date("Y-m-d H:i:s");

                        // Auto Increment Table
                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                        $row = $stmtCheck->fetch_assoc();
                        if ($row['checktable'] == 0) {
                            $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                        }
                        // Insert User Logs
                        $stmtInsert = $connection->prepare("
                            INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmtInsert->bind_param(
                            "ississss", 
                            $userid, 
                            $action, 
                            $module,   
                            $recordid, 
                            $description, 
                            $ipaddress, 
                            $useragent, 
                            $created);
                        $stmtInsert->execute();
                        $stmtInsert->close();

                    header("Location: barangay?notification=barangaydeleted");
                    exit();
                } else {
                    header("Location: viewbarangay?b=$hashFromURL&notification=barangaydeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Update System Logo
    if(isset($_POST['savechange'])){
        $systemlogo = $_FILES['systemlogo']['name'];
        $systemlogo_tmp = $_FILES['systemlogo']['tmp_name'];
        $key = 'system_logo';

        $systemlogoextension = pathinfo($systemlogo, PATHINFO_EXTENSION);
        $systemlogoextensionlw = strtolower($systemlogoextension);

        // Remove extension from original name
        $baseName = pathinfo($systemlogo, PATHINFO_FILENAME);

        // Use WebP extension
        $systemlogoname = $baseName . '.webp';
        $file_path = "../storage/logos/";

        // Create folder if not exists
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }

        // Check for duplicates and append (1), (2), etc.
        $counter = 1;
        while (file_exists($file_path . $systemlogoname)) {
            $systemlogoname = $baseName . "($counter).webp";
            $counter++;
        }

        // Convert uploaded file to image resource
        switch ($systemlogoextensionlw) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($systemlogo_tmp);
                break;
            case 'png':
                $image = imagecreatefrompng($systemlogo_tmp);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                header("Location: systemlogo?notification=systemlogoerrorimagetype");
                exit();
        }

        // Resize to 2000x2000
        $resizedImage = imagecreatetruecolor(2000, 2000);

        // Preserve transparency for PNG
        if ($systemlogoextensionlw === 'png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefilledrectangle($resizedImage, 0, 0, 2000, 2000, $transparent);
        }

        // Resize original image into 2000x2000
        imagecopyresampled(
            $resizedImage, $image,
            0, 0, 0, 0,
            2000, 2000,
            imagesx($image), imagesy($image)
        );

        // Save as WebP
        imagewebp($resizedImage, $file_path . $systemlogoname, 80);

        // Free memory
        imagedestroy($image);
        imagedestroy($resizedImage);

        $stmtUpdate = $connection->prepare(
            "UPDATE `rpms_settings` SET `setting_Value`= ? WHERE `setting_Key` = ?"
        );
        $stmtUpdate->bind_param(
            "si",
            $systemlogoname,
            $key);
        if ($stmtUpdate->execute()) {
            // Create User Logs
            $userid = $id;
            $action = "UPDATE";
            $module = "SYSTEM SETTINGS";
            $recordid = $id;
            $description = "USER UPDATED SYSTEM LOGO";
            $ip = $_SERVER['REMOTE_ADDR'];
            if($ip == '::1'){
                $ipaddress = "LOCALHOST";
            }else{
                $ipaddress = $ip;
            }
            $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
            $created = date("Y-m-d H:i:s");

            // Auto Increment Table
            $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
            $row = $stmtCheck->fetch_assoc();
            if ($row['checktable'] == 0) {
                $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
            }
            // Insert User Account
            $stmtInsert = $connection->prepare("
                INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtInsert->bind_param(
                "ississss", 
                $userid, 
                $action, 
                $module, 
                $recordid, 
                $description, 
                $ipaddress, 
                $useragent, 
                $created);
            $stmtInsert->execute();
            $stmtInsert->close();
            header("Location: systemlogo?notification=systemlogoupdated");
            exit();
        }else{
            header("Location: systemlogo?notification=systemlogouploaderror");
            exit();
        }
        $stmtUpdate->close();  
    }

    // Database Backups
    $databaselimit = 10; // Number of records per page
    $databasepage = isset($_GET['databasepage']) ? (int)$_GET['databasepage'] : 1;
    if ($databasepage < 1) $databasepage = 1;
    $databasestart = ($databasepage - 1) * $databaselimit;

    $whereDatabase = "";
    if (isset($_POST['databasedate']) && !empty($_POST['databasedate'])) {
        $databasedate = mysqli_real_escape_string($connection, $_POST['databasedate']);
        $whereDatabase = "WHERE DATE(`database_Backup`) = '$databasedate'";
    }

    // Count Database Entries
    $getcountdatabase = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_databases $whereDatabase");
    $resultcountdatabase = mysqli_fetch_assoc($getcountdatabase);
    $totaldatabaseentries = $resultcountdatabase['total'];
    $totaldatabasepages = ceil($totaldatabaseentries / $databaselimit);

    // Get All Database
    $getalldbbackups = "SELECT * FROM rpms_databases $whereDatabase ORDER BY `database_ID` DESC LIMIT $databasestart, $databaselimit";
    $resultalldbbackups = mysqli_query($connection, $getalldbbackups);

    // Get Default Census Record
    if($appointed != 'MAIN OFFICE'){
        $getdefaultcensusrecord = mysqli_query($connection, "SELECT * FROM `rpms_censusconfig` WHERE `censusconfig_Appointed` = '$appointed'");
        $resultdefaultcensusrecord = mysqli_fetch_assoc($getdefaultcensusrecord);
        $censustype = $resultdefaultcensusrecord['censusconfig_Type'];
        $censusyear = $resultdefaultcensusrecord['censusconfig_Year'];
        $censuscontext = $resultdefaultcensusrecord['censusconfig_Context'];
        $censusname = $resultdefaultcensusrecord['censusconfig_Name'];
    }
    

    // Update Census Settings
    if(isset($_POST['updatecensussettings'])){
        $censustype = strtoupper(trim($_POST['censustype']));
        $censusyear = strtoupper(trim($_POST['censusyear']));
        $specialcensustype = strtoupper(trim($_POST['specialcensustype']));
        $specialcensusname = strtoupper(trim($_POST['specialcensusname']));
        if($censustype == 'SPECIAL'){
            $censuscontext = $specialcensustype;
            $censusname = $specialcensusname;
        }else{
            $censuscontext = '';
            $censusname = '';
        }

        $stmtUpdate = $connection->prepare(
        "UPDATE `rpms_censusconfig` SET `censusconfig_Type`= ?, `censusconfig_Year`= ?, `censusconfig_Context` = ?, `censusconfig_Name`= ? WHERE `censusconfig_Appointed` = ?");
        $stmtUpdate->bind_param(
            "sssss", 
            $censustype,
            $censusyear,
            $censuscontext,
            $censusname,
            $appointed);
        if ($stmtUpdate->execute()) {
            // Create User Logs
            $userid = $id;
            $action = "UPDATE";
            $module = "CENSUS MANAGEMENT";
            $recordid = $bid;
            $description = "USER UPDATED CENSUS REPORT";
            $ip = $_SERVER['REMOTE_ADDR'];
            if($ip == '::1'){
                $ipaddress = "LOCALHOST";
            }else{
                $ipaddress = $ip;
            }
            $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
            $created = date("Y-m-d H:i:s");

            // Auto Increment Table
            $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
            $row = $stmtCheck->fetch_assoc();
            if ($row['checktable'] == 0) {
                $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
            }
            // Insert User Logs
            $stmtInsert = $connection->prepare("
                INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtInsert->bind_param(
                "ississss", 
                $userid, 
                $action, 
                $module,   
                $recordid, 
                $description, 
                $ipaddress, 
                $useragent, 
                $created);
            $stmtInsert->execute();
            $stmtInsert->close();

            header("Location: settings?notification=censussettingupdated");
            exit();
        } else {
            header("Location: settings?notification=censussettingserror");
            exit();
        }
        $stmtUpdate->close();
    }      
?>
