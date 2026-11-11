<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        .badge-maroon {
          background: #800000;
          color: #ffffff;
        }

        .transaction-card {
            transition: transform 0.3s ease; /* Smooth animation */
        }

        .transaction-card:hover {
            transform: scale(0.95); /* Zoom out to 95% */
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
                                    <li class="breadcrumb-item active">Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                switch ($role) {
                    case '1':
                ?>
                        <section id="main-content">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="barangay">
                                                <div class="card transaction-card">
                                                    <h4 class="text-dark text-center p-20">Barangay Management</h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="databasebackup">
                                                <div class="card transaction-card">
                                                    <h4 class="text-dark text-center p-20">Database Backup</h4>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="systemlogo">
                                                <div class="card transaction-card">
                                                    <h4 class="text-dark text-center p-20">System Logo</h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="systeminformation">
                                                <div class="card transaction-card">
                                                    <h4 class="text-dark text-center p-20">System Information</h4>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Footer -->
                            <?php require_once FOOTER_PATH; ?>
                        </section>
                <?php
                        break;
                    
                    default:
                ?>
                        <section id="main-content">
                            <div class="row justify-content-center">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-title">
                                                    <h3 class="font-weight-bold">CENSUS SETTINGS</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post">
                                            <div class="row">
                                                <label class="col-sm-5">Default Census Record:</label>
                                                <div class="col-sm-7">
                                                    <select name="censustype" id="censustype"
                                                        class="form-control font-weight-bold text-uppercase"
                                                        style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                        <option value="<?php echo $censustype; ?>" selected>
                                                            <?php echo $censustype; ?>
                                                        </option>
                                                        <option value="Annual">Annual</option>
                                                        <option value="Mid-Year">Mid-Year</option>
                                                        <option value="Special">Special</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-5">Census Year:</label>
                                                <div class="col-sm-7">
                                                    <?php
                                                    $currentYear = date("Y");
                                                    $startYear = 1900;
                                                    ?>
                                                    <select name="censusyear" class="form-control font-weight-bold text-uppercase"
                                                        style="font-size: 12px; height: 30px; line-height: 1.5;" data-bs-display="static" required>
                                                        <option value="<?php echo $censusyear; ?>" selected><?php echo $censusyear; ?></option>
                                                        <?php for ($year = $currentYear; $year >= $startYear; $year--): ?>
                                                        <option value="<?php echo $year; ?>">
                                                        <?php echo $year; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- ALWAYS PRESENT -->
                                            <div class="row specialcontexttype">
                                                <label class="col-sm-5">Types of Special Census:</label>
                                                <div class="col-sm-7">
                                                    <?php
                                                        $options = [
                                                            "DISASTER-RELATED",
                                                            "HEALTH EMERGENCY",
                                                            "LIVELIHOOD/ ECONOMIC IMPACT",
                                                            "SOCIAL ASSISTANCE/ BENEFICIARY",
                                                            "EDUCATION/ SCHOOL STATUS"
                                                        ];
                                                    ?>
                                                    <select name="specialcensustype" id="specialcensus"
                                                        class="form-control font-weight-bold text-uppercase"
                                                        style="font-size: 12px; height: 30px; line-height: 1.5;">

                                                        <?php foreach($options as $opt): ?>
                                                            <option value="<?php echo $opt; ?>"
                                                                <?php if($opt == $censuscontext) echo 'selected'; ?>>
                                                                <?php echo $opt; ?>
                                                            </option>
                                                        <?php endforeach; ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row specialcontextname">
                                                <label class="col-sm-5">Name: </label>
                                                <div class="col-sm-7">
                                                    <input type="text" value="<?php echo $censusname; ?>" name="specialcensusname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success" name="updatecensussettings">UPDATE</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Footer -->
                            <?php require_once FOOTER_PATH; ?>
                        </section>
                <?php
                        break;
                }
                ?>
                
            </div>
        </div>
    </div>
    <!-- Notification -->
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/sweetalert/sweetalert.js"></script>
    <?php
        $notification = (isset($_GET['notification']) ? $_GET['notification'] : '');
        if($notification=='censussettingupdated'){
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
                        title: "Census Settings Updated",
                        text: "The census report has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "settings";
                    });
                </script>
            ';
        }elseif($notification=='censussettingserror'){
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
                        title: "Unable to Update Census Settings",
                        text: "There was a problem updating the census report. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "settings";
                    });
                </script>
            ';
        }
    ?>

    <!-- Special Context -->
    <script>
        const censusSelect = document.getElementById("censustype");
        const specialType = document.querySelector(".specialcontexttype");
        const specialName = document.querySelector(".specialcontextname");

        const specialNameInput = document.querySelector(".specialcontextname input");
        const specialTypeInput = document.querySelector(".specialcontexttype input");

        function toggleSpecialFields() {
            const value = censusSelect.value.trim().toLowerCase();

            if (value === "special") {
                specialType.style.display = "flex";
                specialName.style.display = "flex";

                // enable required
                specialNameInput.required = true;
                specialTypeInput.required = true;

            } else {
                specialType.style.display = "none";
                specialName.style.display = "none";

                // disable required
                specialNameInput.required = false;
                specialTypeInput.required = false;

                // optional: clear values when hidden
                specialNameInput.value = "";
                specialTypeInput.value = "";
            }
        }

        censusSelect.addEventListener("change", toggleSpecialFields);
        window.addEventListener("DOMContentLoaded", toggleSpecialFields);
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