<?php

    require_once "includes/dbh.inc.php";

    //create database tables

    try{

        //create users table
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


        //create sections table
        $sql = "CREATE TABLE IF NOT EXISTS sections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            section VARCHAR(250) NOT NULL)
            ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }


        //create roles table
        $sql = "CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            role VARCHAR(250) NOT NULL)
            ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            //create roles table
            $sql = "INSERT INTO roles (id, role)
                    VALUES (NULL, 'Master'), (NULL, 'Student'),
                    (NULL, 'Teaching'), (NULL, 'Non-Teaching')";

            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                exit();
            }
            else{
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }


        //create factors table
        $sql = "CREATE TABLE IF NOT EXISTS factors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            factor VARCHAR(250) NOT NULL,
            description VARCHAR(250) NOT NULL,
            peer_rate INT NOT NULL,
            student_rate INT NOT NULL)
            ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }


        //create evaluations table
        $sql = "CREATE TABLE IF NOT EXISTS evaluations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            evaluator VARCHAR(250) NOT NULL,
            evaluatee VARCHAR(250) NOT NULL,
            positive_comment VARCHAR(250) NOT NULL,
            negative_comment VARCHAR(250) NOT NULL)
            ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }


        //create evaluatees table
        $sql = "CREATE TABLE IF NOT EXISTS evaluatees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            evaluatee_username VARCHAR(250) NOT NULL,
            evaluatee_fname VARCHAR(250) NOT NULL,
            evaluatee_lname VARCHAR(250) NOT NULL,
            evaluator VARCHAR(250) NOT NULL)
            ENGINE=INNODB";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }
        else{
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
            
        header("location: index.php?error=setupdone");

    }
    catch(Exception $e){
        header("location: index.php?error=internal");
    }
    

?>