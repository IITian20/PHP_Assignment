<?php 
session_start();
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);

    setcookie("Username","", time() - 3600);
    setcookie("Password","", time() - 3600);
    header("location: login.php");


?>
