<?php
    $phone_check = "/^(\+?91|\+?91[ -]|0)?[6|7|8|9][0-9]{9}$/";
    if(preg_match($phone_check, $_POST["number"]) == 0){ ?>
        <p id="phone_err">Enter valid mobile number, eg:</p><br><br><br>
        <p id="phone_err">8989239231, 08989239231</p>
   <?php }
    else{
        echo "";
    }
?>
