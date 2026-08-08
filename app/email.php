<?php
// PHP Mailer
    use PHPMailer\PHPMailer\PHPMailer;      
    use PHPMailer\PHPMailer\Exception;
// PHP Mailer
        require '../public/assets/vendor/autoload.php';
        require '../public/assets/PHPMailer/src/Exception.php';
        require '../public/assets/PHPMailer/src/PHPMailer.php';
        require '../public/assets/PHPMailer/src/SMTP.php';
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'm.alizalomugdang@gmail.com'; // Official Email Here
            $mail->Password = 'rhpm edik xpfv cilr'; // SMTP Password
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            //Send Email
            $mail->setFrom('m.alizalomugdang@gmail.com'); // Official Email Here
            //Recipients
            $mail->addAddress('layslomugdang@gmail.com'); // Display registered email
            $mail->addReplyTo('m.alizalomugdang@gmail.com'); // Official Email Here
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Temporary Password for eResident Profiling Module System (eRPMS)';

            $body = '
                <p>Dear,</p>

                <p>We received a request to reset your password for the <strong>eResident Profiling Module System (eRPMS)</strong>. Below is your temporary password:</p>

                <p><strong>Temporary Password:</strong></p>

                <p>You can log in using this password at the following link:</p>
                <p><a href="http://localhost/Personal-System/eRPMS">http://localhost/Personal-System/eRPMS</a></p>

                <p><strong>Important:</strong> For your security, please change your password immediately after logging in.</p>

                <p>If you did not request a password reset or believe this message was sent to you by mistake, please contact our support team immediately at <a href="mailto:sample@gmail.com">sample@gmail.com</a>.</p>

                <p>Thank you for using the <strong>eResident Profiling Module System (eRPMS)</strong>.</p>

                <p>Best regards,<br>
                <strong>eRPMS Technical Support Team</strong><br>
                Resident Profiling Module System (eRPMS)<br>
                <a href="mailto:sample@gmail.com">sample@gmail.com</a><br>
                09123456789
                </p>
            ';

            $mail->Body = $body;
            $mail->send();

            header("Location: forgotpassword?notification=forgotpasswordsent");
            exit();
        }catch (Exception $e) {
            // Notification
            header("Location: forgotpassword?notification=forgotpasswordunsent");
            exit();
        }
?>