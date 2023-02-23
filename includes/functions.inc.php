<?php

    include_once "dbh.inc.php";

    function attemptLogin($conn, $lrn, $password){
        $sql = "SELECT * FROM users WHERE lrn = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=userdoesnotexist");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $lrn);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row === false){
            header("location: index.php?error=loginfailed");
            exit();
        }

        if(empty($row["lrn"])){
            header("location: index.php?error=noaccount");
        }
        else{
            $isMatch = password_verify($password, $row["password"]);

            if($isMatch === true){
                echo "alert('Logged in!');";
            }
            else{
                header("location: index.php?error=incorrectpassword");
                exit();
            }
        }

        mysqli_stmt_close($stmt);
    }

    function userExist($conn, $lrn){
        $sql = "SELECT * FROM users WHERE lrn = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $lrn);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row === false){
            header("location: register.php?error=internal");
            exit();
        }

        if(empty($row["lrn"])){
            mysqli_stmt_close($stmt);
            return false;
        }
        else{
            mysqli_stmt_close($stmt);
            return true;
        }
    }

    function registerUser($conn, $lrn, $fname, $lname, $password){

        $exist = userExist($conn, $lrn);

        if ($exist){
            header("location: register.php?error=taken");
            exit();
        }

        $stmt = mysqli_stmt_init($conn);

        $sql = "INSERT INTO users (id, lrn, fname, lname, password, created) VALUES (NULL,?,?,?,?,?)";

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: register.php?error=internal");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $date = date("M d, Y h:i a");

        mysqli_stmt_bind_param($stmt, "sssss", $lrn, $fname, $lname, $hashedPassword, $date);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        header("location: index.php?error=none");
        exit();

    }


?>