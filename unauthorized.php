<?php
    include_once "header.php";  
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="unauth-pane">
        <div class="container-fluid d-flex justify-content-center">
            <?php
                if(isset($_GET["username"])){
                    echo '<p class="h1"><span class="badge bg-success text-white">Evaluation submitted</span></p>';
                }
                else{
                    echo '<p class="h1"><span class="badge bg-danger text-white">Unauthorized Access</span></p>';
                }
            ?>
        </div>
        <br>
        <div class="container-fluid d-flex justify-content-center">
            <?php
                if(isset($_GET["username"])){
                    echo '<button class="btn btn-primary" onclick="window.location.href=\'index.php\'">Home</button>';
                }
                else{
                    echo '<button class="btn btn-primary" onclick="history.back()">Go Back</button>';
                }
            ?>
        </div>
    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>

<?php 
    include_once "footer.php";
?>