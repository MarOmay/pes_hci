<?php 
    include_once "header.php";
    include_once "includes/functions.inc.php";
    checkLoginStatus();
    checkAuthorization("Student");
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="register-pane">
        <form id="register-form" method="POST">

            <br>
            <div class="row">
                <div class="col-sm-5">

                    <h4 class="text-left">Before you begin...</h4>

                    <br>
                    <p class="h6">Remember to evaluate and provide feedback according to the given criteria. Once submitted, evaluations can no longer be modified.</p>

                    <br>
                    

                </div>

                <!-- spacer -->
                <div class="col-sm-2"></div>

                <div class="col-sm-5">
                    
                    <div class="form-group">
                        <label for="facultyName">Faculty Name</label>
                        <select class="form-control" id="facultyName" name="facultyName" required>
                            <?php
                                include_once "includes/dbh.inc.php";
                                include_once "includes/functions.inc.php";
                                getUsersToEvaluate($conn, $_SESSION["username"], $_SESSION["section"], $_SESSION["role"]);
                            ?>
                        </select>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-12" align="right">
                            <br>
                            <button type="submit" class="btn btn-primary" align="right" id="registerBtn" name="registerBtn">Evaluate</button>
                        </div>
                    </div>

                </div>
            </div>

            

        </form>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>