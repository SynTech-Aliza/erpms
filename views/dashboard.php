<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Digital Resident Profiling and Census Management System (DRPCMS)</title>
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

        .color-softgray,
        .text-softgray{
            color: #DEE2E6;
         }

        .bg-newprimary{
            background: #1A1341;
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

        #householdtype,
        #householdsizedistribution,
        #agedistribution,
        #genderdistribution,
        #employmentstatus,
        #civilstatus,
        #educationalattainment,
        #populationgrowthtrend
         {
            width: 100% !important;
            height: 400px; /* or any fixed height */
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
    <?php 
        switch ($role) {
            case '1':
    ?>
            <div class="content-wrap">
                <div class="main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 p-r-0 title-margin-right">
                                <div class="page-header">
                                    <div class="page-title">
                                        <h1>Hello, Admin <?php
                                        $fullname = $firstname.' '.$middlename.' '.$lastname;
                                        $formatted_name = ucwords(strtolower($fullname));
                                        echo $formatted_name;
                                        ?>!</h1>
                                        <h2>Welcome to the <strong>Digital Resident Profiling and Census Management System (DRPCMS)</strong></h2>
                                        <p><em><?php echo ucwords(strtolower($appointed)); ?>, Libertad, Antique</em></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section id="main-content">
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-building-user color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Registered Voters</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otrvf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid color-softgray fa-person-cane f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Senior Citizens</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otsc; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-wheelchair color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Person with Disability</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otpwdf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-people-roof color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> 4P's</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otfpf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-people-group color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Indigenous People</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otipf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-person-breastfeeding color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Solo Parents</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otspf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="text-dark">Barangay Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="barangaydistribution"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="text-dark">Household Type</h5>
                                                <div class="panel-body">
                                                    <canvas id="householdtype"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <h5 class="text-dark">Household Size Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="householdsizedistribution"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h5 class="text-dark">Age Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="agedistribution"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h5 class="text-dark">Gender Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="genderdistribution"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="text-dark">Employment Status</h5>
                                                <div class="panel-body">
                                                    <canvas id="employmentstatus"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="text-dark">Civil Status</h5>
                                                <div class="panel-body">
                                                    <canvas id="civilstatus"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="text-dark">Educational Attainment</h5>
                                                <div class="panel-body">
                                                    <canvas id="educationalattainment"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="text-dark">Population Growth Trend</h5>
                                                <div class="panel-body">
                                                    <canvas id="populationgrowthtrend"></canvas>
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
  <?php
            break;
      
            default:
  ?>
            <div class="content-wrap">
                <div class="main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 p-r-0 title-margin-right">
                                <div class="page-header">
                                    <div class="page-title">
                                        <h1>Hello, BSPO <?php
                                        $fullname = $firstname.' '.$middlename.' '.$lastname;
                                        $formatted_name = ucwords(strtolower($fullname));
                                        echo $formatted_name;
                                        ?>!</h1>
                                        <h2>Welcome to the <strong>Digital Resident Profiling and Census Management System (DRPCMS)</strong></h2>
                                        <p><em>Barangay <?php echo ucwords(strtolower($appointed)); ?>, Libertad, Antique</em></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section id="main-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-building f-s-15 color-softgray"></i>
                                            <h4 class="text-softgray f-s-15"> Households <small class="f-s-10">+<?php echo $tnhf; ?> This Month</small></h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $othf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-users color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Residents <small class="f-s-10">+<?php echo $tnrf; ?> This Month</small></h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otpf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-route color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Purok</h4>
                                        </div>
                                    <div class="stat-content">
                                        <h3 class="stat-text text-white"><?php echo $otprf; ?></h3>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-building-user color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Registered Voters</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otrvf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid color-softgray fa-person-cane f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Senior Citizens</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otsc; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-wheelchair color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Person with Disability</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otpwdf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-people-roof color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> 4P's</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otfpf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-people-group color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Indigenous People</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otipf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card bg-newprimary">
                                        <div class="card-title">
                                            <i class="fa-solid fa-person-breastfeeding color-softgray f-s-15"></i>
                                            <h4 class="text-softgray f-s-15"> Solo Parents</h4>
                                        </div>
                                        <div class="stat-content">
                                            <h3 class="stat-text text-white"><?php echo $otspf; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <h5 class="text-dark">Household Type</h5>
                                                <div class="panel-body">
                                                    <canvas id="householdtype"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <h5 class="text-dark">Household Size Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="householdsizedistribution"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h5 class="text-dark">Age Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="agedistribution"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h5 class="text-dark">Gender Distribution</h5>
                                                <div class="panel-body">
                                                    <canvas id="genderdistribution"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="text-dark">Employment Status</h5>
                                                <div class="panel-body">
                                                    <canvas id="employmentstatus"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="text-dark">Civil Status</h5>
                                                <div class="panel-body">
                                                    <canvas id="civilstatus"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="text-dark">Educational Attainment</h5>
                                                <div class="panel-body">
                                                    <canvas id="educationalattainment"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5 class="text-dark">Population Growth Trend</h5>
                                                <div class="panel-body">
                                                    <canvas id="populationgrowthtrend"></canvas>
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
  <?php
            break;
        }
  ?>
    <!-- Reload Page-->
    <script>
        setTimeout(function(){
            location.reload();
        }, 60000); // 1 minute in milliseconds
    </script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/chart-js/chart-npm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        // Barangay Distribution
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('barangaydistribution').getContext('2d');

            // Gradient for Households (green)
            const gradientHouse = ctx.createLinearGradient(0, 0, 0, 400);
            gradientHouse.addColorStop(0, '#28a745'); // top (Bootstrap green)
            gradientHouse.addColorStop(1, '#71c786'); // bottom (lighter green)

            // Gradient for Residents (navy)
            const gradientResidents = ctx.createLinearGradient(0, 0, 0, 400);
            gradientResidents.addColorStop(0, '#1A1341'); // top (deep navy)
            gradientResidents.addColorStop(1, '#4B367E'); // bottom (lighter purple/navy)

            const data = {
                labels: <?= json_encode($bn ?? []) ?>, // barangay names
                datasets: [
                    {
                        label: 'Number of Households',
                        data: <?= json_encode($tbhf ?? []) ?>,
                        backgroundColor: gradientHouse,
                        borderColor: '#28a745',
                        borderWidth: 0
                    },
                    {
                        label: 'Number of Residents',
                        data: <?= json_encode($tbrf ?? []) ?>,
                        backgroundColor: gradientResidents,
                        borderColor: '#1A1341',
                        borderWidth: 0
                    }
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        title: { display: false, text: 'Barangay Distribution' }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            };

            new Chart(ctx, config);
        });

       // Household Type
      document.addEventListener('DOMContentLoaded', function () {
          const data = {
              labels: <?= json_encode($hhtype ?? []) ?>,
              datasets: [{
                  label: 'Household Type',
                  data: <?= json_encode($othhtf ?? []) ?>,
                  backgroundColor: ['#198754', '#1A1341'],
                  borderColor: ['#198754', '#1A1341'],
                  borderWidth: 3,
                  fill: false
              }]
          };

          const config = {
              type: 'pie',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'top',
                      },
                      title: {
                          display: false,
                          text: 'Gender Distribution'
                      }
                  }
              },
          };

          new Chart(
              document.getElementById('householdtype'),
              config
          );
      });

      // Household Size Distribution
      document.addEventListener('DOMContentLoaded', function () {
          const ctx = document.getElementById('householdsizedistribution').getContext('2d');

          // Create vertical gradient for bars
          const gradient = ctx.createLinearGradient(0, 0, 0, 400);
          gradient.addColorStop(0, '#1A1341');   // top (dark navy)
          gradient.addColorStop(1, '#4B367E');   // bottom (lighter purple)

          const data = {
              labels: <?= json_encode($hhs ?? []) ?>,
              datasets: [{
                  label: 'Household Size Distribution',
                  data: <?= json_encode($othsf ?? []) ?>,
                  backgroundColor: gradient,      // <-- use gradient here
                  borderColor: '#1A1341',         // solid border
                  borderWidth: 1,
                  fill: false
              }]
          };

          const config = {
              type: 'bar',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: { display: false },
                      title: { display: false, text: 'Household Size Distribution' }
                  },
                  scales: {
                      y: { beginAtZero: true, ticks: { precision: 0 } }
                  }
              }
          };

          new Chart(ctx, config);
      });

      // Age Distribution
      document.addEventListener('DOMContentLoaded', function () {
          const data = {
              labels: <?= json_encode($agedistribution ?? []) ?>,
              datasets: [{
                  label: 'Age Distribution',
                  data: <?= json_encode($otadf ?? []) ?>, // replace with DB values
                  backgroundColor: '#1A1341',
                  borderColor: '#1A1341',
                  borderWidth: 3,
                  fill: false,
                  tension: 0.2,
                  pointRadius: 6,        // <-- size of points
                  pointHoverRadius: 8    // <-- size when hovered
              }]
          };

          const config = {
              type: 'line',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          display: false
                      },
                      title: {
                          display: false,
                          text: 'Age Distribution of Residents'
                      }
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: {
                              precision: 0
                          }
                      }
                  }
              }
          };

          new Chart(
              document.getElementById('agedistribution'),
              config
          );
      });

      // Gender Distribution
      document.addEventListener('DOMContentLoaded', function () {
          const data = {
              labels: <?= json_encode($rg ?? []) ?>,
              datasets: [{
                  label: 'Gender Distribution',
                  data: <?= json_encode($otgf ?? []) ?>, // replace with dynamic values if needed
                  backgroundColor: ['#1A1341', '#FF3C7E'],
                  borderColor: ['#1A1341', '#FF3C7E'],
                  borderWidth: 3,
                  fill: false
              }]
          };

          const config = {
              type: 'doughnut',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'top',
                      },
                      title: {
                          display: false,
                          text: 'Gender Distribution'
                      }
                  }
              },
          };

          new Chart(
              document.getElementById('genderdistribution'),
              config
          );
      });

      // Employment Status
      document.addEventListener('DOMContentLoaded', function () {
          const ctx = document.getElementById('householdsizedistribution').getContext('2d');

          // Create vertical gradient for bars
          const gradient = ctx.createLinearGradient(0, 0, 0, 400);
          gradient.addColorStop(0, '#1A1341');   // top (dark navy)
          gradient.addColorStop(1, '#4B367E');   // bottom (lighter purple)

          const data = {
              labels: <?= json_encode($es ?? []) ?>,
              datasets: [{
                  label: 'Number of Residents',
                  data: <?= json_encode($otesf ?? []) ?>,
                  backgroundColor: gradient,
                  borderColor: ['#1A1341'],
                  borderWidth: 0,
                  fill: false
              }]
          };

          const config = {
              type: 'bar',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          display: false
                      },
                      title: {
                          display: false,
                          text: 'Age Distribution of Residents'
                      }
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: {
                              precision: 0
                          }
                      }
                  }
              }
          };

          new Chart(
              document.getElementById('employmentstatus'),
              config
          );
      });

      // Civil Status
      document.addEventListener('DOMContentLoaded', function () {
          const data = {
              labels: <?= json_encode($cs ?? []) ?>,
              datasets: [{
                  label: 'Number of Residents',
                  data: <?= json_encode($otcsf ?? []) ?>,
                  backgroundColor: ['#1A1341', '#2E2B5F', '#4A447A', '#6B6193', '#877FB0', '#A49ACD', '#BFB7E6', '#D9D4F0'],
                  borderColor: ['#1A1341', '#2E2B5F', '#4A447A', '#6B6193', '#877FB0', '#A49ACD', '#BFB7E6', '#D9D4F0'],
                  borderWidth: 0,
                  fill: false
              }]
          };

          const config = {
              type: 'bar',
              data: data,
              options: {
                  indexAxis: 'y', // <-- makes the bars horizontal
                  responsive: true,
                  plugins: {
                      legend: {
                          display: false
                      },
                      title: {
                          display: false,
                          text: 'Age Distribution of Residents'
                      }
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: {
                              precision: 0
                          }
                      }
                  }
              }
          };

          new Chart(
              document.getElementById('civilstatus'),
              config
          );
      });

      // Educational Attainment
      document.addEventListener('DOMContentLoaded', function () {
          const ctx = document.getElementById('householdsizedistribution').getContext('2d');

          // Create vertical gradient for bars
          const gradient = ctx.createLinearGradient(0, 0, 0, 400);
          gradient.addColorStop(0, '#1A1341');   // top (dark navy)
          gradient.addColorStop(1, '#4B367E');   // bottom (lighter purple)

          const data = {
              labels: <?= json_encode($et ?? []) ?>,
              datasets: [{
                  label: 'Number of Residents',
                  data: <?= json_encode($otetf ?? []) ?>,
                  backgroundColor: gradient,
                  borderColor: ['#1A1341'],
                  borderWidth: 0,
                  fill: false
              }]
          };

          const config = {
              type: 'bar',
              data: data,
              options: {
                  indexAxis: 'x', // <-- makes the bars horizontal
                  responsive: true,
                  plugins: {
                      legend: {
                          display: false
                      },
                      title: {
                          display: false,
                          text: 'Age Distribution of Residents'
                      }
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: {
                              precision: 0
                          }
                      }
                  }
              }
          };

          new Chart(
              document.getElementById('educationalattainment'),
              config
          );
      });

      // Population Growth Trend
      document.addEventListener('DOMContentLoaded', function () {
          const data = {
              labels: <?= json_encode($yr ?? []) ?>,
              datasets: [{
                  label: 'Number of Residents',
                  data: <?= json_encode($otycf ?? []) ?>,
                  backgroundColor: ['#E6E8F8'],
                  borderColor: ['#1A1341'],
                  borderWidth: 3,
                  fill: true,
                  tension: 0.2,
                  pointRadius: 3,        // <-- size of points
                  pointHoverRadius: 8    // <-- size when hovered
              }]
          };

          const config = {
              type: 'line',
              data: data,
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          display: false
                      },
                      title: {
                          display: false,
                          text: 'Age Distribution of Residents'
                      }
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          ticks: {
                              precision: 0
                          }
                      }
                  }
              }
          };

          new Chart(
              document.getElementById('populationgrowthtrend'),
              config
          );
      });
    </script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/chart-js/chart-npm.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/contextprevention.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/menubar/sidebar.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/preloader/pace.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/js/scripts.js"></script>
</body>
</html>
