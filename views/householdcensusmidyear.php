<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resident Census Midyear - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">Resident Census Midyear</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-title">
                                            <h2>Midyear Records</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <form method="post" class="form-inline d-flex align-items-center"> 
                                                <select id="userrole" name="midyear" class="form-control form-control text-uppercase mr-2" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                    <option value="All" selected>Year</option>
                                                    <?php while ($row = mysqli_fetch_array($resultresidentyearmidyear)) { ?>
                                                        <option value="<?php echo $row['rc_Year']; ?>">
                                                            <?php echo $row['rc_Year']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <button type="submit" name="selectmidyear" class="btn btn-sm btn-dark m-r-5">Select</button>
                                                <button type="submit" name="exportmidyearrecord" class="btn btn-sm btn-success">Export Record</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Table List -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped f-s-12" id="table-search">
                                                    <thead class="bg-warning">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Year</th>
                                                            <th>Profile</th>
                                                            <th>Name</th>
                                                            <th>Educational Attainment</th>
                                                            <th>Person with Disability?</th>
                                                            <th>4Ps Member?</th>
                                                            <th>Occupation</th>
                                                            <th>Monthly Income</th>
                                                            <th>Employment Status</th>
                                                            <th><i class="fa-solid fa-ellipsis-vertical"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultmidyearresidententries) <= 0){
                                                                echo '<td scope="row" colspan="11" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultmidyearresidententries)){
                                                                    $hashID = hash('sha256', $row['rc_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php echo $row['rc_Year']; ?></td>
                                                            <td><?php 
                                                            if($row['resident_ProfilePicture'] == 'Default.png'){
                                                                echo '<img src="'.BASE_URL.'public/assets/images/Default.png" class="profile-header" alt="Profile Picture" />';
                                                            }else{
                                                               echo '<img src="'.BASE_URL.'storage/residents/'.$row['resident_ProfilePicture'].'" class="profile-header" alt="" />';
                                                            } ?></td>
                                                            <td><?php echo $row['resident_FirstName'].' '.$row['resident_FirstName'].' '.$row['resident_FirstName']; ?></td>
                                                            <td><?php echo $row['rc_EducationAttainment']; ?></td>
                                                            <td><?php echo ($row['rc_PWD'] == 1) ? 'YES' : 'NO'; ?></td>
                                                            <td><?php echo ($row['rc_Fourps'] == 1) ? 'YES' : 'NO'; ?></td>
                                                            <td><?php echo $row['rc_Occupation']; ?></td>
                                                            <td><?php echo '₱' . number_format($row['rc_MonthlyIncome']); ?></td>
                                                            <td><?php echo $row['rc_EmployerStatus']; ?></td>
                                                            <td><a href="residentcensusmidyear?myr=<?php echo $hashID?>&notification=deletemyrrecord"><i class="fa-solid fa-xmark text-danger"></i></a></td>
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
                                                <?php
                                                $query = "";
                                                ?>

                                                <!-- Previous -->
                                                <?php if ($myrpage > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?=<?= $myrpage - 1 . $query ?>">Previous Page</a>
                                                    </li>
                                                <?php endif; ?>
                                                <!-- Next -->
                                                <?php if ($myrpage < $totalmyrpages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?myrpage=<?= $myrpage + 1 . $query ?>">Next Page</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
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
        $myr = (isset($_GET['myr']) ? $_GET['myr'] : '');
        if($notification == 'deletemyrrecord'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete Census Record?",
                        text: "This action cannot be undone. The census record will be permanently deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "residentcensusmidyear?deletemyrrecord='.$myr.'";
                        } else {
                            window.location = "residentcensusmidyear";
                        }
                    });
                </script>
            ';
        }
        elseif($notification == 'recorddeleteerror'){
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
                        title: "Unable to Delete Census Record",
                        text: "There was a problem deleting the census record. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "residentcensusmidyear";
                    });
                </script>
            ';
        }
        elseif($notification == 'recorddeleted'){
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
                        title: "Census Record Deleted Successfully",
                        text: "The census record has been removed from the system.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "residentcensusmidyear";
                    });
                </script>
            ';
        }
    ?>
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/menubar/sidebar.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/preloader/pace.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/scripts.js"></script>
</body>
</html>