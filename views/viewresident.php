<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if(isset($_GET['hr'])){echo $rresidentidnumber; }else{echo $rresidentidnumber;}?> - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        /*Choose Profile*/
        .img-div:hover .img-placeholder{
            display: block;
            cursor: pointer;
        }
        .img-div:hover .img-placeholders{
            display: block;
            cursor: pointer;
        }
        #profilepicture { 
            display: block;
            height: 160px;
            width: 160px;
            margin-left: auto;
            margin-right: auto;
            cursor: pointer;
            outline: 2px dashed #858585;
        }

        #otherID {
            display: none; /* Hide the input initially */
        }

        .radio{
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
                            <?php 
                            if(isset($_GET['hr'])){
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Households</li>
                                    <li class="breadcrumb-item">View Household</li>
                                    <li class="breadcrumb-item">Residents</li>
                                    <li class="breadcrumb-item active">View Resident</li>
                                </ol>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Residents</li>
                                    <li class="breadcrumb-item active">View Resident</li>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-title">
                                            <h3 class="font-weight-bold">RESIDENT INFORMATION</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php 
                                    if(isset($_GET['hr'])){
                                    ?>
                                    <div class="col-lg-12 text-right">
                                        <a href="fileattachments?hr=<?php echo $hashFromURL; ?>"class="btn btn-sm btn-primary" target="_blank">Resident File Attachments</a>
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                    <div class="col-lg-12 text-right">
                                        <button type="button" data-toggle="modal" data-target="#addcensusrecord" class="btn btn-sm btn-success" target="_blank">Add Census Record</button>
                                        <!-- <a href="#" class="btn btn-sm btn-warning" target="_blank">Census Record Histories</a> -->
                                        <a href="fileattachments?r=<?php echo $hashFromURL; ?>" class="btn btn-sm btn-primary" target="_blank">Resident File Attachments</a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Resident ID Number</label>
                                                            <input type="text" name="residentidnumber" class="form-control text-center font-weight-bold bg-info f-s-50 h-50 text-white text-uppercase" value="<?php echo $rresidentidnumber; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Household Role</label><br/>
                                                            <select name="householdrole" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $rhouserole; ?>" selected><?php echo $rhouserole; ?></option>
                                                                <option value="Head of Household" style="display:<?php echo $headofhouseholdstatus; ?>">Head of Household</option>
                                                                <option value="Spouse">Spouse</option>
                                                                <option value="Child">Child</option>
                                                                <option value="Parent">Parent</option>
                                                                <option value="Sibling">Sibling</option>
                                                                <option value="Grandparent">Grandparent</option>
                                                                <option value="Grandchild">Grandchild</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Resident Status</label><br/>
                                                            <div class="form-check form-check-inline m-r-20">
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Permanent" <?php if($rresidentstatus == 'PERMANENT') echo 'checked'; ?>>
                                                                <label class="form-check-label">Permanent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline m-r-20">
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Temporary" <?php if($rresidentstatus == 'TEMPORARY') echo 'checked'; ?>>
                                                                <label class="form-check-label">Temporary</label>
                                                            </div>
                                                            <div class="form-check form-check-inline m-r-20">
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Renter" <?php if($rresidentstatus == 'RENTER') echo 'checked'; ?>>
                                                                <label class="form-check-label">Renter</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">Personal Information</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4 text-center">
                                                        <div class="form-group">
                                                            <div class="user-photo">
                                                                <?php
                                                                if($rprofilepicture == 'Default.png'){
                                                                    $profile = BASE_URL.'public/assets/images/Default.png';
                                                                }else{
                                                                    $profile = BASE_URL.'storage/residents/'.$rprofilepicture.'';
                                                                }
                                                                ?>
                                                                <span class="img-div text">
                                                                    <img class="img-fluid" src="<?php echo $profile; ?>" alt="profile-picture" onClick="triggerClickProfileImage()" id="profilepicture">
                                                                </span>
                                                                <input type="file" name="profilepicture" onChange="displayProfileImage(this)" id="profileselect" accept="image/jpeg, image/png" style="display: none;">
                                                            </div>
                                                            <label class="m-t-10">Profile Picture</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>First Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="firstname" value="<?php echo $rfirstname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Middle Name</label>
                                                                    <input type="text" name="middlename" value="<?php echo $rmiddlename; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Last Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="lastname" value="<?php echo $rlastname; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Suffix <span class="text-danger">*</span></label>
                                                                    <select name="suffix" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                        <option value="<?php echo $rsuffix; ?>" selected><?php echo $rsuffix; ?></option>
                                                                        <option value="N/A">N/A</option>
                                                                        <option value="Jr">Jr</option>
                                                                        <option value="Sr">Sr</option>
                                                                        <option value="I">I</option>
                                                                        <option value="II">II</option>
                                                                        <option value="III">III</option>
                                                                        <option value="IV">IV</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                                                    <input type="date" name="dateofbirth" value="<?php echo $rdateofbirth; ?>" class="form-control font-weight-bold text-uppercase input-sm" id="dateofbirth" onchange="calculateAge()" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Age</label>
                                                                    <input type="text" name="age" value="<?php echo $rage; ?>" class="form-control font-weight-bold text-uppercase input-sm" id="age" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Gender <span class="text-danger">*</span></label>
                                                            <select name="gender" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $rgender; ?>" selected><?php echo $rgender; ?></option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Civil Status</label>
                                                            <select name="civilstatus" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $rcivilstatus; ?>" selected><?php echo $rcivilstatus; ?></option>
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
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Religion <span class="text-danger">*</span></label>
                                                            <input type="text" name="religion" value="<?php echo $rreligion; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Nationality <span class="text-danger">*</span></label>
                                                            <input type="text" name="nationality" value="<?php echo $rnationality; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Street/ Purok <span class="text-danger">*</span></label>
                                                            <input type="text" name="streetpurok" value="<?php echo $hstreetpurok; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Barangay</label>
                                                            <input type="text" name="barangay" value="<?php echo $hbarangay; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Municipality</label>
                                                            <input type="text" name="municipality" value="<?php echo $hmunicipality; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Province</label>
                                                            <input type="text" name="province" value="<?php echo $hprovince; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Contact Number </label>
                                                            <input type="text" name="contactnumber" value="<?php echo $rcontactnumber; ?>" class="form-control font-weight-bold text-uppercase input-sm" placeholder="09xxxxxxxxx" maxlength="11" pattern="09\d{9}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Email Address</label>
                                                            <input type="email" name="emailaddress" value="<?php echo $remailaddress; ?>" class="form-control font-weight-bold text-lowercase input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Educational Attainment <span class="text-danger">*</span></label>
                                                            <select name="educationalattainment" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $reducationalattainment; ?>" selected><?php echo $reducationalattainment; ?></option>
                                                                <option value="No Education">No Education</option>
                                                                <option value="Elementary Level">Elementary Level</option>
                                                                <option value="Elementary Graduate">Elementary Graduate</option>
                                                                <option value="High School Level">High School Level</option>
                                                                <option value="High School Graduate">High School Graduate</option>
                                                                <option value="Junior High School Level">Junior High School Level</option>
                                                                <option value="Junior High School Graduate">Junior High School Graduate</option>
                                                                <option value="Senior High School Level">Senior High School Level</option>
                                                                <option value="Senior High School Graduate">Senior High School Graduate</option>
                                                                <option value="College Level">College Level</option>
                                                                <option value="College Graduate">College Graduate</option>
                                                                <option value="Vocational">Vocational</option>
                                                                <option value="Post-Graduate">Post-Graduate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Height (ft) <span class="text-danger">*</span></label>
                                                            <input type="text" name="height" value="<?php echo $rheight; ?>" id="feet" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Weight (kg) <span class="text-danger">*</span></label>
                                                            <input type="text" name="weight" value="<?php echo $rweight; ?>" id="kg" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Blood Type <span class="text-danger">*</span></label>
                                                            <select name="bloodtype" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $rbloodtype; ?>" selected><?php echo $rbloodtype; ?></option>
                                                                <option valye="N/A">N/A</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="O">O</option>
                                                                <option value="AB">AB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Are you a Solo Parent? <span class="text-danger">*</span></label>
                                                            <select name="parentstatus" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $rparentstatus; ?>" selected><?php echo $rparentstatus; ?></option>
                                                                <option value="N/A">N/A</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Person with Disability?</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="pwd" value="1" <?php if($rpwd == '1') echo 'checked'; ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="pwd" value="0" <?php if($rpwd == '0') echo 'checked'; ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">4Ps Member?</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="fourps" value="1" <?php if($rfourps == '1') echo 'checked'; ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="fourps" value="0" <?php if($rfourps == '0') echo 'checked'; ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Indigenous People?</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="indigenous" value="1" <?php if($rindegenous == '1') echo 'checked'; ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="indigenous" value="0" <?php if($rindegenous == '0') echo 'checked'; ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Voter Status</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Registered" <?php if($rvoterstatus == 'REGISTERED') echo 'checked'; ?>>
                                                                <label class="form-check-label">Registered</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Not Registered" <?php if($rvoterstatus == 'NOT REGISTERED') echo 'checked'; ?>>
                                                                <label class="form-check-label">Not Registered</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Not Eligible" <?php if($rvoterstatus == 'NOT ELIGIBLE') echo 'checked'; ?>>
                                                                <label class="form-check-label">Not Eligible</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">Personal Identification</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ID Type <span class="text-danger">*</span></label>
                                                            <select name="idtype" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" id="idtype" onchange="showInput()" required>
                                                                <option value="<?php echo $ridtype; ?>" selected><?php echo $ridtype; ?></option>
                                                                <option value="None">None</option>
                                                                <option value="School ID">School ID</option>
                                                                <option value="PhilHealth ID">PhilHealth ID</option>
                                                                <option value="National ID">National ID</option>
                                                                <option value="Postal ID">Postal ID</option>
                                                                <option value="TIN ID">TIN ID</option>
                                                                <option value="SSS ID / SSS UMID">SSS ID / SSS UMID</option>
                                                                <option value="GSIS ID / GSIS UMID">GSIS ID / GSIS UMID</option>
                                                                <option value="Drivers License">Drivers License</option>
                                                                <option value="PRC ID">PRC ID</option>
                                                                <option value="GOCC ID">GOCC ID</option>
                                                                <option value="Voters ID">Voters ID</option>
                                                                <option value="OthersID">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4" id="otherID">
                                                        <div class="form-group">
                                                            <label>Other ID <span class="text-danger">*</span></label>
                                                            <input type="text" name="otheridtype" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>ID Number</label>
                                                            <input type="text" name="idnumber" value="<?php echo $ridnumber; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">Employment Information</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Employment Status <span class="text-danger">*</span></label>
                                                            <select name="employementstatus" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $remployerstatus; ?>" selected><?php echo $remployerstatus; ?></option>
                                                                <option value="Employed">Employed</option>
                                                                <option value="Self-employed">Self-employed</option>
                                                                <option value="Unemployed">Unemployed</option>
                                                                <option value="Retired">Retired</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Occupation</label>
                                                            <input type="text" name="occupation" value="<?php echo $roccupation; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Monthly Income <span class="text-danger">*</span></label>
                                                            <input type="text" name="monthlyincome" value="<?php echo $rmonthlyincome; ?>" id="monthlyincome" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Employer / Business Name</label>
                                                            <input type="text" name="employerbusinessname" value="<?php echo $remployerbusinessname; ?>" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div> 
                                                </div>
                                                <button type="submit" class="btn btn-success" name="updateinformation">UPDATE</button>
                                                <?php 
                                                if(isset($_GET['hr'])){
                                                ?>
                                                <a href="viewresident?hr=<?php echo $residentshashID; ?>&notification=deletehouseholdresident" class="btn btn-danger">DELETE</a>
                                                <a href="residents?hh=<?php echo $householdhashID; ?>" class="btn btn-dark">CANCEL</a>
                                                <?php
                                                }else{
                                                ?>
                                                <a href="viewresident?r=<?php echo $residentshashID; ?>&notification=deleteresident" class="btn btn-danger">DELETE</a>
                                                <a href="residents" class="btn btn-dark">CANCEL</a>
                                                <?php
                                                }
                                                ?>
                                            </form>
                                            <!-- Form End -->
                                            <!-- Census Modal Start -->
                                            <div class="modal fade none-border" id="addcensusrecord">
                                                <div class="modal-dialog modal-lg" style="margin-top:0px">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                <strong>Census for<b>
                                                                    <?php
                                                                    if($censustype == 'SPECIAL'){
                                                                        echo $censusyear.' '.$censuscontext.': '.$censusname;
                                                                    }else{
                                                                        echo $censusyear.' '.$censustype;
                                                                    }$censusyear;
                                                                    ?></b></strong>
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post">
                                                                <?php 
                                                                if($censustype == 'SPECIAL'){
                                                                    switch ($censuscontext) {
                                                                        case 'DISASTER-RELATED':
                                                                ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Affected?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaffected" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaffected" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Missing?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusmissing" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusmissing" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Deceased?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdeceased" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdeceased" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Displaced?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdisplaced" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdisplaced" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Medical Attention?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsmedicalattention" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsmedicalattention" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Food Assistance?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsfoodassistance" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsfoodassistance" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Shelter?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsshelter" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsshelter" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Injury Status</label>
                                                                                        <select name="censusinjurystatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="None" selected>None</option>
                                                                                            <option value="Minor">Minor</option>
                                                                                            <option value="Severe">Severe</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Current Location</label>
                                                                                        <select name="censuscurrentlocation" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="Home" selected>Home</option>
                                                                                            <option value="Evacuation">Evacuation</option>
                                                                                            <option value="Relative">Relative</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                            break;
                                                                        
                                                                        case 'HEALTH EMERGENCY':
                                                                ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Has Symptoms?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushassymptoms" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushassymptoms" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Under Monitoring?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusundermonitoring" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusundermonitoring" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Symptom Details <span class="text-danger">*</span></label>
                                                                                        <input type="text" name="censussymptomdetails" class="form-control font-weight-bold text-uppercase input-sm" placeholder="Fever, Cough, etc" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Diagnosed Disease <span class="text-danger">*</span></label>
                                                                                        <input type="text" name="censusdiagnosedisease" class="form-control font-weight-bold text-uppercase input-sm" placeholder="Dengue, COVID, etc" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Quarantine Status</label>
                                                                                        <select name="censusquarantinestatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="None" selected>None</option>
                                                                                            <option value="Home">Home</option>
                                                                                            <option value="Facility">Facility</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Vaccination Status</label>
                                                                                        <select name="censusvaccinationstatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="None" selected>None</option>
                                                                                            <option value="Partial">Partial</option>
                                                                                            <option value="Full">Full</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Date Diagnosed <span class="text-danger">*</span></label><br/>
                                                                                        <input type="date" name="censusdatediagnosed" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Recovery Status</label>
                                                                                        <select name="censusrecoverystatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="Recovered" selected>Recovered</option>
                                                                                            <option value="Ongoing">Ongoing</option>
                                                                                            <option value="Deceased">Deceased</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                            break;

                                                                        case 'LIVELIHOOD/ ECONOMIC IMPACT':
                                                                ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Employment Status</label>
                                                                                        <select name="censuslemployementstatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="Unemployed" selected>Unemployed</option>
                                                                                            <option value="Employed">Employed</option>
                                                                                            <option value="Self-employed">Self-employed</option>
                                                                                            <option value="Retired">Retired</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Job Lost?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusjoblost" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusjoblost" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Type of Work</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censustypeofwork" value="Formal" checked>
                                                                                            <label class="form-check-label">Formal</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censustypeofwork" value="Informal">
                                                                                            <label class="form-check-label">Informal</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Occupation <span class="text-danger">*</span></label>
                                                                                        <input type="text" name="censusloccupation" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Monthly Income Before</label>
                                                                                        <input type="text" name="censusmonthlyincomebefore" value="0" id="monthlyincomebefore" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Monthly Income After</label>
                                                                                        <input type="text" name="censusmonthlyincomeafter" value="0" id="monthlyincomeafter" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Business Affected?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusbusinessaffected" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusbusinessaffected" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Livelihood Assistance ?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedlivelihoodassistance" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedlivelihoodassistance" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                            break;

                                                                        case 'SOCIAL ASSISTANCE/ BENEFICIARY':
                                                                ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">4Ps Beneficiary</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusfourpsbeneficiary" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusfourpsbeneficiary" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Senior Citizen?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusseniorcitizen" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusseniorcitizen" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Person with Disability?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censuspersonwithdisability" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censuspersonwithdisability" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Solo Parent?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censussoloparent" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censussoloparent" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Assistance Type</label>
                                                                                        <select name="censusassistancetype" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="Cash" selected>Cash</option>
                                                                                            <option value="Food">Food</option>
                                                                                            <option value="Medical">Medical</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>If Cash Amount Received</label>
                                                                                        <input type="text" name="censusamountreceived" value="0" id="amountreceived" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Date Received <span class="text-danger">*</span></label>
                                                                                        <input type="date" name="censusdatereceived" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                            break;

                                                                        default:
                                                                ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Currently Enrolled?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censuscurrentlyenrolled" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censuscurrentlyenrolled" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>School Name <span class="text-danger">*</span></label>
                                                                                        <input type="text" name="censusschoolname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Grade/ Level <span class="text-danger">*</span></label>
                                                                                        <input type="text" name="censusgradelevel" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Mode of Learning</label>
                                                                                        <select name="censusmodeoflearning" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="Face-to-face" selected>Face-to-face</option>
                                                                                            <option value="Online">Online</option>
                                                                                            <option value="Modular">Modular</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Dropped Out?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdroppedout" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusdroppedout" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Educational Support ?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedseducationalsupport" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedseducationalsupport" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                            break;
                                                                    }
                                                                }else{
                                                                ?>
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Educational Attainment</label>
                                                                                <select name="censuseducationalattainment" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                    <option value="None" selected>None</option>
                                                                                    <option value="No Education">No Education</option>
                                                                                    <option value="Elementary Level">Elementary Level</option>
                                                                                    <option value="Elementary Graduate">Elementary Graduate</option>
                                                                                    <option value="High School Level">High School Level</option>
                                                                                    <option value="High School Graduate">High School Graduate</option>
                                                                                    <option value="Junior High School Level">Junior High School Level</option>
                                                                                    <option value="Junior High School Graduate">Junior High School Graduate</option>
                                                                                    <option value="Senior High School Level">Senior High School Level</option>
                                                                                    <option value="Senior High School Graduate">Senior High School Graduate</option>
                                                                                    <option value="College Level">College Level</option>
                                                                                    <option value="College Graduate">College Graduate</option>
                                                                                    <option value="Vocational">Vocational</option>
                                                                                    <option value="Post-Graduate">Post-Graduate</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Person with Disability?</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censuspwd" value="1">
                                                                                    <label class="form-check-label">Yes</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censuspwd" value="0" checked>
                                                                                    <label class="form-check-label">No</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="form-label">4Ps Member?</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censusfourps" value="1">
                                                                                    <label class="form-check-label">Yes</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censusfourps" value="0" checked>
                                                                                    <label class="form-check-label">No</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Employment Status</label>
                                                                                <select name="censusemployementstatus" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                    <option value="None" selected>None</option>
                                                                                    <option value="Employed">Employed</option>
                                                                                    <option value="Self-employed">Self-employed</option>
                                                                                    <option value="Unemployed">Unemployed</option>
                                                                                    <option value="Retired">Retired</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Occupation</label>
                                                                                <input type="text" name="censusoccupation" class="form-control font-weight-bold text-uppercase input-sm">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Monthly Income</label>
                                                                                <input type="text" name="censusmonthlyincome" value="0" id="censusmonthlyincome" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                                <div class="modal-footer">
                                                                    <button type="submit" name="addcensusrecord" class="btn btn-success waves-effect waves-light save-category">SUBMIT</button>
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Census Modal End -->
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
        $hr = (isset($_GET['hr']) ? $_GET['hr'] : '');
        $r = (isset($_GET['r']) ? $_GET['r'] : '');
        $date = (isset($_GET['date']) ? $_GET['date'] : '');
        $formattedDate = date("F j, Y", strtotime($date));
        // Household Residents
        if($notification=='householdresidentinformationupdated'){
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
                        title: "Resident Information Updated",
                        text: "The resident information has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification=='householdresidentinformationerror'){
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
                        title: "Unable to Update Resident Information",
                        text: "There was a problem updating the resident information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification=='deletehouseholdresident'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete Resident Information?",
                        text: "This action cannot be undone. The resident information will be permanently deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "viewresident?hr='.$hr.'&deleteresident='.$hr.'";
                        } else {
                            window.location = "viewresident?hr='.$hr.'";
                        }
                    });
                </script>
            ';
        }elseif($notification=='householdresidentdeleteerror'){
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
                        title: "Unable to Resident Information",
                        text: "There was a problem deleting the resident information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?hr='.$hr.'";
                    });
                </script>
            ';
        }elseif($notification=='householdresidenterrorimagetype'){
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
                        title: "Unsupported Image Type.",
                        text: "Please upload a valid image file (JPG, JPEG, PNG or GIF only).",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?hr='.$hr.'";
                    });
                </script>
            ';
        }
        
        // Residents
        elseif($notification=='residentinformationupdated'){
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
                        title: "Resident Information Updated",
                        text: "The resident information has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='residentinformationerror'){
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
                        title: "Unable to Update Resident Information",
                        text: "There was a problem updating the resident information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='deleteresident'){
            echo '
                <script type="text/javascript">
                    Swal.fire({
                        title: "Delete Resident Information?",
                        text: "This action cannot be undone. The resident information will be permanently deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#0d6efd",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "viewresident?r='.$r.'&deleteresident='.$r.'";
                        } else {
                            window.location = "viewresident?r='.$r.'";
                        }
                    });
                </script>
            ';
        }elseif($notification=='residentdeleteerror'){
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
                        title: "Unable to Resident Information",
                        text: "There was a problem deleting the resident information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='residenterrorimagetype'){
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
                        title: "Unsupported Image Type.",
                        text: "Please upload a valid image file (JPG, JPEG, PNG or GIF only).",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }

        // Census
        elseif($notification=='censusrecorded'){
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
                        title: "Resident Census Recorded",
                        text: "The resident census has been recorded successfully.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='errorcensusrecorded'){
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
                        title: "Unable to Record Resident Census",
                        text: "There was a problem recording the resident census. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r='.$r.'";
                    });
                </script>
            ';
        }elseif($notification=='censusrecordedexist'){
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
                        icon: "warning",
                        title: "Census Record Already Exists",
                        text: "A census record was already recorded on '.$formattedDate.'.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewresident?r=' . $r . '";
                    });
                </script>
            ';
        }
    ?>
    
    <script>
const form = document.getElementById("censusForm");

form.addEventListener("submit", function(e) {
    e.preventDefault(); // stop default submit

    Swal.fire({
        title: "Confirm Submission",
        text: "Do you want to continue saving this record?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Submit",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {

            // optional loading
            Swal.fire({
                title: "Saving...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // IMPORTANT: use stored form variable
            setTimeout(() => {
                form.submit();
            }, 500);
        }
    });
});
</script>
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
        
        // Height ft
        document.getElementById('feet').addEventListener('input', function () {
            let raw = this.value.replace(/[^\d]/g, ''); // Remove non-digits

            if (raw.length === 0) {
                this.value = '';
            } else if (raw.length <= 2) {
                // Assume feet only
                this.value = raw.charAt(0) + (raw.length === 2 ? "'" + raw.charAt(1) + '"' : "'");
            } else {
                // First digit(s) = feet, rest = inches
                let feet = raw.slice(0, 1);
                let inches = raw.slice(1, 3);
                this.value = feet + "'" + inches + '"';
            }
        });

        // Weight kg
        const kgInput = document.getElementById('kg');
        kgInput.addEventListener('input', function () {
            let val = this.value.replace(/[^\d.]/g, ''); // Keep only numbers and dot
            this.value = val;
        });

        // ID Type Other
        function showInput() {
            var selectID = document.getElementById("idtype");
            var selectedIDValue = selectID.value;

            var otherIDDiv = document.getElementById("otherID");
            var otherIDInput = otherIDDiv.querySelector("input");

            if (selectedIDValue === "OthersID") {
                otherIDDiv.style.display = "block";
                otherIDInput.setAttribute("required", "required");
            } else {
                otherIDDiv.style.display = "none";
                otherIDInput.removeAttribute("required");
                otherIDInput.value = ""; // optional reset
            }
        }

        // Profile DIsplay
        function triggerClickProfileImage() {
            document.querySelector('#profileselect').click();
        }

        function displayProfileImage(input) {
            const file = input.files[0];

            if (file) {
                const allowedTypes = ["image/jpeg", "image/png"];

                if (!allowedTypes.includes(file.type)) {
                    alert("Invalid profile type. Please upload a JPEG or PNG image.");
                    input.value = "";
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#profilepicture').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }

        // Monthly Income
        const input = document.getElementById("monthlyincome");

        input.addEventListener("input", function(e) {
            let value = e.target.value.replace(/,/g, ""); // remove existing commas

            if (!isNaN(value) && value !== "") {
                e.target.value = Number(value).toLocaleString("en-US");
            } else {
                e.target.value = "";
            }
        });
    </script>
    <!-- Digit Format -->
    <script>
        // Event delegation: works even if input is inside a modal
        document.addEventListener("input", function(e) {
            // Check if the target is the Monthly Income inside your census modal
            if (e.target && e.target.id === "censusmonthlyincome") {
                let input = e.target;

                // Save cursor position
                let selectionStart = input.selectionStart;
                let selectionEnd = input.selectionEnd;

                // Remove non-digit characters (commas, letters)
                let value = input.value.replace(/\D/g, "");

                if (value === "") {
                    input.value = "";
                    return;
                }

                // Format the number with commas
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Adjust cursor position to stay in place
                let newLength = input.value.length;
                let diff = newLength - value.length;
                input.setSelectionRange(selectionStart + diff, selectionEnd + diff);
            }
        });

        // Event delegation: works even if input is inside a modal
        document.addEventListener("input", function(e) {
            // Check if the target is the Monthly Income inside your census modal
            if (e.target && e.target.id === "monthlyincomebefore") {
                let input = e.target;

                // Save cursor position
                let selectionStart = input.selectionStart;
                let selectionEnd = input.selectionEnd;

                // Remove non-digit characters (commas, letters)
                let value = input.value.replace(/\D/g, "");

                if (value === "") {
                    input.value = "";
                    return;
                }

                // Format the number with commas
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Adjust cursor position to stay in place
                let newLength = input.value.length;
                let diff = newLength - value.length;
                input.setSelectionRange(selectionStart + diff, selectionEnd + diff);
            }
        });

        // Event delegation: works even if input is inside a modal
        document.addEventListener("input", function(e) {
            // Check if the target is the Monthly Income inside your census modal
            if (e.target && e.target.id === "monthlyincomeafter") {
                let input = e.target;

                // Save cursor position
                let selectionStart = input.selectionStart;
                let selectionEnd = input.selectionEnd;

                // Remove non-digit characters (commas, letters)
                let value = input.value.replace(/\D/g, "");

                if (value === "") {
                    input.value = "";
                    return;
                }

                // Format the number with commas
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Adjust cursor position to stay in place
                let newLength = input.value.length;
                let diff = newLength - value.length;
                input.setSelectionRange(selectionStart + diff, selectionEnd + diff);
            }
        });

        // Event delegation: works even if input is inside a modal
        document.addEventListener("input", function(e) {
            // Check if the target is the Monthly Income inside your census modal
            if (e.target && e.target.id === "amountreceived") {
                let input = e.target;

                // Save cursor position
                let selectionStart = input.selectionStart;
                let selectionEnd = input.selectionEnd;

                // Remove non-digit characters (commas, letters)
                let value = input.value.replace(/\D/g, "");

                if (value === "") {
                    input.value = "";
                    return;
                }

                // Format the number with commas
                input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Adjust cursor position to stay in place
                let newLength = input.value.length;
                let diff = newLength - value.length;
                input.setSelectionRange(selectionStart + diff, selectionEnd + diff);
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