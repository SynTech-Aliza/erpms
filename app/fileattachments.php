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

    // Get Household Resident Information
        if(isset($_GET['hr'])){
            $hashFromURL = $_GET['hr'];
            $sql = "SELECT * FROM rpms_residents";
            $result = mysqli_query($connection, $sql);
            $residentID = null;
            while ($row = mysqli_fetch_assoc($result)) {
                $checkHash = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                if ($checkHash === $hashFromURL) {
                    $resident = $row['resident_ID'];

                    // Get Resident Information
                    $stmtResident = $connection->prepare(
                        "SELECT * FROM `rpms_residents` WHERE `resident_ID` = ?"
                    );
                    $stmtResident->bind_param("i", $resident);
                    $stmtResident->execute();
                    $resultResident = $stmtResident->get_result();
                    if ($residentRow = $resultResident->fetch_assoc()) {
                        $rid = $residentRow['resident_ID'];
                        $residentshashID = hash('sha256', $rid. 'SECRET_KEY');
                        $rresidentidnumber= $residentRow['resident_IDNumber'];
                        $rhouserole = $residentRow['resident_HouseRole'];
                        $rresidentstatus = $residentRow['resident_ResidentStatus'];
                        $rprofilepicture = $residentRow['resident_ProfilePicture'];
                        $rfirstname = $residentRow['resident_FirstName'];
                        $rmiddlename = $residentRow['resident_MiddleName'];
                        $rlastname = $residentRow['resident_LastName'];
                        $rsuffix = $residentRow['resident_Suffix'];
                        $rdateofbirth = $residentRow['resident_DateofBirth'];
                        $rgender = $residentRow['resident_Gender'];
                        $rstreetpurok = $residentRow['resident_StreetPurok'];
                        $rbarangay = $residentRow['resident_Barangay'];
                        $rmunicipality = $residentRow['resident_Municipality'];
                        $rprovince = $residentRow['resident_Province'];
                        $rcivilstatus = $residentRow['resident_CivilStatus'];
                        $rreligion = $residentRow['resident_Religion'];
                        $rnationality = $residentRow['resident_Nationality'];
                        $rcontactnumber = $residentRow['resident_ContactNumber'];
                        $remailaddress = $residentRow['resident_EmailAddress'];
                        $reducationalattainment = $residentRow['resident_EducationAttainment'];
                        $rheight = $residentRow['resident_Height'];
                        $rweight = $residentRow['resident_Weight'];
                        $rbloodtype = $residentRow['resident_BloodType'];
                        $rparentstatus = $residentRow['resident_ParentStatus'];
                        $rpwd = $residentRow['resident_PWD'];
                        $rfourps = $residentRow['resident_Fourps'];
                        $rindegenous = $residentRow['resident_Indigenous'];
                        $rvoterstatus = $residentRow['resident_VoterStatus'];
                        $ridtype = $residentRow['resident_IDType'];
                        $ridnumber = $residentRow['resident_IDTypeNumber'];
                        $roccupation = $residentRow['resident_Occupation'];
                        $remployerbusinessname = $residentRow['resident_EmployerBusinessName'];
                        $rmonthlyincome = $residentRow['resident_MonthlyIncome'];
                        $remployerstatus = $residentRow['resident_EmployerStatus'];
                        $household = $residentRow['household_ID'];

                        // Calculate Age
                        $dob = new DateTime($rdateofbirth);
                        $today = new DateTime('today');
                        $rage = $dob->diff($today)->y;
                    }

                    // File Attachments
                    $getallfileattachments = "SELECT * FROM `rpms_rattachments` WHERE `resident_ID` = '$resident' ORDER BY `rattachment_Uploaded` DESC";
                    $resultallfileattachments = mysqli_query($connection, $getallfileattachments);

                    // Upload File Attachments
                    if(isset($_POST['uploadfileattachments'])){
                        $uploaded = date("Y-m-d H:i:s");

                        function formatFileSize($sizeInBytes) {
                            $sizeUnits = array('B', 'KB', 'MB', 'GB', 'TB');
                            $i = 0;
                            while ($sizeInBytes >= 1024 && $i < count($sizeUnits) - 1) {
                                $sizeInBytes /= 1024;
                                $i++;
                            }
                            return round($sizeInBytes, 2) . ' ' .$sizeUnits[$i];
                        }

                        // Folder Name
                        $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                        $file_path = "../storage/fileattachments/$foldername/";

                        // Create folder if not exists
                        if (!is_dir($file_path)) {
                            mkdir($file_path, 0777, true);
                        }

                        // Loop through each uploaded file
                        foreach ($_FILES['fileattachment']['name'] as $key => $FA) {
                            $fa_tmp  = $_FILES['fileattachment']['tmp_name'][$key]; // Tmpname per file
                            $fa_size = formatFileSize($_FILES['fileattachment']['size'][$key]); // Size
                            $fa_name = pathinfo($FA, PATHINFO_FILENAME); // Name only
                            $fa_ext = pathinfo($FA, PATHINFO_EXTENSION); // Extension
                            $fa_ext_lw = strtolower($fa_ext); // Lowercase extension

                            // Check existing files for duplicates
                            $stmtCheck = $connection->prepare("
                                SELECT COUNT(*) as filecount 
                                FROM rpms_rattachments 
                                WHERE rattachment_Filename LIKE ? 
                                AND resident_ID = ?
                            ");
                            $search = $fa_name."%";
                            $stmtCheck->bind_param("ss", $search, $resident);
                            $stmtCheck->execute();
                            $result = $stmtCheck->get_result();
                            $row = $result->fetch_assoc();
                            $filecount = (int)$row['filecount'];

                            // Generate filename
                            if ($filecount > 0) {
                                $fileattachment = $fa_name."(".$filecount.").".$fa_ext;
                            } else {
                                $fileattachment = $fa_name.".".$fa_ext;
                            }

                            // Insert file attachment record
                            $stmtInsert = $connection->prepare("
                                INSERT INTO rpms_rattachments
                                (rattachment_Filename, rattachment_Size, rattachment_Uploaded, resident_ID) 
                                VALUES (?, ?, ?, ?)
                            ");
                            $stmtInsert->bind_param("sssi",
                                $fileattachment,
                                $fa_size,
                                $uploaded,
                                $resident
                            );

                            if($stmtInsert->execute()) {
                                // Move File Attachment
                                move_uploaded_file($fa_tmp, $file_path."/".$fileattachment);
                            }else {
                                header("Location: fileattachments?hr=$hashFromURL&notification=hrfileuploadederror");
                                exit();
                            }
                            $stmtInsert->close();
                        }

                        // Create User Logs
                        $userid = $id;
                        $action = "UPLOAD";
                        $module = "FILE MANAGEMENT";
                        $recordid = $rid;
                        $description = "USER UPLOADED A FILE FOR RESIDENT {$rresidentidnumber}";
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $ipaddress = ($ip == '::1') ? "LOCALHOST" : $ip;
                        $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                        $created = date("Y-m-d H:i:s");

                        // Insert User Logs
                        $stmtLog = $connection->prepare("
                            INSERT INTO rpms_userlogs
                            (user_ID, userlogs_Action, userlogs_Module, userlogs_RecordID, userlogs_Description, userlogs_IPAddress, userlogs_Agent, userlogs_Created)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmtLog->bind_param(
                            "ississss", 
                            $userid, 
                            $action, 
                            $module, 
                            $recordid, 
                            $description, 
                            $ipaddress, 
                            $useragent, 
                            $created
                        );
                        $stmtLog->execute();
                        $stmtLog->close();

                        header("Location: fileattachments?hr=$hashFromURL&notification=hrfileuploaded");
                        exit();
                    }

                    // Delete File
                    if (isset($_GET['deletefile'])) {
                        $hashFromURL = $_GET['deletefile'];
                        $sql = "SELECT * FROM rpms_rattachments";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $checkHash = hash('sha256', $row['rattachment_ID'] . 'SECRET_KEY');
                            if ($checkHash === $hashFromURL) {
                                $fileattachment = $row['rattachment_ID'];

                                // Get File Information
                                $stmtFile = $connection->prepare(
                                    "SELECT * FROM `rpms_rattachments` WHERE `rattachment_ID` = ?"
                                );
                                $stmtFile->bind_param("i", $fileattachment);
                                $stmtFile->execute();
                                $resultFile = $stmtFile->get_result();
                                if ($fileRow = $resultFile->fetch_assoc()) {
                                    $fid = $fileRow['rattachment_ID'];
                                    $filehashID = hash('sha256', $fid . 'SECRET_KEY');
                                    $ffilename = $fileRow['rattachment_Filename'];
                                    $fsize = $fileRow['rattachment_Size'];
                                    $fresident = $fileRow['resident_ID'];
                                    $residenthashID = hash('sha256', $fresident . 'SECRET_KEY');
                                }

                                // Folder Name
                                $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                                $file_path = "../storage/fileattachments/$foldername/$ffilename";

                                $stmtDelete = $connection->prepare(
                                    "DELETE FROM `rpms_rattachments` WHERE `rattachment_ID` = ?"
                                );
                                $stmtDelete->bind_param("i", $fileattachment);
                                if ($stmtDelete->execute()) {
                                    // Remove File in Folder
                                    unlink($file_path);
                                    // Create User Logs
                                    $userid = $id;
                                    $action = "DELETE";
                                    $module = "FILE MANAGEMENT";
                                    $recordid = $rid;
                                    $description = "USER DELETED FILE {$ffilename} FOR RESIDENT {$rresidentidnumber}";
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

                                    header("Location: fileattachments?hr=$residenthashID&notification=hrfiledeleted");
                                    exit();
                                } else {
                                    header("Location: fileattachments?hr=$residenthashID&notification=hrfiledeletederror");
                                    exit();
                                }
                                $stmtDelete->close();
                            }
                        }
                    }
                }
            }
        }

    // Get Resident Information
        if(isset($_GET['r'])){
            $hashFromURL = $_GET['r'];
            $sql = "SELECT * FROM rpms_residents";
            $result = mysqli_query($connection, $sql);
            $residentID = null;
            while ($row = mysqli_fetch_assoc($result)) {
                $checkHash = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                if ($checkHash === $hashFromURL) {
                    $resident = $row['resident_ID'];

                    // Get Resident Information
                    $stmtResident = $connection->prepare(
                        "SELECT * FROM `rpms_residents` WHERE `resident_ID` = ?"
                    );
                    $stmtResident->bind_param("i", $resident);
                    $stmtResident->execute();
                    $resultResident = $stmtResident->get_result();
                    if ($residentRow = $resultResident->fetch_assoc()) {
                        $rid = $residentRow['resident_ID'];
                        $residentshashID = hash('sha256', $rid. 'SECRET_KEY');
                        $rresidentidnumber= $residentRow['resident_IDNumber'];
                        $rhouserole = $residentRow['resident_HouseRole'];
                        $rresidentstatus = $residentRow['resident_ResidentStatus'];
                        $rprofilepicture = $residentRow['resident_ProfilePicture'];
                        $rfirstname = $residentRow['resident_FirstName'];
                        $rmiddlename = $residentRow['resident_MiddleName'];
                        $rlastname = $residentRow['resident_LastName'];
                        $rsuffix = $residentRow['resident_Suffix'];
                        $rdateofbirth = $residentRow['resident_DateofBirth'];
                        $rgender = $residentRow['resident_Gender'];
                        $rstreetpurok = $residentRow['resident_StreetPurok'];
                        $rbarangay = $residentRow['resident_Barangay'];
                        $rmunicipality = $residentRow['resident_Municipality'];
                        $rprovince = $residentRow['resident_Province'];
                        $rcivilstatus = $residentRow['resident_CivilStatus'];
                        $rreligion = $residentRow['resident_Religion'];
                        $rnationality = $residentRow['resident_Nationality'];
                        $rcontactnumber = $residentRow['resident_ContactNumber'];
                        $remailaddress = $residentRow['resident_EmailAddress'];
                        $reducationalattainment = $residentRow['resident_EducationAttainment'];
                        $rheight = $residentRow['resident_Height'];
                        $rweight = $residentRow['resident_Weight'];
                        $rbloodtype = $residentRow['resident_BloodType'];
                        $rparentstatus = $residentRow['resident_ParentStatus'];
                        $rpwd = $residentRow['resident_PWD'];
                        $rfourps = $residentRow['resident_Fourps'];
                        $rindegenous = $residentRow['resident_Indigenous'];
                        $rvoterstatus = $residentRow['resident_VoterStatus'];
                        $ridtype = $residentRow['resident_IDType'];
                        $ridnumber = $residentRow['resident_IDTypeNumber'];
                        $roccupation = $residentRow['resident_Occupation'];
                        $remployerbusinessname = $residentRow['resident_EmployerBusinessName'];
                        $rmonthlyincome = $residentRow['resident_MonthlyIncome'];
                        $remployerstatus = $residentRow['resident_EmployerStatus'];
                        $household = $residentRow['household_ID'];

                        // Calculate Age
                        $dob = new DateTime($rdateofbirth);
                        $today = new DateTime('today');
                        $rage = $dob->diff($today)->y;
                    }

                    // File Attachments
                    $getallfileattachments = "SELECT * FROM `rpms_rattachments` WHERE `resident_ID` = '$resident' ORDER BY `rattachment_Uploaded` DESC";
                    $resultallfileattachments = mysqli_query($connection, $getallfileattachments);

                    // Upload File Attachments
                    if(isset($_POST['uploadfileattachments'])){
                        $uploaded = date("Y-m-d H:i:s");

                        function formatFileSize($sizeInBytes) {
                            $sizeUnits = array('B', 'KB', 'MB', 'GB', 'TB');
                            $i = 0;
                            while ($sizeInBytes >= 1024 && $i < count($sizeUnits) - 1) {
                                $sizeInBytes /= 1024;
                                $i++;
                            }
                            return round($sizeInBytes, 2) . ' ' .$sizeUnits[$i];
                        }

                        // Folder Name
                        $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                        $file_path = "../storage/fileattachments/$foldername/";

                        // Create folder if not exists
                        if (!is_dir($file_path)) {
                            mkdir($file_path, 0777, true);
                        }

                        // Loop through each uploaded file
                        foreach ($_FILES['fileattachment']['name'] as $key => $FA) {
                            $fa_tmp  = $_FILES['fileattachment']['tmp_name'][$key]; // Tmpname per file
                            $fa_size = formatFileSize($_FILES['fileattachment']['size'][$key]); // Size
                            $fa_name = pathinfo($FA, PATHINFO_FILENAME); // Name only
                            $fa_ext = pathinfo($FA, PATHINFO_EXTENSION); // Extension
                            $fa_ext_lw = strtolower($fa_ext); // Lowercase extension

                            // Check existing files for duplicates
                            $stmtCheck = $connection->prepare("
                                SELECT COUNT(*) as filecount 
                                FROM rpms_rattachments 
                                WHERE rattachment_Filename LIKE ? 
                                AND resident_ID = ?
                            ");
                            $search = $fa_name."%";
                            $stmtCheck->bind_param("ss", $search, $resident);
                            $stmtCheck->execute();
                            $result = $stmtCheck->get_result();
                            $row = $result->fetch_assoc();
                            $filecount = (int)$row['filecount'];

                            // Generate filename
                            if ($filecount > 0) {
                                $fileattachment = $fa_name."(".$filecount.").".$fa_ext;
                            } else {
                                $fileattachment = $fa_name.".".$fa_ext;
                            }

                            // Insert file attachment record
                            $stmtInsert = $connection->prepare("
                                INSERT INTO rpms_rattachments
                                (rattachment_Filename, rattachment_Size, rattachment_Uploaded, resident_ID) 
                                VALUES (?, ?, ?, ?)
                            ");
                            $stmtInsert->bind_param("sssi",
                                $fileattachment,
                                $fa_size,
                                $uploaded,
                                $resident
                            );

                            if($stmtInsert->execute()) {
                                // Move File Attachment
                                move_uploaded_file($fa_tmp, $file_path."/".$fileattachment);
                            }else {
                                header("Location: fileattachments?r=$hashFromURL&notification=rfileuploadederror");
                                exit();
                            }
                            $stmtInsert->close();
                        }

                        // Create User Logs
                        $userid = $id;
                        $action = "UPLOAD";
                        $module = "FILE MANAGEMENT";
                        $recordid = $rid;
                        $description = "USER UPLOADED A FILE FOR RESIDENT {$rresidentidnumber}";
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $ipaddress = ($ip == '::1') ? "LOCALHOST" : $ip;
                        $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                        $created = date("Y-m-d H:i:s");

                        // Insert User Logs
                        $stmtLog = $connection->prepare("
                            INSERT INTO rpms_userlogs
                            (user_ID, userlogs_Action, userlogs_Module, userlogs_RecordID, userlogs_Description, userlogs_IPAddress, userlogs_Agent, userlogs_Created)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmtLog->bind_param(
                            "ississss", 
                            $userid, 
                            $action, 
                            $module, 
                            $recordid, 
                            $description, 
                            $ipaddress, 
                            $useragent, 
                            $created
                        );
                        $stmtLog->execute();
                        $stmtLog->close();

                        header("Location: fileattachments?r=$hashFromURL&notification=rfileuploaded");
                        exit();
                    }

                    // Delete File
                    if (isset($_GET['deletefile'])) {
                        $hashFromURL = $_GET['deletefile'];
                        $sql = "SELECT * FROM rpms_rattachments";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $checkHash = hash('sha256', $row['rattachment_ID'] . 'SECRET_KEY');
                            if ($checkHash === $hashFromURL) {
                                $fileattachment = $row['rattachment_ID'];

                                // Get File Information
                                $stmtFile = $connection->prepare(
                                    "SELECT * FROM `rpms_rattachments` WHERE `rattachment_ID` = ?"
                                );
                                $stmtFile->bind_param("i", $fileattachment);
                                $stmtFile->execute();
                                $resultFile = $stmtFile->get_result();
                                if ($fileRow = $resultFile->fetch_assoc()) {
                                    $fid = $fileRow['rattachment_ID'];
                                    $filehashID = hash('sha256', $fid . 'SECRET_KEY');
                                    $ffilename = $fileRow['rattachment_Filename'];
                                    $fsize = $fileRow['rattachment_Size'];
                                    $fresident = $fileRow['resident_ID'];
                                    $residenthashID = hash('sha256', $fresident . 'SECRET_KEY');
                                }

                                // Folder Name
                                $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                                $file_path = "../storage/fileattachments/$foldername/$ffilename";

                                $stmtDelete = $connection->prepare(
                                    "DELETE FROM `rpms_rattachments` WHERE `rattachment_ID` = ?"
                                );
                                $stmtDelete->bind_param("i", $fileattachment);
                                if ($stmtDelete->execute()) {
                                    // Remove File in Folder
                                    unlink($file_path);
                                    // Create User Logs
                                    $userid = $id;
                                    $action = "DELETE";
                                    $module = "FILE MANAGEMENT";
                                    $recordid = $rid;
                                    $description = "USER DELETED FILE {$ffilename} FOR RESIDENT {$rresidentidnumber}";
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

                                    header("Location: fileattachments?r=$residenthashID&notification=rfiledeleted");
                                    exit();
                                } else {
                                    header("Location: fileattachments?r=$residenthashID&notification=rfiledeletederror");
                                    exit();
                                }
                                $stmtDelete->close();
                            }
                        }
                    }
                }
            }
        }
?>