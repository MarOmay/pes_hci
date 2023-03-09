<?php 
    include_once "header.php";
    include_once "includes/functions.inc.php";
    checkAuthorization(array("Master"));
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

                    <?php

                        $editMode = false;

                        if(isset($_GET["username"])){
                            $employee = getEmployeeInfo($conn, $_GET["username"]);
                            $editMode = true;

                            echo '<input type="hidden" name="editMode" value="true">';
                        }
                        
                    ?>

                    <div class="form-group">
                        <label for="username">Employee ID</label>
                        <input type="text" class="form-control" maxlength="12" id="username" name="username" value = "<?php echo ($editMode)?$employee["username"]:'';?>" <?php echo (isset($employee["username"]))?'readonly':'';?> required>
                    </div>
                    <div class="form-group">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value = "<?php echo ($editMode)?$employee["fname"]:'';?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value = "<?php echo ($editMode)?$employee["lname"]:'';?>" required>
                    </div>

                    <?php 
                        if (isset($_GET["error"])){
                            if ($_GET["error"] === "internal"){
                                echo '<label class="error_message">Server Error. Try Again.</label>';
                            }
                            else if ($_GET["error"] === "taken"){
                                echo '<label class="error_message">Employee ID is taken.</label>';
                            }
                            else if ($_GET["error"] === "success"){
                                echo '<label class="error_message" style="color:green;">Account successfully created!</label>';
                            }
                        }

                    ?>
                </div>

                <!-- spacer -->
                <div class="col-sm-2"></div>

                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" value = "<?php echo ($editMode)?$employee["role"]:'';?>" required>
                            <?php
                                include_once "includes/dbh.inc.php";
                                include_once "includes/functions.inc.php";
                                getRoles($conn,array("Student","Master"), $editMode?$employee["role"]:"");
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sections-listbox">Evaluator</label>
                        <div class="container-fluid" id="sections-listbox">
                            <?php 
                                if($editMode){
                                    getSectionsForChecklist($conn, getEvaluatorsAsArray($conn, $_GET["username"]));
                                }
                                else{
                                    getSectionsForChecklist($conn, array(""));
                                }
                            ?>
                        </div>
                    </div>

                    <br>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" align="right">
                    
                    <?php
                        if($editMode){
                            echo '<button type="submit" class="btn btn-primary" id="registerBtn" name="registerBtn">Save</button>';
                        }
                        else{
                            echo '<button type="submit" class="btn btn-primary" id="registerBtn" name="registerBtn">Register Employee</button>';
                        }
                        
                    ?>

                </div>
            </div>

        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>