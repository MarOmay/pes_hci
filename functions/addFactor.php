<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();

    if(isset($_POST["submit"]) && isset($_POST["id"])){

        $id = $_POST["id"];
        $factor = $_POST["factor"];
        $description = $_POST["description"];
        $peerRate = $_POST["peerRating"];
        $studentRate = $_POST["studentRating"];

        updateFactor($conn, $id, $factor, $description, $peerRate, $studentRate);
        header("location: ../master_manageFactors.php?error=updated");

    }
    else if(isset($_POST["submit"])){

        $factor = $_POST["factor"];
        $description = $_POST["description"];
        $peerRate = $_POST["peerRating"];
        $studentRate = $_POST["studentRating"];

        addFactor($conn, $factor, $description, $peerRate, $studentRate);
        header("location: ../master_manageFactors.php?error=added");
        
    }
    else{
        header("location: ../master_manageFactors.php?error=notadded");
    }
?>