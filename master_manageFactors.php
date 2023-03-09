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

            <?php
                include_once "includes/dbh.inc.php";
                include_once "includes/functions.inc.php";

                function displayFactors($conn){
                    try{
                        $sql = "SELECT * FROM factors";

                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            //header("location: ../register.php?error=internal");
                            exit();
                        }

                        mysqli_stmt_execute($stmt);

                        $resultData = mysqli_stmt_get_result($stmt);

                        while($row = mysqli_fetch_assoc($resultData)){
                            $id = $row["id"];
                            $factor = $row["factor"];
                            $description = $row["description"];
                            $peerRate = $row["peer_rate"];
                            $studentRate = $row["student_rate"];
                            echo "<div class='container-fluid' id='factorRow'>

                                    <div class='row' style='word-wrap: break-word;'>
                                        <div class='col-sm-10'>
                                            <h5>" . $factor . "</h5>
                                        </div>
                                        <div class='col-sm-2'>
                                            <a href='addFactor.php?id=" . $id . "'><img src='images/edit.png' width='20' height='20'></a>
                                            &nbsp
                                            <a href='#' onclick='deleteConf(" . $id . ")'><img src='images/delete.png' width='20' height='20'></a>
                                        </div>
                                    </div>

                                    <div class='row' style='word-wrap: break-word;'>
                                        <div class='col-sm-10'>
                                            <p>" . $description . "</p>
                                        </div>
                                    </div>

                                    <div class='row'>
                                        <p>Peer Max. Rate: " . $peerRate . "<br>
                                        Student Max. Rate: " . $studentRate . "</p>
                                    </div>
                            
                                </div>";

                        }

                        mysqli_stmt_close($stmt);
                    }
                    catch(Exception $e){
                        echo '<div align="left"><label class="label">' . $e . '</label></div>';
                    }
                    
                }

                echo '<div class="container-fluid" align="left" id="factorBox">
                        <div class="row">
                            <div class="col-sm-9">
                                <p class="h5">Factors</p>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn bg-success text-white" onclick="window.location.href=\'addFactor.php\'">New Factor</button>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>';

                displayFactors($conn);

                echo '</div>';

                if(isset($_GET["error"])){
                    if($_GET["error"] === "added"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Factor saved! </strong>New factor created.
                                </div>';
                    }
                    else if($_GET["error"] === "updated"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Changes saved! </strong>Factor information updated.
                                </div>';
                    }
                    else if($_GET["error"] === "deleted"){
                        echo '  <div class="alert alert-success" id="alertBox">
                                    <strong>Changes saved! </strong>Factor deleted successfully.
                                </div>';
                    }
                    else if($_GET["error"] === "notadded"){
                        echo '  <div class="alert alert-danger" id="alertBox">
                                    <strong>Cancelled! </strong>Failed to create new factor.
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

    function deleteConf(id){

        if (confirm("Delete selected factor?")) {
            window.location.href= "functions/deleteFactor.php?id=" + id;
        }
    }

</script>
