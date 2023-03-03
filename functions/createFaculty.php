<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerBtn'])){

        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $role = $_POST['role'];

        $sections = isset($_POST["sections"]) ? $_POST["sections"] : array();

        if(isset($_POST["editMode"])){
            updateUserInfo($conn, $username, $fname, $lname, $sections, $role);
        }
        else{
            registerUser($conn, $username, $fname, $lname, "", "", $role);
        }
        

    }
    else{
        header("location: ../index.php");
    }

?>