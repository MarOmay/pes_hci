<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Student", "Teaching", "Non-Teaching", "Master"));

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginBtn'])){

        $username = $_SESSION['username'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if(strlen($username) !== 12){
            header("location: ../resetPassword.php?error=invalid");
            exit();
        }

        if($newPassword !== $confirmPassword){
            header("location: ../resetPassword.php?error=notmatch");
            exit();
        }

        resetPassword($conn, $username, $newPassword);

    }
    else if(isset($_GET["username"]) && isset($_GET["initials"])){
        checkAuthorization(array("Master"));
        resetPasswordToDefault($conn, $_GET["username"], $_GET["initials"]);
    }
    else{
        header("location:  ../index.php");
    }

?>