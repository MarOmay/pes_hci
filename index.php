<?php
    include_once "header.php";  
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="login-pane">


        <form id="login-form" action="authenticate.php" method="POST">

            <h4 class="text-center">Student Login</h4>

            <br>
            <div class="form-group">
                <label for="lrn">Learner Reference Number</label>
                <input type="text" class="form-control" id="lrn" name="lrn" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <?php 

                if (isset($_GET["error"])){
                    if ($_GET["error"] === "incorrectpassword"){
                        echo '<label class="error_message">Incorrect password</label>';
                    }
                    else if ($_GET["error"] === "loginfailed"){
                        echo '<label class="error_message">Login failed</label>';
                    }
                    else if ($_GET["error"] === "noaccount"){
                        echo '<label class="error_message">Account does not exist</label>';
                    }
                }
            ?>

            <br>
            <button type="submit" class="btn btn-primary" id="loginBtn" name="loginBtn">Login</button>


        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>

<?php 
    include_once "footer.php";
?>