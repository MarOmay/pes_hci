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

        <div class="container-fluid" id="master-home-panel" align="center">
            <button class="custom_btn" onclick="window.location.href='master_registerEmployee.php'">New Employee <br> Account</button>
            <button class="custom_btn" onclick="window.location.href='master_manageFactors.php'">Manage <br> Factors</button>
            <br>
            <button class="custom_btn" onclick="window.location.href='master_manageEmployees.php'">Manage <br> Employees</button>
            <button class="custom_btn" onclick="window.location.href='master_viewReports.php?type=summaryAll_Peer'">Generate <br> Reports</button>

            <br>    
            <button class="custom_btn" onclick="window.location.href='master_manageSections.php'">Manage <br> Sections</button>
            <button class="custom_btn" onclick="window.location.href='master_resetDatabase.php'">Reset <br> Database</button>

            <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] === "dbreset"){
                        echo '  <br><div class="alert alert-success" id="alertBox">
                                    <strong>Success! </strong>Database reset successfully.
                                </div>';
                    }
                }
            ?>

        </div>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>

<script type="text/javascript">

    setTimeout(() => {
            const alerts = document.getElementById("alertBox");

            alerts.style.display = "none";

        }, 3000);

</script>