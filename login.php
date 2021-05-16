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

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $sql = "SELECT * FROM divyansh_user WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
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
                $sql1 = "SELECT * FROM divyansh_user_data WHERE username='$username'";
                $result1 = mysqli_query($conn, $sql1);
                $num = mysqli_num_rows($result1);
                if($num == 1){
                    header("location:main.php");
                }else{
                    header('location: profile.php');
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
        a{
            padding: 20px;
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
        .login_box{
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: rgb(235,235,235);
            border: 2px solid black;
            padding: 50px;
        }
        .extra{
            display: flex;
            justify-content: space-evenly;
        }
    </style>
</head>
<body>
    <h1 class="h1"><span class="heading">Login</span></h1><br><br>
    <div class="form">
        <form action="" method="POST">
            <div class="login_box">
                <label class="label" for="username">
                    Username:
                </label><br><br>
                <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username" value="<?php if(isset($_COOKIE["Username"])){ echo $_COOKIE["Username"];} ?>">
                <br><br>
                <br><br>
                <label class="label" for="password">
                    Password:
                </label><br><br>
                <input  type="password" id="password" name="password" size="15" value="" placeholder="Password">
                <br><br><br>
                <div class="extra">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label class="label label2" for="remember">
                            Remember Username
                        </label>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="forget_pass.php">Forgot Password?</a>
                </div>
            </div>
            <br><br>
            <div class="button1"> 
                <p class = "err"><?php if(!empty($message)){ echo "$message";}?></p>
            </div>
            <br>
            <div class="button1">
                <input name="submit" type="submit" value="Log In" class="button">
            </div>
            <div class="button1">
                <a href="sign_up.php">Don't have an account? Sign Up here.</a>
            </div>
        </form>
    </div>
</body>
</html>

