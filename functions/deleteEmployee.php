<?php
    include_once "../includes/dbh.inc.php";
    include_once "../includes/functions.inc.php";

    session_start();
    checkAuthorization(array("Master"));

    $routeBack = "location: ../master_home.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(isset($_POST["employees"])){

            foreach($_POST["employees"] as $employee){

                if(getRoleByUsername($conn, $employee) === "Student"){
                    $routeBack = "location: ../master_manageStudents.php";
                }
                else{
                    $routeBack = "location: ../master_manageEmployees.php";
                }

                deleteEmployee($conn, $employee);
            }

            header($routeBack . "?error=deleted");
        }
        else{
            header($routeBack . "?error=noselect");
        }
    }
    else if (isset($_GET["username"])){

        $username = $_GET["username"];

        if(getRoleByUsername($conn, $username) === "Student"){
            $routeBack = "location: ../master_manageStudents.php";
        }
        else{
            $routeBack = "location: ../master_manageEmployees.php";
        }

        deleteEmployee($conn, $username);
        header($routeBack . "?error=deleted");
    }
    else{
        header($routeBack);
    }

?>