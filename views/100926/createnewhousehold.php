<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Household - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        .radio,
        .checkbox{
            width: 20px;
            height: 20px;
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
                                    <li class="breadcrumb-item">Households</li>
                                    <li class="breadcrumb-item active">Create New Household</li>
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
                                            <h3 class="font-weight-bold">HOUSEHOLD FORM</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" method="post">
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">Household Details</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Street/ Purok <span class="text-danger">*</span></label>
                                                            <input type="text" name="streetpurok" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Barangay</label>
                                                            <input type="text" name="barangay" value="<?php echo $appointed; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Municipality</label>
                                                            <input type="text" name="municipality" value="Libertad" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Province</label>
                                                            <input type="text" name="province" value="Antique" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Type:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="type" value="Owned" checked>
                                                                <label class="form-check-label">Owned</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="type" value="Rented">
                                                                <label class="form-check-label">Rented</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Size:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Small (1-2 rooms)" checked>
                                                                <label class="form-check-label">Small (1-2 rooms)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Medium (3-4 rooms)">
                                                                <label class="form-check-label">Medium (3-4 rooms)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Large (5+ rooms)">
                                                                <label class="form-check-label">Large (5+ rooms)</label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Condition <span class="text-danger">*</span></label>
                                                            <select name="condition" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
                                                                <option value="Concrete">Concrete</option>
                                                                <option value="Semi-Concrete">Semi-Concrete</option>
                                                                <option value="Wood">Wood</option>
                                                                <option value="Light Materials">Light Materials</option>
                                                                <option value="Mixed Materials">Mixed Materials</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Utilities:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="None" checked>
                                                                <label class="form-check-label">None</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Electricity">
                                                                <label class="form-check-label">Electricity</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Water">
                                                                <label class="form-check-label">Water</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Gas/ LPG">
                                                                <label class="form-check-label">Gas/ LPG</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Internet/ Broadband">
                                                                <label class="form-check-label">Internet/ Broadband</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Cable TV/ Satellite TV">
                                                                <label class="form-check-label">Cable TV/ Satellite TV</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Telephone/ Landline">
                                                                <label class="form-check-label">Telephone/ Landline</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Sewerage/ Drainage">
                                                                <label class="form-check-label">Sewerage/ Drainage</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Garbage Collector">
                                                                <label class="form-check-label">Garbage Collector</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Facilities:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="None" checked>
                                                                <label class="form-check-label">None</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Kitchen">
                                                                <label class="form-check-label">Kitchen</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Dining Area">
                                                                <label class="form-check-label">Dining Area</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Living Room">
                                                                <label class="form-check-label">Living Room</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Bedrooms">
                                                                <label class="form-check-label">Bedrooms</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Toilet / Bathroom">
                                                                <label class="form-check-label">Toilet / Bathroom</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Laundry Area">
                                                                <label class="form-check-label">Laundry Area</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Storage Room">
                                                                <label class="form-check-label">Storage Room</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Parking Space/ Garage">
                                                                <label class="form-check-label">Parking Space/ Garage</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Garden/ Backyard">
                                                                <label class="form-check-label">Garden/ Backyard</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Fence/ Gate">
                                                                <label class="form-check-label">Fence/ Gate</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Balcony/ Terrace">
                                                                <label class="form-check-label">Balcony/ Terrace</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">Household Head</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>First Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="firstname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input type="text" name="middlename" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Last Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="lastname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>Suffix <span class="text-danger">*</span></label>
                                                            <select name="suffix" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="">Select</option>
                                                                <option value="N/A" selected>N/A</option>
                                                                <option value="Jr">Jr</option>
                                                                <option value="Sr">Sr</option>
                                                                <option value="I">I</option>
                                                                <option value="II">II</option>
                                                                <option value="III">III</option>
                                                                <option value="IV">IV</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Date of Birth <span class="text-danger">*</span></label>
                                                            <input type="date" name="dateofbith" class="form-control font-weight-bold text-uppercase input-sm" id="dateofbirth" onchange="calculateAge()" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input type="text" name="age" class="form-control font-weight-bold text-uppercase input-sm" id="age" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Gender <span class="text-danger">*</span></label>
                                                            <select name="gender" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Civil Status <span class="text-danger">*</span></label>
                                                            <select name="civilstatus" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Civil">Civil</option>
                                                                <option value="Live-in">Live-in</option>
                                                                <option value="Separated">Separated</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
                                                                <option value="Annulled">Annulled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="submit">SUBMIT</button>
                                                <a href="households" class="btn btn-dark">CANCEL</a>
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
        if($notification=='residentheadexist'){
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
                        title: "Head of Household Already Exists",
                        text: "This resident is already assigned as the Head of another household. Only one head per household is allowed.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewhousehold";
                    });
                </script>
            ';
        }elseif($notification=='householderror'){
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
                        title: "Failed to Create Household",
                        text: "An error occurred while creating the household information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewhousehold";
                    });
                </script>
            ';
        }elseif($notification=='householdcreated'){
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
                        title: "Household Created Successfully",
                        text: "The household information has been successfully saved.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewhousehold";
                    });
                </script>
            ';
        }
    ?>
    
    <!-- Calculate Age -->
    <script>
        function calculateAge() {
            var birthdate = document.getElementById("dateofbirth").value;
            var ageField = document.getElementById("age");

            if (!birthdate) {
                ageField.value = "";
                ageField.style.backgroundColor = "";
                ageField.style.color = "";
                return;
            }

            var today = new Date();
            var birthDate = new Date(birthdate);
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();

            // Adjust age if birthdate hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            ageField.value = age;
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