<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create New Resident - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item">Households</li>
                                    <li class="breadcrumb-item">View Household</li>
                                    <li class="breadcrumb-item">Residents</li>
                                    <li class="breadcrumb-item active">Create New Resident</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="main-content">
                    <!-- BSPO -->
                    <div class="row justify-content-center">
                        <!--  -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3 class="font-weight-bold">RESIDENT FORM</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" method="post"  enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Household Role</label><br/>
                                                            <select name="householdrole" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
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
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Permanent" checked>
                                                                <label class="form-check-label">Permanent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline m-r-20">
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Temporary">
                                                                <label class="form-check-label">Temporary</label>
                                                            </div>
                                                            <div class="form-check form-check-inline m-r-20">
                                                                <input class="form-check-input radio" type="radio" name="residentstatus" value="Renter">
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
                                                                <span class="img-div text">
                                                                    <img class="img-fluid" src="<?php echo BASE_URL; ?>public/assets/images/Default.png" alt="profile-picture" onClick="triggerClickProfileImage()" id="profilepicture">
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
                                                                    <input type="text" name="firstname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Middle Name</label>
                                                                    <input type="text" name="middlename" class="form-control font-weight-bold text-uppercase input-sm">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Last Name <span class="text-danger">*</span></label>
                                                                    <input type="text" name="lastname" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label>Suffix <span class="text-danger">*</span></label>
                                                                    <select name="suffix" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                        <option value="" selected>Select</option>
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
                                                                    <input type="date" name="dateofbirth" class="form-control font-weight-bold text-uppercase input-sm" id="dateofbirth" onchange="calculateAge()" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Age</label>
                                                                    <input type="text" name="age" class="form-control font-weight-bold text-uppercase input-sm" id="age" readonly>
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
                                                                <option value="" selected>Select</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Civil Status</label>
                                                            <select name="civilstatus" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
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
                                                            <input type="text" name="religion" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Nationality <span class="text-danger">*</span></label>
                                                            <input type="text" name="nationality" class="form-control font-weight-bold text-uppercase input-sm" required>
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
                                                            <input type="text" name="contactnumber" class="form-control font-weight-bold text-uppercase input-sm" placeholder="09xxxxxxxxx" maxlength="11" pattern="09\d{9}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Email Address</label>
                                                            <input type="email" name="emailaddress" class="form-control font-weight-bold text-lowercase input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Educational Attainment <span class="text-danger">*</span></label>
                                                            <select name="educationalattainment" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
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
                                                            <input type="text" name="height" id="feet" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Weight (kg) <span class="text-danger">*</span></label>
                                                            <input type="text" name="weight" id="kg" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Blood Type <span class="text-danger">*</span></label>
                                                            <select name="bloodtype" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="" selected>Select</option>
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
                                                                <option value="" selected>Select</option>
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
                                                                <input class="form-check-input radio" type="radio" name="pwd" value="1">
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="pwd" value="0" checked>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">4Ps Member?</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="fourps" value="1">
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="fourps" value="0" checked>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Indigenous People?</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="indigenous" value="1">
                                                                <label class="form-check-label">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="indigenous" value="0" checked>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Voter Status</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Registered">
                                                                <label class="form-check-label">Registered</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Not Registered">
                                                                <label class="form-check-label">Not Registered</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="voterstatus" value="Not Eligible" checked>
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
                                                                <option value="" selected>Select</option>
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
                                                            <input type="text" name="idnumber" class="form-control font-weight-bold text-uppercase input-sm">
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
                                                                <option value="" selected>Select</option>
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
                                                            <input type="text" name="occupation" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Monthly Income <span class="text-danger">*</span></label>
                                                            <input type="text" value="0" name="monthlyincome" id="monthlyincome" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Employer / Business Name)</label>
                                                            <input type="text" name="employerbusinessname" class="form-control font-weight-bold text-uppercase input-sm">
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="card-title">
                                                    <h6 class="font-weight-bold text-dark">File Attachments</h6>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 m-t-10">
                                                        <div class="form-group files">
                                                            <input type="file" id="fileattachment" name="fileattachment[]" class="form-control" multiple="multiple" accept=".pdf,.doc,.docx">
                                                        </div> 
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="submit">SUBMIT</button>
                                                <a href="residents?hh=<?php echo $hashFromURL; ?>" class="btn btn-dark">CANCEL</a>
                                            </form>
                                            <!-- Form End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
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
        if($notification=='residentexist'){
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
                        title: "Resident Already Exist",
                        text: "The resident information you entered is already in the system. Please check the details or use a different entry.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewresident?hh='.$hh.'";
                    });
                </script>
            ';
        }
        elseif($notification=='residenterror'){
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
                        title: "Unable to Create Resident",
                        text: "Something went wrong. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewresident?hh='.$hh.'";
                    });
                </script>
            ';
        }
        elseif($notification=='residentcreated'){
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
                        title: "Resident Created Successfully",
                        text: "The resident information has been successfully saved.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "createnewresident?hh='.$hh.'";
                    });
                </script>
            ';
        }
    ?>
    
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
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/menubar/sidebar.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/preloader/pace.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/scripts.js"></script>
</body>
</html>