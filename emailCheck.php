<?php
    $email_check = "/^[a-zA-Z0-9]+[a-zA-Z0-9\W_]*[a-zA-Z0-9]+@[a-zA-Z]+\.[A-z]+[\.A-z]*[a-zA-Z]+$/";
    
    if(preg_match($email_check, $_POST["email"]) == 0){    
        echo "Enter a valid email!";
    }
    else{
        echo "";
    }
?>
