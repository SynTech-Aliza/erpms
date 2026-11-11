<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Account - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item">User Accounts</li>
                                    <li class="breadcrumb-item active">Create New Account</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row justify-content-center">
                        <!--  -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3 class="font-weight-bold">USER ACCOUNT FORM</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" method="post">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="card-title">
                                                            <h6 class="font-weight-bold text-dark">Personal Information</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>First Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="firstname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Middle Name</label>
                                                                    <input type="text" name="middlename" class="form-control font-weight-bold text-uppercase input-sm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Last Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="lastname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Email Address <span class="text-danger">*</span></label>
                                                                    <input type="email" name="emailaddress" class="form-control font-weight-bold text-lowercase input-sm" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Contact Number <span class="text-danger">*</span></label>
                                                                    <input type="text" name="contactnumber" class="form-control font-weight-bold text-uppercase input-sm" placeholder="09xxxxxxxxx" maxlength="11" pattern="09\d{9}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="card-title">
                                                            <h6 class="font-weight-bold text-dark">User Account Details</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Username <span class="text-danger">*</span></label>
                                                                    <input type="text" name="username" class="form-control font-weight-bold input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Temporary Password </label>
                                                                    <div class="input-group">
                                                                        <button type="button" class="btn btn-dark btn-sm" value ='generate' onclick='document.getElementById("passwordgenerator").value = Password.generate(5)'>Generate</button>
                                                                        <input type="text" name="temporarypassword" value="<?php echo randomPassword()?>" id="passwordgenerator" class="form-control input-sm font-weight-bold">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">User Role</label><br/>
                                                                <select id="userrole" name="userrole" 
                                                                    class="form-control font-weight-bold text-uppercase mb-3"
                                                                    style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                    <option value="" selected>Select</option>
                                                                    <option value="1">Administrator</option>
                                                                    <option value="2">Enumerator</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="barangay" style="display:none">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">Assigned Barangay</label><br/>
                                                                <select id="assignedbarangay" name="assignedbarangay"
                                                                    class="form-control font-weight-bold text-uppercase mb-3"
                                                                    style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                    <option value="" selected>Select</option>
                                                                    <?php 
                                                                        while ($row = mysqli_fetch_array($resultassignedbarangay)){ 
                                                                    ?>
                                                                        <option value="<?php echo $row['barangay_Name']?>">
                                                                            <?php echo $row['barangay_Name']?>
                                                                        </option>
                                                                    <?php 
                                                                        } 
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="submit">SUBMIT</button>
                                                <a href="useraccounts" class="btn btn-dark">CANCEL</a>
                                            </form>
                                            <!-- Form End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
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
        if($notification=='usernameexist'){
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
                        title: "Username Already Taken",
                        text: "Please choose a different username.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewaccount";
                    });
                </script>
            ';
        }elseif($notification=='useremailexist'){
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
                        title: "Email Already Registered",
                        text: "Please use a different email address.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewaccount";
                    });
                </script>
            ';
        }
        elseif($notification=='useraccounterror'){
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
                        title: "Unable to Create Account",
                        text: "Something went wrong. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewaccount";
                    });
                </script>
            ';
        }
        elseif($notification=='useraccountcreated'){
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
                        title: "Account Created Successfully",
                        text: "New user account has been created.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewaccount";
                    });
                </script>
            ';
        }
    ?>
    
    <!-- Contact Number Format -->
    <script>
        const contactInput = document.querySelector('input[name="contactnumber"]');
        contactInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 11) this.value = this.value.slice(0, 11);
        });

        // Password Generator
        var Password = {
            _pattern : /[a-zA-Z\&\!@#$%^&*]/,
            _getRandomByte : function(){
                if(window.crypto && window.crypto.getRandomValues){
                    var result = new Uint8Array(1);
                    window.crypto.getRandomValues(result);
                    return result[0];
                }else if(window.msCrypto && window.msCrypto.getRandomValues){
                    var result = new Uint8Array(1);
                    window.msCrypto.getRandomValues(result);
                    return result[0];
                }else{
                    return Math.floor(Math.random() * 256);
                }
            },
          
            generate : function(length){
                return Array.apply(null, {'length': length})
                    .map(function(){
                        var result;
                        while(true){
                            result = String.fromCharCode(this._getRandomByte());
                            if(this._pattern.test(result)){
                            return result;
                        }
                    }
                }, this)
                .join('');  
            }
        };

        // Assigned Barangay Pop-up
        const userrole = document.getElementById('userrole');
        const barangay = document.getElementById('barangay');
        const assignedbarangay = document.getElementById('assignedbarangay'); // add this

        userrole.addEventListener('change', function() {

            if (this.value === '2') { // BSPO
                barangay.style.display = 'block';
                assignedbarangay.setAttribute('required', 'required'); // make required
            } 
            else {
                barangay.style.display = 'none';
                assignedbarangay.removeAttribute('required'); // remove required
                assignedbarangay.value = ''; // reset selection
            }

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