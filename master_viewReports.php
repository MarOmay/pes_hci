<?php

use function PHPSTORM_META\type;

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

                $type = null;
                if(isset($_GET["type"])){
                    $type = $_GET["type"];
                }

                function setSelected($value){
                    global $type;
                    if($value === $type){
                        return 'selected';
                    }
                    return "";
                }

                function setSelectedEmp($username){
                    if(isset($_GET["username"])){
                        if($_GET["username"] === $username){
                            return 'selected';
                        }
                    }
                }

            ?>

            <form action="" method="GET" id="usernameFilter">

                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control" name="type" onchange="setType(this.value)">
                            <option value="summaryAll_Peer" <?php echo setSelected("summaryAll_Peer"); ?> >Peer Summary</option>
                            <option value="summaryAll_Student" <?php echo setSelected("summaryAll_Student"); ?> >Student Summary</option>
                            <option value="summaryDetailed_Peer" <?php echo setSelected("summaryDetailed_Peer"); ?> >Peer Detailed</option>
                            <option value="summaryDetailed_Student" <?php echo setSelected("summaryDetailed_Student"); ?> >Student Detailed</option>
                            <option value="commentPerUser_Peer" <?php echo setSelected("commentPerUser_Peer"); ?> >Peer Comments</option>
                            <option value="commentPerUser_Student" <?php echo setSelected("commentPerUser_Student"); ?> >Student Comments</option>
                        </select>
                    </div>

                    <?php
                        if(isset($_GET["type"])){
                            $type = $_GET["type"];

                            $username = "";
                            if(isset($_GET["username"])){
                                $username = $_GET["username"];
                            }

                            if($type === "commentPerUser_Peer" || $type === "commentPerUser_Student"){

                                echo '<div class="col-sm-6">
                                        <select class="form-control" name="username" id="comment-emp-list" onchange="setUsername(this.value)">';

                                        $allEmployeeUsernames = getAllEmployeesUsername($conn);

                                        echo '<option value="all" ' . (isset($username) ? "selected" : "") . '>All</option>';

                                        while($employee = mysqli_fetch_assoc($allEmployeeUsernames)){
                                            echo '<option value="' . $employee["username"] . '"' . setSelectedEmp($employee["username"]) .  '>' . $employee["lname"] . ", " . $employee["fname"] . '</option>';
                                        }

                                echo '</select></div>';
                                //echo '<div class="col-sm-1"><input type="submit" class="btn btn-primary" name="submit" value="Apply"></div>';
                            }

                        }
                    ?>

                    
                </div>

            </form>

            <div class="container-fluid" align="left">
                
            </div>

            <div class="row container-fluid reportsBox">
                <table class="table table-striped table-bordered">

                <?php
                    include_once "includes/dbh.inc.php";
                    include_once "includes/functions.inc.php";

                    if(isset($type)){

                        if($type === "summaryAll_Peer" || $type === "summaryAll_Student"){
                            //display table headers
                            echo '  <thead class="thead-dark">
                                        <tr>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Entry</th>
                                            <th>Final Rating</th>
                                        </tr>
                                    </thead>';
                            
                            //display contents
                            echo '  <tbody>'
                                    .displayReport_summaryAll($conn, $type === "summaryAll_Student" ? "Student" : "").
                                    '</tbody>';

                        }
                        else if($type === "summaryDetailed_Peer" || $type === "summaryDetailed_Student"){
                            //display table headers
                            echo '  <thead class="thead-dark">
                                        <tr>
                                            <th>Username</th>
                                            <th>Name</th>';

                                $columns = getColumns($conn);

                                foreach($columns as $column){
                                    $col = $column['Field'];
                                    if($col !== "id" && $col !== "evaluator" && $col !== "evaluatee" && $col !== "positive_comment" && $col !== "negative_comment")
                                    echo '<th>' . $col . '</th>';
                                }

                            echo '      <th>Rating</th>
                                        </tr>
                                    </thead>';
                            
                            //display contents
                            echo '  <tbody>'
                                    .displayReport_summaryDetailed($conn, $type === "summaryDetailed_Student" ? "Student" : "").
                                    '</tbody>';
                        }
                        else if(($type === "commentPerUser_Peer" || $type === "commentPerUser_Student")){

                            if(isset($_GET["username"])){
                                //display table headers
                                echo '  <thead class="thead-dark">
                                            <tr>
                                                <th>Positive</th>
                                                <th>Negative</th>
                                            </tr>
                                        </thead>';

                                //display contents
                                echo '  <tbody>'
                                        .displayReport_commentPerUser($conn, $type === "commentPerUser_Student" ? "Student" : "", $username).
                                        '</tbody>';
                            }
                            else{
                                //display table headers
                                echo '  <thead class="thead-dark">
                                            <tr>
                                                <th>Subject</th>
                                                <th>Positive</th>
                                                <th>Negative</th>
                                            </tr>
                                        </thead>';

                                //display contents
                                echo '  <tbody>'
                                        .displayReport_commentAllUsers($conn, $type === "commentPerUser_Student" ? "Student" : "", $username).
                                        '</tbody>';
                            }

                            
                        }
                        

                    }

                ?>

                </table>

            </div>

                <div class="container-fluid" id="exportBtn">
                    <input type="button" class="btn bg-success text-white" onclick="exportData('<?php echo $type; ?>','<?php echo isset($username) ? $username : null ?>')" value="Export">
                </div>

        </div>

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">
        
    </div>
    
</div>

<script type="text/javascript">

    function setType(type){
        window.location.href="master_viewReports.php?type=" + type;
    }

    function setUsername(username){
        if(username === "all"){
            document.getElementById("comment-emp-list").value = null;
        }
        document.getElementById("usernameFilter").submit();
    }

    function exportData(type, username){
        if (typeof username === 'undefined' || username === null || username.length < 1) {
            console.log("Username undefined");
            window.location.href="functions/exportData.php?type=" + type;
        }
        else{
            console.log("Username: '" + username + "'");
            window.location.href="functions/exportData.php?type=" + type + "&username=" + username;
        }
        
    }

</script>
