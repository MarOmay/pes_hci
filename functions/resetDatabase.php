<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

        $pass = $_POST['password'];

        try{
            verify_credential($conn, $_SESSION["username"], $pass);
        }
        catch(Exception $e){
            header("location: ../master_resetDatabase.php?error=internal");
        }

    }
    else{
        header("location: ../master_resetDatabase.php?error=internal");
    }

?>