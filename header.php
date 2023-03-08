<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>PES-HCI</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <link href="style.css" rel="stylesheet">

</head>

<body>

<?php 
    include_once "includes/functions.inc.php";
    session_start();
?>

<div class="container-fluid p-4 bg-warning text-white" id="banner">

    <div class="row">
        <div class="col-sm-2">
            <img src="images/logo.webp" alt="HCI-Logo" id="hci-logo">
        </div>

        <div class="col-sm-6" id="hci-name">
            <h1>HEADWATERS COLLEGE</h1>
            <h2>ELIZABETH CAMPUS</h2>
        </div>
        <div class="col-sm-3">

        </div>
        <div class="col-sm-1">
            <?php 
                if(isset($_SESSION["id"])){
                    echo '<button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapse-ribbon">'. $_SESSION["fname"] . '</button>';
                }
            ?>
        </div>
    </div>
  
</div>

<div class="container-fluid bg-white collapse row" id="collapse-ribbon">
    <div class="col-sm-8"></div>
    <ul class="nav col-sm-4" align="right">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="resetPassword.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="functions/logout.php">Logout</a>
        </li>
    </ul>
</div>

