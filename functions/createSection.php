<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    if(isset($_POST["section"])){

        $section = $_POST['section'];

        createNewSection($conn, $section);

        header("location: ../master_manageSections.php?error=added");

    }
    else{
        header("location: ../master_manageSections.php");
    }

?>