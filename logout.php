<?php 
session_start();
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);

    header("location: login.php");


?>
