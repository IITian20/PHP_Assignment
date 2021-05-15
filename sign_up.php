<?php

require_once "config.php";
    $username = $name = $password = "";
    $username_err = $name_err = $password_err1 = $password_err2 = $password_err3 = $password_err4 = $confirm_password_err = "";
    $value = "none";
    $value1 = "inline";

    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $name_check = "/^[A-Za-z]+[A-Za-z \.'\,\-]*[A-Za-z\.]+$/";
        $username_check = "/^[A-z._0-9]+$/";
        $smallLetter = "/[a-z]/";
        $capitalLetter = "/[A-Z]/";
        $numberPassword = "/[0-9]/";
        $specialCharacter = "/[\W_]/";
        $x = 0;
        if(preg_match($name_check, $_POST["name"]) == 0){
            $name_err = "Enter a valid name! Only letters and whitespace are allowed.";
        }
        else{
            if(strlen($_POST["name"]) < 3){
                $name_err = "Enter a valid name! Name should have minimum 3 chracters.";
            }
            else{
                $name = $_POST["name"];
                $name_err = "";
            }
        }
        if(preg_match($username_check, $_POST["username"]) == 0){
            $username_err = "Enter a valid username! Only letters, numbers, . , _ , are allowed.";
        }
        else{
            if(strlen($_POST["name"]) < 3){
                $username_err = "Enter a valid username! Usernnme should have minimum 3 chracters.";
            }
            else{
                $username_err = $_POST["username"];
                $username_err = "";
            }
        }
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
        if($x < 5){
            $password_err1 ="Enter password of:";
            $password_err2 = "atleat 6 characters long,";
            $password_err3 = "having both lowercase and uppercase";
            $password_err4 = "having atleast 1 number and 1 special characters.";
        }
        else{
            $password = $_POST["password"];
            $password_err1 = "";
        }
        if($_POST["cpassword"] != $password){
            $confirm_password_err = "Passsword do not match!";
        }
        else{
            $confirm_password = $_POST["cpassword"];
            $confirm_password_err = "";
        }
        
        
        // storing in database
        if(empty($name_err) && empty($username_err) && empty($password_err1) && empty($confirm_password_err)){
            $sql = "SELECT * FROM divyansh_user WHERE username='$username'";

            $result = mysqli_query($conn, $sql);

            $num = mysqli_num_rows($result);
            if($num==1){
                $username_err = "Username already exits!!";
            }
            else{
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO divyansh_user (name, username, password) VALUES ('$name', '$username', '$hash')";
                if(mysqli_query($conn, $sql)){
                    header('location: login.php');
                }
            }
        } 
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap'); 
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap');

        body{
            font-family: 'Lato', sans-serif;
            margin: 0px;
            padding-bottom: 50px;
        }
        p{
            border: 2px solid red;
            background-color: rgb(254, 241, 211);
            padding: 10px;
            color: red;
            font-weight: 700;
            font-family: 'Verdana, Geneva, Tahoma, sans-serif';
            font-size: 20px;
        }
        #name_err{
            display: <?php if(empty($name_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        #username_err{
            display: <?php if(empty($username_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        .err{
            display: <?php if(empty($password_err1)){ echo $value; } else { echo "block";}  ?>;
        }
        #pass_err{
            display: <?php if(empty($password_err1)){ echo $value; } else { echo $value1;}  ?>;
        }
        #c_pass_err{
            display: <?php if(empty($confirm_password_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        .h1{
            text-align: center;
            font-size: 50px;
            font-family: 'Playfair Display';
            margin-top: 0px;
            padding-top: 20px;
        }
        a{
            font-size: 20px;
            color:grey;
            
        }
        a:hover{
            color: rgb(90, 112, 134);
        }
        .heading{
            border-bottom: 2px solid #032957;
            padding-left: 20px;
            padding-right: 25px;
        }
        label{
            font-size: 40px;
            font-weight: 700;
            color: #032957;
        }
        .form{
            display: flex;
            justify-content: center;
            padding-left: 30px;
        }
        input{
            font-size: 35px;
        }
        .button{
            padding: 10px;
            margin-bottom: 30px;
            font-family: 'Playfair Display';
            background-color: rgb(235,235,235);
            font-size: 30px;
            font-weight: 500;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
            border: 1px solid black;
        }
        .button:hover{
            background-color:  #b5cff0;
        }
        .button1{
            display: flex;
            justify-content: center;
            align-self:baseline;
        }
        .sign_up_box{
            background-color: rgb(235,235,235);
            border: 2px solid black;
            padding: 50px;
        }
    </style>
</head>
<body>
    <h1 class="h1"><span class="heading">Sign Up</span></h1><br><br>
    <div class="form">
        <form autocomplete="off" action="" method="POST">
            <div class="sign_up_box">
                    <label class="label" for="name">
                        Name:
                    </label><br><br>
                    <input  type="text" id="name" name="name" maxlength="30" size="15" placeholder="Name"><br><br>
                    <p id="name_err"><?php if(!empty($name_err)){ echo $name_err; } ?></p>
                    <br><br>
                    <label class="label" for="username">
                        Username:
                    </label><br><br>
                    <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username">
                    <br><br>
                    <p id="username_err"><?php if(!empty($username_err)){ echo $username_err; } ?></p>
                    <br><br>
                    <label class="label" for="password">
                        Password:
                    </label><br><br>
                    <input  type="password" id="password" name="password" size="15" value="" placeholder="Password">
                    <br><br>
                    <div class="err">
                    <p id="pass_err"><?php if(!empty($password_err1)){ echo $password_err1; } ?></p><br><br><br>
                    <p id="pass_err"><?php if(!empty($password_err2)){ echo $password_err2; } ?></p><br><br><br>
                    <p id="pass_err"><?php if(!empty($password_err3)){ echo $password_err3; } ?></p><br><br><br>
                    <p id="pass_err"><?php if(!empty($password_err4)){ echo $password_err4; } ?></p>
                    </div>
                    <br><br>
                    <label class="label" for="cpassword">
                        Confirm Password:
                    </label><br><br>
                    <input  type="password" id="cpassword" name="cpassword" size="15" value="" placeholder="Confirm Password">
                    <br><br>
                    <p id="c_pass_err"><?php if(!empty($confirm_password_err)){ echo $confirm_password_err; } ?></p>
            </div>
            
            <br><br>
            <div class="button1">
                <input name="submit" type="submit" value="Sign Up" class="button">
            </div>
            <br><div class="button1">
                <a href="login.php">Already have an account. Sign In here.</a>
            </div>
        </form>
    </div>
</body>
</html>

