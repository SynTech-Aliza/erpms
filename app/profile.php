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

    // Get Profile Informatiom
    $stmtUser = $connection->prepare(
        "SELECT * FROM rpms_users WHERE user_ID = ?"
    );
    $stmtUser->bind_param("i", $id);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    if ($profileRow = $resultUser->fetch_assoc()) {
        $puserid = $profileRow['user_ID'];
        $pprofile = $profileRow['user_ProfilePicture'];
        $pfirstname = $profileRow['user_FirstName'];
        $pmiddlename = $profileRow['user_MiddleName'];
        $plastname = $profileRow['user_LastName'];
        $pemailaddress = $profileRow['user_EmailAddress'];
        $pcontactnumber = $profileRow['user_ContactNumber'];
        $pusername = $profileRow['user_Username'];
    }

    // Update Profile Information
    if(isset($_POST['updateprofile'])){
        $lastmodified = date("Y-m-d H:i:s");
        $profilepicture= $_FILES['profilepicture']['name'];
        $profilepicture_tmp= $_FILES['profilepicture']['tmp_name'];
        $firstname = strtoupper(trim($_POST['firstname']));
        $middlename = strtoupper(trim($_POST['middlename']));
        $lastname = strtoupper(trim($_POST['lastname']));
        $contactnumber = trim($_POST['contactnumber']);

        // Check Profile Attachment
        if(!empty($profilepicture)){
            $profilefileextension = pathinfo($profilepicture, PATHINFO_EXTENSION);
            $profilefileextensionlw = strtolower($profilefileextension);

            // Use WebP extension
            $profilename = 'Profile'.date("ymdHis").'.webp';
            $file_path = "../storage/profiles/";

            // Create folder if not exists
            if (!is_dir($file_path)) {
                mkdir($file_path, 0777, true);
            }

            // Convert uploaded file to WebP
            switch ($profilefileextensionlw) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($profilepicture_tmp);
                    break;
                case 'png':
                    $image = imagecreatefrompng($profilepicture_tmp);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($profilepicture_tmp);
                    break;
                default:
                    header("Location: profile?notification=errorimagetype");
                    exit();
            }

            // Save as WebP (replaces move_uploaded_file)
            imagewebp($image, $file_path.$profilename, 80);
            imagedestroy($image);

            $profile = $profilename;
        }else{
            $profile = $pprofile;
        }

        $stmtUpdate = $connection->prepare(
            "UPDATE `rpms_users` SET `user_ProfilePicture`= ?,`user_FirstName`= ?,`user_MiddleName`= ?,`user_LastName`= ?, `user_ContactNumber`= ?,`user_LastModified`= ? WHERE `user_ID` = ?"
        );
        $stmtUpdate->bind_param(
            "ssssssi", 
            $profile, 
            $firstname,
            $middlename, 
            $lastname,
            $contactnumber,
            $lastmodified,
            $puserid);
        if ($stmtUpdate->execute()) {
            // Create User Logs
            $userid = $id;
            $action = "UPDATE";
            $module = "USER PROFILE";
            $recordid = $id;
            $description = "USER UPDATED THEIR PERSONAL INFORMATION";
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
            header("Location: profile?notification=profileinformationupdated");
            exit();
        }else{
            header("Location: profile?notification=profileinformationerror");
            exit();
        }
        $stmtUpdate->close();  
    }

    // Update Password
    if(isset($_POST['updatepassword'])){
        $lastmodified = date("Y-m-d H:i:s");
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $confirmpassword = $_POST['confirmpassword'];
        $hashedPassword = password_hash($confirmpassword, PASSWORD_DEFAULT);

        // Check Password
        if (!password_verify($currentpassword, $profileRow['user_Password'])) {
            header("Location: changepassword?notification=invalidpassword");
            exit();
        }

        // Check Match
        if($newpassword !== $confirmpassword){
            header("Location: changepassword?notification=twopasswordunmatched");
            exit();
        }

        $stmtUpdate = $connection->prepare(
            "UPDATE rpms_users SET user_Password = ?, user_LastModified = ? WHERE user_ID = ?"
        );
        $stmtUpdate->bind_param(
            "ssi", 
            $hashedPassword, 
            $lastmodified, 
            $puserid);
        if ($stmtUpdate->execute()) {
            // Create User Logs
            $userid = $id;
            $action = "PASSWORD CHANGE";
            $module = "CHANGE PASSWORD";
            $recordid = $id;
            $description = "USER CHANGED THEIR ACCOUNT PASSWORD";
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

            header("Location: changepassword?notification=passwordupdated");
            exit();
        } else {
            header("Location: changepassword?notification=passworderror");
            exit();
        }
        $stmtUpdate->close();
    }

?>