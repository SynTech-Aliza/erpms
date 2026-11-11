<?php 
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Resident Profiling and Census Management System (DRPCMS)</title>
    <link rel="icon" type="image/x-icon" href="storage/logos/<?php echo $systemlogo; ?>">
    <!-- Styles -->
    <link href="public/assets/icons/fontawesome 6.3.0/css/all.css" rel="stylesheet">
    <link href="public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="public/assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="public/assets/css/lib/helper.css" rel="stylesheet">
    <link href="public/assets/css/style.css" rel="stylesheet">
    <!-- Extensions -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Loader Screen */
        #loader-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #1A1341;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
            text-align: center;
        }

        .logo-loader {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .load-logo {
            width: 150px;
            z-index: 2;
            margin-bottom: 20px;
        }

        /* Dots Spinner */
        .dots-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .dots-spinner .dot {
            width: 15px;
            height: 15px;
            background-color: #ffffff;
            border-radius: 50%;
            animation: bounce 1.2s infinite ease-in-out;
        }

        .dots-spinner .dot:nth-child(1) { animation-delay: 0s; }
        .dots-spinner .dot:nth-child(2) { animation-delay: 0.2s; }
        .dots-spinner .dot:nth-child(3) { animation-delay: 0.4s; }
        .dots-spinner .dot:nth-child(4) { animation-delay: 0.6s; }
        .dots-spinner .dot:nth-child(5) { animation-delay: 0.8s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        .loading-text {
            margin-top: 20px;
            color: white;
            font-size: 18px;
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
<body class="bg-newprimary">
    <!-- Loading Screen -->
    <div id="loader-screen">
        <div class="logo-loader">
            <div class="dots-spinner">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
        <div class="loading-text">
            <?php echo ($connection ? "Loading System" : "System Connecting"); ?>
            <span id="dots"></span>
        </div>
    </div>
    <!-- Loading Page -->
    <script>
        let dots = document.getElementById("dots");
        let count = 0;

        // Animate the dots
        let dotsInterval = setInterval(() => {
            count = (count + 1) % 4;
            dots.innerHTML = ".".repeat(count);
        }, 500);

        // Record when loading started
        const startTime = Date.now();

        // Function to check connection via AJAX
        function checkConnection() {
            fetch('app/check_connection.php')
            .then(response => response.json())
            .then(data => {
                if (data.connected) {
                    // Calculate elapsed time
                    const elapsed = Date.now() - startTime;
                    const delay = Math.max(0, 2000 - elapsed);

                    setTimeout(() => {
                        clearInterval(dotsInterval);
                        document.getElementById("loader-screen").style.display = "none";
                        window.location.href = "views/login";
                    }, delay);
                } else {
                    // Retry after 2 seconds if not connected
                    setTimeout(checkConnection, 2000);
                }
            })
            .catch(err => {
                console.error("Connection check failed:", err);
                setTimeout(checkConnection, 2000);
            });
        }

        // Start polling
        checkConnection();
    </script>
    <script src="public/assets/js/contextprevention.js"></script>
</body>
</html>

