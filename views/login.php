<?php
require_once __DIR__ . '/../app/authocontrol.php';
require_once __DIR__ . '/../app/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Resident Profiling and Census Management System (DRPCMS)</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>storage/logos/<?php echo $systemlogo; ?>">
    <!-- Styles -->
    <link href="<?php echo BASE_URL; ?>public/assets/icons/fontawesome 6.3.0/css/all.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/helper.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/style.css" rel="stylesheet">
    <!-- Extensions -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .bg-newprimary {
            background: #1A1341;
            color: #ffffff;
            fill: #545454;
        }

        .icon img { 
            width: 120px; 
            height: auto; 
            margin-bottom: 10px; 
        }

        .btn-newprimary {
            background: #28a745;
            border-color: #28a745;
            color: #ffffff;
        }

        .btn-newprimary.active,
        .btn-newprimary:focus,
        .btn-newprimary:hover {
          background: #3cd070;
          border-color: #3cd070;
          color: #ffffff;
          box-shadow: none;
        }

        .color-newprimary,
        .text-newprimary {
          color: #1A1341;
        }

        .card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 10);
            border-radius: 5% 5% 0 0 !important;
        }

        .border-newprimary {
            border-color: #1A1341;
        }

        .bg-img { 
            background-image: url('<?php echo BASE_URL; ?>public/assets/images/bg-top.png'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center; 
            position: fixed; 
            top: 0; 
            left: 0; 
            height: 43vh; 
            width: 100%; 
            z-index: -10; 
            opacity: 0.5; 
        }

        .font-arialroundmtbold{
            font-family: "Arial Rounded MT Bold", Arial, sans-serif;
        }

        .toggle-password {
            position: absolute;
            right: 50px;
            top: 62%;
            cursor: pointer;
            color: #1A1341;
        }

        .toggle-password:hover {
            color: #241A5B;
        }

        /* Mobile Auto Shrink */
        @media (max-width: 768px) {

            .sidebar {
                width: 60px !important;
            }

            /* Hide text inside menu */
            .sidebar .nav-text,
            .sidebar span,
            .sidebar .menu-title {
                display: none !important;
            }

            /* Center icons */
            .sidebar i {
                font-size: 20px;
                display: block;
                text-align: center;
            }

            /* Adjust content area */
            .content-wrap {
                margin-left: 70px !important;
            }

            .hamburger{
              display: none;
            }
        }
    </style>
</head>
<body class="bg-newprimary">
    <div id="main-content">
        <div class="bg-img"></div>
        <div class="bg-img-overlay"></div>
        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-3 m-t-120">
                        <div class="card rounded">
                            <div class="icon text-center">
                                <img src="<?php echo BASE_URL; ?>storage/logos/<?php echo $systemlogo; ?>">
                            </div>
                            <div class="basic-form p-l-20 p-r-20">
                                <form method="post">
                                    <div class="form-group">
                                        <label class="text-newprimary">Username</label>
                                        <input type="text" name="username" class="form-control border-newprimary" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-newprimary">Password</label>
                                        <input type="password" name="password" class="form-control border-newprimary" id="password" required>
                                    </div>
                                    <span class="toggle-password" onclick="togglePassword()">
                                        <i class="fa fa-eye color-newprimary" id="hideunhidepassword"></i>
                                    </span>
                                    
                                    <div class="p-b-20">
                                        <button type="submit" name="login" class="btn btn-block btn-newprimary">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5 border-top m-t-50">
                        <div class="footer">
                            <p class="text-center color-white">Copyright © 2026 Boys at the Back. All rights reserved.<br/>Digital Resident Profiling and Census Management System (DRPCMS).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toggle Password -->
    <script>
        function togglePassword(){

            const input=document.getElementById("password");
            const icon=document.getElementById("hideunhidepassword");

            if(input.type==="password"){
                input.type="text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }else{
                input.type="password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }

        }
    </script>
    <!-- Notification -->
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/sweetalert/sweetalert.js"></script>
    <?php
        $notification = (isset($_GET['notification']) ? $_GET['notification'] : '');
        if($notification=='usernamenotfound'){
            echo '
                <style>
                    .swal-title-large {
                        font-size: 1.6em !important;
                        font-weight: bold;
                    }
                </style>
                <script type="text/javascript">
                    Swal.fire({
                        position: "middle",
                        icon: "error",
                        title: "Invalid Username",
                        text: "No account is registered with the provided username.",
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "login";
                    });
                </script>
            ';
        }elseif($notification=='invalidpassword'){
            echo '
                <style>
                    .swal-title-large {
                        font-size: 1.6em !important;
                        font-weight: bold;
                    }
                </style>
                <script type="text/javascript">
                    Swal.fire({
                        position: "middle",
                        icon: "error",
                        title: "Incorrect Password",
                        text: "The password you entered is incorrect. Please try again.",
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "login";
                    });
                </script>
            ';
        }elseif($notification=='accountinactive'){
            echo '
                <style>
                    .swal-title-large {
                        font-size: 1.6em !important;
                        font-weight: bold;
                    }
                </style>
                <script type="text/javascript">
                    Swal.fire({
                        position: "middle",
                        icon: "error",
                        title: "Access Restricted",
                        text: "Your account is inactive. Please coordinate with the system administrator.",
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "login";
                    });
                </script>
            ';
        }
    ?>
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
</body>
</html>

