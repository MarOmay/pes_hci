<?php

    $DB_SERVER = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "pas_hci";

    $conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if(!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }

?>