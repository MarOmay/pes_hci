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
        <form id="register-form" action="" method="POST">

            <br>
            <div class="row">
                <div class="col-sm-5">
                    <p class="h6">Employee Accounts</p>
                    <div class="container-fluid" id="emp_listbox">
                        <?php
                            include_once "includes/dbh.inc.php";
                            include_once "includes/functions.inc.php";

                            getEmployeesAsChecklist($conn);
                            getEmployeesAsChecklist($conn);
                            getEmployeesAsChecklist($conn);
                        ?>
                    </div>
                    <br>
                    <div align="center">
                        <button onclick="isChecked()" class="btn btn-primary" id="registerBtn" name="registerBtn">Delete Selected</button>
                        | 
                        <button type="submit" class="btn btn-danger" id="registerBtn" name="registerBtn">Delete ALL</button>
                    </div>

                </div>

                <!-- spacer -->
                <div class="col-sm-2"></div>

                <div class="col-sm-5">
                    

                </div>
            </div>

        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>

<script type="text/javascript">
    function isChecked(){
        const checkboxes = Array.from(document.querySelectorAll(".form-check-input"));
        if (checkboxes.reduce((acc, curr) => acc || curr.checked, false)){

            var password = prompt("Password","");

            //document.getElementById("myForm").submit();
        }
        else{
            alert("Please select at least one Employee Account to delete.");
        }
    }
</script>