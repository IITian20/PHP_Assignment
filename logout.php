<?php 
session_start();
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);
    $_SEESION["Login"] = 0;
    header("location: login.php");


?>
