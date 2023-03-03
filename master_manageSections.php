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

        <div class="container-fluid row">

            <div class="col-sm-1"></div>

            <div class="col-sm-5">
                <form id="register-form" action="functions/deleteSection.php" method="POST">
                    <p class="h6">Class Sections</p>
                    <div class="container-fluid" id="emp_listbox">
                        <?php
                            include_once "includes/dbh.inc.php";
                            include_once "includes/functions.inc.php";

                            getSectionsForChecklist($conn, array(""));
                        ?>
                    </div>
                    <button onclick="isChecked()" class="btn btn-danger" id="deleteAccountBtn" name="deleteSelectedBtn">Delete Selected</button>
                </form>
            </div>

            <div class="col-sm-1"></div>

            <div class="col-sm-4">
                <form action="functions/createSection.php" method="POST">
                    <div align="left">
                        <p class="h6">Add New Class Section</p>
                        <input type="text" class="form-control" name="section" id="sectionInputText" required>
                    </div>
                    <div align="right">
                        <button onclick="createSection()" class="btn btn-success" align="right">Add</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-1"></div>

        </div>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>

<script type="text/javascript">

    function isChecked(){
        const checkboxes = Array.from(document.querySelectorAll(".form-check-input"));
        if (checkboxes.reduce((acc, curr) => acc || curr.checked, false)){

            var confirmation = prompt("Type \"DELETE\" to confim deletion of selected sections.","");

            if(confirmation == "DELETE"){
                document.getElementById("register-form").submit();
            }

        }
        else{
            alert("Please select at least one Section to delete.");
            exit();
        }
    }

</script>