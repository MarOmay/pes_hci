<?php 
    include_once "header.php";
    include_once "includes/functions.inc.php";
    checkAuthorization(array("Student","Teaching","Non-Teaching"));
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
                    echo '<div class="row">';
                    echo '<div class="col-sm-8">';
                    getEvaluateeName($conn, $_GET["id"]);
                    echo '</div>';
                    echo '<div class="col-sm-4" align="right">';
                    echo '<input type="checkbox" id="fullscreen" style="display:none;">';
                    echo '<input type="button" class="btn text-success"" onclick="setFullscreen()" id="fLabel" value="Expand">';
                    echo '</div>';
                    echo '</div>';
                }
                else{
                    header("location: index.php?error=internal");
                }

            ?>

            <?php 
                include_once "includes/dbh.inc.php";
                include_once "includes/functions.inc.php";

                getFactors($conn, $_SESSION["role"]);
            ?>

            <br>

            <div class="row">
                <h6><b>PROMOTIONAL / POSITIVE POINTS</b></h6>
                <textarea rows="4" maxlength="200" class="comment_field form-group" name="positive_comment" placeholder="Type your comment in English or Tagalog" required></textarea>
            </div>

            <br>

            <div class="row">
                <h6><b>IMPROVEMENT NEEDS / CORRECTIVE POINTS</b></h6>
                <textarea rows="4" maxlength="200" class="comment_field form-group" name="negative_comment" placeholder="Type your comment in English or Tagalog" required></textarea>
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

<script type="text/javascript">
    function setFullscreen(val){
        
        if(document.getElementById("fullscreen").checked === false){
            document.getElementById("register-pane").style.height = "auto";
            document.getElementById("fLabel").value = "Collapse";
            document.getElementById("fullscreen").checked = true;
            return;
        }
        else if(document.getElementById("fullscreen").checked === true){
            document.getElementById("register-pane").style.height = "350px";
            document.getElementById("fLabel").value = "Expand";
            document.getElementById("fullscreen").checked = false;
            return;
        }
    }
</script>