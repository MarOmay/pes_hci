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
                    echo '<img src="images/burger.png" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" width="50" height="auto" style="cursor:pointer;">';
                }
            ?>
        </div>
    </div>
  
</div>

<div class="offcanvas offcanvas-end" tabindex="1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" id="menu-ribbon">
        <h5 id="offcanvasRightLabel" ><?php echo isset($_SESSION["fname"]) ? strtoupper($_SESSION["fname"] . " " . $_SESSION["lname"]) : "" ?></h5>
    </div>
    <div class="offcanvas-body" id="offcanvas-body">
        <div class="container-fluid bg-white row" id="collapse-ribbon">
            <nav class="navbar">
                <ul class="navbar-nav" align="left">
                    <li class="nav-item">
                        <a class="nav-link active menu-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="resetPassword.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="functions/logout.php">Logout</a>
                    </li>
                </ul>
            </nav>

        </div>

        
    </div>

    <div id="siganture">
        <p>Developed by<br><br>Mar Alexis O. Omay<br>Jireh D. Trinidad<br>Bulacan State University - SC</p>
    </div>

    <div id="menu-ribbon">
    &nbsp;
    </div>

</div>

