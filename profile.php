<?php
session_start();
require_once "config.php";
    $username = $_SESSION["Username"];
    $name = $_SESSION["Name"];
    $dob = $_SESSION["DOB"];
    $email = $phone = "";
    $email_err =  $phone_err1 = $phone_err2 = $phone_err3 = $phone_err4 = $gender_err = "";
    $value = "none";
    $value1 = "inline";


    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $phone_check = "/^(\+?91|\+?91[ -]|0)?[6|7|8|9][0-9]{9}$/";
        $email_check = "/^[a-zA-Z0-9]+[a-zA-Z0-9\W_]*[a-zA-Z0-9]+@[a-zA-Z]+\.[A-z]+[\.A-z]*[a-zA-Z]+$/";
        if(preg_match($email_check, $_POST["email"]) == 0){
            $email_err = "Enter a valid email!";
        }
        else{
            $email = $_POST["email"];
            $email_err = "";
        }
        if(preg_match($email_check, $_POST["email"]) == 0){
            $phone_err1 ="Enter valid mobile number, eg:";
            $phone_err2 = "+918989239231, +91-8989239231,";
            $phone_err3 = "918989239231, 08989239231 or";
            $phone_err4 = "8989239231";
        }
        else{
            $phone = $_POST["phone"];
            $phone_err1 = "";
        }
        if(empty($_POST["gender"])){
            $gender_err = "Select gender.";
        }
        else{
            $gender = $_POST["gender"];
            $confirm_password_err = "";
        }
        
        // storing in database
        if(empty($email_err) && empty($phone_err1) && empty($gender_err)){
            $sql = "INSERT INTO divyansh_user_data (username, number, email, gender) VALUES ('$username', '$phone', '$email', '$gender')";
            if(mysqli_query($conn, $sql)){
                header("location: main.php");
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
            display: <?php if(empty($email_err)){ echo $value; } else { echo $value1;}  ?>;
        }
        .err{
            display: <?php if(empty($phone_err1)){ echo $value; } else { echo "block";}  ?>;
        }
        #phone_err{
            display: <?php if(empty($phone_err1)){ echo $value; } else { echo $value1;}  ?>;
        }
        #gender_err{
            display: <?php if(empty($gender_err)){ echo $value; } else { echo $value1;}  ?>;
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
        .label2{
            font-size: 35px;
        }
        .radio{
            width: 20px;
            height: 15px;
        }
    </style>
</head>
<body>
    <?php if($_SESSION["Login"]==0){ $_SESSION["Login"]=0; header("location: login.php"); } ?>
    <h1 class="h1"><span class="heading">Profile</span></h1><br><br>
    <div class="form">
        <form action="" method="POST">
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
                    <input  type="text" id="phone" name="phone" size="15" value="" placeholder="Mobile Number" >
                    <br><br>
                    <div class="err">
                    <p id="phone_err"><?php if(!empty($phone_err1)){ echo $phone_err1; } ?></p><br><br><br>
                    <p id="phone_err"><?php if(!empty($phone_err2)){ echo $phone_err2; } ?></p><br><br><br>
                    <p id="phone_err"><?php if(!empty($phone_err3)){ echo $phone_err3; } ?></p><br><br><br>
                    <p id="phone_err"><?php if(!empty($phone_err4)){ echo $phone_err4; } ?></p>
                    </div>
                    <br><br>
                    <label class="label" for="email">
                        Email:
                    </label><br><br>
                    <input  type="test" id="email" name="email" size="15" value="" placeholder="Email">
                    <br><br>
                    <p id="email_err"><?php if(!empty($email_err)){ echo $email_err; } ?></p>
                    <br><br>
                    <label class="label">
                        Gender:
                    </label><br>
                    <input class="radio" type="radio" id="male" name="gender"  value="male">
                    <label for="male" class="label label2">
                        Male
                    </label><br>
                    <input class="radio" type="radio" id="female" name="gender" value="female">
                    <label for="female" class="label label2">
                        Female
                    </label>
                    <br><br>
                    <p id="gender_err"><?php if(!empty($gender_err)){ echo $gender_err; } ?></p>

            </div>
            
            <br><br>
            <div class="button1">
                <input name="submit" type="submit" value="Update Profile" class="button">
            </div>
        </form>
    </div>
</body>
</html>

