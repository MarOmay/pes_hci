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
                                        <div class='col-sm-3' align='left'>
                                            $name
                                        </div>
                                        <div class='col-sm-3' align='left'>
                                            <p class=''>" . $username . "</p>
                                        </div>
                                        <div class='col-sm-2' align='right'>
                                            <a href='master_registerEmployee.php?username=" . $username . "'><img src='images/edit.png' width='20' height='20'></a>
                                        </div>
                                        <div class='col-sm-2' align='right'>
                                            <a href='#' onclick='resetConf(\"" . $username . "&initials=" . $initials . "&\")'><img src='images/reset.png' width='20' height='20'></a>
                                        </div>
                                        <div class='col-sm-2' align='right'>
                                            <a href='#' onclick='deleteConf(" . $username . ")'><img src='images/delete.png' width='20' height='20'></a>
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
                        <form action='functions/deleteEmployee.php' id='selection-form' method='POST'>
                        <div class='container-fluid'>
                            <div class='row'>
                                <div class='col-sm-3' align='left'>
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
                    else if($_GET["error"] === "internal"){
                        echo '  <div class="alert alert-danger" id="alertBox">
                                    <strong>Error! </strong>Server error. Try again.
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

            if (confirm("Delete selected accounts?")) {
                document.getElementById("selection-form").submit();
            }
        
        }
        else{
            alert("Please select at least one Account to delete.");
            exit();
        }
    }

    function resetConf(GETParams){
        if (confirm("Reset password of this account to default?")) {
                window.location.href= "functions/resetPassword.php?username=" + GETParams;
            }
    }

    function deleteConf(username){
        if (confirm("Delete selected account?")) {
            window.location.href= "functions/deleteEmployee.php?username=" + username;
        }
    }

</script>
