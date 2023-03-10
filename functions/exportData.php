<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    function filterData(&$str){
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/","\\n",$str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    if(isset($_GET["type"])){

        if($_GET["type"] === "summaryAll_Peer" || $_GET["type"] === "summaryAll_Student"){

            $filter = $_GET["type"] === "summaryAll_Student" ? "Student" : "";

            $filename = "summary-all-". $filter . "-" . date('Y-m-d') . ".xls";
            $fields = array("Username", "Name", "Entry", "Rating");
            $excelData = implode("\t", array_values($fields)) . "\n";

            $allEmployeeUsernames = getAllEmployeesUsername($conn);
            while($usernames = mysqli_fetch_assoc($allEmployeeUsernames)){
                $evaluations = getEvaluationsByUsername($conn, $usernames["username"]);
                $username = $usernames["username"];

                $fields = [];
                $ave = 0;
                $ctr = 0;
                while($eval = mysqli_fetch_assoc($evaluations)){

                    $role = getRoleByUsername($conn, $eval["evaluator"]);

                    if($filter === "Student"){
                        if($role !== "Student"){
                            continue;
                        }
                    }
                    else{
                        if($role !== "Teaching" && $role !== "Non-Teaching"){
                            continue;
                        }
                    }

                    $columns = getColumns($conn);

                    $total = 0;

                    try{
                        while($column = mysqli_fetch_assoc($columns)){
                            $col = "" . $column['Field'];
                            
                            if($col !== "id" && $col !== "evaluator" && $col !== "evaluatee" && $col !== "positive_comment" && $col !== "negative_comment"){
                                
                                if(isset($fields[$col])){
                                    $fields[$col] = $fields[$col] + $eval[$col];
                                }
                                else{
                                    $fields[$col] = $eval[$col];
                                }

                                $total = $total + $eval[$col];
                            }
                        }
                    }
                    catch(Exception $e){
                        //pass
                    }

                    $ave = $ave + $total;

                    $ctr++;
                }

                $ave =  $ave > 0 ? $ave / $ctr : 0;

                if($ave === 0){
                    continue;
                }

                $lineData = array($username, getNameByUsername($conn, $username), $ctr, number_format($ave, 2));

                array_walk($lineData, 'filterData');

                $excelData .= implode("\t", array_values($lineData)) . "\n";
            }

            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            echo $excelData;

            exit();
        }
        else if($_GET["type"] === "summaryDetailed_Peer" || $_GET["type"] === "summaryDetailed_Student"){

            $filter = $_GET["type"] === "summaryDetailed_Student" ? "Student" : "";

            $filename = "summary-detailed-". $filter . "-" . date('Y-m-d') . ".xls";
            
            $heads = array("username", "Name");
            $columns = getColumns($conn);
            foreach($columns as $column){
                $col = $column['Field'];
                if($col !== "id" && $col !== "evaluator" && $col !== "evaluatee" && $col !== "positive_comment" && $col !== "negative_comment")
                    array_push($heads, $col);
            }
            array_push($heads, "Rating");

            $excelData = implode("\t", array_values($heads)) . "\n";

            $allEmployeeUsernames = getAllEmployeesUsername($conn);
            while($usernames = mysqli_fetch_assoc($allEmployeeUsernames)){
                $evaluations = getEvaluationsByUsername($conn, $usernames["username"]);
                $username = $usernames["username"];

                $fields = [];
                $ave = 0;
                $ctr = 0;
                while($eval = mysqli_fetch_assoc($evaluations)){

                    $role = getRoleByUsername($conn, $eval["evaluator"]);

                    if($filter === "Student"){
                        if($role !== "Student"){
                            continue;
                        }
                    }
                    else{
                        if($role !== "Teaching" && $role !== "Non-Teaching"){
                            continue;
                        }
                    }


                    $columns = getColumns($conn);

                    $total = 0;

                    try{
                        while($column = mysqli_fetch_assoc($columns)){
                            $col = "" . $column['Field'];
                            
                            if($col !== "id" && $col !== "evaluator" && $col !== "evaluatee" && $col !== "positive_comment" && $col !== "negative_comment"){
                                
                                if(isset($fields[$col])){
                                    $fields[$col] = $fields[$col] + $eval[$col];
                                }
                                else{
                                    $fields[$col] = $eval[$col];
                                }

                                $total = $total + $eval[$col];
                            }
                        }
                    }
                    catch(Exception $e){
                        //pass
                    }

                    $ave = $ave + $total;

                    $ctr++;
                }

                $ave =  $ave > 0 ? $ave / $ctr : 0;

                if($ave === 0){
                    continue;
                }

                $lineData = array($username, getNameByUsername($conn, $username));

                foreach($fields as $field => $val){
                    array_push($lineData, number_format($val / $ctr, 2));
                    echo $val;
                }

                array_push($lineData, number_format($ave, 2));

                array_walk($lineData, 'filterData');

                $excelData .= implode("\t", array_values($lineData)) . "\n";
                
            }

            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            echo $excelData;

            exit();
        }
        else if($_GET["type"] === "commentPerUser_Peer" || $_GET["type"] === "commentPerUser_Student"){

            if(isset($_GET["username"])){
                $username = $_GET["username"];

                $filter = $_GET["type"] === "commentPerUser_Student" ? "Student" : "";

                $filename = "comments-individual-". $filter . "-" . date('Y-m-d') . ".xls";
                $fields = array("Fer Employee", "Positive Comments", "Negative Comments");
                $excelData = implode("\t", array_values($fields)) . "\n";

                //error_reporting(0);
                $evaluations = getEvaluationsByUsername($conn, $username);

                while($eval = mysqli_fetch_assoc($evaluations)){

                    if($eval["evaluatee"] !== $username){
                        continue;
                    }

                    $role = getRoleByUsername($conn, $eval["evaluator"]);

                    if($filter === "Student"){
                        if($role !== "Student"){
                            continue;
                        }
                    }
                    else{
                        if($role !== "Teaching" && $role !== "Non-Teaching"){
                            continue;
                        }
                    }

                    $lineData = array(getNameByUsername($conn, $username), $eval["positive_comment"], $eval["negative_comment"]);

                    array_walk($lineData, 'filterData');

                    $excelData .= implode("\t", array_values($lineData)) . "\n";
                }

                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                echo $excelData;
            }
            else{
                $filter = $_GET["type"] === "commentPerUser_Student" ? "Student" : "";

                $filename = "comments-individual-". $filter . "-" . date('Y-m-d') . ".xls";
                $fields = array("For Employee", "Positive Comments", "Negative Comments");
                $excelData = implode("\t", array_values($fields)) . "\n";

                //error_reporting(0);

                $allEmployeeUsernames = getAllEmployeesUsername($conn);

                while($usernames = mysqli_fetch_assoc($allEmployeeUsernames)){

                    $username = $usernames["username"];
                    
                    $evaluations = getEvaluationsByUsername($conn, $username);

                    while($eval = mysqli_fetch_assoc($evaluations)){

                        $role = getRoleByUsername($conn, $eval["evaluator"]);

                        if($filter === "Student"){
                            if($role !== "Student"){
                                continue;
                            }
                        }
                        else{
                            if($role !== "Teaching" && $role !== "Non-Teaching"){
                                continue;
                            }
                        }

                        $lineData = array(getNameByUsername($conn, $username), $eval["positive_comment"], $eval["negative_comment"]);

                        array_walk($lineData, 'filterData');

                        $excelData .= implode("\t", array_values($lineData)) . "\n";
                    }
                }

                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=\"$filename\"");
                echo $excelData;
            }
            
        }

    }
    else{
        header("location: ../master_viewReports.php?type=summaryAll&error=invalidtype");
    }

    
    
?>

