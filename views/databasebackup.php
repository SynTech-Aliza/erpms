<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Backup - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        /* Pagination */
        .pagination {
            justify-content: left;
            margin-top: 20px;
        }

        /* Space between buttons */
        .pagination .page-item {
            margin: 0 3px;
        }

        /* Normal buttons */
        .pagination .page-link {
            color: #1A1341; /* text color */
            background-color: #f8f9fa; /* button bg */
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px 12px;
            transition: all 0.3s;
        }

        /* Hover effect */
        .pagination .page-link:hover {
            background-color: #1A1341;
            color: #fff;
            border-color: #1A1341;
        }

        /* Active page button */
        .pagination .page-item.active .page-link {
            background-color: #28a745; /* maroon active */
            color: #fff;
            border-color: #28a745;
        }

        /* Previous / Next special styling */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-weight: bold;
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
                                    <li class="breadcrumb-item">Settings</li>
                                    <li class="breadcrumb-item active">Database Backup</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-title">
                                            <h2>Database Backups</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Backups:</span>
                                            <span class="text-success font-weight-bold"><?php echo $totaldatabaseentries; ?></span>
                                        </div>
                                        <div class="btn-group">
                                            <form method="post">Search Date: 
                                                <input type="date" name="databasedate" class="input-sm text-uppercase">
                                                <button type="submit" name="searchdatabase" class="btn btn-sm btn-dark">Search</button>
                                            </form>
                                        </div>
                                        <div class="btn-group">
                                            <a href="../app/settings?databasebackup" class="btn btn-sm btn-success">Create Backup</a>
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
                                                            <th>#</th>
                                                            <th>Database Name</th>
                                                            <th>Backup</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultalldbbackups) <= 0){
                                                                echo '<td scope="row" colspan="3" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = $databasestart + 1;
                                                                while($row = mysqli_fetch_array($resultalldbbackups)){
                                                                    $hashID = hash('sha256', $row['database_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr onclick="window.location.href='<?php echo BASE_URL; ?>storage/database/<?php echo $row['database_Filename']?>'" style="cursor: pointer">
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php echo $row['database_Filename']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['database_Backup'])); ?></td>
                                                        </tr>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Page Numbers -->
                                            <ul class="pagination">
                                                <!-- Previous Button -->
                                                <?php if ($databasepage > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?databasepage=<?php echo $databasepage - 1; ?>">Previous</a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- Page Numbers -->
                                                <?php for ($i = 1; $i <= $totaldatabasepages; $i++): ?>
                                                    <li class="page-item <?php if ($i == $databasepage) echo 'active'; ?>">
                                                        <a class="page-link" href="?databasepage=<?php echo $i; ?>">
                                                            <?php echo $i; ?>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>

                                                <!-- Next Button -->
                                                <?php if ($databasepage < $totaldatabasepages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?databasepage=<?php echo $databasepage + 1; ?>">Next</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="settings" class="btn btn-dark">CANCEL</a>
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
        if($notification == 'databasecreated'){
            echo '
                <style>
                    .swal-title-large {
                        font-size: 1.6em !important;
                        font-weight: bold;
                    }
                </style>
                <script type="text/javascript">
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Database Created Successfully",
                        text: "The database backup file has been created and saved.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "databasebackup";
                    });
                </script>
            ';
        }elseif($notification == 'databaseerror'){
            echo '
                <style>
                    .swal-title-large {
                        font-size: 1.6em !important;
                        font-weight: bold;
                    }
                </style>
                <script type="text/javascript">
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Database Backup Failed",
                        text: "An error occurred while creating the database backup. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "databasebackup";
                    });
                </script>
            ';
        }
    ?>
    
    <!-- Search Table -->
    <script>
        document.getElementById('search-table').addEventListener('keyup', function () {
            var filter = this.value.toLowerCase();
            var rows = document.querySelectorAll('#table-search tbody tr');
            var visibleCount = 0;

            rows.forEach(function (row) {
                // Skip the "noRecordRow" if it's already in the table
                if (row.id === "noRecordRow") return;

                var text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Check if any rows are visible
            if (visibleCount === 0) {
                if (!document.getElementById('noRecordRow')) {
                    const colspan = document.querySelector('#table-search thead tr').children.length;
                    const noDataRow = `<tr id="noRecordRow"><td colspan="${colspan}" style="text-align:center;">No records found</td></tr>`;
                    document.querySelector('#table-search tbody').insertAdjacentHTML('beforeend', noDataRow);
                }
            } else {
                const noDataRow = document.getElementById('noRecordRow');
                if (noDataRow) noDataRow.remove();
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
