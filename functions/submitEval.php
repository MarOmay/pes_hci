<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerBtn'])){

        $evaluator_username = $_SESSION["username"];
        $evaluatee_username = $_POST["username"];

        $responses = [];
        
        $sql = "SELECT * FROM factors";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){
            $id = $row["id"];
            $responses[$id] = $_POST["rating_".$id];
        }

        $responses["c1"] = $_POST["c1"];
        $responses["c2"] = $_POST["c2"];

        postEval($conn, $evaluator_username, $evaluatee_username, $responses);

    }
    else{
        header("location: ../index.php?error=done");
    }

?>