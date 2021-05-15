<?php
session_start();
require_once "config.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    $remember = $_POST["remember"];
    $message = "";
    $value = "none";
    $value1 = "inline";
    
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
                header('location: main.php');
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
            background-color: #f8d16c;
            font-family: 'Lato', sans-serif;
            margin: 0px;
        }
        p{
            border: 2px solid red;
            margin-left: 33%;
            background-color: rgb(254, 241, 211);
            padding: 10px;
            color: red;
            font-weight: 700;
            font-family: 'Verdana, Geneva, Tahoma, sans-serif';
            font-size: 20px;
        }
        a{
            margin-left: 41%;
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
            justify-content: center;
            padding-left: 30px;
        }
        input{
            font-size: 35px;
        }
        .button{
            padding: 10px;
            margin-left: 46%;
            margin-bottom: 30px;
            font-family: 'Playfair Display';
            background-color: white;
            font-size: 30px;
            font-weight: 500;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
            border: 0px;
        }
        .button:hover{
            background-color:  #b5cff0;
        }
    </style>
</head>
<body>
    <h1 class="h1"><span class="heading">Login</span></h1>
    <div class="form">
        <form autocomplete="off" action="" method="POST">
            <label class="label" for="username">
                Username:
            </label><br><br>
            <input  type="text" id="username" name="username" maxlength="30" size="40" placeholder="Username" value="<?php if(isset($_COOKIE["Username"])){ echo $_COOKIE["Username"];} ?>">
            <br><br>
            <br><br>
            <label class="label" for="password">
                Password:
            </label><br><br>
            <input  type="password" id="password" name="password" size="15" value="<?php if(isset($_COOKIE["Password"])){ if($_COOKIE["Password"]){ echo password_needs_rehash($_COOKIE["Password"],PASSWORD_DEFAULT);} else{echo "";}} ?>" placeholder="Password">
            <br><br><br>
            <input type="checkbox" id="remember" name="remember">
            <label class="label label2" for="remember">
                Remember Me
            </label>
            <br><br>
            <p class = "err"><?php if(!empty($message)){ echo "$message";}?></p>
            <br><br>
            <input name="submit" type="submit" value="Log In" class="button">
            <br><br><a href="sign_up.php">Don't have an account? Sign Up here.</a>
        </form>
    </div>
</body>
</html>

