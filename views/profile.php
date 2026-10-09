<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3 class="font-weight-bold">PROFILE</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                        <!-- Form Start -->
                                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-5 text-center">
                                                        <div class="user-photo">
                                                            <?php
                                                            if($pprofile == 'Default.png'){
                                                                $profile = BASE_URL."public/assets/images/Default.png";
                                                            }else{
                                                                $profile = BASE_URL."storage/profiles/".$pprofile."";
                                                            }
                                                            ?>
                                                            <span class="img-div text">
                                                                <img class="img-fluid" src="<?php echo $profile; ?>" alt="profile-picture" onClick="triggerClickProfileImage()" id="profilepicture">
                                                            </span>
                                                            <input type="file" name="profilepicture" onChange="displayProfileImage(this)" id="profileselect" accept="image/jpeg, image/png" style="display: none;">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7" style="border-left: 1px solid #6c757d;">
                                                        <div class="card-title">
                                                            <h6 class="font-weight-bold text-dark">User Information</h6>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">Username:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="username" value="<?php echo $pusername ?>" class="form-control font-weight-bold input-sm" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">First Name:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="firstname" value="<?php echo $pfirstname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">Middle Name:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="middlename" value="<?php echo $pmiddlename; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">Last Name:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="lastname" value="<?php echo $plastname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">Email Address:</label>
                                                            <div class="col-sm-8">
                                                                <input type="email" name="emailaddress" value="<?php echo $pemailaddress; ?>" class="form-control font-weight-bold text-lowercase input-sm" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-sm-4">Contact Number:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="contactnumber" value="<?php echo $pcontactnumber; ?>" class="form-control font-weight-bold text-uppercase input-sm" placeholder="09xxxxxxxxx" maxlength="11" pattern="09\d{9}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="updateprofile">UPDATE</button>
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
    
    <!-- Notification -->
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/sweetalert/sweetalert.js"></script>
    <?php
        $notification = (isset($_GET['notification']) ? $_GET['notification'] : '');
        if($notification=='profileinformationupdated'){
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
                        title: "Profile Information Updated",
                        text: "Your profile information has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "profile";
                    });
                </script>
            ';
        }elseif($notification=='profileinformationerror'){
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
                        title: "Unable to Update Profile Information",
                        text: "There was a problem updating your profile information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "profile";
                    });
                </script>
            ';
        }elseif($notification=='errorimagetype'){
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
                        title: "Unsupported Image Type.",
                        text: "Please upload a valid image file (JPG, JPEG, PNG or GIF only).",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "profile";
                    });
                </script>
            ';
        }
    ?>
    <script>
        // Profile DIsplay
        function triggerClickProfileImage() {
            document.querySelector('#profileselect').click();
        }

        function displayProfileImage(input) {
            const file = input.files[0];

            if (file) {
                const allowedTypes = ["image/jpeg", "image/png"];

                if (!allowedTypes.includes(file.type)) {
                    alert("Invalid profile type. Please upload a JPEG or PNG image.");
                    input.value = "";
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#profilepicture').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }

        // Contact Number Format
        const contactInput = document.querySelector('input[name="contactnumber"]');
        contactInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 11) this.value = this.value.slice(0, 11);
        });
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