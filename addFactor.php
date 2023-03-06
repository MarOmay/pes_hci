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

                $editMode = false;
                $factorId = null;
                $factorTitle = null;
                $factorDesc = null;
                $factorPeerRate = null;
                $factorStudentRate = null;

                if(isset($_GET["id"])){
                    $sql = "SELECT * FROM factors WHERE id=?";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        exit();
                    }

                    mysqli_stmt_bind_param($stmt, "s", $_GET["id"]);

                    mysqli_stmt_execute($stmt);

                    $resultData = mysqli_stmt_get_result($stmt);

                    try{
                        $resultData = mysqli_fetch_assoc($resultData);

                        $factorId = $_GET["id"];
                        $factorTitle = $resultData["factor"];
                        $factorDesc = $resultData["description"];
                        $factorPeerRate = $resultData["peer_rate"];
                        $factorStudentRate = $resultData["student_rate"];
                        
                        $editMode = true;
                    }
                    catch(Exception $e){
                        //pass
                    }
                    
                }
            ?>

            <form action="functions/addFactor.php" method="POST">
                <div class="row">
                    <p class="h5">New Factor</p>
                </div>
                <div class="row" align="left">
                    <div class="col-sm-8">
                        <label for="factor">Factor</label>
                        <input type="text" class="form-control" name="factor" value='<?php echo $factorTitle ?>' placeholder="Type factor title" maxlength="200" required>

                        <label for="description">Description</label>
                        <textarea type="text" id="factor-textarea" class="form-control" name="description" maxlength="200" placeholder="Type factor description" required><?php echo $factorDesc ?></textarea>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <label for="factor">Peer Max. Rating</label>
                        <input type="number" min="1" class="form-control" name="peerRating" value='<?php echo $factorPeerRate ?>' required>

                        <br>

                        <label for="factor">Student  Max. Rating</label>
                        <input type="number" min="1" class="form-control" name="studentRating" value='<?php echo $factorStudentRate ?>' required>

                        <br>

                        <?php
                            if($editMode){
                                echo '<input type="text" class="form-control" name="id" value="' . $factorId . '" hidden>';
                            }
                        ?>

                        <button type="submit" class="container-fluid btn btn-primary" name="submit" value="Add Factor">Save</button>
                    </div>
                    
                </div>

                <br>
                <div class="row" align="left">
                    <p class="opacity-50">Note: <br> Use &lt;br&gt; to indicate new line.</p>
                </div>

            </form>

        </div>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>
