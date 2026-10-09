<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audit Logs - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">Audit Logs</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-title">
                                            <h2>Audit Logs</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="actionDropdown">
                                                    <li><a href="#" data-action="" class="text-uppercase">All</a></li>
                                                    <?php 
                                                        while ($row = mysqli_fetch_array($resultallactions)){ 
                                                    ?>
                                                        <li>
                                                            <a href="#" data-action="<?php echo $row['userlogs_Action']?>" class="text-uppercase">
                                                                <?php echo $row['userlogs_Action']?>
                                                            </a>
                                                        </li>
                                                    <?php 
                                                        } 
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <a href="../app/export?auditlogs_excl" class="btn btn-dark btn-flat f-s-12">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Excel Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Table List -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="table-search">
                                                    <thead class="bg-warning">
                                                        <tr>
                                                            <th class="w-15">User</th>
                                                            <th class="w-10">Action</th>
                                                            <th class="w-15">Date & Time</th>
                                                            <th>Subject</th>
                                                            <th>Browser</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12" id="auditlogs-body"></tbody>
                                                </table>
                                            </div>
                                            <!-- Pagination -->
                                            <div id="auditlogs-pagination"></div>
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
        if($notification=='userdeleted'){
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
                        title: "Account Deleted Successfully",
                        text: "The user account has been removed from the system.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "useraccounts";
                    });
                </script>
            ';
        }
    ?>
    
    <!-- AJAX Table -->
    <script>
        let currentAction = ''; // keeps track of selected filter

        function loadAuditLogs(action = '') {
            currentAction = action; // store for auto-refresh

            let url = '<?php echo BASE_URL; ?>app/ajaxauditlogs.php';
            if(action) {
                url += '?auditaction=' + encodeURIComponent(action);
            }

            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('auditlogs-body').innerHTML = data;
                });
        }

        // Capture dropdown clicks
        document.querySelectorAll('#actionDropdown a').forEach(link => {
            link.addEventListener('click', function(e){
                e.preventDefault(); // prevent page reload
                let action = this.getAttribute('data-action');
                loadAuditLogs(action);
            });
        });

        // Load table on page load
        loadAuditLogs();

        // Auto-refresh every 5 seconds keeping the current filter
        setInterval(() => loadAuditLogs(currentAction), 5000);
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