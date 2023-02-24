<?php

    include_once "dbh.inc.php";

    function checkLoginStatus(){
        if (isset($_SESSION["id"]) !== true){
            header("location: ../index.php?error=unauth");
        }
    }

    function checkAuthorization($role){
        if (isset($_SESSION["role"]) === true){

            if ($_SESSION["role"] !== $role){
                header("location: unauthorized.php");
                exit();
            }
            
        }
        else{
            header("location: functions/logout.php");
        }
    }

    function attemptLogin($conn, $username, $password){
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=userdoesnotexist");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row === false){
            header("location: ../index.php?error=loginfailed");
            exit();
        }

        if(empty($row["username"])){
            header("location: ../index.php?error=noaccount");
        }
        else{
            $isMatch = password_verify($password, $row["password"]);

            if($isMatch === true){
                session_start();
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["fname"] = $row["fname"];
                $_SESSION["lname"] = $row["lname"];
                $_SESSION["section"] = $row["section"];
                $_SESSION["role"] = $row["role"];

                header("location: ../index.php");

            }
            else{
                header("location: ../index.php?error=incorrectpassword");
                exit();
            }
        }

        mysqli_stmt_close($stmt);
    }

    function userExist($conn, $username){
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row === false){
            header("location: ../register.php?error=internal");
            exit();
        }

        if(empty($row["username"])){
            mysqli_stmt_close($stmt);
            return false;
        }
        else{
            mysqli_stmt_close($stmt);
            return true;
        }
    }

    function registerUser($conn, $username, $fname, $lname, $section, $password, $role){

        $exist = userExist($conn, $username);

        $routeBack = "/";

        if($role === "Student"){
            $routeBack = "location: ../register.php?error=taken";
        }
        else if($role === "Teaching" || $role === "Non-Teaching"){
            $routeBack = "location: ../registerFaculty.php?error=taken";
        }

        if ($exist){
            header($routeBack);
            exit();
        }

        $stmt = mysqli_stmt_init($conn);

        $sql = "INSERT INTO users (id, username, fname, lname, section, password, created, role) VALUES (NULL,?,?,?,?,?,?,?)";

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header($routeBack);
            exit();
        }

        if ($role === "Teaching" || $role === "Non-Teaching"){
            $password = $username . strtoupper($fname[0]) . strtoupper($lname[0]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $date = date("M d, Y h:i a");

        mysqli_stmt_bind_param($stmt, "sssssss", $username, $fname, $lname, $section, $hashedPassword, $date, $role);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        if($role === "Teaching" || $role === "Non-Teaching"){

            if(isset($_POST["sections"])){

                foreach ($_POST["sections"] as $evaluator){
                    $stmt = mysqli_stmt_init($conn);
                    $sql = "INSERT INTO evaluatee (id, evaluatee_username, evaluatee_fname, evaluatee_lname, evaluator) VALUES (NULL,?,?,?,?)";
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "ssss", $username, $fname, $lname, $evaluator);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_close($stmt);
                }

            }

            header("location: ../registerFaculty.php?error=success");
        }
        else {
            header("location: ../index.php?error=created");
        }

        exit();

    }

    function getSectionsForDropDown($conn){
        $sql = "SELECT * FROM sections";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){
            $section = $row["section"];
            echo "<option value='" . $section . "'>" . $section . "</option>";
        }

        mysqli_stmt_close($stmt);
    }

    function getSectionsForChecklist($conn){
        $sql = "SELECT * FROM sections";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){
            $section = $row["section"];
            echo "<input type='checkbox' class='form-check-input' name=\"sections[]\" value='$section' /> $section<br>";
        }

        mysqli_stmt_close($stmt);
    }

    function getRoles($conn, $exclude){
        $sql = "SELECT * FROM roles";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../registerFaculty.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){

            $toExclude = false;

            $role = $row["role"];
            
            foreach($exclude as $ex){
                if($role === $ex){
                    $toExclude = true;
                }
            }

            if($toExclude === false){
                echo "<option value='" . $role . "'>" . $role . "</option>";
            }
        
        }

        mysqli_stmt_close($stmt);
    }

    function getUsersToEvaluate($conn, $username, $section, $role){

        $sql = "SELECT username, fname, lname, role FROM users WHERE role='Teaching' or role='Non-Teching'";
        $stmt = mysqli_stmt_init($conn);

        if($role === "Student"){
            //$sql = "SELECT * FROM evaluatee WHERE evaluator=?";
            $sql = "SELECT * FROM evaluatees
            WHERE evaluatee_username NOT IN (SELECT evaluatee FROM evaluations)
            AND evaluator NOT IN (SELECT evaluator FROM evaluations)
            AND evaluator=?";
            $stmt = mysqli_stmt_init($conn);
        }

        if(!mysqli_stmt_prepare($stmt, $sql)){
            //header("location: ../index.php?error=internal");
            
            exit();
        }

        if($role === "Student"){
            mysqli_stmt_bind_param($stmt, "s",$section);
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){

            if($role === "Student"){
                echo "<option value='" . $row["evaluatee_username"] . "'>" . $row["evaluatee_fname"] . " " . $row["evaluatee_lname"] . "</option>";
            }
            else{
                echo "<option value='" . $row["username"] . "'>" . $row["fname"] . " " . $row["lname"] . "</option>";
            }
        
        }

        mysqli_stmt_close($stmt);

    }

    function resetPassword($conn, $username, $currentPassword, $newPassword){
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../resetPassword.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row === false){
            header("location: ../resetPassword.php?error=loginfailed");
            exit();
        }

        if(empty($row["username"])){
            header("location: ../resetPassword.php?error=noaccount");
        }
        else{

            $isMatch = false;

            if(empty($row["password"])){
                $isMatch = true;
            }
            else{
                $isMatch = password_verify($currentPassword, $row["password"]);
            }

            if($isMatch === true){
                $stmt = mysqli_stmt_init($conn);

                $sql = "UPDATE users SET password=? WHERE username=?";

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: ../resetPassword.php?error=internal");
                    exit();
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);
                mysqli_stmt_execute($stmt);

                mysqli_stmt_close($stmt);

                header("location: ../resetPassword.php?error=success");
                exit();
            }
            else{
                header("location: ../resetPassword.php?error=incorrectpassword");
                exit();
            }
        }

        mysqli_stmt_close($stmt);
    }


?>