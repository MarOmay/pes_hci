<?php

    $DB_SERVER = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "pas_hci";

    $conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if(!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }

    function createTables(){
        //https://www.mysqltutorial.org/mysql-create-table/#:~:text=The%20IF%20NOT%20EXISTS%20is,columns%20are%20separated%20by%20commas.
    }

?>