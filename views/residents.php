<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if(isset($_GET['hh'])){echo $hhouseholdidnumber; }else{echo 'Residents';}?> - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                            <?php
                            if(isset($_GET['hh'])){
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Households</li>
                                    <li class="breadcrumb-item">View Household</li>
                                    <li class="breadcrumb-item active">Residents</li>
                                </ol>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Residents</li>
                                </ol>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row">
                        <?php
                        if(isset($_GET['hh'])){
                        ?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h2>Residents</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="border border-primary p-20">
                                            <div class="card-title">
                                                <h4 class="font-weight-bold text-dark">Household Information</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p class="f-s-15">Household ID Number: <span class="text-dark font-weight-bold"><?php echo $hhouseholdidnumber; ?></span></p>
                                                    <p class="f-s-15">Address: <span class="text-dark font-weight-bold"><?php echo $hstreetpurok.', '.$hbarangay.', '.$hmunicipality.', '.$hprovince?></span></p>
                                                    <p class="f-s-15">Type: <span class="text-dark font-weight-bold"><?php echo $htype; ?></span></p>
                                                    <p class="f-s-15">Size: <span class="text-dark font-weight-bold"><?php echo $hsize; ?></span></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p class="f-s-15">Condition: <span class="text-dark font-weight-bold"><?php echo $hcondition; ?></span></p>
                                                    <p class="f-s-15">Utilities: <span class="text-dark font-weight-bold"><?php echo $hutitlies; ?></span></p>
                                                    <p class="f-s-15">Facilities: <span class="text-dark font-weight-bold"><?php echo $hfacilities; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Members:<span class="text-success font-weight-bold"> <?php echo $thref; ?></span>
                                            </span>
                                        </div>
                                        <div class="btn-group">
                                            <span>Search:<span class="text-success font-weight-bold">
                                            <input type="text" id="search-table" class="input-sm">
                                        </div>
                                        <div class="btn-group">
                                            <a href="createnewresident?hh=<?php echo $householdhashID; ?>" class="btn btn-sm btn-success">Add New Member</a>
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
                                                            <th>Resident ID Number</th>
                                                            <th>Full Name</th>
                                                            <th>Date of Birth</th>
                                                            <th>Contact Number</th>
                                                            <th>Email Address</th>
                                                            <th>Date Registered</th>
                                                            <th>Resident Status</th>
                                                            <th>Role</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallhouseholdresidents) < 0){
                                                                echo '<td scope="row" colspan="10" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultallhouseholdresidents)){
                                                                    $hashID = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr onclick="window.location.href='viewresident?hr=<?php echo $hashID;?>'" style="cursor: pointer">
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
                                                            <td><?php echo $row['resident_ContactNumber']; ?></td>
                                                            <td><?php echo $row['resident_EmailAddress']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['resident_Registered'])); ?></td>
                                                            <td><?php echo $row['resident_ResidentStatus']; ?></td>
                                                            <td><?php 
                                                            switch ($row['resident_HouseRole']) {
                                                                case 'HEAD OF HOUSEHOLD':
                                                                    echo '<span class="badge badge-success">Head of Household</span>';
                                                                    break;

                                                                case 'SPOUSE':
                                                                    echo '<span class="badge badge-warning">Spouse</span>';
                                                                    break;

                                                                case 'CHILD':
                                                                    echo '<span class="badge badge-info">Child</span>';
                                                                    break;

                                                                case 'PARENT':
                                                                    echo '<span class="badge badge-primary">Parent</span>';
                                                                    break;

                                                                case 'SIBLING':
                                                                    echo '<span class="badge badge-dark">Sibling</span>';
                                                                    break;

                                                                case 'GRANDPARENT':
                                                                    echo '<span class="badge badge-pink">Grandparent</span>';
                                                                    break;

                                                                case 'GRANDCHILD':
                                                                    echo '<span class="badge badge-maroon">Grandchild</span>';
                                                                    break;
                                                                
                                                                default:
                                                                    echo '<span class="badge badge-danger">Others</span>';
                                                                    break;
                                                            } ?></td>
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
                        <?php
                        }else{
                        ?>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-title">
                                            <h2>Residents</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Entries:</span>
                                            <span class="text-success font-weight-bold"><?php echo $totalresidententries; ?></span>
                                        </div>
                                        <div class="btn-group">
                                            <form method="post">Search Resident ID Number: 
                                                <input type="text" name="residentid" class="input-sm">
                                                <button type="submit" name="searchresident" class="btn btn-sm btn-dark">Search</button>
                                            </form>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Purok <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="residents" class="text-uppercase">All</a></li>
                                                    <?php 
                                                        while ($row = mysqli_fetch_array($resultbarangaypurokfilter)){ 
                                                    ?>
                                                    <li><a href="residents?purok=<?php echo $row['household_StreetPurok']; ?>" class="text-uppercase"><?php echo $row['household_StreetPurok']; ?></a></li>
                                                    <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Age <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                        <li><a href="residents" class="text-uppercase">All</a></li>
                                                        <li><a href="residents?age=0-2 Infants" class="text-uppercase">0-2 Infants</a></li>
                                                        <li><a href="residents?age=3-12 Child" class="text-uppercase">3-12 Child</a></li>
                                                        <li><a href="residents?age=13-17 Teen" class="text-uppercase">13-17 Teen</a></li>
                                                        <li><a href="residents?age=18-25 Young Adult" class="text-uppercase">18-25 Young Adult</a></li>
                                                        <li><a href="residents?age=26-40 Adult" class="text-uppercase">26-40 Adult</a></li>
                                                        <li><a href="residents?age=41-59 Middle Age" class="text-uppercase">41-59 Middle Age</a></li>
                                                        <li><a href="residents?age=60+ Seniors" class="text-uppercase">60+ Seniors</a></li>
                                                    </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Gender <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="residents" class="text-uppercase">All</a></li>
                                                    <li><a href="residents?gender=Male" class="text-uppercase">Male</a></li>
                                                    <li><a href="residents?gender=Female" class="text-uppercase">Female</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Sector <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="status-filter">
                                                    <li><a href="residents" class="text-uppercase">All</a></li>
                                                    <li><a href="residents?sectors=PWD" class="text-uppercase">PWD</a></li>
                                                    <li><a href="residents?sectors=4P's" class="text-uppercase">4P's</a></li>
                                                    <li><a href="residents?sectors=Indigenous People" class="text-uppercase">Indigenous People</a></li>
                                                    <li><a href="residents?sectors=Solo Parent" class="text-uppercase">Solo Parents</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Role <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="residents" class="text-uppercase">All</a></li>
                                                    <li><a href="residents?role=Head of Household" class="text-uppercase">Head of Household</a></li>
                                                    <li><a href="residents?role=Spouse" class="text-uppercase">Spouse</a></li>
                                                    <li><a href="residents?role=Child" class="text-uppercase">Child</a></li>
                                                    <li><a href="residents?role=Parent" class="text-uppercase">Parent</a></li>
                                                    <li><a href="residents?role=Sibling" class="text-uppercase">Sibling</a></li>
                                                    <li><a href="residents?role=Grandparent" class="text-uppercase">Grandparent</a></li>
                                                    <li><a href="residents?role=Grandchild" class="text-uppercase">Grandchild</a></li>
                                                    <li><a href="residents?role=Others" class="text-uppercase">Others</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <a href="../app/export?bresidents_excl" class="btn btn-dark btn-flat f-s-12">
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
                                                            <th>#</th>
                                                            <th>Profile</th>
                                                            <th>Resident ID Number</th>
                                                            <th>Full Name</th>
                                                            <th>Date of Birth</th>
                                                            <th>Age</th>
                                                            <th>Gender</th>
                                                            <th>Address</th>
                                                            <th>Resident Status</th>
                                                            <th>Date Registered</th>
                                                            <th>Role</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallresidents) <= 0){
                                                                echo '<td scope="row" colspan="11" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = $residentstart + 1;
                                                                while($row = mysqli_fetch_array($resultallresidents)){
                                                                    $hashID = hash('sha256', $row['resident_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr onclick="window.location.href='viewresident?r=<?php echo $hashID;?>'" style="cursor: pointer">
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
                                                            <td><?php echo $row['resident_ResidentStatus']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['resident_Registered'])); ?></td>
                                                            <td><?php 
                                                            switch ($row['resident_HouseRole']) {
                                                                case 'HEAD OF HOUSEHOLD':
                                                                    echo '<span class="badge badge-success">Head</span>';
                                                                    break;

                                                                case 'SPOUSE':
                                                                    echo '<span class="badge badge-warning">Spouse</span>';
                                                                    break;

                                                                case 'CHILD':
                                                                    echo '<span class="badge badge-info">Child</span>';
                                                                    break;

                                                                case 'PARENT':
                                                                    echo '<span class="badge badge-primary">Parent</span>';
                                                                    break;

                                                                case 'SIBLING':
                                                                    echo '<span class="badge badge-dark">Sibling</span>';
                                                                    break;

                                                                case 'GRANDPARENT':
                                                                    echo '<span class="badge badge-pink">Grandparent</span>';
                                                                    break;

                                                                case 'GRANDCHILD':
                                                                    echo '<span class="badge badge-maroon">Grandchild</span>';
                                                                    break;
                                                                
                                                                default:
                                                                    echo '<span class="badge badge-danger">Others</span>';
                                                                    break;
                                                            } ?></td>
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
                                                    if (isset($_GET['purok'])) {
                                                        $query = "&purok=" . urlencode($_GET['purok']);
                                                    }elseif (isset($_GET['age'])) {
                                                        $query = "&age=" . urlencode($_GET['age']);
                                                    }elseif (isset($_GET['gender'])) {
                                                        $query = "&gender=" . urlencode($_GET['gender']);
                                                    }elseif (isset($_GET['sectors'])) {
                                                        $query = "&sectors=" . urlencode($_GET['sectors']);
                                                    }
                                                ?>
                                                <!-- Previous Button -->
                                                <?php if ($residentpage > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?residentpage=<?php echo $residentpage - 1 . $query; ?>">Previous</a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- Next Button -->
                                                <?php if ($residentpage < $totalresidentpages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?residentpage=<?php echo $residentpage + 1 . $query ; ?>">Next</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
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
        $hh = (isset($_GET['hh']) ? $_GET['hh'] : '');
        if($notification=='householdresidentdeleted'){
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
                        title: "Resident Deleted Successfully",
                        text: "The resident information has been removed from the system.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "residents?hh='.$hh.'";
                    });
                </script>
            ';
        }
        elseif($notification=='residentdeleted'){
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
                        title: "Resident Deleted Successfully",
                        text: "The resident information has been removed from the system.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "residents";
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