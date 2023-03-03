<?php

    include_once "dbh.inc.php";

    function checkLoginStatus(){
        if (isset($_SESSION["id"]) !== true){
            header("location: ../index.php?error=unauth");
        }
    }

    function checkAuthorization($role){
        if (isset($_SESSION["role"]) === true){

            $authorized = false;

            foreach($role as $r){
                if($r === $_SESSION["role"]){
                    $authorized= true;
                }
            }

            if ($authorized === false){
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
            $routeBack = "location: ../master_registerEmployee.php?error=taken";
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
                    $sql = "INSERT INTO evaluatees (id, evaluatee_username, evaluatee_fname, evaluatee_lname, evaluator) VALUES (NULL,?,?,?,?)";
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "ssss", $username, $fname, $lname, $evaluator);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_close($stmt);
                }

            }

            header("location: ../master_registerEmployee.php?error=success");
        }
        else {
            header("location: ../index.php?error=created");
        }

        exit();

    }

    function updateUserInfo($conn, $username, $fname, $lname, $sections, $role){
        $sql = "UPDATE users
                SET fname=?, lname=?, role=?
                WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $role, $username);
        mysqli_stmt_execute($stmt);

        deleteEvaluatee($conn, $username);

        foreach ($sections as $evaluator){
            $stmt = mysqli_stmt_init($conn);
            $sql = "INSERT INTO evaluatees (id, evaluatee_username, evaluatee_fname, evaluatee_lname, evaluator) VALUES (NULL,?,?,?,?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $username, $fname, $lname, $evaluator);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);
        }

        header("location: ../master_manageEmployees.php?usernameSearchBox=" . $username . "&error=saved");

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

    function getSectionsForChecklist($conn, $sections){
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

            $found = false;
            foreach($sections as $s){
                if($s === $section){
                    $found = true;
                }
            }

            if($found === true){
                echo "<input type='checkbox' checked='checked' class='form-check-input' name=\"sections[]\" value='$section' /> $section<br>";
            }
            else{
                echo "<input type='checkbox' class='form-check-input' name=\"sections[]\" value='$section' /> $section<br>";
            }
            
        }

        mysqli_stmt_close($stmt);
    }

    function getRoles($conn, $exclude, $curRole){
        $sql = "SELECT * FROM roles";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../master_registerEmployee.php?error=internal");
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
                if($curRole === $role){
                    echo "<option value='" . $role . "' selected='selected'>" . $role . "</option>";
                }
                else{
                    echo "<option value='" . $role . "'>" . $role . "</option>";
                }
                
            }
        
        }

        mysqli_stmt_close($stmt);
    }

    function getUsersToEvaluate($conn, $username, $section, $role){

        $sql = "SELECT username, fname, lname, role FROM users WHERE role='Teaching' or role='Non-Teaching'";
        $stmt = mysqli_stmt_init($conn);

        if($role === "Student"){
            $sql = "SELECT * FROM evaluatees WHERE evaluator=?";
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
                if(isEvaluated($conn, $username, $row["evaluatee_username"]) !== true)
                    echo "<option value='" . $row["evaluatee_username"] . "'>" . $row["evaluatee_fname"] . " " . $row["evaluatee_lname"] . "</option>";
            }
            else if (isEvaluated($conn, $username, $row["username"]) !== true && $username !== $row["username"]){
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


    // for evaluationForm.php

    function getFactors($conn){
        $sql = "SELECT * FROM factors";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){
            
            echo '<br>
            <div class="row">

                <div class="col-sm-10">
                    <h6 class="">
                        <b>' . $row["factor"] . '</b>
                    </h6>
                    <p class="">' . $row["description"] . '</p>
                </div>

                <div class="col-sm-2">

                    <div class="form-group">
                        <select class="form-control" id="rating" name="rating_' . $row["id"] . '" required>';

            echo "<option value=''>--</option>";

            for($i = $row["max_rate"]; $i>0; $i--){
                echo "<option value='" . $i . "'>" . $i . "</option>";
            }

            echo "</select></div></div></div>";
        
        }

        mysqli_stmt_close($stmt);
    }

    function isEvaluated($conn, $evaluator_username, $evaluatee_username){
        $sql = "SELECT COUNT(*) AS total FROM evaluations WHERE evaluator=? AND evaluatee=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"ss",$evaluator_username, $evaluatee_username);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($resultData);

        if($row["total"] > 0){
            return true;
        }

        mysqli_stmt_close($stmt);

        return false;
    }

    function getEvaluateeName($conn, $username){
        $sql = "SELECT username, fname, lname FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"s",$username);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($resultData)){
            if($row["username"] == $username){
                $fname = $row["fname"];
                $lname = $row["lname"];

                echo "<h4 class='text-left'>" . $lname . ", " . $fname . "</h4>";
                echo "<input type='text' class='text-left' name='username' value='" . $username . "' style='display:none;'>";
            }
        }

        mysqli_stmt_close($stmt);
    }

    function postEval($conn, $evaluator_username, $evaluatee_username, $responses){
        $sql = "INSERT INTO evaluations (id, evaluator, evaluatee, f1, f2, f3, f4, f5, f6, f7, f8, f9, c1, c2)
                VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"ssiiiiiiiiiss",$evaluator_username, $evaluatee_username,
                                $responses["1"],$responses["2"],$responses["3"],
                                $responses["4"],$responses["5"],$responses["6"],$responses["7"],
                                $responses["8"],$responses["9"],$responses["c1"],$responses["c2"]);

        mysqli_stmt_execute($stmt);

        header("location: ../unauthorized.php?username=" . $evaluatee_username);

    }

    // FOR MASTER USE ONLY

    function getEmployeesAsChecklist($conn){
        $sql = "SELECT * FROM users WHERE role='Teaching' OR role='Non-Teaching'";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($resultData)){
            $username = $row["username"];
            $name = $row["fname"] . " " . $row["lname"];
            echo "<input type='checkbox' class='form-check-input' name=\"employees[]\" value='$username' /> $name<br>";
        }

        mysqli_stmt_close($stmt);
    }

    function deleteEmployee($conn, $username){
        $sql = "DELETE FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"i",$username);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        deleteEvaluatee($conn, $username);
    }

    function deleteEvaluatee($conn, $username){
        $sql = "DELETE FROM evaluatees WHERE evaluatee_username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"i",$username);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }

    function deleteSection($conn, $section){
        $sql = "DELETE FROM sections WHERE section=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"s",$section);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        deleteSectionFromEvaluatees($conn, $section);
    }

    function deleteSectionFromEvaluatees($conn, $section){
        $sql = "DELETE FROM evaluatees WHERE evaluator=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"s",$section);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }

    function createNewSection($conn, $section){
        try{
            $sql = "INSERT INTO sections (id,section) VALUES (NULL, ?)";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../register.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"s",$section);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        }
        catch(Exception $e){
            //pass
        }
        
    }

    function resetPasswordToDefault($conn, $username, $initials){
        $sql = "UPDATE users SET password=? WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../master_manageEmployees.php?usernameSearchBox=" . $username . "&error=internal");
            exit();
        }

        $newPassword = $username . strtoupper($initials);

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        header("location: ../master_manageEmployees.php?usernameSearchBox=" . $username . "&error=reset");
    }

    function getEmployeeInfo($conn, $username){
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../resetPassword.php?error=internal");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($resultData);
        
    }

    function getEvaluatorsAsArray($conn, $username){
        $sql = "SELECT * FROM evaluatees WHERE evaluatee_username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $evaluators = array();

        while($row = mysqli_fetch_assoc($resultData)){
            if($row["evaluator"]){
                array_push($evaluators, $row["evaluator"]);
            }
        }

        return $evaluators;
    }


?>