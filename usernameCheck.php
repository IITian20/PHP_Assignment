<?php
require_once "config.php";

    $username_check = "/^[A-z._0-9]+$/";
    $username = $_POST["username"];
    $sql = "SELECT * FROM divyansh_user WHERE username=?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($result);
        if($num==1){
            echo "Username already exits!!";
        }    
        if(preg_match($username_check, $_POST["username"]) == 0){
                
            echo "Enter a valid username! Only letters, numbers, . , _ are allowed.";
        }
        else{
            if(strlen($_POST["username"]) < 3){
                echo "Enter a valid username! Username should have minimum 3 chracters.";
            }
            else{
                echo "";
            }
        }
    }
?>
