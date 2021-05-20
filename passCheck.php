<?php

    $x = 0;
    $smallLetter = "/[a-z]/";
    $capitalLetter = "/[A-Z]/";
    $numberPassword = "/[0-9]/";
    $specialCharacter = "/[\W_]/";

    if(preg_match($smallLetter, $_POST["password"])==1){
        $x = $x + 1;
    }
    if(preg_match($capitalLetter, $_POST["password"])==1){
        $x = $x + 1;
    }
    if(preg_match($numberPassword, $_POST["password"])==1){
        $x = $x + 1;
    }
    if(preg_match($specialCharacter, $_POST["password"])==1){
        $x = $x + 1;
    }
    if(strlen($_POST["password"])>=6){
        $x = $x + 1;
    }
    if($x < 5){ ?>
        <p id="pass_err">Enter password of:</p><br><br>
        <p id="pass_err">atleat 6 characters long,</p><br><br>
        <p id="pass_err">having both lowercase and uppercase</p><br><br>
        <p id="pass_err">having atleast 1 number and 1 special characters.</p><br><br>
<?php
    }
    else{
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        setcookie("pass1", $hash);
        echo "";
    }
?>
