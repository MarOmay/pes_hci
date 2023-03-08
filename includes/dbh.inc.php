<?php

    $DB_SERVER = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "pas_hci";

    $conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if(!$conn){
        die("Connection failed: " .mysqli_connect_error());
    }

    function createTables($conn){
        
        $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(12) NOT NULL,
                fname VARCHAR(250) NOT NULL,
                lname VARCHAR(250) NOT NULL,
                section VARCHAR(250) NOT NULL,
                password VARCHAR(250) NOT NULL,
                created VARCHAR(250) NOT NULL,
                role VARCHAR(250) NOT NULL)
                ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

?>