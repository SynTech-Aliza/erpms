<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>File Attachments - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        /* File Attachments*/
        .files input {
            outline: 2px dashed #858585;
            outline-offset: -10px;
            -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
            transition: outline-offset .15s ease-in-out, background-color .15s linear;
            padding: 50px 10px 75px 100px;
            text-align: center !important;
            margin: 0;
        }

        .files input:focus{     
            outline: 2px dashed #858585;  
            outline-offset: -10px;
            -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
            transition: outline-offset .15s ease-in-out, background-color .15s linear;
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
                            if(isset($_GET['hr'])){
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Households</li>
                                    <li class="breadcrumb-item">View Household</li>
                                    <li class="breadcrumb-item">Residents</li>
                                    <li class="breadcrumb-item">View Residents</li>
                                    <li class="breadcrumb-item active">File Attachments</li>
                                </ol>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Residents</li>
                                    <li class="breadcrumb-item">View Residents</li>
                                    <li class="breadcrumb-item active">File Attachments</li>
                                </ol>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <?php
                    if(isset($_GET['hr'])){
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h2>File Attachments</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Search:<span class="text-success font-weight-bold">
                                            <input type="text" id="search-table" class="input-sm">
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" data-toggle="modal" data-target="#uploadfileattachments" class="btn btn-success btn-sm">Upload Attachments</a>
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
                                                            <th>File Name</th>
                                                            <th>Size</th>
                                                            <th>Date</th>
                                                            <th><i class="fa-solid fa-ellipsis-vertical"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallfileattachments) <= 0){
                                                                echo '<td scope="row" colspan="5" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultallfileattachments)){
                                                                    $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                                                        ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php echo $row['rattachment_Filename']; ?></td>
                                                            <td><?php echo $row['rattachment_Size']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['rattachment_Uploaded'])); ?></td>
                                                            <td>
                                                                <?php $hashID = hash('sha256', $row['rattachment_ID'] . 'SECRET_KEY'); ?>
                                                                <a href="<?php echo BASE_URL; ?>storage/fileattachments/<?php echo $foldername; ?>/<?php echo $row['rattachment_Filename']; ?>" target="_blank" class="text-primary f-s-15"><i class="fa-solid fa-folder-open"></i></a>
                                                                /
                                                                <a href="fileattachments?hr=<?php echo $hashFromURL;?>&file=<?php echo $hashID;?>&notification=hrdeletefile" class=" text-danger f-s-15"><i class="fa-solid fa-trash-can"></i></a>
                                                            </td>
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
                                <!-- Add File Attachment Start-->
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal fade none-border" id="uploadfileattachments">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                        <strong>File Attachments</strong>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 m-t-10">
                                                            <div class="form-group files">
                                                                <input type="file" id="fileattachment" name="fileattachment[]" class="form-control" multiple="multiple" accept=".pdf,.doc,.docx" required>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="uploadfileattachments" class="btn btn-success">Upload</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <form>
                                <!-- Add File Attachment End-->
                            </div>
                        </div>
                    </div>
                    <?php
                    }else{
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h2>File Attachments</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <span>Search:<span class="text-success font-weight-bold">
                                            <input type="text" id="search-table" class="input-sm">
                                        </div>
                                        <div class="btn-group">
                                            <a href="#" data-toggle="modal" data-target="#uploadfileattachments" class="btn btn-success btn-sm">Upload Attachments</a>
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
                                                            <th>File Name</th>
                                                            <th>Size</th>
                                                            <th>Date</th>
                                                            <th><i class="fa-solid fa-ellipsis-vertical"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="f-s-12">
                                                        <?php
                                                            if(mysqli_num_rows($resultallfileattachments) <= 0){
                                                                echo '<td scope="row" colspan="5" class="text-center">No records found</td>';
                                                            }else{
                                                                $counter = 1;
                                                                while($row = mysqli_fetch_array($resultallfileattachments)){
                                                                    $foldername = $rfirstname."-".$rmiddlename."-".$rlastname.($rsuffix == "N/A" ? "" : "-" . $rsuffix)."_".$rresidentidnumber;
                                                        ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $counter++?></td>
                                                            <td><?php echo $row['rattachment_Filename']; ?></td>
                                                            <td><?php echo $row['rattachment_Size']; ?></td>
                                                            <td><?php echo date('F d, Y h:i A',strtotime($row['rattachment_Uploaded'])); ?></td>
                                                            <td>
                                                                <?php $hashID = hash('sha256', $row['rattachment_ID'] . 'SECRET_KEY'); ?>
                                                                <a href="<?php echo BASE_URL; ?>public/fileattachments/<?php echo $foldername; ?>/<?php echo $row['rattachment_Filename']; ?>" target="_blank" class="text-primary f-s-15"><i class="fa-solid fa-folder-open"></i></a>
                                                                /
                                                                <a href="fileattachments?r=<?php echo $hashFromURL;?>&file=<?php echo $hashID;?>&notification=rdeletefile" class=" text-danger f-s-15"><i class="fa-solid fa-trash-can"></i></a>
                                                            </td>
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
                                <!-- Add File Attachment Start-->
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal fade none-border" id="uploadfileattachments">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                        <strong>File Attachments</strong>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 m-t-10">
                                                            <div class="form-group files">
                                                                <input type="file" id="fileattachment" name="fileattachment[]" class="form-control" multiple="multiple" accept=".pdf,.doc,.docx" required>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="uploadfileattachments" class="btn btn-success">Upload</button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <form>
                                <!-- Add File Attachment End-->
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
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
        $hr = (isset($_GET['hr']) ? $_GET['hr'] : '');
        $r = (isset($_GET['r']) ? $_GET['r'] : '');
        $file = (isset($_GET['file']) ? $_GET['file'] : '');
        // HR
        if($notification == 'hrfileuploaded'){
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
                        title: "File Uploaded Successfully",
                        text: "The resident file has been uploaded and saved.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification == 'hrfileuploadederror'){
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
                        title: "File Upload Failed",
                        text: "An error occurred while uploading the resident file. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification=='hrdeletefile'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete File?",
                        text: "This file will be permanently removed and cannot be recovered.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete it",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "fileattachments?hr='.$hr.'&deletefile='.$file.'";
                        } else {
                            window.location = "fileattachments?hr='.$hr.'";
                        }
                    });
                </script>
            ';
        }elseif($notification == 'hrfiledeleted'){
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
                        title: "File Deleted Successfully",
                        text: "The resident file has been deleted.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification == 'hrfiledeletederror'){
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
                        title: "File Deletion Failed",
                        text: "There was an error deleting the resident file. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?hr='.$hr.'";
                    });
                </script>
            ';
        }

        // R
        elseif($notification == 'rfileuploaded'){
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
                        title: "File Uploaded Successfully",
                        text: "The resident file has been uploaded and saved.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification == 'rfileuploadederror'){
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
                        title: "File Upload Failed",
                        text: "An error occurred while uploading the resident file. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='rdeletefile'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete File?",
                        text: "This file will be permanently removed and cannot be recovered.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete it",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "fileattachments?r='.$r.'&deletefile='.$file.'";
                        } else {
                            window.location = "fileattachments?r='.$r.'";
                        }
                    });
                </script>
            ';
        }elseif($notification == 'rfiledeleted'){
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
                        title: "File Deleted Successfully",
                        text: "The resident file has been deleted.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification == 'rfiledeletederror'){
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
                        title: "File Deletion Failed",
                        text: "There was an error deleting the resident file. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "fileattachments?r='.$r.'";
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