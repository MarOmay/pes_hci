<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();

    if(isset($_POST["facultyName"])){

        if(isEvaluated($conn, $_SESSION["username"], $_POST["facultyName"])){
            
        }
        else{
            header("location: ../evaluationForm.php?id=" . $_POST["facultyName"]);
        }
        
    }
?>