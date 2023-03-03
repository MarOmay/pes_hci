<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(isset($_POST["employees"])){

            foreach($_POST["employees"] as $employee){
                deleteEmployee($conn, $employee);
            }

            header("location: ../master_manageEmployees.php?error=deleted");
        }
        else{
            header("location: ../master_manageEmployees.php?error=noselect");
        }
    }
    else{
        header("location: ../master_manageEmployees.php");
    }
?>