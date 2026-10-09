<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>public/assets/images/logo/masl-logo.png">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <style>
    body {
        background: #1A1341 !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-403 .outer {
        position: absolute;
        top: 0;
        display: table;
        width: 100%;
        height: 100%;
    }

    .page-403 .middle {
        display: table-cell;
        vertical-align: middle;
    }

    .page-403 .inner {
        width: 300px;
        margin: auto;
    }

    .inner-circle {
        height: 300px;
        width: 300px;
        border-radius: 50%;
        background: #fff;
        position: relative;
        animation: float 3s ease-in-out infinite;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .inner-circle span {
        font-size: 9em;
        font-weight: 700;
        display: block;
        text-align: center;
        color: #1A1341;
        line-height: 300px;
    }

    .inner-circle i {
        font-size: 4em;
        position: absolute;
        top: -20px;
        right: -20px;
        padding: 20px;
        color: #fff;
        background: #1A1341;
        border-radius: 50%;
        animation: shake 1.5s infinite;
    }

    .inner-status {
        font-size: 20px;
        margin-top: 20px;
        text-align: center;
        color: #ffffff;
        display: block;
    }

    .inner-detail {
        text-align: center;
        color: #999;
        margin-bottom: 15px;
        display: block;
    }

    .btn-home {
        display: block;
        margin: auto;
        width: 150px;
        transition: all 0.3s ease;
    }

    .btn-home:hover {
        transform: scale(1.1);
    }

    /* Floating animation for circle */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Shake animation for icon */
    @keyframes shake {
        0%, 100% { transform: rotate(0deg); }
        20% { transform: rotate(-15deg); }
        40% { transform: rotate(10deg); }
        60% { transform: rotate(-10deg); }
        80% { transform: rotate(15deg); }
    }

    /* Responsive */
    @media (max-width: 400px) {
        .inner-circle {
            height: 200px;
            width: 200px;
        }
        .inner-circle span {
            font-size: 6em;
            line-height: 200px;
        }
        .inner-circle i {
            font-size: 3em;
            top: -15px;
            right: -15px;
            padding: 15px;
        }
    }
</style>
</head>
<body>
<div class="page-403">
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="inner-circle">
                    <span>403</span>
                </div>
                <span class="inner-status">Access Denied</span>
                <span class="inner-detail">You are not authorized to access this page. You must log in first.</span>
                <div class="text-center">
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-sm btn-dark">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/contextprevention.js"></script>
<script src="../assets/css/lib/jquery-1.10.2.min.js"></script>
<script src="../assets/css/lib/bootstrap.min.js"></script>
</body>
</html>