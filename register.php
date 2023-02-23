<?php 
    include_once "header.php";
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="register-pane">
        <form id="register-form" action="createUser.php" method="POST">

            <h4 class="text-center">Registration</h4>

            <br>
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="lrn">Learner Reference Number</label>
                        <input type="text" class="form-control" id="lrn" name="lrn" required>
                    </div>
                    <div class="form-group">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                </div>

                <!-- spacer -->
                <div class="col-sm-2"></div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    </div>

                    <?php 
                        if (isset($_GET["error"])){
                            if ($_GET["error"] === "invalid"){
                                echo '<label class="error_message">Invalid LRN.</label>';
                            }
                            else if ($_GET["error"] === "pass"){
                                echo '<label class="error_message">Password did not match.</label>';
                            }
                            else if ($_GET["error"] === "internal"){
                                echo '<label class="error_message">Server Error. Try Again.</label>';
                            }
                            else if ($_GET["error"] === "taken"){
                                echo '<label class="error_message">Account already exists.</label>';
                            }
                        }
                    ?>

                    <br>
                    <button type="submit" class="btn btn-primary" id="loginBtn" name="registerBtn">Register</button>
                </div>
            </div>

        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>