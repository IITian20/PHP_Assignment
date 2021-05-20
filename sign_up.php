<?php
session_start();
require_once "config.php";
    $username = $name = $password = $date = "";
    $username_err = $name_err = $password_err1 = $password_err2 = $password_err3 = $password_err4 = $confirm_password_err = $date_err = "";
    $value = "none";
    $value1 = "inline";
    if(isset($_COOKIE["Id"])){
        setcookie("Id", "", time()-3600);
    }
    unset($_SESSION["Username"]);
    unset($_SESSION["Name"]);


    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $smallLetter = "/[a-z]/";
        $capitalLetter = "/[A-Z]/";
        $numberPassword = "/[0-9]/";
        $specialCharacter = "/[\W_]/";
        $username = $name = $password = $cpassword = $date = "";
        $name = $_COOKIE["Name1"];
        $date = $_COOKIE["Date1"];
        $username = $_COOKIE["Username1"];
        $password = $_COOKIE["pass1"];
        $cpassword = $_COOKIE["cpass1"];
        // storing in database
        if(!empty($name) && !empty($username) && !empty($password) && !empty($cpassword) && !empty($date)){
            $sql = "INSERT INTO divyansh_user (name, username, password, dob) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt,$sql)){
                mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $password, $date);
                mysqli_stmt_execute($stmt);
                $_SESSION["Username"] = $username;
                $_SESSION["Name"] = $name;
                $_SESSION["Login"] = 1;
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
                $sql1 = "SELECT * FROM divyansh_user_data WHERE username=?";
                $stmt1 = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt1, $sql1)){
                    mysqli_stmt_bind_param($stmt1, 's', $username);
                    mysqli_stmt_execute($stmt1);
                    $result1 = mysqli_stmt_get_result($stmt1);
                    $num = mysqli_num_rows($result1);
                    if($num == 1){
                        $_SESSION["Profile"] = 1;
                        header("location:main.php");
                    }else{
                        $_SESSION["Profile"] = 0;
                        header('location: profile.php');
                    }
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
    <script>
        function name_request(){
            var x ="";
            var name = document.getElementById("name").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   x = this.responseText;
                    if(x == ""){
                        document.getElementById("name_err").style.display = "none";
                        document.cookie = "Name1 = " + name;
                    }
                    else{
                        document.getElementById("name_err").style.display = "inline";
                        document.getElementById("name_err").innerHTML = x;
                        document.cookie = "Name1 =; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    }
                }
            };
            xmlhttp.open("POST", "nameCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("name="+name);
        }
        function username_request(){
            var y ="";
            var username = document.getElementById("username").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   y = this.responseText;
                    if(y == ""){
                        document.getElementById("username_err").style.display = "none";
                        document.cookie = "Username1 = " + username;
                    }
                    else{
                        document.getElementById("username_err").style.display = "inline";
                        document.getElementById("username_err").innerHTML = y;
                        document.cookie = "Username1 =; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    }
                }
            };
            xmlhttp.open("POST", "usernameCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("username="+username);
        }
        function date_request(){
            var z ="";
            var date = document.getElementById("date").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   z = this.responseText;
                    if(z == ""){
                        document.getElementById("date_err").style.display = "none";
                        document.cookie = "Date1 = " + date;
                    }
                    else{
                        document.getElementById("date_err").style.display = "inline";
                        document.getElementById("date_err").innerHTML = z;
                        document.cookie = "Date1 =; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    }
                }
            };
            xmlhttp.open("POST", "dateCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("date="+date);
        }
        function pass_request(){
            var a="";
            var pass = document.getElementById("password").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   a = this.responseText;
                    if(a == ""){
                        document.getElementById("err").style.display = "none";
                    }
                    else{
                        document.getElementById("err").style.display = "inline";
                        document.getElementById("err").innerHTML = a;
                    }
                }
            };
            xmlhttp.open("POST", "passCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("password="+pass);
        }
        function cpass_request(){
            var b ="";
            var pass = document.getElementById("cpassword").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   b = this.responseText;
                    if(b == ""){
                        document.getElementById("c_pass_err").style.display = "none";
                    }
                    else{
                        document.getElementById("c_pass_err").style.display = "inline";
                        document.getElementById("c_pass_err").innerHTML = b;
                    }
                }
            };
            xmlhttp.open("POST", "cpassCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("cpassword="+pass);
        }
    </script>
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
            margin: 0px;
            margin-bottom: 10px;
        }
        #name_err{
            display: none;
        }
        #username_err{
            display: none;
        }
        #err{
            display: none;
            margin-top: 10px;
        }
        #pass_err{
            display: inline;
        }
        #c_pass_err{
            display: none;
        }

        #date_err{
            display: none;
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
            padding: 20px;
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
        .sign_up_box{
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
    <h1 class="h1"><span class="heading">Sign Up for ChatterBox</span></h1><br>
    <div class="form">
        <form action="" method="POST" autocomplete="off">
            <div class="sign_up_box">
                    <label class="label" for="name">
                        Name:
                    </label><br>
                    <input  type="text" id="name" name="name" maxlength="30" size="15" placeholder="Name" value="<?php echo $name ?>" onkeyup="name_request()"><br>
                    <p id="name_err"></p>
                    <label class="label" for="username">
                        Username:
                    </label><br>
                    <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username" value="<?php echo $username ?>" onkeyup="username_request()">
                    <br>
                    <p id="username_err"></p>
                    <label class="label" for="date">
                        Date of birth:
                    </label><br>
                    <input  type="date" id="date" name="date" maxlength="30" size="15" placeholder="dd-mm-yyyy" value="<?php $date ?>" onkeyup="date_request()">
                    <br>
                    <p id="date_err"></p>
                    <label class="label" for="password">
                        Password:
                    </label><br>
                    <input  type="password" id="password" name="password" size="15" value="" placeholder="Password" onkeyup="pass_request()">
                    <br>
                    <div id="err">
                    </div>
                    <br>
                    <label class="label" for="cpassword">
                        Confirm Password:
                    </label><br>
                    <input  type="password" id="cpassword" name="cpassword" size="15" value="" placeholder="Confirm Password" onkeyup="cpass_request()">
                    <br>
                    <p id="c_pass_err"></p>
            </div>
            <br>
            <div class="button1">
                <input name="submit" type="submit" value="Sign Up" class="button">
            </div>
            <div class="button1">
                <a href="login.php">Already have an account. Sign In here.</a>
            </div>
        </form>
    </div>
</body>
</html>

