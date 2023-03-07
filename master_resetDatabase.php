<?php

use function PHPSTORM_META\type;

    include_once "header.php";
    include_once "includes/functions.inc.php";
    checkLoginStatus();
    checkAuthorization(array("Master"));
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="manage-emp-pane">

        <div class="container-fluid" id="master-reset-emp" align="center">

            <br>

            <div class="row" align="center">
                <p class="h1"><span class="badge bg-danger text-white">WARNING</span></p>
            </div>

            <br>

            <div class="row" align="center">
                <p class="h5">This action will delete all records of evaluations in the database.</p>
                <p class="h5">It is recommended to <a href="master_viewReports.php?type=summaryAll_Peer">generate reports</a> before proceeding.</p>
            </div>

            <br>
            <br>

            <form action="functions/resetDatabase.php" method="POST">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="password" placeholder="Type password" required>
                    </div>
                    
                    <div class="container-fluid col-sm-2">
                        <input type="submit" class="btn btn-danger" name="submit" value="DELETE">
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </form>

            <?php
                if(isset($_GET["error"])){
                    if($_GET["error"] === "ipw"){
                        echo '  <br><div class="alert alert-danger" id="alertBox">
                                    <strong>Cancelled! </strong>Incorrect password.
                                </div>';
                    }
                    else if($_GET["error"] === "internal"){
                        echo '  <br><div class="alert alert-danger" id="alertBox">
                                    <strong>Cancelled! </strong>Server error. Try again.
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

        }, 2000);

</script>
