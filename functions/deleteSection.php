<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["sections"])){
        
        if(isset($_POST["sections"])){

            foreach($_POST["sections"] as $section){
                deleteSection($conn, $section);
            }

            header("location: ../master_manageSections.php?error=success");
        }
    }
    else{
        header("location: ../master_manageSections.php");
    }
?>