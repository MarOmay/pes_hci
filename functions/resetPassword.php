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
    else{
        header("location:  ../index.php");
    }

?>