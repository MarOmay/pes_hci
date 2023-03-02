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

        <div class="container-fluid">
            <button type="button" class="btn" onclick="window.location.href='registerFaculty.php'">Add Faculty</button>
            <br>
            <button type="button" class="btn" onclick="window.location.href='master_removeFaculty.php'">Remove Faculty</button>
            <br>
            <button type="button" class="btn " onclick="window.location.href='registerFaculty.php'">Add Faculty</button>
            <br>
        </div>

        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>