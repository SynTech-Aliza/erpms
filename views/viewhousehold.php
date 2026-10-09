<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if(isset($_GET['hh'])){echo $hhouseholdidnumber;}?> - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        .radio,
        .checkbox{
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
                                    <li class="breadcrumb-item active">View Household</li>
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
                                            <h3 class="font-weight-bold">HOUSEHOLD INFORMATION</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="basic-form">
                                            <!-- Form Start -->
                                            <form class="form-horizontal" method="post">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="card-title">
                                                            <h6 class="font-weight-bold text-dark">Household Details</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 text-right">
                                                        <!-- <button type="button" data-toggle="modal" data-target="#addcensusrecord" class="btn btn-sm btn-success" target="_blank">Add Census Record</button> -->
                                                        <a href="residents?hh=<?php echo $hashFromURL; ?>" target="_blank" class="btn btn-sm btn-primary">View Household Residents</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Household ID</label>
                                                            <input type="text" name="householdid" class="form-control text-center font-weight-bold bg-warning f-s-50 h-50 text-white text-uppercase" value="<?php echo $hhouseholdidnumber; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Street/ Purok <span class="text-danger">*</span></label>
                                                            <input type="text" name="streetpurok" value="<?php echo $hstreetpurok; ?>" class="form-control font-weight-bold text-uppercase input-sm" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Barangay</label>
                                                            <input type="text" name="barangay" value="<?php echo $hbarangay; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Municipality</label>
                                                            <input type="text" name="municipality" value="<?php echo $hmunicipality; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Province</label>
                                                            <input type="text" name="province" value="<?php echo $hprovince; ?>" class="form-control font-weight-bold text-uppercase input-sm" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Type:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="type" value="Owned" <?php if($htype == 'OWNED') echo 'checked'; ?>>
                                                                <label class="form-check-label">Owned</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="type" value="Rented" <?php if($htype == 'RENTED') echo 'checked'; ?>>
                                                                <label class="form-check-label">Rented</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Size:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Small (1-2 rooms)" <?php if($hsize == 'SMALL (1-2 ROOMS)') echo 'checked'; ?>>
                                                                <label class="form-check-label">Small (1-2 rooms)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Medium (3-4 rooms)" <?php if($hsize == 'MEDIUM (3-4 ROOMS)') echo 'checked'; ?>>
                                                                <label class="form-check-label">Medium (3-4 rooms)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input radio" type="radio" name="size" value="Large (5+ rooms)" <?php if($hsize == 'LARGE (5+ ROOMS)') echo 'checked'; ?>>
                                                                <label class="form-check-label">Large (5+ rooms)</label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Condition <span class="text-danger">*</span></label>
                                                            <select name="condition" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" required>
                                                                <option value="<?php echo $hcondition; ?>" selected><?php echo $hcondition; ?></option>
                                                                <option value="Concrete">Concrete</option>
                                                                <option value="Semi-Concrete">Semi-Concrete</option>
                                                                <option value="Wood">Wood</option>
                                                                <option value="Light Materials">Light Materials</option>
                                                                <option value="Mixed Materials">Mixed Materials</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Utilities:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="None" <?= in_array('NONE', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">None</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Electricity" <?= in_array('ELECTRICITY', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Electricity</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Water" <?= in_array('WATER', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Water</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Gas/ LPG" <?= in_array('GAS/ LPG', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Gas/ LPG</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Internet/ Broadband" <?= in_array('INTERNET/ BROADBAND', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Internet/ Broadband</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Cable TV/ Satellite TV" <?= in_array('CABLE TV/ SATELLITE TV', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Cable TV/ Satellite TV</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Telephone/ Landline" <?= in_array('TELEPHONE/ LANDLINE', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Telephone/ Landline</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Sewerage/ Drainage" <?= in_array('SEWERAGE/ DRAINAGE', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Sewerage/ Drainage</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="utilities[]" value="Garbage Collector" <?= in_array('GARBAGE COLLECTOR', $hutitlies) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Garbage Collector</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Facilities:</label><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="None" <?= in_array('NONE', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">None</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Kitchen" <?= in_array('KITCHEN', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Kitchen</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Dining Area" <?= in_array('DINING AREA', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Dining Area</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Living Room" <?= in_array('LIVING ROOM', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Living Room</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Bedrooms" <?= in_array('BEDROOMS', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Bedrooms</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Toilet / Bathroom" <?= in_array('TOILET/ BATHROOM', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Toilet / Bathroom</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Laundry Area" <?= in_array('LAUNDRY AREA', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Laundry Area</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Storage Room" <?= in_array('STORAGE ROOM', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Storage Room</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Parking Space/ Garage" <?= in_array('PARKING SPACE/ GARAGE', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Parking Space/ Garage</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Garden/ Backyard" <?= in_array('GARDEN/ BACKYARD', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Garden/ Backyard</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Fence/ Gate" <?= in_array('FENCE/ GATE', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Fence/ Gate</label>
                                                            </div><br/>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input checkbox" type="checkbox" name="facilities[]" value="Balcony/ Terrace" <?= in_array('BALCONY/ TERRACE', $hfacilities) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">Balcony/ Terrace</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success" name="updateinformation">UPDATE</button>
                                                <a href="households" class="btn btn-dark">CANCEL</a>
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
                                                                                        <label>Date of Incident</label>
                                                                                        <input type="date" name="censusdateofincident" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Damage Level</label>
                                                                                        <select name="censusdamagelevel" class="form-control font-weight-bold text-uppercase" style="font-size: 12px; height: 30px; line-height: 1.5;">
                                                                                            <option value="None" selected>None</option>
                                                                                            <option value="Partial">Partial</option>
                                                                                            <option value="Totally Damaged">Totally Damaged</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">House Still Livable?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushousestilllivable" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushousestilllivable" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Estimated Damage Cost</label>
                                                                                        <input type="text" name="censusestimateddamagecost" id="censusestimateddamagecost" value="0" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number of Affected Members</label>
                                                                                        <input type="number" name="censusnumberofaffectedmembers" value="0" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Evacuated?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusevacuated" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusevacuated" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Evacuation Center Name</label>
                                                                                        <input type="text" name="censusevacuationcentername" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
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
                                                                                        <label class="form-label">Needs Repair Assistance?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedrepairassistance" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedrepairassistance" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
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
                                                                                        <label class="form-label">Household Under Monitoring?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushouseholdundermonitoring" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushouseholdundermonitoring" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number of Sick Members</label>
                                                                                        <input type="number" name="censusnumberofsickmembers" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Type of Disease</label>
                                                                                        <input type="text" name="censustypeofdisease" class="form-control font-weight-bold text-uppercase input-sm" placeholder="Dengue, COVID, etc." unrequired>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
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
                                                                                        <label class="form-label">Sanitation Condition</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censussanitationcondition" value="Poor">
                                                                                            <label class="form-check-label">Poor</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censussanitationcondition" value="Good" checked>
                                                                                            <label class="form-check-label">Good</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Access to Clean Water?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaccesstocleanwater" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaccesstocleanwater" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Medical Assistance?</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsmedicalassistance" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedsmedicalassistance" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
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
                                                                                        <label>Main Source of Income</label>
                                                                                        <input type="text" name="censusmainsourceofincome" class="form-control font-weight-bold text-uppercase input-sm" placeholder="Farming, Driving, Business, etc." unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Combined Monthly Income Before</label>
                                                                                        <input type="text" name="censuscombinedmonthlyincomebefore" value="0" id="censuscombinedmonthlyincomebefore" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Combined Monthly Income After</label>
                                                                                        <input type="text" name="censuscombinedmonthlyincomeafter" value="0" id="censuscombinedmonthlyincomeafter" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number of Working Member</label>
                                                                                        <input type="number" name="censusnumberofworkingmember"  class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number of Working Unemployed</label>
                                                                                        <input type="number" name="censusnumberofworkingunemployed" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Livelihood Assistance</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedslivelihoodassistance" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusneedslivelihoodassistance" value="0" checked>
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
                                                                                        <label class="form-label">4Ps Household</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusfourpshousehold" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusfourpshousehold" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Total Eligible Members</label>
                                                                                        <input type="number" name="censustotaleligiblemembers" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Total Senior Citizens</label>
                                                                                        <input type="number" name="censustotalseniorcitizens" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Total PWDs</label>
                                                                                        <input type="number" name="censustotalpwds" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Total Solo Parents</label>
                                                                                        <input type="number" name="censustotalsoloparents" class="form-control font-weight-bold text-uppercase input-sm" unrequired>
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
                                                                                        <label>Number of Students in Household</label>
                                                                                        <input type="number" name="censusnumberofstudentsinhousehold"  class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number Currently Enrolled</label>
                                                                                        <input type="number" name="censusnumberofcurrentlyenrolled"  class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label>Number of Out-of-School Youth</label>
                                                                                        <input type="number" name="censusnumberofoutofschollyouth"  class="form-control font-weight-bold text-uppercase input-sm" unrequired>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Access to Internet</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaccesstointernet" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censusaccesstointernet" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Has Gadgets for Learning</label><br/>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushasgadgetforlearning" value="1">
                                                                                            <label class="form-check-label">Yes</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline">
                                                                                            <input class="form-check-input radio" type="radio" name="censushasgadgetforlearning" value="0" checked>
                                                                                            <label class="form-check-label">No</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Needs Educational Support</label><br/>
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
                                                                                <label class="form-label">Type:</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censustype" value="Owned" checked>
                                                                                    <label class="form-check-label">Owned</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censustype" value="Rented">
                                                                                    <label class="form-check-label">Rented</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Size:</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censussize" value="Small (1-2 rooms)" checked>
                                                                                    <label class="form-check-label">Small (1-2 rooms)</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censussize" value="Medium (3-4 rooms)">
                                                                                    <label class="form-check-label">Medium (3-4 rooms)</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input radio" type="radio" name="censussize" value="Large (5+ rooms)">
                                                                                    <label class="form-check-label">Large (5+ rooms)</label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Condition</label>
                                                                                <select name="censuscondition" class="form-control font-weight-bold text-uppercase mb-3" style="font-size: 12px; height: 30px; line-height: 1.5;" unrequired>
                                                                                    <option value="None" selected>None</option>
                                                                                    <option value="Concrete">Concrete</option>
                                                                                    <option value="Semi-Concrete">Semi-Concrete</option>
                                                                                    <option value="Wood">Wood</option>
                                                                                    <option value="Light Materials">Light Materials</option>
                                                                                    <option value="Mixed Materials">Mixed Materials</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Utilities:</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="None" checked>
                                                                                    <label class="form-check-label">None</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Electricity">
                                                                                    <label class="form-check-label">Electricity</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Water">
                                                                                    <label class="form-check-label">Water</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Gas/ LPG">
                                                                                    <label class="form-check-label">Gas/ LPG</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Internet/ Broadband">
                                                                                    <label class="form-check-label">Internet/ Broadband</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Cable TV/ Satellite TV">
                                                                                    <label class="form-check-label">Cable TV/ Satellite TV</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Telephone/ Landline">
                                                                                    <label class="form-check-label">Telephone/ Landline</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Sewerage/ Drainage">
                                                                                    <label class="form-check-label">Sewerage/ Drainage</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusutilities[]" value="Garbage Collector">
                                                                                    <label class="form-check-label">Garbage Collector</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Facilities:</label><br/>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="None" checked>
                                                                                    <label class="form-check-label">None</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Kitchen">
                                                                                    <label class="form-check-label">Kitchen</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Dining Area">
                                                                                    <label class="form-check-label">Dining Area</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Living Room">
                                                                                    <label class="form-check-label">Living Room</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Bedrooms">
                                                                                    <label class="form-check-label">Bedrooms</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Toilet / Bathroom">
                                                                                    <label class="form-check-label">Toilet / Bathroom</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Laundry Area">
                                                                                    <label class="form-check-label">Laundry Area</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Storage Room">
                                                                                    <label class="form-check-label">Storage Room</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Parking Space/ Garage">
                                                                                    <label class="form-check-label">Parking Space/ Garage</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Garden/ Backyard">
                                                                                    <label class="form-check-label">Garden/ Backyard</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Fence/ Gate">
                                                                                    <label class="form-check-label">Fence/ Gate</label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline">
                                                                                    <input class="form-check-input checkbox" type="checkbox" name="censusfacilities[]" value="Balcony/ Terrace">
                                                                                    <label class="form-check-label">Balcony/ Terrace</label>
                                                                                </div>
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
        $date = (isset($_GET['date']) ? $_GET['date'] : '');
        $formattedDate = date("F j, Y", strtotime($date));
        if($notification=='householdinformationupdated'){
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
                        title: "Household Information Updated",
                        text: "The household information has been successfully updated.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewhousehold?hh='.$hh.'";
                    });
                </script>
            ';
        }elseif($notification=='householdinformationerror'){
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
                        title: "Unable to Update Household Information",
                        text: "There was a problem updating the household information. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewhousehold?hh='.$hh.'";
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
                        title: "Household Census Recorded",
                        text: "The household census has been recorded successfully.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewhousehold?hh='.$hh.'";
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
                        title: "Unable to Record Household Census",
                        text: "There was a problem recording the household census. Please try again.",
                        showConfirmButton: false,
                        timer: 5000,
                        customClass: {
                            title: "swal-title-large"
                        }
                    }).then(function() {
                        window.location = "viewhousehold?hh='.$hh.'";
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
                        window.location = "viewhousehold?hh='.$hh.'";
                    });
                </script>
            ';
        }
    ?>

    <!-- Digit Format -->
    <script>
        // Event delegation: works even if input is inside a modal
        document.addEventListener("input", function(e) {
            // Check if the target is the Monthly Income inside your census modal
            if (e.target && e.target.id === "censusestimateddamagecost") {
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
            if (e.target && e.target.id === "censuscombinedmonthlyincomebefore") {
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
            if (e.target && e.target.id === "censuscombinedmonthlyincomeafter") {
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
            if (e.target && e.target.id === "censustotalamountreceived") {
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