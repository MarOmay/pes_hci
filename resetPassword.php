<?php
    include_once "header.php";  
    checkAuthorization(array("Student", "Teaching", "Non-Teaching", "Master"));
?>

<div class="container-fluid border" id="login-container">

    <div class="container-fluid text-white" id="login-pane-ribbon">
        <h4 class="text-center">Performance Evaluation System</h4>
    </div>

    <div id="login-pane">


        <form id="login-form" action="functions/resetPassword.php" method="POST">

            <h4 class="text-center">Change Password</h4>

            <br>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
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
                    else if ($_GET["error"] === "invalid"){
                        echo '<label class="error_message">Invalid username</label>';
                    }
                    else if ($_GET["error"] === "internal"){
                        echo '<label class="error_message">Internal error. Try again.</label>';
                    }
                    else if ($_GET["error"] === "success"){
                        echo '<label class="error_message" style="color:green;">Password reset successful!</label>';
                    }
                }
            ?>

            <br>
            <button type="submit" class="btn btn-primary" id="loginBtn" name="loginBtn">Submit</button>


        </form>
        

    </div>

    <div class="container-fluid text-white" id="login-pane-ribbon">

    </div>
    
</div>
