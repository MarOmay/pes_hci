<?php 
    include_once "header.php";
    include_once "includes/functions.inc.php";
    //checkAuthorization(array("Student","Teaching","Non-Teaching"));
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div class="evaluation-pane" id="register-pane" style="overflow-y: auto;">
        <form id="register-form" action="functions/submitEval.php" method="POST">

            <?php
                include_once "includes/dbh.inc.php";
                include_once "includes/functions.inc.php";

                if(isset($_GET["id"])){
                    getEvaluateeName($conn, $_GET["id"]);
                }
                else{
                    header("location: index.php?error=internal");
                }

            ?>

            <?php 
                include_once "includes/dbh.inc.php";
                include_once "includes/functions.inc.php";

                getFactors($conn);
            ?>

            <br>

            <div class="row">
                <h6><b>PROMOTIONAL / POSITIVE POINTS</b></h6>
                <input type="text" class="comment_field form-group" name="c1" placeholder="TYPE YOUR COMMENT - in english or tagalog" required>
            </div>

            <br>

            <div class="row">
                <h6><b>IMPROVEMENT NEEDS / CORRECTIVE POINTS</b></h6>
                <input type="text" class="comment_field form-group" name="c2" placeholder="TYPE YOUR COMMENT - in english or tagalog" required>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-12" align="right">
                    
                    <button type="submit" class="btn btn-primary" id="registerBtn" name="registerBtn">Submit</button>
                    <br>
                    <br>
                </div>
            </div>

        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>