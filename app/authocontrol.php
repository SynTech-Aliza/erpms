<?php
    include '../config/database.php';
    date_default_timezone_set('Asia/Manila');

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

    // Vendor
    require '../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Login
    if (isset($_POST['login'])) {
        session_start();
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $stmt = $connection->prepare(
            "SELECT * FROM rpms_users WHERE user_Username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            header("Location: login?notification=usernamenotfound");
            exit();
        }
        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['user_Password'])) {
            header("Location: login?notification=invalidpassword");
            exit();
        }
        if ($user['user_Status'] != 1) {
            header("Location: login?notification=accountinactive");
            exit();
        }

        // Create User Logs
        $userid = $user['user_ID'];
        $action = "LOGIN";
        $module = "AUTHENTICATION";
        $recordid = $user['user_ID'];
        $description = "USER LOGGED INTO THE SYSTEM";
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

        session_regenerate_id(true);
        $_SESSION['user'] = $user['user_ID'];
        header("Location: ../auth/dashboard");
        exit();
    }
  
    // Forgot Password
    if(isset($_POST['confirmemail'])){
        $email = $_POST['email'];

        $stmt = $connection->prepare(
            "SELECT * FROM rpms_users WHERE user_EmailAddress = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($userRow = $result->fetch_assoc()) {
            $user = $userRow['user_ID'];
            $firstname = $userRow['user_FirstName'];
            $middlename = $userRow['user_MiddleName'];
            $lastname = $userRow['user_LastName'];
            $username = $userRow['user_Username'];
            $temporarypassword = base64_encode($userRow['user_Username']);
            $hashedPassword = password_hash($temporarypassword, PASSWORD_DEFAULT);
        } else {
            header("Location: forgotpassword?notification=emailnotfound");
            exit();
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
            $mail->addAddress($email);
            $mail->addReplyTo('drpcmstechnicalsupport@gmail.com', 'Technical Support');

            $fullname = $firstname . ' ' . ($middlename ? $middlename . ' ' : '') . $lastname;
<<<<<<< HEAD
            $systemLink = "http://localhost/eRPMS";
=======
            $systemLink = "http://localhost/Personal-System/eRPMS";
>>>>>>> ec28f0859aace89c457ce703dfd179e5118fdcdd

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request for Digital Resident Profiling and Census Management System (DRPCMS)';

            $mail->Body = "
            <div style='font-family:Arial,sans-serif; font-size:14px; color:#333; line-height:1.6; background:#f4f6f9; padding:20px;'>

                <div style='max-width:600px; margin:0 auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e0e0e0;'>

                    <div style='background:#c0392b; padding:20px; text-align:center;'>
                        <h2 style='color:#ffffff; margin:0; font-size:16px;'>
                            Digital Resident Profiling and Census Management System (DRPCMS)
                        </h2>
                        <p style='color:#f5cccc; margin:5px 0 0; font-size:12px;'>
                            Password Reset Notification
                        </p>
                    </div>

                    <div style='padding:20px;'>

                        <p>Dear <b>{$fullname}</b>,</p>

                        <p>
                            Your password reset request has been processed successfully.
                            A temporary password has been generated for your DRPCMS account.
                        </p>

                        <p>
                            Please use the temporary password below to access your account:
                        </p>

                        <div style='background:#f8f9fc; border:1px solid #e1e5ea; border-radius:8px; padding:15px; margin:15px 0;'>

                            <p style='margin:5px 0;'>
                                <b>Username:</b> {$username}
                            </p>

                            <p style='margin:5px 0;'>
                                <b>Temporary Password:</b> {$temporarypassword}
                            </p>

                        </div>

                        <div style='text-align:center; margin-top:20px;'>

                            <a href='{$systemLink}'
                                style='display:inline-block; background:#007bff; color:#ffffff; padding:12px 22px; text-decoration:none; border-radius:6px; font-weight:bold;'>
                                Login to DRPCMS
                            </a>

                        </div>

                        <p style='margin-top:20px; font-size:12px; color:#777;'>
                            For security purposes, please change your password immediately after logging in.
                        </p>

                    </div>

                    <div style='background:#f1f1f1; padding:12px; text-align:center; font-size:11px; color:#666;'>
                        This is an automated message from the Digital Resident Profiling and Census Management System (DRPCMS).
                        Please do not reply.
                    </div>

                </div>

            </div>
            ";

            $mail->AltBody = "DRPCMS Account Created. Username: $username Password: $temporarypassword Login: $systemLink";
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
                // Notification
                header("Location: forgotpassword?notification=forgotpasswordsent");
                exit();
            } else {
                // Notification
                header("Location: forgotpassword?notification=forgotpassworderror"); 
                exit();
            }
            $stmtUpdate->close();

        } catch (Exception $e) {
            // Notification
            header("Location: forgotpassword?notification=forgotpasswordunsent"); 
            exit();

        }
        
    }

    // Logout
    if(isset($_GET['logout'])){
        $hashUserURL = $_GET['logout'];
        $sql = "SELECT * FROM rpms_users";
        $result = mysqli_query($connection, $sql);
        $userID = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['user_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashUserURL) {
                $user = $row['user_ID'];
                
                // Create User Logs
                $userid = $user;
                $action = "LOGOUT";
                $module = "AUTHENTICATION";
                $recordid = $user;
                $description = "USER LOGGED OUT OF THE SYSTEM";
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

                $_SESSION = array();
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(),
                        '',
                        time() - 42000,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"]
                    );
                }
                session_destroy();
                header("Location: ../");
                exit();  
            }
        }
    }
?>