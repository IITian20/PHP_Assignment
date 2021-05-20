<?php 
session_start();
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);
    $_SESSION["Login"] = 0;
    header("location: login.php");
    if(isset($_COOKIE["Name1"])){
        setcookie("Name1", "", time()-3600);
    }
    if(isset($_COOKIE["Username1"])){
        setcookie("Username1", "", time()-3600);
    }
    if(isset($_COOKIE["Date1"])){
        setcookie("Date1", "", time()-3600);
    }
    if(isset($_COOKIE["pass1"])){
        setcookie("pass1", "", time()-3600);
    }
    if(isset($_COOKIE["cpass1"])){
        setcookie("cpass1", "", time()-3600);
    }

?>
