<?php 
    include_once "header.php";
    include_once "includes/functions.inc.php";
    checkLoginStatus();
    checkAuthorization(array("Master"));
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="register-pane">

        <div class="container-fluid" id="master-home-panel">
            <button class="custom_btn" onclick="window.location.href='master_removeFaculty.php'">Manage Employees</button>
            <button class="custom_btn">Generate <br> Reports</button>
            <button class="custom_btn" onclick="window.location.href='master_manageSections.php'">Manage <br> Sections</button>

            <button class="custom_btn"><br><br></button>
            <button class="custom_btn">Reset <br> Password</button>
            <button class="custom_btn">Reset <br> Database</button>
        </div>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>