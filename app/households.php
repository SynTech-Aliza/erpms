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

    // Count Household Registered
        $getcounthouseholdregistered = "SELECT COUNT(*) as totalhouseholds FROM `rpms_households` WHERE `household_Barangay` = '$appointed'";
        $resultcounthouseholdregistered = mysqli_query($connection, $getcounthouseholdregistered);
        $totalhouseholds = mysqli_fetch_assoc($resultcounthouseholdregistered)['totalhouseholds']+1;
        $totalhouseholdsformat = str_pad($totalhouseholds, 6, "0", STR_PAD_LEFT);
    
    // Output Household ID Number
    $idnumberhousehold = "HH".$barangayInitials.date("Y").$totalhouseholdsformat;
    
    // Output Residents ID Number
    $idnumberresidents = "R".$barangayInitials.date("Y").mt_rand(1, 9999);

    // Add New Household
        if(isset($_POST['submit'])){
            $registered = date("Y-m-d H:i:s");
            $householdidnumber = $idnumberhousehold;
            $streetpurok = strtoupper(trim($_POST['streetpurok']));
            $barangay = strtoupper(trim($_POST['barangay']));
            $municipality = strtoupper(trim($_POST['municipality']));
            $province = strtoupper(trim($_POST['province']));
            $type = strtoupper(trim($_POST['type']));
            $size = strtoupper(trim($_POST['size']));
            $condition = strtoupper(trim($_POST['condition']));
            $utilitiesarray = implode(", ", $_POST['utilities']);
            $utilities = strtoupper(trim($utilitiesarray));
            $facilitiesarray = implode(", ", $_POST['facilities']);
            $facilities = strtoupper(trim($facilitiesarray));
            $profile = 'Default.png';
            $firstname = strtoupper(trim($_POST['firstname']));
            $middlename = strtoupper(trim($_POST['middlename']));
            $lastname = strtoupper(trim($_POST['lastname']));
            $suffix = strtoupper(trim($_POST['suffix']));
            $dateofbith = $_POST['dateofbith']  ;
            $age = $_POST['age'];
            $gender = strtoupper(trim($_POST['gender']));
            $civilstatus = strtoupper(trim($_POST['civilstatus']));
            $houserole = 'HEAD OF HOUSEHOLD';
            $residentstatus = 'PERMANENT';

            // Check Household Head
            $stmtCheck = $connection->prepare("SELECT * FROM `rpms_residents` WHERE `resident_Barangay` = ? AND `resident_FirstName` = ? AND `resident_MiddleName` = ? AND `resident_LastName` = ? AND `resident_Suffix` = ?");
            $stmtCheck->bind_param("sssss", $barangay, $firstname, $middlename, $lastname, $suffix);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
            if($resultCheck->num_rows > 0){
                header("Location: createnewhousehold?notification=residentheadexist");
                exit();
            }else{ 
                // Auto Increment Table
                $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM `rpms_households`");
                $row = $stmtCheck->fetch_assoc();
                if ($row['checktable'] == 0) {
                    $connection->query("ALTER TABLE `rpms_households` AUTO_INCREMENT = 1");
                }
                // Insert Household
                $stmtInsert = $connection->prepare("
                    INSERT INTO `rpms_households`(`household_Registered`, `household_IDNumber`, `household_StreetPurok`, `household_Barangay`, `household_Municipality`, `household_Province`, `household_Type`, `household_Size`, `household_Condition`, `household_Utilities`, `household_Facilities`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmtInsert->bind_param(
                    "sssssssssss", 
                    $registered, 
                    $householdidnumber, 
                    $streetpurok, 
                    $barangay, 
                    $municipality, 
                    $province , 
                    $type, 
                    $size, 
                    $condition, 
                    $utilities, 
                    $facilities);
                if($stmtInsert->execute()){
                    $householdlastid = $connection->insert_id;
                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM `rpms_residents`");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE `rpms_residents` AUTO_INCREMENT = 1");
                    }
                    // Insert Resident
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_residents`(`resident_Registered`, `resident_IDNumber`, `resident_HouseRole`, `resident_ResidentStatus`, `resident_ProfilePicture`, `resident_FirstName`, `resident_MiddleName`, `resident_LastName`, `resident_Suffix`, `resident_DateofBirth`, `resident_Age`, `resident_Gender`, `resident_StreetPurok`, `resident_Barangay`, `resident_Municipality`, `resident_Province`, `resident_CivilStatus`, `household_ID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ssssssssssssssssss", 
                        $registered, 
                        $idnumberresidents, 
                        $houserole, 
                        $residentstatus,
                        $profile,
                        $firstname, 
                        $middlename , 
                        $lastname, 
                        $suffix, 
                        $dateofbith, 
                        $age, 
                        $gender, 
                        $streetpurok, 
                        $barangay, 
                        $municipality, 
                        $province,
                        $civilstatus,
                        $householdlastid);
                    if($stmtInsert->execute()){
                        // Create User Logs
                        $userid = $id;
                        $action = "CREATE";
                        $module = "HOUSEHOLD MANAGEMENT";
                        $recordid = $householdlastid;
                        $description = "USER CREATED A NEW HOUSEHOLD RECORD FOR {$householdidnumber}";
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

                        header("Location: createnewhousehold?notification=householdcreated");
                        exit();
                    }else{
                        header("Location: createnewhousehold?notification=householderror");
                        exit();
                    }
                    $stmtInsert->close();
                }else{
                    header("Location: createnewhousehold?notification=householderror");
                    exit();
                }
                $stmtInsert->close();
            } 
        }

    // Filter Purok
        $getbarangaypurokfilter = "SELECT `household_StreetPurok` FROM `rpms_households` WHERE `household_Barangay` = '$appointed' GROUP BY `household_StreetPurok`";
        $resultbarangaypurokfilter = mysqli_query($connection, $getbarangaypurokfilter);

    // Household
        $householdlimit = 100; // Number of records per page
        $householdpage = isset($_GET['householdpage']) ? (int)$_GET['householdpage'] : 1;
        if ($householdpage < 1) $householdpage = 1;
        $householdstart = ($householdpage - 1) * $householdlimit;

        $whereHousehold = "WHERE household_Barangay = '$appointed'";
        if (isset($_POST['householdid']) && !empty($_POST['householdid'])) {
            $householdid = mysqli_real_escape_string($connection, $_POST['householdid']);
            $whereHousehold .= " AND household_StreetPurok = '$householdid'";
        }elseif(isset($_GET['purok'])){
            $purok = $_GET['purok'];
            $whereHousehold .= " AND household_StreetPurok = '$purok'";
        }elseif(isset($_GET['type'])){
            $type = $_GET['type'];
            $whereHousehold .= " AND household_Type = '$type'";
        }elseif(isset($_GET['size'])){
            $size = $_GET['size'];
            $whereHousehold .= " AND household_Size = '$size'";
        }elseif(isset($_GET['conditon'])){
            $conditon = $_GET['conditon'];
            $whereHousehold .= " AND household_Condition = '$conditon'";
        }

        // Count Household Entries
        $getcounthousehold = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_households $whereHousehold");
        $resultcounthousehold = mysqli_fetch_assoc($getcounthousehold);
        $thf = $resultcounthousehold['total'];
        $totalhouseholdpages = ceil($thf / $householdlimit);

        // Get All Household
        $getallhouseholds = "SELECT 
                h.household_ID,
                h.household_Registered,
                h.household_IDNumber,
                h.household_StreetPurok,
                h.household_Barangay,
                h.household_Municipality,
                h.household_Province,
                h.household_Type,
                h.household_Size,
                h.household_Condition,
                CONCAT_WS(' ', r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, NULLIF(r.resident_Suffix, 'N/A')) AS headofhousehold,
                (
                    SELECT COUNT(*)
                    FROM rpms_residents rr
                    WHERE rr.household_ID = h.household_ID
                ) AS totalresidents
            FROM rpms_households h
            LEFT JOIN rpms_residents r 
                ON h.household_ID = r.household_ID
                AND r.resident_HouseRole = 'HEAD OF HOUSEHOLD' $whereHousehold
            ORDER BY h.household_Registered ASC LIMIT $householdstart, $householdlimit";
        $resultallhouseholds = mysqli_query($connection, $getallhouseholds);

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
                        $householdhashID = hash('sha256', $hid. 'SECRET_KEY');
                        $hhouseholdidnumber = $householdRow['household_IDNumber'];
                        $hstreetpurok = $householdRow['household_StreetPurok'];
                        $hbarangay = $householdRow['household_Barangay'];
                        $hmunicipality = $householdRow['household_Municipality'];
                        $hprovince = $householdRow['household_Province'];
                        $htype = $householdRow['household_Type'];
                        $hsize = $householdRow['household_Size'];
                        $hcondition = $householdRow['household_Condition'];
                        $hutitliesarray = $householdRow['household_Utilities'];
                        $hutitlies = array_map('trim', explode(',', $hutitliesarray));
                        $hfacilitiesarray = $householdRow['household_Facilities'];
                        $hfacilities = array_map('trim', explode(',', $hfacilitiesarray));
                    }

                    // Update Household Information
                    if (isset($_POST['updateinformation'])) {
                        $lastmodified = date("Y-m-d H:i:s");
                        $streetpurok = strtoupper(trim($_POST['streetpurok']));
                        $type = strtoupper(trim($_POST['type']));
                        $size = strtoupper(trim($_POST['size']));
                        $condition = strtoupper(trim($_POST['condition']));
                        $utilitiesarray = implode(", ", $_POST['utilities']);
                        $utilities = strtoupper(trim($utilitiesarray));
                        $facilitiesarray = implode(", ", $_POST['facilities']);
                        $facilities = strtoupper(trim($facilitiesarray));
                        $stmtUpdate = $connection->prepare(
                            "UPDATE `rpms_households` SET `household_StreetPurok` = ?,`household_Type` = ?,`household_Size` = ?,`household_Condition` = ?,`household_Utilities` = ?,`household_Facilities` = ?,`household_LastModified` = ? WHERE `household_ID` = ?"
                        );
                        $stmtUpdate->bind_param(
                            "ssssssss", 
                            $streetpurok, 
                            $type, 
                            $size, 
                            $condition, 
                            $utilities, 
                            $facilities, 
                            $lastmodified, 
                            $household);
                        if ($stmtUpdate->execute()) {
                            // Create User Logs
                            $userid = $id;
                            $action = "UPDATE";
                            $module = "HOUSEHOLD MANAGEMENT";
                            $recordid = $hid;
                            $description = "USER UPDATED HOUSEHOLD INFORMATION FOR {$hhouseholdidnumber}";
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
                        
                            header("Location: viewhousehold?hh=$hashFromURL&notification=householdinformationupdated");
                            exit();
                        } else {
                            header("Location: viewhousehold?hh=$hashFromURL&notification=householdinformationerror");
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
                                    $cdoi = $_POST['censusdateofincident'];
                                    $cdl = strtoupper(trim($_POST['censusdamagelevel']));
                                    $chsl = $_POST['censushousestilllivable'];
                                    $cedc = str_replace(',', '', trim($_POST['censusestimateddamagecost']));
                                    $cnoam = $_POST['censusnumberofaffectedmembers'];
                                    $ce = $_POST['censusevacuated'];
                                    $cecn = strtoupper(trim($_POST['censusevacuationcentername']));
                                    $cns = $_POST['censusneedsshelter'];
                                    $cnrs = $_POST['censusneedrepairassistance'];

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householddisasterrelated` WHERE `hdr_Year` = ? AND `hdr_DisasterName` = ? AND `household_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $household);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rcCreated = $censusRow['hdr_Created'];
                                        header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householddisasterrelated");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_householddisasterrelated AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_householddisasterrelated`(`hdr_Created`, `hdr_Year`, `hdr_DisasterName`, `hdr_DateofIncident`, `hdr_DamageLevel`, `hdr_HouseStillLivable`, `hdr_EstimatedDamageCost`, `hdr_NumberofAffectedMembers`, `hdr_Evacuated`, `hdr_EvacuationCenterName`, `hdr_NeedsShelter`, `hdr_NeedsRepairAssistance`, `household_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssssiiiisiii", 
                                            $created, 
                                            $censusyear, 
                                            $censusname,
                                            $cdoi,
                                            $cdl, 
                                            $chsl, 
                                            $cedc, 
                                            $cnoam,
                                            $ce,
                                            $cecn,
                                            $cns,
                                            $cnrs,
                                            $household);
                                        if ($stmtInsert->execute()) {
                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "HOUSEHOLD MANAGEMENT";
                                            $recordid = $hid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                case 'HEALTH EMERGENCY':
                                    $chum = $_POST['censushouseholdundermonitoring']; // 1 0
                                    $cnsm = $_POST['censusnumberofsickmembers']; // Number
                                    $ctod = strtoupper(trim($_POST['censustypeofdisease'])); // Text
                                    $cqs = strtoupper(trim($_POST['censusquarantinestatus'])); // Text
                                    $csc = $_POST['censussanitationcondition']; // 1 0
                                    $catcw = $_POST['censusaccesstocleanwater']; // 1 0
                                    $cnma = $_POST['censusneedsmedicalassistance']; // 1 0

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householdhealthemergency` WHERE `hhe_Year` = ? AND `hhe_Name` = ? AND `household_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $household);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rcCreated = $censusRow['hhe_Created'];
                                        header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householdhealthemergency");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_householdhealthemergency AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_householdhealthemergency`(`hhe_Created`, `hhe_Year`, `hhe_Name`, `hhe_HouseholdUnderMonitoring`, `hhe_NumberofSickMembers`, `hhe_TypeofDisease`, `hhe_QuarantineStatus`, `hhe_SanitationCondition`, `hhe_AccesstoCleanWater`, `hhe_NeedsMedicalAssistance`, `household_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssisssiiis",
                                            $created, 
                                            $censusyear, 
                                            $censusname,
                                            $chum,
                                            $cnsm, 
                                            $ctod, 
                                            $cqs, 
                                            $csc,
                                            $catcw,
                                            $cnma,
                                            $household);
                                        if ($stmtInsert->execute()) {
                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "HOUSEHOLD MANAGEMENT";
                                            $recordid = $hid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                case 'LIVELIHOOD/ ECONOMIC IMPACT':
                                    $cmsoi = strtoupper(trim($_POST['censusmainsourceofincome']));
                                    $ccmib = str_replace(',', '', trim($_POST['censuscombinedmonthlyincomebefore']));
                                    $ccmia = str_replace(',', '', trim($_POST['censuscombinedmonthlyincomeafter']));
                                    $cnowm = $_POST['censusnumberofworkingmember'];
                                    $cnowu = $_POST['censusnumberofworkingunemployed'];
                                    $cnla = $_POST['censusneedslivelihoodassistance'];

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householdlivelihoodeconomicimpact` WHERE `hlhe_Year` = ? AND `hlhe_Name` = ? AND `household_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $household);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rcCreated = $censusRow['hlhe_Created'];
                                        header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householdlivelihoodeconomicimpact");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_householdlivelihoodeconomicimpact AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_householdlivelihoodeconomicimpact`(`hlhe_Created`, `hlhe_Year`, `hlhe_Name`, `hlhe_MainSourceofIncome`, `hlhe_CombinedMonthlyIncomeBefore`, `hlhe_CombinedMonthlyIncomeAfter`, `hlhe_NumberofWorkingMember`, `hlhe_NumberofWorkingUnemployed`, `hlhe_NeedsLivelihoodAssistance`, `household_ID`) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "ssssiiiiii",
                                            $created, 
                                            $censusyear, 
                                            $censusname,
                                            $cmsoi,
                                            $ccmib,
                                            $ccmia, 
                                            $cnowm, 
                                            $cnowu, 
                                            $cnla,
                                            $household);
                                        if ($stmtInsert->execute()) {
                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "HOUSEHOLD MANAGEMENT";
                                            $recordid = $hid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                case 'SOCIAL ASSISTANCE/ BENEFICIARY':
                                    $cfh = $_POST['censusfourpshousehold'];
                                    $ctem = $_POST['censustotaleligiblemembers'];
                                    $ctsc = $_POST['censustotalseniorcitizens'];
                                    $ctp = $_POST['censustotalpwds'];
                                    $ctsp = $_POST['censustotalsoloparents'];

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householdsocialassistancebeneficiary` WHERE `hsab_Year` = ? AND `hsab_Name` = ? AND `household_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $household);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rcCreated = $censusRow['hsab_Created'];
                                        header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householdsocialassistancebeneficiary");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_householdsocialassistancebeneficiary AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_householdsocialassistancebeneficiary`(`hsab_Created`, `hsab_Year`, `hsab_Name`, `hsab_4PsHousehold`, `hsab_TotalEligibleMembers`, `hsab_TotalSeniorCitizens`, `hsab_TotalPWDs`, `hsab_TotalSoloParents`, `household_ID`) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssiiiiii",
                                            $created, 
                                            $censusyear, 
                                            $censusname,
                                            $cfh,
                                            $ctem,
                                            $ctsc, 
                                            $ctp, 
                                            $ctsp, 
                                            $household);
                                        if ($stmtInsert->execute()) {
                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "HOUSEHOLD MANAGEMENT";
                                            $recordid = $hid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;

                                default:
                                    $cnsh = $_POST['censusnumberofstudentsinhousehold'];
                                    $cnce = $_POST['censusnumberofcurrentlyenrolled'];
                                    $cnsy = $_POST['censusnumberofoutofschollyouth'];
                                    $cai = $_POST['censusaccesstointernet'];
                                    $chgl = $_POST['censushasgadgetforlearning'];
                                    $cnes = $_POST['censusneedseducationalsupport'];

                                    // Check Record
                                    $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householdeducationschoolstatus` WHERE `hess_Year` = ? AND `hess_Name` = ? AND `household_ID` = ?");
                                    $stmtCheck->bind_param("ssi", 
                                        $censusyear,
                                        $censusname,
                                        $household);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();
                                    if($resultCheck->num_rows > 0){
                                        $censusRow = $resultCheck->fetch_assoc();
                                        $rcCreated = $censusRow['hess_Created'];
                                        header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                        exit();
                                    }else{
                                        // Auto Increment Table
                                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householdeducationschoolstatus");
                                        $row = $stmtCheck->fetch_assoc();
                                        if ($row['checktable'] == 0) {
                                            $connection->query("ALTER TABLE rpms_householdeducationschoolstatus AUTO_INCREMENT = 1");
                                        }

                                        // Insert Census Record
                                        $stmtInsert = $connection->prepare("
                                            INSERT INTO `rpms_householdeducationschoolstatus`(`hess_Created`, `hess_Year`, `hess_Name`, `hess_NumberofStudentsinHousehold`, `hess_NumberCurrentlyEnrolled`, `hess_NumberofOut-of-SchoolYouth`, `hess_AccesstoInternet`, `hess_HasGadgetsforLearning`, `hess_NeedsEducationalSupport`, `household_ID`)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                        ");
                                        $stmtInsert->bind_param(
                                            "sssiiiiiii",
                                            $created, 
                                            $censusyear, 
                                            $censusname,
                                            $cnsh,
                                            $cnce,
                                            $cnsy, 
                                            $cai, 
                                            $chgl, 
                                            $cnes,
                                            $household);
                                        if ($stmtInsert->execute()) {
                                            // Create User Logs
                                            $userid = $id;
                                            $action = "CREATE";
                                            $module = "HOUSEHOLD MANAGEMENT";
                                            $recordid = $hid;
                                            $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                            header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                            exit();
                                        }else{
                                            header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                            exit();
                                        }
                                        $stmtInsert->close();
                                    }
                                    $stmtCheck->close();
                                    break;
                            }
                        }else{
                            // ANNUAL/ MID-YEAR
                            $ct = strtoupper(trim($_POST['censustype']));
                            $cs = strtoupper(trim($_POST['censussize']));
                            $cc = strtoupper(trim($_POST['censuscondition']));
                            $cuarray = implode(", ", $_POST['censusutilities']);
                            $cu = strtoupper(trim($cuarray));
                            $cfarray = implode(", ", $_POST['censusfacilities']);
                            $cf = strtoupper(trim($cfarray));

                            // Check Record
                            $stmtCheck = $connection->prepare("SELECT * FROM `rpms_householdcensus` WHERE `hc_Year` = ? AND `hc_Census` = ? AND `household_ID` = ?");
                            $stmtCheck->bind_param("ssi", 
                                $censusyear,
                                $censusrecordtype,
                                $household);
                            $stmtCheck->execute();
                            $resultCheck = $stmtCheck->get_result();
                            if($resultCheck->num_rows > 0){
                                $censusRow = $resultCheck->fetch_assoc();
                                $rcCreated = $censusRow['hdr_Created'];
                                header("Location: viewhousehold?hh=$hashFromURL&date=$rcCreated&notification=censusrecordedexist");
                                exit();
                            }else{
                                // Auto Increment Table
                                $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_householdcensus");
                                $row = $stmtCheck->fetch_assoc();
                                if ($row['checktable'] == 0) {
                                    $connection->query("ALTER TABLE rpms_householdcensus AUTO_INCREMENT = 1");
                                }

                                // Insert Census Record
                                $stmtInsert = $connection->prepare("
                                    INSERT INTO `rpms_householdcensus`(`hc_Created`, `hc_Year`, `hc_Census`, `hc_Type`, `hc_Size`, `hc_Condition`, `hc_Utilities`, `hc_Facilities`, `household_ID`)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                ");
                                $stmtInsert->bind_param(
                                    "ssssssssi", 
                                    $created, 
                                    $censusyear, 
                                    $censusrecordtype,
                                    $ct,
                                    $cs, 
                                    $cc, 
                                    $cu, 
                                    $cf,
                                    $household);
                                $stmtInsert->execute();
                                $stmtInsert->close();
                                // Update Household Details
                                $stmtUpdate = $connection->prepare(
                                    "UPDATE `rpms_households` SET `household_Type`= ?,`household_Size`= ?,`household_Condition`= ?,`household_Utilities`= ?,`household_Facilities`= ?,`household_LastModified`= ? WHERE `household_ID` = ?");
                                $stmtUpdate->bind_param(
                                    "ssssssi", 
                                    $ct, 
                                    $cs, 
                                    $cc, 
                                    $cu, 
                                    $cf,
                                    $created,
                                    $household);
                                if ($stmtUpdate->execute()) {
                                    // Create User Logs
                                    $userid = $id;
                                    $action = "CREATE";
                                    $module = "HOUSEHOLD MANAGEMENT";
                                    $recordid = $hid;
                                    $description = "USER CREATE A {$censuscontext} CENSUS RECORD FOR HOUSEHOLD {$hhouseholdidnumber}";
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

                                    header("Location: viewhousehold?hh=$hashFromURL&notification=censusrecorded");
                                    exit();
                                }else{
                                    header("Location: viewhousehold?hh=$hashFromURL&notification=errorcensusrecorded");
                                    exit();
                                }
                                $stmtUpdate->close();
                            }
                            $stmtCheck->close();
                        }
                    }
                }
            }
        }
?>