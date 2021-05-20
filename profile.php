<?php
session_start();
require_once "config.php";

    if(isset($_COOKIE["Username"])){
        if($_COOKIE["Username"]==$_SESSION["Username"]){
        }else{
            setcookie("Username","", time() - 3600);
            setcookie("Password","", time() - 3600);
        }
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

    $username = $_SESSION["Username"];
    $sql2 = "SELECT * FROM divyansh_user WHERE username= ?";
    $stmt2 = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt2, $sql2)){
        mysqli_stmt_bind_param($stmt2, 's', $username);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $num2 = mysqli_num_rows($result2);
        if($num2 == 1){
            $row2 = mysqli_fetch_assoc($result2);
            $dob = $row2["dob"];
        }
    }
    $name = $_SESSION["Name"];
    $email = $phone = "";
    $email_err =  $phone_err1 = $phone_err2 = $phone_err3 = $phone_err4 = $gender_err = $image_err =  "";
    $value = "none";
    $value1 = "inline";

    $sql1 = "SELECT * FROM divyansh_user_data WHERE username=?";
    $stmt1 = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt1, $sql1)){
        mysqli_stmt_bind_param($stmt1, 's', $username);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $num1 = mysqli_num_rows($result1);
        if($num1 == 1){
            $row1 = mysqli_fetch_assoc($result1);
            $email = $row1["email"];
            $phone = $row1["number"];
            $gender = $row1["gender"];
        }
    }
    
    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){   
       
        $email = $_COOKIE["Email1"];
        $phone = $_COOKIE["Phone1"];
        $image = $_COOKIE["Image1"];
        if(empty($_POST["gender"])){
            $gender_err = "Select gender.";
        }
        else{
            $gender = $_POST["gender"];
            $gender_err = "";
        }

        // storing in database
        if($num1 == 0){
            if(!empty($email) && !empty($phone) && empty($gender_err) && !empty($image)){
                $sql = "INSERT INTO divyansh_user_data (username, number, email, gender, profile_image) VALUES (?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt, $sql)){
                    mysqli_stmt_bind_param($stmt, 'sisss', $username, $phone, $email, $gender, $image);
                    mysqli_stmt_execute($stmt);
                   header("location: main.php");
                }
            }
        }else{
            $image_err = "";
            if(!empty($email) && !empty($phone) && empty($gender_err) && !empty($image)){
                $sql = "UPDATE divyansh_user_data SET number=?, email=?, gender=?, profile_image=? WHERE username=?";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt, $sql)){
                    mysqli_stmt_bind_param($stmt, 'issss', $phone, $email, $gender, $image, $username);
                    mysqli_stmt_execute($stmt);
                    header("location: main.php");
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
    <title>Profile</title>
<script>
    function email_request(){
            var x ="";
            var email = document.getElementById("email").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   x = this.responseText;
                    if(x == ""){
                        document.getElementById("email_err").style.display = "none";
                        document.cookie = "Email1 = " + email;
                    }
                    else{
                        document.getElementById("email_err").style.display = "inline";
                        document.getElementById("email_err").innerHTML = x;
                        document.cookie = "Email1 =; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    }
                }
            };
            xmlhttp.open("POST", "emailCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("email="+email);
        }
       
        function number_request(){
            var y ="";
            var number = document.getElementById("phone").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   y = this.responseText;
                    if(y == ""){
                        document.getElementById("err").style.display = "none";
                        document.cookie = "Phone1 = " + number;
                    }
                    else{
                        document.getElementById("err").style.display = "inline";
                        document.getElementById("err").innerHTML = y;
                        document.cookie = "Phone1 =; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                    }
                }
            };
            xmlhttp.open("POST", "numberCheck.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("number="+number);
        }
        function image_request(){
            var x ="";
            var image = document.getElementById("image")
            var frmData = new FormData();
            var xmlhttp = new XMLHttpRequest();

            for(const file of image.files){
                frmData.append("image[]", file);
            }

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   x = this.responseText;
                    if(x == ""){
                        document.getElementById("image_err").style.display = "none";
                    }
                    else{
                        document.getElementById("image_err").style.display = "inline";
                        document.getElementById("image_err").innerHTML = x;
                    }
                }
            };
            xmlhttp.open("POST", "profileCheck.php", true);
            xmlhttp.send(frmData);
        }
</script>
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
        #email_err{
            display: none;
        }
        #err{
            display: none;
        }
        #phone_err{
            display: inline;
        }
        #gender_err{
            display: <?php if(empty($gender_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        #image_err{
            display: <?php if(empty($image_err)){ echo $value; } else { echo $value1;}  ?>;
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
            align-self: center;
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
        }
        .sign_up_box{
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: rgb(235,235,235);
            border: 2px solid black;
            padding: 50px;
        }
        .label2{
            font-size: 35px;
        }
        .radio{
            width: 20px;
            height: 15px;
        }
        #image{
            align-self: center;
        }
    </style>
</head>
<body>
    <?php if($_SESSION["Login"]==0){ header("location: login.php"); } ?>
    <h1 class="h1"><span class="heading">Update Profile</span></h1><br><br>
    <div class="form">
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="sign_up_box">
                    <label class="label" for="name">
                        Name:
                    </label><br><br>
                    <input  type="text" id="name" name="name" maxlength="30" size="15" placeholder="Name" value="<?php echo $name; ?>" disabled><br><br>
                    <br><br>
                    <label class="label" for="username">
                        Username:
                    </label><br><br>
                    <input  type="text" id="username" name="username" maxlength="30" size="15" placeholder="Username" value="<?php echo $username; ?>" disabled>
                    <br><br>
                    <br><br>
                    <label class="label" for="date">
                        Date of birth:
                    </label><br><br>
                    <input  type="date" id="date" name="date" maxlength="30" size="15" placeholder="dd-mm-yyyy" value="<?php echo $dob; ?>" disabled>
                    <br><br>
                    <label class="label" for="phone">
                        Mobile Number:
                    </label><br><br>
                    <input  type="text" id="phone" name="phone" size="15" placeholder="Mobile Number" value="<?php echo $phone ?>" onkeyup="number_request()">
                    <br><br>
                    <div id="err">
                    
                    </div>
                    <br><br>
                    <label class="label" for="email">
                        Email:
                    </label><br><br>
                    <input  type="test" id="email" name="email" size="15" placeholder="Email" value="<?php echo $email; ?>" onkeyup="email_request()">
                    <br>
                    <p id="email_err"></p>
                    <br><br>
                    <label class="label">
                        Gender:
                    </label><br>
                    <div>
                        <input class="radio" type="radio" id="male" name="gender"  value="male" <?php if(empty($gender_err)){ if($gender == "male"){ echo "checked";}} ?>>
                        <label for="male" class="label label2">
                            Male
                        </label><br>
                        <input class="radio" type="radio" id="female" name="gender" value="female" <?php if(empty($gender_err)){ if($gender == "female"){ echo "checked";}} ?>>
                        <label for="female" class="label label2">
                            Female
                        </label>
                    </div>
                    <br><br>
                    <p id="gender_err"><?php if(!empty($gender_err)){ echo $gender_err; } ?></p>
                    <br><br>
                    <label class="label" for="image">
                        Image:
                    </label><br><br>
                    <input  type="file" id="image" name="image" onchange="image_request()">
                    <br><br>
                    <p id="image_err"><?php if(!empty($image_err)){ echo $image_err; } ?></p>

            </div>

            <br><br>
            <div class="button1">
                <input name="submit" type="submit" value="Update Profile" class="button" onclick="my()">
                
            </div>
            <br>
            <a href="<?php if($num1==1){echo 'main.php';}else{echo 'login.php';} ?>">Go Back</a>
        </form>
    </div>
</body>
</html>

