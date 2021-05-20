<?php
require_once "config.php";

    if(!isset($_COOKIE["pass1"])){
        echo "Password not entered";
    }else{
        $pass = $_COOKIE["pass1"];
        $cpass = $_POST["cpassword"];    
        if(password_verify($cpass, $pass)){
            echo "";
            $hash = password_hash($cpass, PASSWORD_DEFAULT);
            setcookie("cpass1", $hash);
        }
        else{
            echo "Password do not match";
        }
    }
    
?>
