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
        $filename = "summary-all-". date('Y-m-d') . ".xls";
        $fields = array("Username", "Name", "Rating");
        $excelData = implode("\t", array_values($fields)) . "\n";

        $allEmployeeUsernames = getAllEmployeesUsername($conn);
        while($usernames = mysqli_fetch_assoc($allEmployeeUsernames)){
            $evaluations = getEvaluationsByUsername($conn, $usernames["username"]);
            $username = $usernames["username"];

            $fields = [];
            $ave = 0;
            $ctr = 0;
            while($eval = mysqli_fetch_assoc($evaluations)){

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
                break;
            }

            $lineData = array($username, getNameByUsername($conn, $username), number_format($ave, 2));

            array_walk($lineData, 'filterData');

            $excelData .= implode("\t", array_values($lineData)) . "\n";
        }

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo $excelData;

        exit();
    }
    else{
        header("location: ../master_viewReports.php?type=summaryAll&error=invalidtype");
    }

    
    
?>