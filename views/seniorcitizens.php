<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senior Citizens - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">Senior Citizens</li>
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
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h2>Senior Citizens</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Seniors:</span>
                                            <span class="text-success font-weight-bold"><?php echo $totalseniorsentries; ?></span>
                                        </div>
                                        <div class="btn-group">
                                            <span>Search:<span class="text-success font-weight-bold">
                                            <input type="text" id="search-table" class="input-sm">
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <a href="../app/export?bseniors_excl" class="btn btn-dark btn-flat f-s-12">
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
                                                <table class="table table-striped" id="table-search">
                                                    <thead class="bg-warning">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Profile</th>
                                                            <th>Resident ID Number</th>
                                                            <th>Full Name</th>
                                                            <th>Date of Birth</th>
                                                            <th>Age</th>
                                                            <th>Gender</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallseniorcitizens) <= 0){
                                                                echo '<td scope="row" colspan="9" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultallseniorcitizens)){
                                                        ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $counter++ ?></td>
                                                            <td><?php 
                                                            if($row['resident_ProfilePicture'] == 'Default.png'){
                                                                echo '<img src="'.BASE_URL.'public/assets/images/Default.png" class="profile-header" alt="Profile Picture" />';
                                                            }else{
                                                               echo '<img src="'.BASE_URL.'storage/residents/'.$row['resident_ProfilePicture'].'" class="profile-header" alt="Profile Picture" />';
                                                            } ?></td>
                                                            <td><?php echo $row['resident_IDNumber']; ?></td>
                                                            <td><?php echo $row['resident_FirstName'].' '.$row['resident_MiddleName'].' '.$row['resident_LastName'].' '.($row['resident_Suffix'] == 'N/A' ? '' : ' '.$row['resident_Suffix']); ?></td>
                                                            <td><?php echo date('F d, Y',strtotime($row['resident_DateofBirth'])); ?></td>
                                                            <td>
                                                                <?php 
                                                                    $dob = new DateTime($row['resident_DateofBirth']);
                                                                    $today = new DateTime();
                                                                    $age = $today->diff($dob)->y;
                                                                    echo $age;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['resident_Gender']; ?></td>
                                                            <td><?php echo $row['resident_StreetPurok'].', '.$row['resident_Barangay'].', '.$row['resident_Municipality'].', '.$row['resident_Province']; ?></td>
                                                        </tr>
                                                        <?php 
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                              </table>
                                            </div>
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