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
        <form id="register-form" action="functions/deleteEmployee.php" method="POST">

            <br>

            <div class="row">
                <div class="col-sm-1"></div>

                <div class="col-sm-5">
                    <p class="h6">Employee Accounts</p>
                    <div class="container-fluid" id="emp_listbox">
                        <?php
                            include_once "includes/dbh.inc.php";
                            include_once "includes/functions.inc.php";

                            getEmployeesAsChecklist($conn);
                        ?>
                    </div>
                    <button onclick="isChecked()" class="btn btn-danger" id="deleteAccountBtn" name="deleteSelectedBtn">Delete Selected</button>

                </div>

                <div class="col-sm-4">
                    <div align="right">
                        <p class="h6">&nbsp</p>
                        <button type="button" class="btn btn-success" onclick="window.location.href='master_registerEmployee.php'">New Employee</button>
                        <br><br><br><br>
                        <button type="button" class="btn text-success" onclick="window.location.href='master_resetEmployeePassword.php'">Edit Employee 🡕</button>
                        <br>
                        <button type="button" class="btn text-success" onclick="window.location.href='master_resetEmployeePassword.php'">Reset Password 🡕</button>
                        
                    </div>
                </div>

                <div class="col-sm-2"></div>
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

            var confirmation = prompt("Type \"DELETE\" to confim deletion of selected accounts.","");

            if(confirmation == "DELETE"){
                document.getElementById("register-form").submit();
            }

        }
        else{
            alert("Please select at least one Employee Account to delete.");
        }
    }

</script>