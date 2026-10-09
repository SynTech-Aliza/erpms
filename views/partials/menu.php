<?php
    switch ($role) {
        // Admin
        case '1':
?>
            <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
                <div class="nano">
                    <div class="nano-content">
                        <ul>
                            <div class="logoicon text-center">
                                <a href="dashboard">
                                    <img src="<?php echo BASE_URL; ?>storage/logos/<?php echo $systemlogo; ?>" alt="Logo" />
                                </a>
                                <h5 class="m-t-10 f-s-15">DIGITAL RESIDENT PROFILING<br/>AND CENSUS MANAGEMENT SYSTEM</h5>
                            </div>
                            <!--  -->
                            <li><a href="../auth/dashboard"><i class="fa-solid fa-chart-diagram"></i>Dashboard</a></li>
                            <!-- User Account -->
                            <?php
                                $isAllUsersActive =
                                    in_array($currentPage, [
                                        'useraccounts.php',
                                        'createnewaccount.php',
                                        'viewuseraccount.php'
                                    ]);
                            ?>
                            <li class="<?= $isAllUsersActive ? 'active' : '' ?>">
                                <a href="../auth/useraccounts">
                                    <i class="fa-solid fa-user"></i>User Accounts
                                </a>
                            </li>
                            <li><a href="../auth/auditlogs"><i class="fa-regular fa-file-lines"></i>Audit Logs</a></li>
                            <!-- Settings -->
                            <?php
                                $isAllSettingsActive =
                                    in_array($currentPage, [
                                        'settings.php',
                                        'systemlogo.php',
                                        'systeminformation.php',
                                        'barangay.php',
                                        'createnewbarangay.php',
                                        'viewbarangay.php',
                                        'databasebackup.php'
                                    ]);
                            ?>
                            <li class="<?= $isAllSettingsActive ? 'active' : '' ?>">
                                <a href="../auth/settings">
                                    <i class="fa-solid fa-gear"></i>Settings
                                </a>
                            </li>
                            <li><a href="../auth/profile"><i class="fa-solid fa-clipboard-user"></i>Profile</a></li>
                            <li><a href="../auth/changepassword"><i class="fa-solid fa-lock"></i>Change Password</a></li>
                            <li><a href="../app/authocontrol?logout=<?php echo $hashUser;?>"><i class="fa-solid fa-xmark"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
<?php
            break;
        // BSPO
        default:
?>
            <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
                <div class="nano">
                    <div class="nano-content">
                        <ul>
                            <div class="logoicon text-center">
                                <a href="dashboard">
                                    <img src="<?php echo BASE_URL; ?>storage/logos/<?php echo $systemlogo; ?>" alt="Logo" />
                                </a>
                                <h5 class="m-t-10 f-s-15">DIGITAL RESIDENT PROFILING<br/>AND CENSUS MANAGEMENT SYSTEM</h5>
                            </div>
                            <li class="label f-s-12">Dashboard</li>
                            <li><a href="../auth/dashboard"><i class="fa-solid fa-chart-diagram"></i>Dashboard</a></li>
                            <li class="label f-s-12">Record Management</li>
                            <!-- Households -->
                            <?php
                                $isHouseholdActive = in_array($currentPage, [
                                    'households.php',
                                    'createnewhousehold.php',
                                    'viewhousehold.php'
                                ]) || isset($_GET['hh']) || isset($_GET['hr']);

                                if (isset($_GET['r'])) {
                                    $isHouseholdActive = false;
                                }
                            ?>
                            <li class="<?= $isHouseholdActive ? 'active' : '' ?>">
                                <a href="../auth/households">
                                    <i class="fa-solid fa-house-user"></i>Households
                                </a>
                            </li>
                            <!-- Residents -->
                            <?php
                                $isResidentsActive = in_array($currentPage, [
                                    'residents.php',
                                    'createnewresident.php',
                                    'viewresident.php'
                                ]) || isset($_GET['r']);
                                if (isset($_GET['hh']) || isset($_GET['hr'])) {
                                    $isResidentsActive = false;
                                }
                            ?>
                            <li class="<?= $isResidentsActive ? 'active' : '' ?>">
                                <a href="../auth/residents">
                                    <i class="fa-solid fa-users"></i>Residents
                                </a>
                            </li>
                            <li class="label f-s-12">Reports</li>
                            <li><a class="sidebar-sub-toggle"><i class="fas fa-clipboard-list"></i>Resident Census<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                                <ul>
                                    <li><a href="residentcensusannual">Annual</a></li>
                                    <li><a href="residentcensusmidyear">Midyear</a></li>
                                    <li><a href="residentcensusdisasterrelated">Disaster Related</a></li>
                                    <li><a href="residentcensushealthemergency">Health Emergency</a></li>
                                    <li><a href="residentcensuslivelihoodeconomicimpact">Livelihood/ Economic Impact </a></li>
                                    <li><a href="residentcensussocialassistancebeneficiary">Social Assistance/ Beneficiary</a></li>
                                    <li><a href="residentcensuseducationalschoolstatus">Education/ School Status</a></li>
                                </ul>
                            </li>

                            <li><a href="registeredvoters"><i class="fa-solid fa-building-user"></i>Registered Voters</a></li>
                            <li><a href="seniorcitizens"><i class="fa-solid fa-person-cane"></i>Senior Citizens</a></li>
                            <li><a href="pwd"><i class="fa-brands fa-accessible-icon"></i>Person with Disability</a></li>
                            <li><a href="4ps"><i class="fa-solid fa-people-roof"></i>4P's</a></li>
                            <li><a href="soloparents"><i class="fa-solid fa-person-breastfeeding"></i>Solo Parents</a></li>
                            <li><a href="indigenouspeople"><i class="fa-solid fa-people-group"></i>Indigenous People</a></li>
                            <li class="label f-s-12">Settings</li>
                            <!-- Settings -->
                            <?php
                                $isAllSettingsActive =
                                    in_array($currentPage, [
                                        'settings.php',
                                        'systemlogo.php',
                                        'systeminformation.php',
                                        'barangay.php',
                                        'createnewbarangay.php',
                                        'viewbarangay.php',
                                        'databasebackup.php'
                                    ]);
                            ?>
                            <li class="<?= $isAllSettingsActive ? 'active' : '' ?>">
                                <a href="../auth/settings">
                                    <i class="fa-solid fa-gear"></i>Settings
                                </a>
                            </li>
                            <li class="label f-s-12">Personal Profile</li>
                            <li><a href="../auth/profile"><i class="fa-solid fa-clipboard-user"></i>Profile</a></li>
                            <li><a href="../auth/changepassword"><i class="fa-solid fa-lock"></i>Change Password</a></li>
                            <li><a href="../app/authocontrol?logout=<?php echo $hashUser;?>"><i class="fa-solid fa-xmark"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
<?php
            break;
    }
?>