<?php 
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
            <form action="" method="GET">
                <div class="row">
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="usernameSearchBox" placeholder="Search by name or username...">
                    </div>
                    <div class="col-sm-2" align="right" id="searchBtn">
                        <button class="btn btn-primary" type="sumbit" name="searchBtn">Search</button>
                    </div>
                </div>
            </form>

            <?php
                include_once "includes/dbh.inc.php";
                include_once "includes/functions.inc.php";

                function getSearchResult($conn, $keyword){
                    try{
                        $sql = "SELECT * FROM users WHERE (username LIKE ? OR fname LIKE ? OR lname LIKE ?)
                        AND (role='Teaching' OR role='Non-Teaching')";

                        if(gettype($keyword) === "boolean"){
                            $sql = "SELECT * FROM users WHERE role='Teaching' OR role='Non-Teaching'";
                        }

                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            //header("location: ../register.php?error=internal");
                            exit();
                        }

                        if(gettype($keyword) === "string"){
                            $keyword = "%" . $keyword . "%";
                            mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
                        }

                        mysqli_stmt_execute($stmt);

                        $resultData = mysqli_stmt_get_result($stmt);

                        $ctr = 0;
                        while($row = mysqli_fetch_assoc($resultData)){
                            $username = $row["username"];
                            $name = $row["fname"] . " " . $row["lname"];
                            $initials = $row["fname"][0] . $row["lname"][0];
                            echo "<div class='container-fluid' id='searchResultRow'>
                                    <div class='row'>
                                        <div class='col-sm-1' align='left'>
                                            <input type='checkbox' class='form-check-input' name=\"employees[]\" value='$username' />
                                        </div>
                                        <div class='col-sm-4' align='left'>
                                            $name
                                        </div>
                                        <div class='col-sm-3' align='left'>
                                            <p class=''>" . $username . "</p>
                                        </div>
                                        <div class='col-sm-2' align='right'>
                                            <a href='master_registerEmployee.php?username=" . $username . "'><img src='images/edit.png' width='20' height='20'></a>
                                        </div>
                                        <div class='col-sm-2' align='right'>
                                            <a href='functions/resetPassword.php?username=" . $username . "&initials=" . $initials . "&'><img src='images/reset.png' width='20' height='20'></a>
                                        </div>
                                    </div>
                                    
                                    </div>";
                            $ctr++;
                        }

                        if($ctr < 1){
                            echo "<div class='container-fluid' id='searchResultRow'>
                                    <div class='row'>
                                        <div class='col-sm-1' align='left'>
                                            <p class=''>&nbsp</p>
                                        </div>
                                        <div class='col-sm-4' align='left'>
                                            <p class=''>No result</p>
                                        </div>
                                        <div class='col-sm-3' align='left'>
                                            <p class=''>No result</p>
                                        </div>
                                        <div class='col-sm-2' align='center'>
                                            <p class=''>No result</p>
                                        </div>
                                        <div class='col-sm-2' align='center'>
                                            <p class=''>No result</p>
                                        </div>
                                    </div>
                                    
                                    </div>";
                        }

                        mysqli_stmt_close($stmt);
                    }
                    catch(Exception $e){
                        echo '<div align="left"><label class="label">' . $e . '</label></div>';
                    }
                    
                }

                echo "<br>
                        <form action='functions/deleteEmployee.php' method='POST'>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-sm-1' align='left'>
                                    <p class=''>&nbsp</p>
                                </div>
                                <div class='col-sm-4' align='left'>
                                    <p class=''>Employee</p>
                                </div>
                                <div class='col-sm-3' align='left'>
                                    <p class=''>Username</p>
                                </div>
                                <div class='col-sm-2' align='center'>
                                    <p class=''>Edit</p>
                                </div>
                                <div class='col-sm-2' align='center'>
                                    <p class=''>Reset</p>
                                </div>
                            </div>
                                    
                        </div>";

                    echo '<div class="container-fluid" align="left" id="searchResultBox">';

                if(isset($_GET["usernameSearchBox"])){ 
                    getSearchResult($conn, $_GET["usernameSearchBox"]);
                }
                else{
                    getSearchResult($conn, false);
                }
                echo '     
                        </div>
                        <div align="right">
                            <button onclick="isChecked()" class="btn text-danger" id="deleteAccountBtn" name="deleteSelectedBtn">Delete Selected</button>
                        </div>
                        </form>';

                if(isset($_GET["error"])){
                    if($_GET["error"] === "saved"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Changes saved! </strong>Employee information updated.
                                </div>';
                    }
                    else if($_GET["error"] === "reset"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Changes saved! </strong>Password reset to default.
                                </div>';
                    }
                    else if($_GET["error"] === "deleted"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Changes saved! </strong>Account deleted successfully.
                                </div>';
                    }
                    else if($_GET["error"] === "noselect"){
                        echo '  <div class="alert alert-danger" id="alertBox">
                                    <strong>Cancelled! </strong>Please select an account.
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

    function isChecked(){
        const checkboxes = Array.from(document.querySelectorAll(".form-check-input"));
        if (checkboxes.reduce((acc, curr) => acc || curr.checked, false)){

            var confirmation = prompt("Type \"DELETE\" to confim deletion of selected accounts.","");

            if(confirmation == "DELETE"){
                document.getElementById("register-form").submit();
            }

        }
    }

</script>
