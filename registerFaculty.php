<?php 
    include_once "header.php";
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="register-pane">
        <form id="register-form" action="functions/createFaculty.php" method="POST">

            <h4 class="text-center">New Employee</h4>

            <br>
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="username">Employee ID</label>
                        <input type="text" class="form-control" id="username" name="username" required>
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
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <?php
                                include_once "includes/dbh.inc.php";
                                include_once "includes/functions.inc.php";
                                getRoles($conn,array("Student","Master"));
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sections-listbox">Classes</label>
                        <div class="container-fluid" id="sections-listbox">

                        </div>
                    </div>

                    <br>

                    <?php 
                        if (isset($_GET["error"])){
                            if ($_GET["error"] === "internal"){
                                echo '<label class="error_message">Server Error. Try Again.</label>';
                            }
                            else if ($_GET["error"] === "taken"){
                                echo '<label class="error_message">Account already exists.</label>';
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" align="right">
                    
                    <button type="submit" class="btn btn-primary" id="registerBtn" name="registerBtn">Register Employee</button>
                </div>
            </div>

        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>