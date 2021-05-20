<?php
session_start();
require_once "config.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = $_POST["remember"];
    $message = "";
    $value = "none";
    $value1 = "inline";
    $_SESSION["Login"] = 0;
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);
    if(isset($_COOKIE["Id"])){
        setcookie("Id", "-1", time()-3600);
    }
    if(isset($_COOKIE["Name1"])){
        setcookie("Name1", "", time()-3600);
    }
    if(isset($_COOKIE["Username1"])){
        setcookie("Username1", "", time()-3600);
    }
    if(isset($_COOKIE["Date1"])){
        setcookie("Date1", "", time()-3600);
    }
    if(isset($_COOKIE["pass1"])){
        setcookie("pass1", "", time()-3600);
    }
    if(isset($_COOKIE["cpass1"])){
        setcookie("cpass1", "", time()-3600);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $sql = "SELECT * FROM divyansh_user WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $num = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            $password_in_db = $row["password"];
            if($num == 1){
                if(password_verify($password, $password_in_db)){
                    $_SESSION["Username"] = $row["username"];
                    $_SESSION["Name"] = $row["name"];
                    if($remember == "on"){
                        setcookie("Username",$row["username"]);
                        setcookie("Password",$row["password"]);
                    }
                    else{
                        if(isset($_COOKIE["Username"])){
                            setcookie("Username","", time() - 3600);
                            setcookie("Password","", time() - 3600);
                        }
                    }
                    $_SESSION["Login"] = 1;
                    $sql1 = "SELECT * FROM divyansh_user_data WHERE username=?";
                    $stmt1 = mysqli_stmt_init($conn);
                    if(mysqli_stmt_prepare($stmt1, $sql1)){
                        mysqli_stmt_bind_param($stmt1, 's', $username);
                        mysqli_stmt_execute($stmt1);
                        $result1 = mysqli_stmt_get_result($stmt1);
                        $num1 = mysqli_num_rows($result1);
                        if($num1 == 1){
                            header("location:main.php");
                        }else{
                            $_SESSION["Profile"] = 0;
                            header('location: profile.php');
                        }
                    }
                }
                else{
                    $message = "Invalid Credentials!! Try Again or Create an account if you don't have.";
                }
            }
            else{
                $message = "Invalid Credentials!! Try Again or Create an account if you don't have.";
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
        a{
            padding: 10px;
            font-size: 20px;
            color:grey;
        }
        a:hover{
            color: rgb(90, 112, 134);
        }
        .err{
            display: <?php if(empty($message)){echo $value;} else{echo $value1;} ?>;
        }
        .h1{
            text-align: center;
            font-size: 50px;
            font-family: 'Playfair Display';
            margin-top: 0px;
            padding-top: 20px;
            margin-bottom: 10px;
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
        .label2{
            font-size: 20px;
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
        .extra{
            display: flex;
            justify-content: left;
        }
        .extra1{
            display: flex;
            flex-direction: row-reverse;
            justify-content: right;
        }
    </style>
</head>
<body>
    <h1 class="h1"><span class="heading">Login to ChatterBox</span></h1><br>
    <div class="form">
        <form action="" method="POST" autocomplete="off">
            <div class="login_box">
                <label class="label" for="username">
                    Username:
                </label><br>
                <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username" value="<?php if(isset($_COOKIE["Username"])){ echo $_COOKIE["Username"];} ?>">
                <br>
                <div class="extra">
                    <div>
                        <input type="checkbox" id="remember" name="remember" checked>
                        <label class="label label2" for="remember">
                            &nbsp;&nbsp;&nbsp;Remember Username
                        </label>
                    </div>
                </div>
                <br>
                <label class="label" for="password">
                    Password:
                </label><br>
                <input  type="password" id="password" name="password" size="15" value="" placeholder="Password">
                <br>
                <div class="extra1">
                    <a href="forget_pass.php">Forgot Password?</a>
                </div>
            </div>
            <br>
    </div>
 
            <div class="button1"> 
                <p class = "err"><?php if(!empty($message)){ echo "$message";}?></p>
            </div>
            <div class="button1">
                <input name="submit" type="submit" value="Log In" class="button">
            </div>
            <div class="button1">
                <a href="sign_up.php">Don't have an account? Sign Up here.</a>
            </div>
        </form>

</body>
</html>

