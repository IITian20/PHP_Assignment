<?php
    $name_check = "/^[A-Za-z]+[A-Za-z \.'\,\-]*[A-Za-z\.]+$/";
    
    if(preg_match($name_check, $_POST["name"]) == 0){
            
        echo "Enter a valid name! Only letters and whitespace are allowed.";
    }
    else{
        if(strlen($_POST["name"]) < 3){
            echo "Enter a valid name! Name should have minimum 3 chracters.";
        }
        else{
            echo "";
        }
    }
?>
