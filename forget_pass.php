<?php
session_start();
require_once "config.php";
    $username = $date = "";
    $username_err = $date_err = "";
    $value = "none";
    $value1 = "inline";
    $_SESSION["Login"] = 0;
    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $username_check = "/^[A-z._0-9]+$/";
        $date = $_POST["date"];
        if(preg_match($username_check, $_POST["username"]) == 0){
            $username_err = "Enter a valid username! Only letters, numbers, . , _ , are allowed.";
        }
        else{
            if(strlen($_POST["username"]) < 3){
                $username_err = "Enter a valid username! Usernnme should have minimum 3 chracters.";
            }
            else{
                $username = $_POST["username"];
                $username_err = "";
            }
        }
        if(empty($date)){
            $date_err = "Date cannot be empty!";
        }
        // storing in database
        if(empty($username_err) && empty($date_err)){
            $sql = "SELECT * FROM divyansh_user WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num == 1){
                $row = mysqli_fetch_assoc($result);
                if($date == $row["dob"]){
                    $_SESSION["FUsername"] = $username;
                    header("location: forget_pass_2.php");
                }
                else{
                    $date_err = "Incorrect date of birth!";
                }
                
            }
            else{
                $username_err = "Username does not exits!!";
                
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
        #username_err{
            display: <?php if(empty($username_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        #date_err{
            display: <?php if(empty($date_err)){ echo $value; } else { echo $value1;}  ?>;
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
        <form action="" method="POST">
            <div class="login_box">
                    <label class="label" for="username">
                        Username:
                    </label><br>
                    <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username" value="<?php if(empty($username_err)){echo isset($username) ? $username : '';}else{echo "";}?>">
                    <br>
                    <p id="username_err"><?php if(!empty($username_err)){ echo $username_err; } ?></p>
                    <label class="label" for="date">
                        Date of birth:
                    </label><br>
                    <input  type="date" id="date" name="date" maxlength="10" size="15" value="<?php if(empty($date_err)){echo isset($date) ? $date : '';}else{ echo "";} ?>">
                    <br>
                    <p id="date_err"><?php if(!empty($date_err)){ echo $date_err; } ?></p>
            </div>
            <div class="button1">
                <input name="submit" type="submit" value="Submit" class="button" style="margin-top:10px">
            </div>
            <div class="button1">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>

