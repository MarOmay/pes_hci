

<?php

    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginBtn'])){

        $username = $_POST['username'];
        $pass = $_POST['password'];

        attemptLogin($conn, $username, $pass);

    }
    else{
        header("location: ../index.php");
    }

?>