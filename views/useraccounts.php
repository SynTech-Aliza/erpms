<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Accounts - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">User Accounts</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- ENUMERATOR -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h2>User Accounts</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Entries:</span>
                                            <span class="text-success font-weight-bold"><?php echo $totaluserentries; ?></span>
                                        </div>
                                        <div class="btn-group">
                                            <form method="post">Search Username: 
                                                <input type="text" name="username" class="input-sm">
                                                <button type="submit" name="searchuser" class="btn btn-sm btn-dark">Search</button>
                                            </form>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Role <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="status-filter">
                                                    <li><a href="useraccounts" class="text-uppercase">All</a></li>
                                                    <li><a href="useraccounts?userrole=Administrator" class="text-uppercase">Administrator</a></li>
                                                    <li><a href="useraccounts?userrole=ENUMERATOR" class="text-uppercase">ENUMERATOR</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Status <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="status-filter">
                                                    <li><a href="useraccounts" class="text-uppercase">All</a></li>
                                                    <li><a href="useraccounts?userstatus=Active" class="text-uppercase">Active</a></li>
                                                    <li><a href="useraccounts?userstatus=Inactive" class="text-uppercase">Inactive</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <a href="createnewaccount" class="btn btn-sm btn-success">Create New</a>
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
                                                            <th>Profile</th>
                                                            <th>Username</th>
                                                            <th>Full Name</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
                                                            <th>Appointed</th>
                                                            <th>Registered</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallusers) <= 0){
                                                                echo '<td scope="row" colspan="9" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultallusers)){
                                                                    $hashID = hash('sha256', $row['user_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr onclick="window.location.href='viewuseraccount?u=<?php echo $hashID; ?>'" style="cursor: pointer">
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php 
                                                            if($row['user_ProfilePicture'] == 'Default.png'){
                                                                echo '<img src="'.BASE_URL.'public/assets/images/Default.png" class="profile-header" alt="Profile Picture" />';
                                                            }else{
                                                               echo '<img src="'.BASE_URL.'storage/profiles/'.$row['user_ProfilePicture'].'" class="profile-header" alt="" />';
                                                            } ?></td>
                                                            <td><?php echo $row['user_Username']; ?></td>
                                                            <td><?php echo $row['user_FirstName'].' '.$row['user_MiddleName'].' '.$row['user_LastName']; ?></td>
                                                            <td><?php echo $row['user_EmailAddress']; ?></td>
                                                            <td><?php 
                                                            switch ($row['user_Role']) {
                                                                case '1':
                                                                    echo 'ADMINISTRATOR';
                                                                    break;
                                                                
                                                                default:
                                                                    echo 'ENUMERATOR';
                                                                    break;
                                                            }?></td>
                                                            <td><?php echo $row['user_Appointed']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['user_Registered'])); ?></td>
                                                            <td><?php 
                                                            switch ($row['user_Status']) {
                                                                case '1':
                                                                    echo '<span class="badge badge-success">Active</span>';
                                                                    break;
                                                                
                                                                default:
                                                                    echo '<span class="badge badge-danger">Inactive</span>';
                                                                    break;
                                                            }?></td>
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
                                                <?php if ($userpage > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?userpage=<?php echo $userpage - 1; ?>">Previous</a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- Next Button -->
                                                <?php if ($userpage < $totaluserpages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?userpage=<?php echo $userpage + 1; ?>">Next</a>
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
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/menubar/sidebar.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/preloader/pace.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/scripts.js"></script>
</body>
</html>