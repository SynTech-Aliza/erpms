<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password - Digital Resident Profiling and Census Management System (DRPCMS)</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>storage/logos/<?php echo $systemlogo; ?>">
    <link href="<?php echo BASE_URL; ?>public/assets/icons/fontawesome 6.7.2/css/all.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/weather-icons.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/menubar/aa.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/helper.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/style.css" rel="stylesheet">
    <style>
        .color-newprimary,
        .text-newprimary {
          color: #1A1341;
        }

        /*Choose Profile*/
        .img-div:hover .img-placeholder{
            display: block;
            cursor: pointer;
        }
        .img-div:hover .img-placeholders{
            display: block;
            cursor: pointer;
        }
        #profilepicture { 
            display: block;
            height: 250px;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
            cursor: pointer;
            outline: 2px dashed #858585;
            border-radius: 100%;
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
<body>
    <!-- Navigation Menu -->
    <?php
        $currentPage = basename($_SERVER['PHP_SELF']);
        require_once MENU_PATH;
    ?>

    <!-- Header -->
    <?php require_once HEADER_PATH; ?>

    <!-- Content -->
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Change Password</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3 class="font-weight-bold">CHANGE PASSWORD</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" id="passwordForm" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <label class="col-sm-4">Enter Current Password:</label>
                                                    <div class="col-sm-7">
                                                        <input type="password" name="currentpassword" class="form-control font-weight-bold input-sm password-field" required>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <i class="fa fa-eye color-newprimary toggle-password"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4">Enter New Password:</label>
                                                    <div class="col-sm-7">
                                                        <input type="password" name="newpassword" id="newpassword" class="form-control font-weight-bold input-sm password-field" required>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <i class="fa fa-eye color-newprimary toggle-password"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4">Confirm Password:</label>
                                                    <div class="col-sm-7">
                                                        <input type="password" name="confirmpassword" id="confirmPassword" class="form-control font-weight-bold input-sm password-field" required>
                                                        <!-- Confirm password match -->
                                                        <div id="passwordmatch" style="margin-top:5px; font-size: 10px;"></div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <i class="fa fa-eye color-newprimary toggle-password"></i>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="updatepassword">UPDATE</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <?php require_once FOOTER_PATH; ?>
                </section>
            </div>
        </div>
    </div>
    
    <!-- Notifications -->
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/sweetalert/sweetalert.js"></script>
    <?php
        $notification = (isset($_GET['notification']) ? $_GET['notification'] : '');
        // Household Residents
        if($notification=='passwordupdated'){
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
                        icon: "success",
                        title: "Password Updated",
                        text: "Your password has been successfully updated. Please log out to restart the system.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "changepassword";
                    });
                </script>
            ';
        }elseif($notification=='passworderror'){
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
                        title: "Unable to Update the Paswsord",
                        text: "There was a problem updating your password. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "changepassword";
                    });
                </script>
            ';
        }
    ?>
    <!-- Toggle Password -->
    <script>
        const togglePassword = document.querySelectorAll('.toggle-password');

        togglePassword.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.row').querySelector('.password-field');
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = "password";
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });

        // Confirm password match checker
        const confirmPassword = document.getElementById('confirmPassword');
        const matchText = document.getElementById('passwordmatch');

        confirmPassword.addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            if(confirmPassword.value === "") {
                matchText.textContent = "";
                return;
            }

            if(newpassword.value === confirmPassword.value) {
                matchText.textContent = "Passwords match";
                matchText.style.color = "green";
            } else {
                matchText.textContent = "Passwords do not match";
                matchText.style.color = "red";
            }
        }
    </script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/menubar/sidebar.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/preloader/pace.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/scripts.js"></script>
</body>
</html>