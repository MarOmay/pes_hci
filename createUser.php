<?php

    include_once "includes/dbh.inc.php";
    include_once "includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerBtn'])){

        $lrn = $_POST['lrn'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];

        if(strlen($lrn) !== 12){
            header("location: register.php?error=invalid");
            exit();
        }

        if($pass !== $cpass){
            header("location: register.php?error=pass");
            exit();
        }

        registerUser($conn, $lrn, $fname, $lname, $pass);

    }
    else{
        header("location: index.php");
    }

?>