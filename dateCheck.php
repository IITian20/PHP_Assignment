<?php

    $today = date("Y-m-d");
    
    if(empty($_POST["date"])){
        echo "Date cannot be empty!";
    }
    elseif ($_POST["date"] >= $today) {
        echo "Enter valid Date of Birth";
    }
    else{
        echo "";
    }
?>
