<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Households - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                                    <li class="breadcrumb-item active">Households</li>
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
                                            <h2>Households</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Total Entries:</span>
                                            <span class="text-success font-weight-bold"><?php echo $thf; ?></span>
                                        </div>
                                        <div class="btn-group">
                                            <form method="post">Search Household ID: 
                                                <input type="text" name="householdid" class="input-sm">
                                                <button type="submit" name="searchhousehold" class="btn btn-sm btn-dark">Search</button>
                                            </form>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Purok <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="households" class="text-uppercase">All</a></li>
                                                    <?php 
                                                        while ($row = mysqli_fetch_array($resultbarangaypurokfilter)){ 
                                                    ?>
                                                    <li><a href="households?purok=<?php echo $row['household_StreetPurok']; ?>" class="text-uppercase"><?php echo $row['household_StreetPurok']; ?></a></li>
                                                    <?php
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Type <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="households" class="text-uppercase">All</a></li>
                                                    <li><a href="households?type=Owned" class="text-uppercase">Owned</a></li>
                                                    <li><a href="households?type=Rented" class="text-uppercase">Rented</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Size <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="households" class="text-uppercase">All</a></li>
                                                    <li><a href="households?size=Small (1-2 rooms)" class="text-uppercase">Small (1-2 rooms)</a></li>
                                                    <li><a href="households?size=Medium (3-4 rooms)" class="text-uppercase">Medium (3-4 rooms)</a></li>
                                                    <li><a href="households?size=Large (5%2B rooms)" class="text-uppercase">Large (5+ rooms)</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm btn-outline btn-flat dropdown-toggle f-s-12" data-toggle="dropdown">
                                                    <i class="fa-solid fa-filter f-s-13"></i> Condition <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" id="status-filter">
                                                    <li><a href="households" class="text-uppercase">All</a></li>
                                                    <li><a href="households?conditon=Concrete" class="text-uppercase">Concrete</a></li>
                                                    <li><a href="households?conditon=Semi-Concrete" class="text-uppercase">Semi-Concrete</a></li>
                                                    <li><a href="households?conditon=Wood" class="text-uppercase">Wood</a></li>
                                                    <li><a href="households?conditon=Light Materials" class="text-uppercase">Light Materials</a></li>
                                                    <li><a href="households?conditon=Mixed Materials" class="text-uppercase">Mixed Materials</a></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <a href="../app/export?bhousehold_excl" class="btn btn-dark btn-flat f-s-12">
                                                    <i class="fa-solid fa-file-arrow-down"></i> Excel Export
                                                </a>
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <a href="createnewhousehold" class="btn btn-sm btn-success">Create New</a>
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
                                                            <th>Household ID</th>
                                                            <th>Head of Household</th>
                                                            <th>Address</th>
                                                            <th>Type</th>
                                                            <th>Size</th>
                                                            <th>Condition</th>
                                                            <th>Members</th>
                                                            <th>Date Registered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallhouseholds) <= 0){
                                                                echo '<td scope="row" colspan="9" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = $householdstart + 1;
                                                                while($row = mysqli_fetch_array($resultallhouseholds)){
                                                                    $hashID = hash('sha256', $row['household_ID'] . 'SECRET_KEY');
                                                        ?>
                                                        <tr onclick="window.location.href='viewhousehold?hh=<?php echo $hashID; ?>'" style="cursor: pointer">
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php echo $row['household_IDNumber']; ?></td>
                                                            <td><?php echo $row['headofhousehold']; ?></td>
                                                            <td><?php echo $row['household_StreetPurok'].', '.$row['household_Barangay'].', '.$row['household_Municipality'].', '.$row['household_Province']; ?></td>
                                                            <td><?php
                                                                switch ($row['household_Type']) {
                                                                    case 'OWNED':
                                                                        echo '<span class="badge badge-success">Owned</span>';
                                                                        break;
                                                                    
                                                                    default:
                                                                        echo '<span class="badge badge-danger">Rented</span>';
                                                                        break;
                                                                }
                                                            ?></td>
                                                            <td><?php echo $row['household_Size']; ?></td>
                                                            <td><?php echo $row['household_Condition']; ?></td>
                                                            <td><?php echo $row['totalresidents']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['household_Registered'])); ?></td>
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
                                                    if (isset($_GET['post'])) {
                                                        $query = "&purok=" . urlencode($_GET['purok']);
                                                    }elseif (isset($_GET['type'])) {
                                                        $query = "&type=" . urlencode($_GET['type']);
                                                    }elseif (isset($_GET['size'])) {
                                                        $query = "&size=" . urlencode($_GET['size']);
                                                    }elseif (isset($_GET['conditon'])) {
                                                        $query = "&conditon=" . urlencode($_GET['conditon']);
                                                    }
                                                ?>
                                                <!-- Previous Button -->
                                                <?php if ($householdpage > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?householdpage=<?php echo $householdpage - 1 . $query; ?>">Previous</a>
                                                    </li>
                                                <?php endif; ?>

                                                <!-- Next Button -->
                                                <?php if ($householdpage < $totalhouseholdpages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?householdpage=<?php echo $householdpage + 1 . $query; ?>">Next</a>
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