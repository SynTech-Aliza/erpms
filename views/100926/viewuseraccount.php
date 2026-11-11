<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View User Account- Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        /* The switch - the box around the slider */
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
          margin-left: 30px;
        }

        /* Hide default HTML checkbox */
        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        /* The slider */
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0px;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #28a745;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #5873fe;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }

        .form-group .input-text{
         padding: 10000px 0010px;
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
                                    <li class="breadcrumb-item active">View User Account</li>
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
                                            <h3 class="font-weight-bold">USER ACCOUNT INFORMATION</h3>
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
                                                                    <input type="text" name="firstname" value="<?php echo $ufirstname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Middle Name</label>
                                                                    <input type="text" name="middlename" value="<?php echo $umiddlename; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Last Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="lastname" value="<?php echo $ulastname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Email Address <span class="text-danger">*</span></label>
                                                                    <input type="email" name="emailaddress" value="<?php echo $uemailaddress; ?>" class="form-control font-weight-bold text-lowercase input-sm" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Contact Number <span class="text-danger">*</span></label>
                                                                    <input type="text" name="contactnumber" value="<?php echo $ucontactnumber; ?>" class="form-control font-weight-bold text-uppercase input-sm" placeholder="09xxxxxxxxx" maxlength="11" pattern="09\d{9}" required>
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
                                                                    <input type="text" name="username" value="<?php echo $uusername ?>" class="form-control font-weight-bold input-sm" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Password </label>
                                                                    <div class="input-group">
                                                                        <button type="button" class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-target="#password">Set New Password</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">Status</label><br/>
                                                                <label style="position: absolute;margin-top: 10px;">No</label>
                                                                    <label class="switch">
                                                                    <?php
                                                                    switch ($ustatus) {
                                                                        case '1':
                                                                            echo '<input type="checkbox" class="form-control input-text" name="status" checked>';
                                                                            break;
                                                                        
                                                                        case '0':
                                                                            echo '<input type="checkbox" class="form-control input-text" name="status">';
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <label style="position: absolute;margin-top: 10px; margin-left: 10px;">Yes</label>
                                                            </div>
                                                        </div>

                                                        <!--  -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">User Role</label><br/>
                                                                <select id="userrole" name="userrole" 
                                                                    class="form-control font-weight-bold text-uppercase mb-3"
                                                                    style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                    <option value="<?php echo $urole; ?>" selected><?php 
                                                                    switch ($urole) {
                                                                        case '1':
                                                                            echo 'Administrator';
                                                                            break;
                                                                        
                                                                        default:
                                                                            echo 'BSPO';
                                                                            break;
                                                                    }?></option>
                                                                    <option value="1">Administrator</option>
                                                                    <option value="2">BSPO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        switch ($urole) {
                                                            case '1':
                                                        ?>
                                                        <div class="row" id="barangay" style="display: none;">
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
                                                        <?php
                                                                break;
                                                            
                                                            default:
                                                        ?>
                                                        <div class="row" id="barangay">
                                                            <div class="col-lg-12">
                                                                <label class="form-label">Assigned Barangay</label><br/>
                                                                <select id="assignedbarangay" name="assignedbarangay"
                                                                    class="form-control font-weight-bold text-uppercase mb-3"
                                                                    style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                    <option value="<?php echo $uappointed ?>" selected><?php echo $uappointed; ?></option>
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
                                                        <?php
                                                                break;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="updateinformation">UPDATE</button>
                                                <?php
                                                if($id != $user){
                                                ?>
                                                <a href="viewuseraccount?u=<?php echo $hashFromURL?>&notification=deleteuser" class="btn btn-danger">DELETE USER</a>
                                                <?php
                                                }
                                                ?>
                                                <a href="useraccounts" class="btn btn-dark">CANCEL</a>
                                            </form>
                                            <!-- Form End -->
                                            <!-- Password Modal Start -->
                                            <div class="modal fade none-border" id="password">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                <strong>Set New Temporary Password</strong>
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="text" name="password" class="form-control input-sm" value="<?php echo randomPassword()?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                     <button type="submit" name="updatepassword" class="btn btn-success waves-effect waves-light save-category">RESET</button>
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Password Modal End -->
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
        $u = (isset($_GET['u']) ? $_GET['u'] : '');
        if($notification=='userpasswordupdated'){
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
                        text: "The user’s password has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewuseraccount?u='.$u.'";
                    });
                </script>
            ';
        }elseif($notification=='userinformationupdated'){
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
                        title: "Information Updated",
                        text: "The user’s information has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewuseraccount?u='.$u.'";
                    });
                </script>
            ';
        }elseif($notification=='userpassworderror'){
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
                        title: "Unable to Reset Password",
                        text: "There was a problem updating the password. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewuseraccount?u='.$u.'";
                    });
                </script>
            ';
        }elseif($notification=='userinformationerror'){
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
                        title: "Unable to Update Information",
                        text: "There was a problem updating the user information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewuseraccount?u='.$u.'";
                    });
                </script>
            ';
        }elseif($notification=='deleteuser'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete User Account?",
                        text: "This action cannot be undone. The user account will be permanently deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "viewuseraccount?deleteuser='.$u.'";
                        } else {
                            window.location = "viewuseraccount?u='.$u.'";
                        }
                    });
                </script>
            ';
        }elseif($notification=='userdeleteerror'){
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
                        title: "Unable to Delete Account",
                        text: "There was a problem deleting the user account. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewuseraccount?u='.$u.'";
                    });
                </script>
            ';
        }
    ?>
    <!-- Contact Number Format -->
    <script>
        // Contact Number Format
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

        userrole.addEventListener('change', function() {
            if(this.value === '2') {
                barangay.style.display = 'block';
            } else {
                barangay.style.display = 'none';
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