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

    // Vendor
    require '../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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

    // Get System API Email
    $stmtSAPIE = $connection->prepare("SELECT setting_Value FROM rpms_settings WHERE setting_Key = 'system_api_email'");
    $stmtSAPIE->execute();
    $resultSAPIE = $stmtSAPIE->get_result();
    $systemapiemail = $resultSAPIE->fetch_assoc()['setting_Value'];
    
	// Random Password Generator
    function randomPassword($length = 5) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Assigned Barangay
    $getassignedbarangay = "SELECT * FROM rpms_barangays ORDER BY barangay_Name ASC;";
    $resultassignedbarangay = mysqli_query($connection, $getassignedbarangay);

    // Add New Account
        if(isset($_POST['submit'])){
            $registered = date("Y-m-d H:i:s");
            $profile = "Default.png";
            $firstname = strtoupper(trim($_POST['firstname']));
            $middlename = strtoupper(trim($_POST['middlename']));
            $lastname = strtoupper(trim($_POST['lastname']));
            $emailaddress = strtolower(trim($_POST['emailaddress']));
            $contactnumber = trim($_POST['contactnumber']);
            $username = trim($_POST['username']);
            $temporarypassword = $_POST['temporarypassword'];
            $hashedPassword = password_hash($temporarypassword, PASSWORD_DEFAULT);
            $userrole = (int)$_POST['userrole'];
            $assignedbarangay = strtoupper(trim($_POST['assignedbarangay']));
            if ($userrole == 1) {
                $appointed = "MAIN OFFICE";
            } else {
                $appointed = strtoupper($assignedbarangay);
            }
            $status = 1;
            $censustype = 'ANNUAL';
            $censuryear = date("Y");
            
            // Check Username
            $stmtCheck = $connection->prepare("SELECT * FROM rpms_users WHERE user_Username = ?");
            $stmtCheck->bind_param("s", $username);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
            if($resultCheck->num_rows > 0){
                header("Location: createnewaccount?notification=usernameexist");
                exit();
            }else{
                // Check Email
                $stmtCheck = $connection->prepare("SELECT * FROM rpms_users WHERE user_EmailAddress = ?");
                $stmtCheck->bind_param("s", $emailaddress);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();
                if($resultCheck->num_rows > 0){
                    header("Location: createnewaccount?notification=useremailexist");
                    exit();
                }else{
                    if($appointed != 1){
                        // Check Config
                        $stmtCheck = $connection->prepare("SELECT * FROM `rpms_censusconfig` WHERE `censusconfig_Appointed`= ? LIMIT 1");
                        $stmtCheck->bind_param("s", $appointed);
                        $stmtCheck->execute();
                        $resultCheck = $stmtCheck->get_result();
                        if($resultCheck->num_rows == 0){
                            $stmtCount = $connection->query("SELECT COUNT(*) as checktable FROM rpms_censusconfig");
                            $row = $stmtCount->fetch_assoc();
                            if ($row['checktable'] == 0) {
                                $connection->query("ALTER TABLE rpms_censusconfig AUTO_INCREMENT = 1");
                            }
                            // Insert new appointment
                            $stmtInsert = $connection->prepare("
                                INSERT INTO `rpms_censusconfig`(`censusconfig_Appointed`, `censusconfig_Type`, `censusconfig_Year`) VALUES (?, ?, ?)
                            ");
                            $stmtInsert->bind_param("sss", $appointed, $censustype, $censuryear);
                            $stmtInsert->execute();
                            $stmtInsert->close();
                        }
                        $resultCheck->close();
                        $stmtCheck->close();
                    }

                    // PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'drpcmstechnicalsupport@gmail.com';
                        $mail->Password = $systemapiemail;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('drpcmstechnicalsupport@gmail.com', 'DRPCMS Technical Support');
                        $mail->addAddress($emailaddress);
                        $mail->addReplyTo('drpcmstechnicalsupport@gmail.com', 'Technical Support');

                        $fullname = $firstname . ' ' . ($middlename ? $middlename . ' ' : '') . $lastname;
                        $systemLink = "http://localhost/eRPMS";

                        $mail->isHTML(true);
                        $mail->Subject = 'Your Account Credentials for Digital Resident Profiling and Census Management System (DRPCMS)';

                        $mail->Body = "
                        <div style='font-family:Arial,sans-serif; font-size:14px; color:#333; line-height:1.6; background:#f4f6f9; padding:20px;'>

                            <div style='max-width:600px; margin:0 auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e0e0e0;'>

                                <!-- Header -->
                                <div style='background:#2c3e50; padding:20px; text-align:center;'>
                                    <h2 style='color:#ffffff; margin:0; font-size:16px;'>
                                        Digital Resident Profiling and Census Management System (DRPCMS)
                                    </h2>
                                    <p style='color:#dcdcdc; margin:5px 0 0; font-size:12px;'>
                                        Account Creation Notification
                                    </p>
                                </div>

                                <!-- Body -->
                                <div style='padding:20px;'>

                                    <p style='margin-top:0;'>Dear <b>{$fullname}</b>,</p>

                                    <p>
                                        Your account has been successfully created in the
                                        <b>Digital Resident Profiling and Census Management System (DRPCMS)</b>.
                                    </p>

                                    <p>Below are your login credentials:</p>

                                    <!-- Credentials Box -->
                                    <div style='background:#f8f9fc; border:1px solid #e1e5ea; border-radius:8px; padding:15px; margin-top:10px;'>

                                        <p style='margin:5px 0;'>
                                            <b>Username:</b> {$username}
                                        </p>

                                        <p style='margin:5px 0;'>
                                            <b>Password:</b> {$temporarypassword}
                                        </p>

                                    </div>

                                    <!-- Button -->
                                    <div style='text-align:center; margin-top:20px;'>
                                        <a href='{$systemLink}'
                                            style='display:inline-block; background:#007bff; color:#fff; padding:12px 22px; text-decoration:none; border-radius:6px; font-weight:bold;'>
                                            Login to DRPCMS
                                        </a>
                                    </div>

                                    <p style='margin-top:20px; font-size:12px; color:#777;'>
                                        For security reasons, please change your password after your first login.
                                    </p>

                                </div>

                                <!-- Footer -->
                                <div style='background:#f1f1f1; padding:12px; text-align:center; font-size:11px; color:#666;'>
                                    This is an automated message from the Digital Resident Profiling and Census Management System (DRPCMS).
                                    Please do not reply.
                                </div>

                            </div>

                        </div>
                        ";

                        $mail->AltBody = "DRPCMS Account Created. Username: $username Password: $temporarypassword Login: $systemLink";
                        $mail->send();

                        // Auto Increment Table
                        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_users");
                        $row = $stmtCheck->fetch_assoc();
                        if ($row['checktable'] == 0) {
                            $connection->query("ALTER TABLE rpms_users AUTO_INCREMENT = 1");
                        }
                        // Insert User Account
                        $stmtInsert = $connection->prepare("
                            INSERT INTO rpms_users
                            (user_Registered, user_ProfilePicture, user_FirstName, user_MiddleName, user_LastName,
                             user_EmailAddress, user_ContactNumber, user_Username, user_Password, user_Appointed, user_Role, user_Status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $stmtInsert->bind_param(
                            "ssssssssssii", 
                            $registered, 
                            $profile, 
                            $firstname, 
                            $middlename, 
                            $lastname, 
                            $emailaddress, 
                            $contactnumber, 
                            $username, 
                            $hashedPassword, 
                            $appointed, 
                            $userrole, 
                            $status);
                        if($stmtInsert->execute()){
                            $userlastid = $connection->insert_id;
                            // Create User Logs
                            $userid = $id;
                            $action = "CREATE";
                            $module = "USER MANAGEMENT";
                            $recordid = $userlastid;
                            $description = "USER CREATED A NEW USER ACCOUNT ".$firstname." ".$middlename." ".$lastname;
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

                            header("Location: createnewaccount?notification=useraccountcreated");
                            exit();
                        }else{
                            header("Location: createnewaccount?notification=useraccounterror");
                            exit();
                        }
                        $stmtInsert->close();

                    } catch (Exception $e) {

                        header("Location: createnewaccount?notification=useraccounterror");
                        exit();

                    }
                }
                $stmtCheck->close();
            }
            $stmtCheck->close();
        }

    // User Accounts
        $userlimit = 10; // Number of records per page
        $userpage = isset($_GET['userpage']) ? (int)$_GET['userpage'] : 1;
        if ($userpage < 1) $userpage = 1;
        $userstart = ($userpage - 1) * $userlimit;

        $whereUser = "";
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $whereUser = "WHERE `user_FirstName` = '$username'";
        }elseif(isset($_GET['userrole'])) {
            $userrole = $_GET['userrole'];
            switch ($userrole) {
                case 'Administrator':
                    $whereUser = "WHERE `user_Role` = 1";
                    break;
                default:
                    $whereUser = "WHERE `user_Role` = 2";
                    break;
            }
        }elseif(isset($_GET['userstatus'])){
            $userstatus = $_GET['userstatus'];
            switch ($userstatus) {
                case 'Active':
                    $whereUser = "WHERE `user_Status` = 1";
                    break;
                default:
                    $whereUser = "WHERE `user_Status` = 0";
                    break;
            }
        }

        // Count User Entries
        $getcountuser = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_users $whereUser");
        $resultcountuser = mysqli_fetch_assoc($getcountuser);
        $totaluserentries = $resultcountuser['total'];
        $totaluserpages = ceil($totaluserentries / $userlimit);

        // Get All User
        $getallusers = "SELECT * FROM rpms_users $whereUser ORDER BY `user_Registered` ASC LIMIT $userstart, $userlimit";
        $resultallusers = mysqli_query($connection, $getallusers);

    // Count User Account Entries
        $getcountusers = "SELECT COUNT(*) AS totaluserentries FROM rpms_users";
        $resultcountusers = mysqli_query($connection, $getcountusers);
        $userentries = mysqli_fetch_assoc($resultcountusers)['totaluserentries'];
        $totaluserentries = number_format($userentries);

    // Get User Information
        if(isset($_GET['u'])){
            $hashFromURL = $_GET['u'];
            $sql = "SELECT * FROM rpms_users";
            $result = mysqli_query($connection, $sql);
            $userID = null;
            while ($row = mysqli_fetch_assoc($result)) {
                $checkHash = hash('sha256', $row['user_ID'] . 'SECRET_KEY');
                if ($checkHash === $hashFromURL) {
                    $user = $row['user_ID'];

                    // Get User Information
                    $stmtUser = $connection->prepare(
                        "SELECT * FROM rpms_users WHERE user_ID = ?"
                    );
                    $stmtUser->bind_param("i", $user);
                    $stmtUser->execute();
                    $resultUser = $stmtUser->get_result();
                    if ($userRow = $resultUser->fetch_assoc()) {
                        $uid = $userRow['user_ID'];
                        $ufirstname = $userRow['user_FirstName'];
                        $umiddlename = $userRow['user_MiddleName'];
                        $ulastname = $userRow['user_LastName'];
                        $uemailaddress = $userRow['user_EmailAddress'];
                        $ucontactnumber = $userRow['user_ContactNumber'];
                        $uusername = $userRow['user_Username'];
                        $uappointed = $userRow['user_Appointed'];
                        $urole = $userRow['user_Role'];
                        $ustatus = $userRow['user_Status'];
                    }

                    // Update Password
                    if (isset($_POST['updatepassword'])) {
                        $lastmodified = date("Y-m-d H:i:s");
                        $password = $_POST['password'];
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // PHPMailer
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'drpcmstechnicalsupport@gmail.com';
                            $mail->Password = $systemapiemail;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom('drpcmstechnicalsupport@gmail.com', 'DRPCMS Technical Support');
                            $mail->addAddress($uemailaddress);
                            $mail->addReplyTo('drpcmstechnicalsupport@gmail.com', 'Technical Support');

                            $fullname = $ufirstname . ' ' . ($umiddlename ? $umiddlename . ' ' : '') . $ulastname;
                            $systemLink = "http://localhost/eRPMS";

                            $mail->isHTML(true);
                            $mail->Subject = 'Your Account Password Has Been Reset for Digital Resident Profiling and Census Management System (DRPCMS)';

                            $mail->Body = "
                            <div style='font-family:Arial,sans-serif; font-size:14px; color:#333; line-height:1.6; background:#f4f6f9; padding:20px;'>

                                <div style='max-width:600px; margin:0 auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e0e0e0;'>

                                    <!-- Header -->
                                    <div style='background:#2c3e50; padding:20px; text-align:center;'>
                                        <h2 style='color:#ffffff; margin:0; font-size:16px;'>
                                            Digital Resident Profiling and Census Management System (DRPCMS)
                                        </h2>
                                        <p style='color:#dcdcdc; margin:5px 0 0; font-size:12px;'>
                                            Temporary Password Notification
                                        </p>
                                    </div>

                                    <!-- Body -->
                                    <div style='padding:20px;'>

                                        <p style='margin-top:0;'>Dear <b>{$fullname}</b>,</p>

                                        <p>
                                            Your account password has been reset. A temporary password has been generated for your
                                            <b>DRPCMS</b> account.
                                        </p>

                                        <p>
                                            Please use the credentials below to log in:
                                        </p>

                                        <!-- Credentials Box -->
                                        <div style='background:#f8f9fc; border:1px solid #e1e5ea; border-radius:8px; padding:15px; margin-top:10px;'>

                                            <p style='margin:5px 0;'>
                                                <b>Username:</b> {$uusername}
                                            </p>

                                            <p style='margin:5px 0;'>
                                                <b>Temporary Password:</b> {$password}
                                            </p>

                                        </div>

                                        <!-- Button -->
                                        <div style='text-align:center; margin-top:25px;'>
                                            <a href='{$systemLink}'
                                                style='display:inline-block; background:#007bff; color:#fff; padding:12px 22px; text-decoration:none; border-radius:6px; font-weight:bold;'>
                                                Login to DRPCMS
                                            </a>
                                        </div>

                                        <p style='margin-top:20px; font-size:12px; color:#777;'>
                                            For security reasons, you are required to change your password immediately after logging in.
                                        </p>

                                    </div>

                                    <!-- Footer -->
                                    <div style='background:#f1f1f1; padding:12px; text-align:center; font-size:11px; color:#666;'>
                                        This is an automated message from the Digital Resident Profiling and Census Management System (DRPCMS).
                                        Please do not reply.
                                    </div>

                                </div>

                            </div>
                            ";

                            $mail->AltBody = "DRPCMS Account Created. Username: $uusername Password: $password Login: $systemLink";
                            $mail->send();

                            $stmtUpdate = $connection->prepare(
                                "UPDATE rpms_users SET user_Password = ?, user_LastModified = ? WHERE user_ID = ?"
                            );
                            $stmtUpdate->bind_param(
                                "ssi", 
                                $hashedPassword, 
                                $lastmodified, 
                                $user);
                            if ($stmtUpdate->execute()) {
                                // Create User Logs
                                $userid = $id;
                                $action = "UPDATE";
                                $module = "USER MANAGEMENT";
                                $recordid = $uid;
                                $description = "USER UPDATED PASSWORD FOR USER ACCOUNT ".$ufirstname." ".$umiddlename." ".$ulastname;
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

                                header("Location: viewuseraccount?u=$hashFromURL&notification=userpasswordupdated");
                                exit();
                            } else {
                                header("Location: viewuseraccount?u=$hashFromURL&notification=userpassworderror");
                                exit();
                            }
                            $stmtUpdate->close();

                        } catch (Exception $e) {

                            header("Location: createnewaccount?notification=useraccounterror");
                            exit();

                        }
                    }

                    // Update User Information
                    if (isset($_POST['updateinformation'])) {
                        $lastmodified = date("Y-m-d H:i:s");
                        $firstname = strtoupper(trim($_POST['firstname']));
                        $middlename = strtoupper(trim($_POST['middlename']));
                        $lastname = strtoupper(trim($_POST['lastname']));
                        $contactnumber = trim($_POST['contactnumber']);
                        $userrole = (int)$_POST['userrole'];
                        $assignedbarangay = strtoupper(trim($_POST['assignedbarangay']));
                        if (empty($assignedbarangay)) {
                            $appointed = "MAIN OFFICE";
                        } else {
                            $appointed = strtoupper($assignedbarangay);
                        }
                        $status = $_POST['status'];
                        if($status == 0){
                            $accountstatus = 0;
                        }else{
                            $accountstatus = 1;
                        }
                        $stmtUpdate = $connection->prepare(
                            "UPDATE rpms_users SET user_FirstName = ?,user_MiddleName= ?,user_LastName= ?,user_ContactNumber= ?,user_Appointed= ?,user_Role= ?, user_Status = ?, user_LastModified= ? WHERE user_ID = ?"
                        );
                        $stmtUpdate->bind_param(
                            "sssssiiss", 
                            $firstname, 
                            $middlename, 
                            $lastname, 
                            $contactnumber, 
                            $appointed, 
                            $userrole, 
                            $accountstatus, 
                            $lastmodified, 
                            $user);
                        if ($stmtUpdate->execute()) {
                            // Create User Logs
                            $userid = $id;
                            $action = "UPDATE";
                            $module = "USER MANAGEMENT";
                            $recordid = $uid;
                            $description = "USER UPDATED INFORMATION FOR USER ACCOUNT ".$ufirstname." ".$umiddlename." ".$ulastname;
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

                            header("Location: viewuseraccount?u=$hashFromURL&notification=userinformationupdated");
                            exit();
                        } else {
                            header("Location: viewuseraccount?u=$hashFromURL&notification=userinformationerror");
                            exit();
                        }
                        $stmtUpdate->close();
                    }
                }
            }
        }

    // Delete User
        if (isset($_GET['deleteuser'])) {
            $hashFromURL = $_GET['deleteuser'];
            $sql = "SELECT * FROM rpms_users";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $checkHash = hash('sha256', $row['user_ID'] . 'SECRET_KEY');
                if ($checkHash === $hashFromURL) {
                    $user = $row['user_ID'];

                    // Get User Information
                    $stmtUser = $connection->prepare(
                        "SELECT * FROM rpms_users WHERE user_ID = ?"
                    );
                    $stmtUser->bind_param("i", $user);
                    $stmtUser->execute();
                    $resultUser = $stmtUser->get_result();
                    if ($userRow = $resultUser->fetch_assoc()) {
                        $uid = $userRow['user_ID'];
                        $ufirstname = $userRow['user_FirstName'];
                        $umiddlename = $userRow['user_MiddleName'];
                        $ulastname = $userRow['user_LastName'];
                        $uemailaddress = $userRow['user_EmailAddress'];
                        $ucontactnumber = $userRow['user_ContactNumber'];
                        $uusername = $userRow['user_Username'];
                        $uappointed = $userRow['user_Appointed'];
                        $urole = $userRow['user_Role'];
                        $ustatus = $userRow['user_Status'];
                    }

                    $stmtDelete = $connection->prepare(
                        "DELETE FROM rpms_users WHERE user_ID = ?"
                    );
                    $stmtDelete->bind_param("i", $user);
                    if ($stmtDelete->execute()) {
                        // Create User Logs
                            $userid = $id;
                            $action = "DELETE";
                            $module = "USER MANAGEMENT";
                            $recordid = $uid;
                            $description = "USER DELETED USER ACCOUNT ".$ufirstname." ".$umiddlename." ".$ulastname;
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

                        header("Location: useraccounts?notification=userdeleted");
                        exit();
                    } else {
                        header("Location: viewuseraccount?u=$hashFromURL&notification=userdeleteerror");
                        exit();
                    }
                    $stmtDelete->close();
                }
            }
        }
?>