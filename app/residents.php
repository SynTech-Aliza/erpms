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
    
    // Barangay Intials
    $usedInitials = [];
    $name = preg_replace('/[\(\)]/', '', $appointed);
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $w) {
        if (!empty($w)) $initials .= strtoupper($w[0]);
    }
    $lettersNeeded = 3;
    $tempInitials = strtoupper($initials);
    $i = 1;
    while (strlen($tempInitials) < $lettersNeeded) {
        foreach ($words as $w) {
            $w = strtoupper($w);
            if (isset($w[$i])) {
                $tempInitials .= $w[$i];
                if (strlen($tempInitials) == $lettersNeeded) break 2;
            }
        }
        $i++;
    }
    $tempInitials = substr($tempInitials, 0, 3);
    $barangayInitials = $tempInitials;
    $j = 1;
    while (in_array($barangayInitials, $usedInitials)) {
        $barangayInitials = substr($tempInitials, 0, 2) . strtoupper(substr($name, $j, 1));
        $barangayInitials = str_pad($barangayInitials, 3, 'X');
        $j++;
    }
    $usedInitials[] = $barangayInitials;
    
    // Output Residents ID Number
    $idnumberresidents = "R".$barangayInitials.date("Y").mt_rand(1, 9999);

    // Get Household Information
        if(isset($_GET['hh'])){
            $hashFromURL = $_GET['hh'];
            $sql = "SELECT * FROM rpms_households";
            $result = mysqli_query($connection, $sql);
            $householdID = null;
            while ($row = mysqli_fetch_assoc($result)) {
                $checkHash = hash('sha256', $row['household_ID'] . 'SECRET_KEY');
                if ($checkHash === $hashFromURL) {
                    $household = $row['household_ID'];

                    // Get Household Information
                    $stmtHousehold = $connection->prepare(
                        "SELECT * FROM `rpms_households` WHERE `household_ID` = ?"
                    );
                    $stmtHousehold->bind_param("i", $household);
                    $stmtHousehold->execute();
                    $resultHousehold = $stmtHousehold->get_result();
                    if ($householdRow = $resultHousehold->fetch_assoc()) {
                        $hid = $householdRow['household_ID'];
                        $householdhashID = hash('sha256', $hid . 'SECRET_KEY');
                        $hhouseholdidnumber = $householdRow['household_IDNumber'];
                        $hstreetpurok = $householdRow['household_StreetPurok'];
                        $hbarangay = $householdRow['household_Barangay'];
                        $hmunicipality = $householdRow['household_Municipality'];
                        $hprovince = $householdRow['household_Province'];
                        $htype = $householdRow['household_Type'];
                        $hsize = $householdRow['household_Size'];
                        $hcondition = $householdRow['household_Condition'];
                        $hutitlies = $householdRow['household_Utilities'];
                        $hfacilities = $householdRow['household_Facilities'];
                    }
                    // Get All Residents
                    $getallhouseholdresidents = "SELECT * FROM `rpms_residents` WHERE `household_ID` = '$household' ORDER BY `resident_Registered` DESC;";
                    $resultallhouseholdresidents = mysqli_query($connection, $getallhouseholdresidents);

                    // Count Residents Entries
                    $getcounthouseholdresidents = "SELECT COUNT(*) AS totalhouseholdresidentsentries FROM `rpms_residents` WHERE `household_ID` = '$household'";
                    $resultcounthouseholdresidents = mysqli_query($connection, $getcounthouseholdresidents);
                    $totalhouseholdresidentsentries = mysqli_fetch_assoc($resultcounthouseholdresidents)['totalhouseholdresidentsentries'];
                    $thref = number_format($totalhouseholdresidentsentries);

                    // Check Household Resident
                    $checkhouseholdhead = "SELECT * FROM `rpms_residents` WHERE `resident_HouseRole` = 'HEAD OF HOUSEHOLD' AND `household_ID` = '$household'";
                    $resulthouseholdhead = mysqli_query($connection, $checkhouseholdhead);
                    $headofhouseholdstatus = (mysqli_num_rows($resulthouseholdhead) > 0) ? "none" : "yes";

                    // Add New Resident
                    if(isset($_POST['submit'])){
                        $registered = date("Y-m-d H:i:s");
                        $residentidnumber = $idnumberresidents;
                        $householdrole = strtoupper(trim($_POST['householdrole']));
                        $residentstatus = strtoupper(trim($_POST['residentstatus']));
                        $profilepicture= $_FILES['profilepicture']['name'];
                        $profilepicture_tmp= $_FILES['profilepicture']['tmp_name'];
                        $firstname = strtoupper(trim($_POST['firstname']));
                        $middlename = strtoupper(trim($_POST['middlename']));
                        $lastname = strtoupper(trim($_POST['lastname']));
                        $suffix = strtoupper(trim($_POST['suffix']));
                        $dateofbirth = ($_POST['dateofbirth']);
                        $age = ($_POST['age']);
                        $gender = strtoupper(trim($_POST['gender']));
                        $civilstatus = strtoupper(trim($_POST['civilstatus']));
                        $religion = strtoupper(trim($_POST['religion']));
                        $nationality = strtoupper(trim($_POST['nationality']));
                        $streetpurok = strtoupper(trim($_POST['streetpurok']));
                        $barangay = strtoupper(trim($_POST['barangay']));
                        $municipality = strtoupper(trim($_POST['municipality']));
                        $province = strtoupper(trim($_POST['province']));
                        $contactnumber = strtoupper(trim($_POST['contactnumber']));
                        $emailaddress = strtolower(trim($_POST['emailaddress']));
                        $educationalattainment = strtoupper(trim($_POST['educationalattainment']));
                        $height = $_POST['height'];
                        $weight = $_POST['weight'];
                        $bloodtype = strtoupper(trim($_POST['bloodtype']));
                        $parentstatus = strtoupper(trim($_POST['parentstatus']));
                        $pwd = $_POST['pwd'];
                        $fourps = $_POST['fourps'];
                        $indigenous = $_POST['indigenous'];
                        $voterstatus = strtoupper(trim($_POST['voterstatus']));
                        $typeid = $_POST['idtype'];
                        if($typeid == 'OthersID'){
                            $idtype = strtoupper(trim($_POST['otheridtype']));
                        }else{
                            $idtype = strtoupper(trim($typeid));
                        }
                        $idnumber = strtoupper(trim($_POST['idnumber']));
                        $occupation = strtoupper(trim($_POST['occupation']));
                        $employerbusinessname = strtoupper(trim($_POST['employerbusinessname']));
                        $monthlyincome = str_replace(',', '', trim($_POST['monthlyincome']));
                        $employementstatus = strtoupper(trim($_POST['employementstatus']));
                        $fileattachments = $_FILES['fileattachment']['name'];

                        // Check Profile Attachment
                        if(!empty($profilepicture)){
                            $profilefileextension = pathinfo($profilepicture, PATHINFO_EXTENSION);
                            $profilefileextensionlw = strtolower($profilefileextension);
                            
                            // Use WebP extension
                            $profilename = $residentidnumber.'('.date("ymdHis").')'.'.webp';
                            $file_path = "../../public/residents/";

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
                                    header("Location: residents?notification=errorimagetype");
                                    exit();
                            }

                            // Save as WebP (replaces move_uploaded_file)
                            imagewebp($image, $file_path.$profilename, 80);
                            imagedestroy($image);
                            $profile = $profilename;
                        }else{
                            $profile = 'Default.png';
                        }

                        // File Size
                        function formatFileSize($sizeInBytes) {
                            $sizeUnits = array('B', 'KB', 'MB', 'GB', 'TB');
                            $i = 0;
                            while ($sizeInBytes >= 1024 && $i < count($sizeUnits) - 1) {
                                $sizeInBytes /= 1024;
                                $i++;
                            }
                            return round($sizeInBytes, 2) . ' ' .$sizeUnits[$i];
                        }

                        // Check Residents
                        $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residents` WHERE `resident_FirstName` = ? AND `resident_MiddleName` = ? AND `resident_LastName` = ? AND `resident_Suffix` = ? AND `resident_StreetPurok` = ? AND `resident_Barangay` = ?");
                        $stmtCheck->bind_param("ssssss", $firstname, $middlename, $lastname, $suffix, $streetpurok, $barangay);
                        $stmtCheck->execute();
                        $resultCheck = $stmtCheck->get_result();
                        if($resultCheck->num_rows > 0){
                            header("Location: createnewresident?hh=$hashFromURL&notification=residentexist");
                            exit();
                        }else{
                            // Auto Increment Table
                            $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM `rpms_residents`");
                            $row = $stmtCheck->fetch_assoc();
                            if ($row['checktable'] == 0) {
                                $connection->query("ALTER TABLE `rpms_residents` AUTO_INCREMENT = 1");
                            }
                            // Insert Resident
                            $stmtInsert = $connection->prepare("
                                INSERT INTO `rpms_residents`(`resident_Registered`, `resident_IDNumber`, `resident_HouseRole`, `resident_ResidentStatus`, `resident_ProfilePicture`, `resident_FirstName`, `resident_MiddleName`, `resident_LastName`, `resident_Suffix`,  `resident_DateofBirth`, `resident_Age`, `resident_Gender`, `resident_StreetPurok`, `resident_Barangay`, `resident_Municipality`, `resident_Province`, `resident_CivilStatus`, `resident_Religion`, `resident_Nationality`, `resident_ContactNumber`, `resident_EmailAddress`, `resident_EducationAttainment`, `resident_Height`, `resident_Weight`, `resident_BloodType`, `resident_ParentStatus`, `resident_PWD`, `resident_Fourps`, `resident_Indigenous`, `resident_VoterStatus`, `resident_IDType`, `resident_IDTypeNumber`, `resident_Occupation`, `resident_EmployerBusinessName`, `resident_MonthlyIncome`, `resident_EmployerStatus`, `household_ID`) 
                                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ");
                            $stmtInsert->bind_param(
                                "ssssssssssissssssssssssdssiiisssssisi", 
                                $registered, 
                                $residentidnumber, 
                                $householdrole, 
                                $residentstatus,
                                $profile,
                                $firstname, 
                                $middlename, 
                                $lastname, 
                                $suffix, 
                                $dateofbirth,
                                $age, 
                                $gender,
                                $streetpurok,
                                $barangay,
                                $municipality,
                                $province,
                                $civilstatus,
                                $religion,
                                $nationality,
                                $contactnumber,
                                $emailaddress,
                                $educationalattainment,
                                $height,
                                $weight,
                                $bloodtype,
                                $parentstatus,
                                $pwd,
                                $fourps,
                                $indigenous,
                                $voterstatus,
                                $idtype,
                                $idnumber,
                                $occupation,
                                $employerbusinessname,
                                $monthlyincome,
                                $employementstatus,
                                $household);
                            if($stmtInsert->execute()){
                                $residentlastid = $connection->insert_id;
                                
                                // Check File Attachment
                                if(!empty($_FILES['fileattachment']['name'][0])){
                                    // Folder Name
                                    $foldername = $firstname."-".$middlename."-".$lastname.($suffix == "N/A" ? "" : "-" . $suffix)."_".$residentidnumber;
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
                                        $fileattachment = $fa_name.".".$fa_ext;

                                        // Insert file attachment record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO rpms_rattachments
                                            (rattachment_Filename, rattachment_Size, rattachment_Uploaded, resident_ID) 
                                            VALUES (?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param("sssi",
                                            $fileattachment,
                                            $fa_size,
                                            $registered,
                                            $residentlastid
                                        );

                                        if($stmtInsert->execute()){
                                            move_uploaded_file($fa_tmp, $file_path."/".$fileattachment);
                                        }
                                        
                                        $stmtInsert->close();
                                    }
                                }

                                // Create User Logs
                                $userid = $id;
                                $action = "CREATE";
                                $module = "RESIDENT MANAGEMENT";
                                $recordid = $hid;
                                $description = "USER ADDED NEW RESIDENT(S) TO HOUSEHOLD {$hhouseholdidnumber}";
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

                                header("Location: createnewresident?hh=$hashFromURL&notification=residentcreated");
                                exit();
                            }else{
                                header("Location: createnewresident?hh=$hashFromURL&notification=residenterror");
                                exit();
                            }
                            $stmtInsert->close();
                        }
                        $stmtCheck->close();
                    }
                }
            }
        }

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
                        $rmonthlyincome = number_format($residentRow['resident_MonthlyIncome']);
                        $remployerstatus = $residentRow['resident_EmployerStatus'];
                        $household = $residentRow['household_ID'];

                        // Calculate Age
                        $dob = new DateTime($rdateofbirth);
                        $today = new DateTime('today');
                        $rage = $dob->diff($today)->y;
                    }

                    // Get Household Information
                    $stmtHousehold = $connection->prepare(
                        "SELECT * FROM `rpms_households` WHERE `household_ID` = ?"
                    );
                    $stmtHousehold->bind_param("i", $household);
                    $stmtHousehold->execute();
                    $resultHousehold = $stmtHousehold->get_result();
                    if ($householdRow = $resultHousehold->fetch_assoc()) {
                        $hid = $householdRow['household_ID'];
                        $householdhashID = hash('sha256', $hid. 'SECRET_KEY');
                        $hhouseholdidnumber = $householdRow['household_IDNumber'];
                        $hstreetpurok = $householdRow['household_StreetPurok'];
                        $hbarangay = $householdRow['household_Barangay'];
                        $hmunicipality = $householdRow['household_Municipality'];
                        $hprovince = $householdRow['household_Province'];
                        $htype = $householdRow['household_Type'];
                        $hsize = $householdRow['household_Size'];
                        $hcondition = $householdRow['household_Condition'];
                        $hutitlies = $householdRow['household_Utilities'];
                        $hfacilities = $householdRow['household_Facilities'];
                    }

                    // Check Household Resident
                    $checkhouseholdhead = "SELECT * FROM `rpms_residents` WHERE `resident_HouseRole` = 'HEAD OF HOUSEHOLD' AND `household_ID` = '$household'";
                    $resulthouseholdhead = mysqli_query($connection, $checkhouseholdhead);
                    $headofhouseholdstatus = (mysqli_num_rows($resulthouseholdhead) > 0) ? "none" : "yes";

                    // Update Resident Information
                    if(isset($_POST['updateinformation'])){
                        $lastmodified = date("Y-m-d H:i:s");
                        $householdrole = strtoupper(trim($_POST['householdrole']));
                        $residentstatus = strtoupper(trim($_POST['residentstatus']));
                        $profilepicture= $_FILES['profilepicture']['name'];
                        $profilepicture_tmp= $_FILES['profilepicture']['tmp_name'];
                        $firstname = strtoupper(trim($_POST['firstname']));
                        $middlename = strtoupper(trim($_POST['middlename']));
                        $lastname = strtoupper(trim($_POST['lastname']));
                        $suffix = strtoupper(trim($_POST['suffix']));
                        $dateofbirth = ($_POST['dateofbirth']);
                        $age = ($_POST['age']);
                        $gender = strtoupper(trim($_POST['gender']));
                        $civilstatus = strtoupper(trim($_POST['civilstatus']));
                        $religion = strtoupper(trim($_POST['religion']));
                        $nationality = strtoupper(trim($_POST['nationality']));
                        $streetpurok = strtoupper(trim($_POST['streetpurok']));
                        $barangay = strtoupper(trim($_POST['barangay']));
                        $municipality = strtoupper(trim($_POST['municipality']));
                        $province = strtoupper(trim($_POST['province']));
                        $contactnumber = strtoupper(trim($_POST['contactnumber']));
                        $emailaddress = strtolower(trim($_POST['emailaddress']));
                        $educationalattainment = strtoupper(trim($_POST['educationalattainment']));
                        $height = $_POST['height'];
                        $weight = $_POST['weight'];
                        $bloodtype = strtoupper(trim($_POST['bloodtype']));
                        $parentstatus = strtoupper(trim($_POST['parentstatus']));
                        $pwd = $_POST['pwd'];
                        $fourps = $_POST['fourps'];
                        $indigenous = $_POST['indigenous'];
                        $voterstatus = strtoupper(trim($_POST['voterstatus']));
                        $typeid = $_POST['idtype'];
                        if($typeid == 'OthersID'){
                            $idtype = strtoupper(trim($_POST['otheridtype']));
                        }else{
                            $idtype = strtoupper(trim($typeid));
                        }
                        $idnumber = strtoupper(trim($_POST['idnumber']));
                        $occupation = strtoupper(trim($_POST['occupation']));
                        $employerbusinessname = strtoupper(trim($_POST['employerbusinessname']));
                        $monthlyincome = str_replace(',', '', trim($_POST['monthlyincome']));
                        $employementstatus = strtoupper(trim($_POST['employementstatus']));

                        // Check Profile Attachment
                        if(!empty($profilepicture)){
                            $profilefileextension = pathinfo($profilepicture, PATHINFO_EXTENSION);
                            $profilefileextensionlw = strtolower($profilefileextension);
                            
                            // Use WebP extension
                            $profilename = $rresidentidnumber.'('.date("ymdHis").')'.'.webp';
                            $file_path = "../storage/residents/";

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
                                    header("Location: viewresident?r=$hashFromURL&notification=householdresidenterrorimagetype");
                                    exit();
                            }

                            // Save as WebP (replaces move_uploaded_file)
                            imagewebp($image, $file_path.$profilename, 80);
                            imagedestroy($image);
                            $profile = $profilename;
                        }else{
                            $profile = 'Default.png';
                        }

                        $stmtUpdate = $connection->prepare(
                            "UPDATE `rpms_residents` SET `resident_HouseRole`= ?,`resident_ResidentStatus`= ?,`resident_ProfilePicture`= ?,`resident_FirstName`= ?,`resident_MiddleName`= ?,`resident_LastName`= ?,`resident_Suffix`= ?,`resident_DateofBirth`= ?,`resident_Age`= ?, `resident_Gender`= ?,`resident_StreetPurok`= ?,`resident_Barangay`= ?,`resident_Municipality`= ?,`resident_Province`= ?,`resident_CivilStatus`= ?,`resident_Religion`= ?,`resident_Nationality`= ?,`resident_ContactNumber`= ?,`resident_EmailAddress`= ?,`resident_EducationAttainment`= ?,`resident_Height`= ?,`resident_Weight`= ?,`resident_BloodType`= ?,`resident_ParentStatus`= ?,`resident_PWD`= ?,`resident_Fourps`= ?,`resident_Indigenous`= ?,`resident_VoterStatus`= ?,`resident_IDType`= ?, `resident_IDTypeNumber`= ?,`resident_Occupation`= ?,`resident_EmployerBusinessName`= ?,`resident_MonthlyIncome`= ?,`resident_EmployerStatus`= ?, `resident_LastModified`= ? WHERE `resident_ID` = ?"
                        );
                        $stmtUpdate->bind_param(
                            "ssssssssissssssssssssdssiiisssssissi", 
                            $householdrole, 
                            $residentstatus,
                            $profile,
                            $firstname, 
                            $middlename, 
                            $lastname, 
                            $suffix, 
                            $dateofbirth,
                            $age, 
                            $gender,
                            $streetpurok,
                            $barangay,
                            $municipality,
                            $province,
                            $civilstatus,
                            $religion,
                            $nationality,
                            $contactnumber,
                            $emailaddress,
                            $educationalattainment,
                            $height,
                            $weight,
                            $bloodtype,
                            $parentstatus,
                            $pwd,
                            $fourps,
                            $indigenous,
                            $voterstatus,
                            $idtype,
                            $idnumber,
                            $occupation,
                            $employerbusinessname,
                            $monthlyincome,
                            $employementstatus,
                            $lastmodified,
                            $resident);
                        if ($stmtUpdate->execute()) {
                            // Create User Logs
                            $userid = $id;
                            $action = "UPDATE";
                            $module = "RESIDENT MANAGEMENT";
                            $recordid = $rid;
                            $description = "USER UPDATED RESIDENT INFORMATION FOR RESIDENT {$rresidentidnumber} IN HOUSEHOLD {$hhouseholdidnumber}";
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

                            header("Location: viewresident?hr=$hashFromURL&notification=householdresidentinformationupdated");
                            exit();
                        } else {
                            header("Location: viewresident?hr=$hashFromURL&notification=householdresidentinformationerror");
                            exit();
                        }
                        $stmtUpdate->close();   
                    }

                    // Delete Resident
                    if (isset($_GET['deleteresident'])) {
                        $hashFromURL = $_GET['deleteresident'];
                        $sql = "SELECT * FROM rpms_residents";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $checkHash = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                            if ($checkHash === $hashFromURL) {
                                $resident = $row['resident_ID'];
                                $stmtDelete = $connection->prepare(
                                    "DELETE FROM `rpms_residents` WHERE `resident_ID` = ?"
                                );
                                $stmtDelete->bind_param("i", $resident);
                                if ($stmtDelete->execute()) {
                                    // Create User Logs
                                    $userid = $id;
                                    $action = "DELETE";
                                    $module = "RESIDENT MANAGEMENT";
                                    $recordid = $rid;
                                    $description = "USER DELETED RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                    header("Location: residents?hh=$householdhashID&notification=householdresidentdeleted");
                                    exit();
                                } else {
                                    header("Location: viewresident?hr=$hashFromURL&notification=householdresidentdeleteerror");
                                    exit();
                                }
                                $stmtDelete->close();
                            }
                        }
                    }
                }
            }
        }

    // Filter Purok
        $getbarangaypurokfilter = "SELECT `household_StreetPurok` FROM `rpms_households` WHERE `household_Barangay` = '$appointed' GROUP BY `household_StreetPurok`";
        $resultbarangaypurokfilter = mysqli_query($connection, $getbarangaypurokfilter);

    // Get All Residents
        $residentlimit = 100; // Number of records per page
        $residentpage = isset($_GET['residentpage']) ? (int)$_GET['residentpage'] : 1;
        if ($residentpage < 1) $residentpage = 1;
        $residentstart = ($residentpage - 1) * $residentlimit;

        $whereResident = "WHERE `resident_Barangay` = '$appointed'";
        if (isset($_POST['residentid']) && !empty($_POST['residentid'])) {
            $residentid = mysqli_real_escape_string($connection, $_POST['residentid']);
            $whereResident .= "AND `resident_IDNumber` = '$residentid'";
        }elseif(isset($_GET['purok'])){
            $purok = $_GET['purok'];
            $whereResident .= "AND `resident_StreetPurok` = '$purok'";
        }elseif(isset($_GET['age'])){
            $age = $_GET['age'];
            switch ($age) {
                case '0-2 Infants':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 0 AND 2";
                    break;

                case '3-12 Child':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 3 AND 12";
                    break;

                case '13-17 Teen':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 13 AND 17";
                    break;

                case '18-25 Young Adult':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 18 AND 25";
                    break;

                case '26-40 Adult':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 26 AND 40";
                    break;

                case '41-59 Middle Age':
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) BETWEEN 41 AND 59";
                    break;
                
                default:
                    $whereResident .= "AND TIMESTAMPDIFF(YEAR, resident_DateofBirth, CURDATE()) >= 60";
                    break;
            }
        }elseif(isset($_GET['gender'])){
            $gender = $_GET['gender'];
            $whereResident .= " AND resident_Gender = '$gender'";
        }elseif(isset($_GET['sectors'])){
            $sectors = $_GET['sectors'];
            switch ($sectors) {
                case 'PWD':
                    $whereResident .= "AND resident_PWD = 1";
                    break;

                case 'Indigenous People':
                    $whereResident .= "AND resident_Indigenous = 1";
                    break;

                case 'Solo Parents':
                    $whereResident .= "AND resident_ParentStatus = 'YES'";
                    break;
                
                default:
                    $whereResident .= "AND resident_Fourps = 1";
                    break;
            }
        }elseif(isset($_GET['role'])){
            $role = $_GET['role'];
            $whereResident .= "AND resident_HouseRole = '$role'"; 
        }

        // Count Residents Entries
        $getcountresident = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residents $whereResident");
        $resultcountresident = mysqli_fetch_assoc($getcountresident);
        $totalresidententries = $resultcountresident['total'];
        $totalresidentpages = ceil($totalresidententries / $residentlimit);

        // Get All Residents
        $getallresidents = "SELECT * FROM `rpms_residents` $whereResident ORDER BY `resident_ID` DESC LIMIT $residentstart, $residentlimit";
        $resultallresidents = mysqli_query($connection, $getallresidents);

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
                        $rage = $residentRow['resident_Age'];
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
                        $rmonthlyincome = number_format($residentRow['resident_MonthlyIncome']);
                        $remployerstatus = $residentRow['resident_EmployerStatus'];
                        $household = $residentRow['household_ID'];
                    }

                    // Get Household Information
                    $stmtHousehold = $connection->prepare(
                        "SELECT * FROM `rpms_households` WHERE `household_ID` = ?"
                    );
                    $stmtHousehold->bind_param("i", $household);
                    $stmtHousehold->execute();
                    $resultHousehold = $stmtHousehold->get_result();
                    if ($householdRow = $resultHousehold->fetch_assoc()) {
                        $hid = $householdRow['household_ID'];
                        $householdhashID = hash('sha256', $hid. 'SECRET_KEY');
                        $hhouseholdidnumber = $householdRow['household_IDNumber'];
                        $hstreetpurok = $householdRow['household_StreetPurok'];
                        $hbarangay = $householdRow['household_Barangay'];
                        $hmunicipality = $householdRow['household_Municipality'];
                        $hprovince = $householdRow['household_Province'];
                        $htype = $householdRow['household_Type'];
                        $hsize = $householdRow['household_Size'];
                        $hcondition = $householdRow['household_Condition'];
                        $hutitlies = $householdRow['household_Utilities'];
                        $hfacilities = $householdRow['household_Facilities'];
                    }

                    // Check Household Resident
                    $checkhouseholdhead = "SELECT * FROM `rpms_residents` WHERE `resident_HouseRole` = 'HEAD OF HOUSEHOLD' AND `household_ID` = '$household'";
                    $resulthouseholdhead = mysqli_query($connection, $checkhouseholdhead);
                    $headofhouseholdstatus = (mysqli_num_rows($resulthouseholdhead) > 0) ? "none" : "yes";

                    // Update Resident Information
                    if(isset($_POST['updateinformation'])){
                        $lastmodified = date("Y-m-d H:i:s");
                        $householdrole = strtoupper(trim($_POST['householdrole']));
                        $residentstatus = strtoupper(trim($_POST['residentstatus']));
                        $profilepicture= $_FILES['profilepicture']['name'];
                        $profilepicture_tmp= $_FILES['profilepicture']['tmp_name'];
                        $firstname = strtoupper(trim($_POST['firstname']));
                        $middlename = strtoupper(trim($_POST['middlename']));
                        $lastname = strtoupper(trim($_POST['lastname']));
                        $suffix = strtoupper(trim($_POST['suffix']));
                        $dateofbirth = ($_POST['dateofbirth']);
                        $age = ($_POST['age']);
                        $gender = strtoupper(trim($_POST['gender']));
                        $civilstatus = strtoupper(trim($_POST['civilstatus']));
                        $religion = strtoupper(trim($_POST['religion']));
                        $nationality = strtoupper(trim($_POST['nationality']));
                        $streetpurok = strtoupper(trim($_POST['streetpurok']));
                        $barangay = strtoupper(trim($_POST['barangay']));
                        $municipality = strtoupper(trim($_POST['municipality']));
                        $province = strtoupper(trim($_POST['province']));
                        $contactnumber = strtoupper(trim($_POST['contactnumber']));
                        $emailaddress = strtolower(trim($_POST['emailaddress']));
                        $educationalattainment = strtoupper(trim($_POST['educationalattainment']));
                        $height = $_POST['height'];
                        $weight = $_POST['weight'];
                        $bloodtype = strtoupper(trim($_POST['bloodtype']));
                        $parentstatus = strtoupper(trim($_POST['parentstatus']));
                        $pwd = $_POST['pwd'];
                        $fourps = $_POST['fourps'];
                        $indigenous = $_POST['indigenous'];
                        $voterstatus = strtoupper(trim($_POST['voterstatus']));
                        $typeid = $_POST['idtype'];
                        if($typeid == 'OthersID'){
                            $idtype = strtoupper(trim($_POST['otheridtype']));
                        }else{
                            $idtype = strtoupper(trim($typeid));
                        }
                        $idnumber = strtoupper(trim($_POST['idnumber']));
                        $occupation = strtoupper(trim($_POST['occupation']));
                        $employerbusinessname = strtoupper(trim($_POST['employerbusinessname']));
                        $monthlyincome = str_replace(',', '', trim($_POST['monthlyincome']));
                        $employementstatus = strtoupper(trim($_POST['employementstatus']));

                        // Check Profile Attachment
                        if(!empty($profilepicture)){
                            $profilefileextension = pathinfo($profilepicture, PATHINFO_EXTENSION);
                            $profilefileextensionlw = strtolower($profilefileextension);

                            // Use WebP extension
                            $profilename = $rresidentidnumber.'('.date("ymdHis").')'.'.webp';
                            $file_path = "../storage/residents/";

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
                                    header("Location: viewresident?r=$hashFromURL&notification=residenterrorimagetype");
                                    exit();
                            }

                            // Save as WebP (replaces move_uploaded_file)
                            imagewebp($image, $file_path.$profilename, 80);
                            imagedestroy($image);

                            $profile = $profilename;
                        }else{
                            $profile = $rprofilepicture;
                        }

                        $stmtUpdate = $connection->prepare(
                            "UPDATE `rpms_residents` SET `resident_HouseRole`= ?,`resident_ResidentStatus`= ?,`resident_ProfilePicture`= ?,`resident_FirstName`= ?,`resident_MiddleName`= ?,`resident_LastName`= ?,`resident_Suffix`= ?,`resident_DateofBirth`= ?,`resident_Age`= ?, `resident_Gender`= ?,`resident_StreetPurok`= ?,`resident_Barangay`= ?,`resident_Municipality`= ?,`resident_Province`= ?,`resident_CivilStatus`= ?,`resident_Religion`= ?,`resident_Nationality`= ?,`resident_ContactNumber`= ?,`resident_EmailAddress`= ?,`resident_EducationAttainment`= ?,`resident_Height`= ?,`resident_Weight`= ?,`resident_BloodType`= ?,`resident_ParentStatus`= ?,`resident_PWD`= ?,`resident_Fourps`= ?,`resident_Indigenous`= ?,`resident_VoterStatus`= ?,`resident_IDType`= ?, `resident_IDTypeNumber`= ?,`resident_Occupation`= ?,`resident_EmployerBusinessName`= ?,`resident_MonthlyIncome`= ?,`resident_EmployerStatus`= ?, `resident_LastModified`= ? WHERE `resident_ID` = ?"
                        );
                        $stmtUpdate->bind_param(
                            "ssssssssissssssssssssdssiiisssssissi", 
                            $householdrole, 
                            $residentstatus,
                            $profile,
                            $firstname, 
                            $middlename, 
                            $lastname, 
                            $suffix, 
                            $dateofbirth,
                            $age, 
                            $gender,
                            $streetpurok,
                            $barangay,
                            $municipality,
                            $province,
                            $civilstatus,
                            $religion,
                            $nationality,
                            $contactnumber,
                            $emailaddress,
                            $educationalattainment,
                            $height,
                            $weight,
                            $bloodtype,
                            $parentstatus,
                            $pwd,
                            $fourps,
                            $indigenous,
                            $voterstatus,
                            $idtype,
                            $idnumber,
                            $occupation,
                            $employerbusinessname,
                            $monthlyincome,
                            $employementstatus,
                            $lastmodified,
                            $resident);
                        if ($stmtUpdate->execute()) {
                            // Create User Logs
                            $userid = $id;
                            $action = "UPDATE";
                            $module = "RESIDENT MANAGEMENT";
                            $recordid = $rid;
                            $description = "USER UPDATED RESIDENT INFORMATION FOR RESIDENT {$rresidentidnumber} IN HOUSEHOLD {$hhouseholdidnumber}";
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

                            header("Location: viewresident?r=$hashFromURL&notification=residentinformationupdated");
                            exit();
                        } else {
                            header("Location: viewresident?r=$hashFromURL&notification=residentinformationerror");
                            exit();
                        }
                        $stmtUpdate->close();   
                    }

                    // Get Default Census Record
                    $getdefaultcensusrecord = mysqli_query($connection, "SELECT * FROM `rpms_censusconfig` WHERE `censusconfig_Appointed` = '$appointed'");
                    $resultdefaultcensusrecord = mysqli_fetch_assoc($getdefaultcensusrecord);
                    $censustype = $resultdefaultcensusrecord['censusconfig_Type'];
                    $censusyear = $resultdefaultcensusrecord['censusconfig_Year'];
                    $censuscontext = $resultdefaultcensusrecord['censusconfig_Context'];
                    $censusname = $resultdefaultcensusrecord['censusconfig_Name'];

                    // Add Census Record
                    if(isset($_POST['addcensusrecord'])){
                        $created = date("Y-m-d H:i:s");
                        $currentyear = date("Y");
                        $currentyearmonth = date("Y-m");
                        $censusrecordtype = $censustype;
                        $censusyear = $censusyear;
                        $censusname = $censusname;

                        if($censusrecordtype == 'SPECIAL'){
                            switch ($censuscontext) {
                                case 'DISASTER-RELATED':
                                    // DISASTER-RELATED
                                    $ca = strtoupper(trim($_POST['censusaffected']));
                                    $cm = strtoupper(trim($_POST['censusmissing']));
                                    $cd = strtoupper(trim($_POST['censusdeceased']));
                                    $cdis = strtoupper(trim($_POST['censusdisplaced']));
                                    $cnma = strtoupper(trim($_POST['censusneedsmedicalattention']));
                                    $cnfa = strtoupper(trim($_POST['censusneedsfoodassistance']));
                                    $cns = strtoupper(trim($_POST['censusneedsshelter']));
                                    $cis = strtoupper(trim($_POST['censusinjurystatus']));
                                    $ccl = strtoupper(trim($_POST['censuscurrentlocation']));
                                    
                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residentdisasterrelated` WHERE `rdr_Year` = ? AND `rdr_Name` = ? AND `resident_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $resident);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rdrCreated = $censusRow['rdr_Created'];
                                        header("Location: viewresident?r=$hashFromURL&date=$rdrCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residentdisasterrelated");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_residentdisasterrelated AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_residentdisasterrelated`(`rdr_Created`,  `rdr_Year`, `rdr_Name`, `rdr_Affected`, `rdr_Missing`, `rdr_Deceased`, `rdr_Displaced`, `rdr_NeedsMedicalAttention`, `rdr_NeedsFoodAssistance`, `rdr_NeedsShelter`, `rdr_InjuryStatus`, `rdr_CurrentLocation`, `resident_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "ssssssssssssi", 
                                            $created,
                                            $censusyear,
                                            $censusname, 
                                            $ca,
                                            $cm, 
                                            $cd, 
                                            $cdis, 
                                            $cnma,  
                                            $cnfa, 
                                            $cns,
                                            $cis,
                                            $ccl,
                                            $resident);
                                        if($stmtInsert->execute()) {

                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "RESIDENT MANAGEMENT";
                                            $recordid = $rid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;
                                
                                case 'HEALTH EMERGENCY':
                                    // HEALTH EMERGENCY
                                    $chs = strtoupper(trim($_POST['censushassymptoms']));
                                    $cum = strtoupper(trim($_POST['censusundermonitoring']));
                                    $csd = strtoupper(trim($_POST['censussymptomdetails']));
                                    $cdd = strtoupper(trim($_POST['censusdiagnosedisease']));
                                    $cqs = strtoupper(trim($_POST['censusquarantinestatus']));
                                    $cvs = strtoupper(trim($_POST['censusvaccinationstatus']));
                                    $cdad = $_POST['censusdatediagnosed'];
                                    $crs = strtoupper(trim($_POST['censusrecoverystatus']));

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residenthealthemergency` WHERE `rhe_Year` = ? AND `rhe_Name` = ? AND `resident_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $resident);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rheCreated = $censusRow['rhe_Created'];
                                        header("Location: viewresident?r=$hashFromURL&date=$rheCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residenthealthemergency");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_residenthealthemergency AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_residenthealthemergency`(`rhe_Created`, `rhe_Year`, `rhe_Name`, `rhe_Symptoms`, `rhe_UnderMonitoring`, `rhe_SymptomDetails`, `rhe_DiagnosedDisease`, `rhe_QuarantineStatus`, `rhe_VaccinationStatus`, `rhe_DateDiagnosed`, `rhe_RecoveryStatus`, `resident_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssssssssssi", 
                                            $created,
                                            $censusyear, 
                                            $censusname,
                                            $chs,
                                            $cum, 
                                            $csd, 
                                            $cdd, 
                                            $cqs,  
                                            $cvs, 
                                            $cdad,
                                            $crs,
                                            $resident);
                                        if($stmtInsert->execute()) {

                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "RESIDENT MANAGEMENT";
                                            $recordid = $rid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                case 'LIVELIHOOD/ ECONOMIC IMPACT':
                                    // LIVELIHOOD/ ECONOMIC IMPACT
                                    $cles = strtoupper(trim($_POST['censuslemployementstatus']));
                                    $cjl = strtoupper(trim($_POST['censusjoblost']));
                                    $ctw = strtoupper(trim($_POST['censustypeofwork']));
                                    $clo = strtoupper(trim($_POST['censusloccupation']));
                                    $cmib = str_replace(',', '', trim($_POST['censusmonthlyincomebefore']));
                                    $cmif = str_replace(',', '', trim($_POST['censusmonthlyincomeafter']));
                                    $cba = strtoupper(trim($_POST['censusbusinessaffected']));
                                    $cnla = strtoupper(trim($_POST['censusneedlivelihoodassistance']));

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residentlivelihoodeconomicimpact` WHERE `rlhei_Year` = ? AND `rlhei_Name` = ? AND `resident_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $resident);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rlheiCreated = $censusRow['rlhei_Created'];
                                        header("Location: viewresident?r=$hashFromURL&date=$rlheiCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residentlivelihoodeconomicimpact");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_residentlivelihoodeconomicimpact AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_residentlivelihoodeconomicimpact`(`rlhei_Created`, `rlhei_Year`, `rlhei_Name`, `rlhei_EmploymentStatus`, `rlhei_JobLost`, `rlhei_TypeofWork`, `rlhei_Occupation`, `rlhei_MonthlyIncomeBefore`, `rlhei_MonthlyIncomeAfter`, `rlhei_BusinessAffected`, `rlhei_NeedsLivelihoodAssistance`, `resident_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssssssssssi", 
                                            $created, 
                                            $censusyear,
                                            $censusname,
                                            $cles,
                                            $cjl, 
                                            $ctw, 
                                            $clo, 
                                            $cmib,  
                                            $cmif, 
                                            $cba,
                                            $cnla,
                                            $resident);
                                        if($stmtInsert->execute()) {

                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "RESIDENT MANAGEMENT";
                                            $recordid = $rid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                case 'SOCIAL ASSISTANCE/ BENEFICIARY':
                                    // SOCIAL ASSISTANCE/ BENEFICIARY
                                    $cfb = strtoupper(trim($_POST['censusfourpsbeneficiary']));
                                    $csc = strtoupper(trim($_POST['censusseniorcitizen']));
                                    $cpwtd = strtoupper(trim($_POST['censuspersonwithdisability']));
                                    $csp = strtoupper(trim($_POST['censussoloparent']));
                                    $cefa = strtoupper(trim($_POST['censuseligibleforassistance']));
                                    $cat = strtoupper(trim($_POST['censusassistancetype']));
                                    $cas = strtoupper(trim($_POST['censusclaimstatus']));
                                    $car = str_replace(',', '', trim($_POST['censusamountreceived']));
                                    $cdr = $_POST['censusdatereceived'];

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residentsocialassistancebeneficiary` WHERE DATE_FORMAT(rsab_Created, '%Y-%m') = ? AND `resident_ID` = ?");
                                    $stmtCheck->bind_param("si", 
                                        $currentyearmonth,
                                        $resident);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rsabCreated = $censusRow['rsab_Created'];
                                        header("Location: viewresident?r=$hashFromURL&date=$rsabCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residentsocialassistancebeneficiary");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_residentsocialassistancebeneficiary AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_residentsocialassistancebeneficiary`(`rsab_Created`, `rsab_Year`, `rsab_Name`, `rsab_4PsBeneficiary`, `rsab_SeniorCitizen`, `rsab_PersonwithDisability`, `rsab_SoloParent`, `rsab_EligibleforAssistance`, `rsab_AssistanceType`, `rsab_ClaimStatus`, `rsab_AmountReceived`, `rsab_DateReceived`, `resident_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "ssssssssssssi", 
                                            $created,
                                            $censusyear, 
                                            $censusname,
                                            $cfb,
                                            $csc, 
                                            $cpwtd, 
                                            $csp, 
                                            $cefa,  
                                            $cat, 
                                            $cas,
                                            $car,
                                            $cdr,
                                            $resident);
                                        if($stmtInsert->execute()) {

                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "RESIDENT MANAGEMENT";
                                            $recordid = $rid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                default:
                                    // EDUCATION/ SCHOOL STATUS
                                    $cce = strtoupper(trim($_POST['censuscurrentlyenrolled']));
                                    $csn = strtoupper(trim($_POST['censusschoolname']));
                                    $cgl = strtoupper(trim($_POST['censusgradelevel']));
                                    $cmol = strtoupper(trim($_POST['censusmodeoflearning']));
                                    $cdo = strtoupper(trim($_POST['censusdroppedout']));
                                    $cnes = strtoupper(trim($_POST['censusneedseducationalsupport']));

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residenteducationschoolstatus` WHERE DATE_FORMAT(ress_Created, '%Y-%m') = ? AND `resident_ID` = ?");
                                    $stmtCheck->bind_param("si", 
                                        $currentyearmonth,
                                        $resident);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $ressCreated = $censusRow['ress_Created'];
                                        header("Location: viewresident?r=$hashFromURL&date=$ressCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residenteducationschoolstatus");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_residenteducationschoolstatus AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_residenteducationschoolstatus`(`ress_Created`, `ress_Year`, `ress_Name`,`ress_CurrentlyEnrolled`, `ress_SchoolName`, `ress_GradeLevel`, `ress_ModeofLearning`, `ress_DroppedOut`, `ress_NeedsEducationalSupport`, `resident_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssssssssi", 
                                            $created, 
                                            $censusyear, 
                                            $censusname, 
                                            $cce,
                                            $csn, 
                                            $cgl, 
                                            $cmol, 
                                            $cdo,  
                                            $cnes,
                                            $resident);
                                        if($stmtInsert->execute()) {

                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "RESIDENT MANAGEMENT";
                                            $recordid = $rid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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
                                            
                                            header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;
                            }
                        }else{
                            // ANNUAL/ MID-YEAR
                            $cea = strtoupper(trim($_POST['censuseducationalattainment']));
                            $cpwd = $_POST['censuspwd'];
                            $cfps = $_POST['censusfourps'];
                            $ces = strtoupper(trim($_POST['censusemployementstatus']));
                            $co = strtoupper(trim($_POST['censusoccupation']));
                            $cmi = str_replace(',', '', trim($_POST['censusmonthlyincome']));

                            // Check Record
                            $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residentcensus` WHERE `rc_Year` = ? AND `rc_Census` = ? AND `resident_ID` = ?");
                            $stmtCheck->bind_param("ssi", 
                                $censusyear,
                                $censusrecordtype,
                                $resident);
                            $stmtCheck->execute();
                            $resultCheck = $stmtCheck->get_result();
                            if($resultCheck->num_rows > 0){
                                $censusRow = $resultCheck->fetch_assoc();
                                $rcCreated = $censusRow['rc_Created'];
                                header("Location: viewresident?r=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                exit();
                            }else{
                                // Auto Increment Table
                                $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_residentcensus");
                                $row = $stmtCheck->fetch_assoc();
                                if ($row['checktable'] == 0) {
                                    $connection->query("ALTER TABLE rpms_residentcensus AUTO_INCREMENT = 1");
                                }

                                // Insert Census Record
                                $stmtInsert = $connection->prepare("
                                    INSERT INTO `rpms_residentcensus`(`rc_Created`, `rc_Year`, `rc_Census`, `rc_EducationAttainment`, `rc_PWD`, `rc_Fourps`, `rc_Occupation`, `rc_MonthlyIncome`, `rc_EmployerStatus`, `resident_ID`) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                ");
                                $stmtInsert->bind_param(
                                    "sssssssssi", 
                                    $created, 
                                    $censusyear, 
                                    $censusrecordtype,
                                    $cea, 
                                    $cpwd, 
                                    $cfps, 
                                    $co,  
                                    $cmi, 
                                    $ces,
                                    $resident);
                                $stmtInsert->execute();
                                $stmtInsert->close();

                                // Update Resident Details
                                $stmtUpdate = $connection->prepare(
                                    "UPDATE `rpms_residents` SET `resident_EducationAttainment`= ?, `resident_PWD`= ?,`resident_Fourps`= ?, `resident_Occupation`= ?,`resident_MonthlyIncome`= ?,`resident_EmployerStatus`= ?, `resident_LastModified`= ? WHERE `resident_ID` = ?");
                                $stmtUpdate->bind_param(
                                    "sssssssi", 
                                    $cea, 
                                    $cpwd,
                                    $cfps,
                                    $co,  
                                    $cmi, 
                                    $ces,
                                    $created,
                                    $resident);
                                if ($stmtUpdate->execute()) {

                                    // Create User Logs
                                    $userid = $id;
                                    $action = "CREATE";
                                    $module = "RESIDENT MANAGEMENT";
                                    $recordid = $rid;
                                    $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                    header("Location: viewresident?r=$hashFromURL&notification=censusrecorded");
                                    exit();
                                }else{
                                    header("Location: viewresident?r=$hashFromURL&notification=errorcensusrecorded");
                                    exit();
                                }
                                $stmtUpdate->close();
                            }
                            $stmtCheck->close();
                        }
                    }

                    // Delete Resident
                    if (isset($_GET['deleteresident'])) {
                        $hashFromURL = $_GET['deleteresident'];
                        $sql = "SELECT * FROM rpms_residents";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $checkHash = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                            if ($checkHash === $hashFromURL) {
                                $resident = $row['resident_ID'];
                                $stmtDelete = $connection->prepare(
                                    "DELETE FROM `rpms_residents` WHERE `resident_ID` = ?"
                                );
                                $stmtDelete->bind_param("i", $resident);
                                if ($stmtDelete->execute()) {
                                    // Create User Logs
                                    $userid = $id;
                                    $action = "DELETE";
                                    $module = "RESIDENT MANAGEMENT";
                                    $recordid = $rid;
                                    $description = "USER DELETED RESIDENT {$rresidentidnumber} FROM HOUSEHOLD {$hhouseholdidnumber}";
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

                                    header("Location: residents?notification=residentdeleted");
                                    exit();
                                } else {
                                    header("Location: viewresident?r=$hashFromURL&notification=residentdeleteerror");
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