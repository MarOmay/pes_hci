

<?php

    include_once "includes/dbh.inc.php";
    include_once "includes/functions.inc.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginBtn'])){

        $lrn = $_POST['lrn'];
        $pass = $_POST['password'];

        attemptLogin($conn, $lrn, $pass);

    }
    else{
        header("location: index.php");
    }

?>