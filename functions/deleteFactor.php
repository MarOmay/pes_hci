<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    if(isset($_GET["id"])){

        $id = $_GET["id"];

        deleteFactor($conn, $id);
        header("location: ../master_manageFactors.php?error=deleted");

    }
    else{
        header("location: ../master_manageFactors.php?error=internal");
    }
?>