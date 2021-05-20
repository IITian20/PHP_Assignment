<?php
session_start();
require_once "config.php";
    if(!isset($_SESSION["FUsername"])){ header("location: forget_pass.php");}
    $username = $_SESSION["FUsername"];
    $password = "";
    $password_err1 = $password_err2 = $password_err3 = $password_err4 = $confirm_password_err  = "";
    $value = "none";
    $value1 = "inline";
    $_SESSION["Login"] = 0;
    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $smallLetter = "/[a-z]/";
        $capitalLetter = "/[A-Z]/";
        $numberPassword = "/[0-9]/";
        $specialCharacter = "/[\W_]/";
        $x = 0;
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
        if(empty($password_err1) && empty($confirm_password_err)){
            $sql = "SELECT * FROM divyansh_user WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt, $sql)){
                mysqli_stmt_bind_param($stmt, 's', $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $num = mysqli_num_rows($result);
                if($num == 1){
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($password, $row["password"])){
                        $password_err1 = "Use a different password!";
                        $password_err2 = "";
                    }
                    else{
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $sql1 = "UPDATE divyansh_user SET password=? WHERE username=?";
                        $stmt1 = mysqli_stmt_init($conn);
                        if(mysqli_stmt_prepare($stmt1, $sql1)){
                            mysqli_stmt_bind_param($stmt1, 'ss', $hash, $username);
                            mysqli_stmt_execute($stmt1);
                            unset($_SESSION["FUsername"]);
                            header('location: login.php');
                        }
                    }
                }
                else{
                    header("location: forget_pass.php");
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
    <title>Login</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap'); 
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap');

        body{
            font-family: 'Lato', sans-serif;
            margin: 0px;
            padding-bottom: 20px;
        }
        p{
            border: 2px solid red;
            background-color: rgb(254, 241, 211);
            padding: 10px;
            color: red;
            font-weight: 700;
            font-family: 'Verdana, Geneva, Tahoma, sans-serif';
            font-size: 20px;
            margin-top: 0px;
        }
        .err{
            display: <?php if(empty($password_err1)){ echo $value; } else { echo $value1;}  ?>;
            margin-top: 10px;
        }
        .err2{
            display: <?php if(empty($password_err2)){ echo $value; } else { echo $value1;}  ?>;
            margin-top: 10px;
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
            margin-bottom: 10px;
        }
        a{
            padding: 10px;
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
        }
        input{
            font-size: 35px;
        }
        .button{
            padding: 10px;
            margin-bottom:10px;
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
            padding-top: 10px;
            display: flex;
            justify-content: center;
            align-self:baseline;
        }
        .login_box{
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: rgb(235,235,235);
            border: 2px solid black;
            padding: 20px 30px;
        }
        .login_box1{
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: rgb(235,235,235);
            border: 2px solid black;
            padding: 20px 30px;
        }

    </style>
</head>
<body>
    <h1 class="h1"><span class="heading">Forget Password</span></h1><br>
    <div class="form">
        <form action="" method="POST" autocomplete="off">
            <div class="login_box1">
                    <label class="label" for="password">
                        New Password:
                    </label><br>
                    <input  type="password" id="password" name="password" size="15" value="" placeholder="Password">
                    <br>
                    <div class="err">
                    <p id="pass_err"><?php if(!empty($password_err1)){ echo $password_err1; } ?></p><br><br>
                        <div class="err2">
                        <p id="pass_err"><?php if(!empty($password_err2)){ echo $password_err2; } ?></p><br><br>
                        <p id="pass_err"><?php if(!empty($password_err3)){ echo $password_err3; } ?></p><br><br>
                        <p id="pass_err"><?php if(!empty($password_err4)){ echo $password_err4; } ?></p>
                        </div>
                    </div>
                    <br>
                    <label class="label" for="cpassword">
                        Confirm Password:
                    </label><br>
                    <input  type="password" id="cpassword" name="cpassword" size="15" value="" placeholder="Confirm Password">
                    <br>
                    <p id="c_pass_err"><?php if(!empty($confirm_password_err)){ echo $confirm_password_err; } ?></p>
            </div>
            <div class="button1">
                <input name="submit" type="submit" value="Change Password" class="button">
            </div>
            <div class="button1">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>

