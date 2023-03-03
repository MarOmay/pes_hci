<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginBtn'])){

        $username = $_POST['username'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];

        if(strlen($username) !== 12){
            header("location: ../resetPassword.php?error=invalid");
            exit();
        }

        resetPassword($conn, $username, $currentPassword, $newPassword);

    }
    else if(isset($_GET["username"]) && isset($_GET["initials"])){
        checkAuthorization(array("Master"));
        resetPasswordToDefault($conn, $_GET["username"], $_GET["initials"]);
    }
    else{
        header("location:  ../index.php");
    }

?>