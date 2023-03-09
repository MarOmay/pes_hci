<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerBtn'])){

        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $section = $_POST['section'];
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];

        if(strlen($username) !== 12){
            header("location: ../register.php?error=invalid");
            exit();
        }

        if($pass !== $cpass){
            header("location: ../register.php?error=pass");
            exit();
        }

        if(isset($_POST["editMode"])){
            updateUserInfo($conn, $username, $fname, $lname, $section, "Student");
        }
        else{
            registerUser($conn, $username, $fname, $lname, $section, $pass, "Student");
        }

    }
    else{
        header("location:  ../index.php");
    }

?>