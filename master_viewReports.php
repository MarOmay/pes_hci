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

            ?>

            <form action="" method="GET">

                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control" name="type" onchange="setType(this.value)">
                            <option value="summaryAll" <?php echo setSelected("summaryAll"); ?> >Summary All</option>
                            <option value="summaryDetailed" <?php echo setSelected("summaryDetailed"); ?> >Detailed Summary</option>
                            <option value="summaryPerUsername" <?php echo setSelected("summaryPerUsername"); ?> >Summary Per Username</option>
                            <option value="commentsPerUsername" <?php echo setSelected("commentsPerUsername"); ?> >Comments Per Username</option>
                            <option value="commentsForUsername" <?php echo setSelected("commentsForUsername"); ?> >Comments For Username</option>
                            <option value="summaryPerSection" <?php echo setSelected("summaryPerSection"); ?> >Summary Per Section</option>
                        </select>
                    </div>

                    <?php
                        if(isset($_GET["type"])){
                            $type = $_GET["type"];

                            if($type === "summaryPerUsername" || $type == "commentsPerUsername" || $type == "commentsForUsername"){
                                echo '<div class="col-sm-5"> <input type="text" class="form-control" name="username" placeholder="Username"></div>';
                                echo '<div class="col-sm-1"><input type="submit" class="btn btn-primary" name="submit" value="Apply"></div>';
                            }
                            else if($type === "summaryPerSection"){
                                echo '<div class="col-sm-5"><select class="form-control" id="section" name="section" required>';
                                getSectionsForDropDown($conn);
                                echo '</select></div>';
                                echo '<div class="col-sm-1"><input type="submit" class="btn btn-primary" name="submit" value="Apply"></div>';
                            }

                        }
                    ?>

                    
                </div>

            </form>

            <!--
            <div class="row conatiner-fluid">
                <div class="row emp-row" id="reportsLabel">
                    <div class="col-sm-4" align="left">
                        <p class="h6">Username</p>
                    </div>

                    <div class="col-sm-4" align="left">
                        <p class="h6">Name</p>
                    </div>

                    <div class="col-sm-2" align="left">
                        <p class="h6">Rating</p>
                    </div>

                    <div class="col-sm-2" align="left">
                        <p class="h6">Details</p>
                    </div>
                </div>
            </div>
                    -->

            <div class="row container-fluid reportsBox">
                <table class="table table-striped table-bordered">

                <?php
                    include_once "includes/dbh.inc.php";
                    include_once "includes/functions.inc.php";

                    if(isset($type)){

                        if($type === "summaryAll"){
                            //display table headers
                            echo '  <thead class="thead-dark">
                                        <tr>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Final Rating</th>
                                        </tr>
                                    </thead>';
                            
                            echo '  <tbody>'
                                    .displayReport_summaryAll($conn).
                                    '</tbody>';

                        }
                        else if($type === "summaryDetailed"){
                            
                        }
                        else if($type === "summaryPerUsername"){
                            
                        }
                        else if($type === "commentsPerUsername"){
                            
                        }
                        else if($type === "commentsForUsername"){
                            
                        }
                        else if($type === "summaryPerSection"){
                            
                        }
                        

                    }

                ?>

                </table>

            </div>

                <div class="container-fluid" id="exportBtn">
                    <input type="button" class="btn bg-success text-white" onclick="exportData('<?php echo $type; ?>')" value="Export">
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

    function exportData(type){
        window.location.href="functions/exportData.php?type=" + type;
    }

</script>
