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

    $username = $_SESSION["Username"];
    $sql2 = "SELECT * FROM divyansh_user WHERE username='$username'";
    $result2 = mysqli_query($conn, $sql2);
    $num2 = mysqli_num_rows($result2);
    if($num2 == 1){
        $row2 = mysqli_fetch_assoc($result2);
        $dob = $row2["dob"];
    }
    $name = $_SESSION["Name"];
    $email = $phone = "";
    $email_err =  $phone_err1 = $phone_err2 = $phone_err3 = $phone_err4 = $gender_err = $image_err =  "";
    $value = "none";
    $value1 = "inline";

    $sql1 = "SELECT * FROM divyansh_user_data WHERE username='$username'";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);
    if($num1 == 1){
        $row1 = mysqli_fetch_assoc($result1);
        $email = $row1["email"];
        $phone = $row1["number"];
        $gender = $row1["gender"];
        $image = $row1["profile_image"];
    }
    
    // Performing all checks
    if($_SERVER["REQUEST_METHOD"]== "POST"){   
       
        $file = $_FILES['image'];
        $fileName = $_FILES['image']['name'];
        if($num1==0){
            $fileName = $_FILES['image']['name'];
            $fileTemp = $_FILES['image']['tmp_name'];
            $fileError = $_FILES['image']['error'];
            $fileSize = $_FILES['image']['size'];
            $fileExt = explode('.',$fileName);
            $fileExtF = strtolower(end($fileExt));
            echo "imageN";
        }
        else{
            if(empty($fileName)){
                $fileName = $image;
                $fileTemp = $image;
                $fileError = 0;
                $fileSize = 2;
                $fileExt = explode('.',$fileName);
                $fileExtF = strtolower(end($fileExt));
            }
            else{
                $fileName = $_FILES['image']['name'];
                $fileTemp = $_FILES['image']['tmp_name'];
                $fileError = $_FILES['image']['error'];
                $fileSize = $_FILES['image']['size'];
                $fileExt = explode('.',$fileName);
                $fileExtF = strtolower(end($fileExt));
            }
            
        }
        $allowed = array('jpg', 'jpeg', 'png');
        if(in_array($fileExtF, $allowed)){
            if($fileError == 0){
                if($fileSize < 20000000){
                    $fileNewName = $username.".".$fileExtF;
                    $destination = "uploads/".$fileNewName;
                    move_uploaded_file($fileTemp, $destination);
                }
                else{
                    $image_err = "Your image size is too big.";
                }
            }
            else{
                $image_err = "Error uploading your image.";
            }
        }
        else{
            $image_err = "You can upload jpg, jpeg, png files only!!";
        }
        $phone_check = "/^(\+?91|\+?91[ -]|0)?[6|7|8|9][0-9]{9}$/";
        $email_check = "/^[a-zA-Z0-9]+[a-zA-Z0-9\W_]*[a-zA-Z0-9]+@[a-zA-Z]+\.[A-z]+[\.A-z]*[a-zA-Z]+$/";
        if(preg_match($email_check, $_POST["email"]) == 0){
            $email_err = "Enter a valid email!";
            echo "emailC";
        }
        else{
            $email = $_POST["email"];
            $email_err = "";
            echo "emailS";
        }
        if(preg_match($phone_check, $_POST["phone"]) == 0){
            $phone_err1 ="Enter valid mobile number, eg:";
            $phone_err2 = "+918989239231, +91-8989239231,";
            $phone_err3 = "918989239231, 08989239231 or";
            $phone_err4 = "8989239231";
            echo "phoneC";
        }
        else{
            $phone = $_POST["phone"];
            $phone_err1 = "";
            echo "phoneS";
        }
        if(empty($_POST["gender"])){
            $gender_err = "Select gender.";
        }
        else{
            $gender = $_POST["gender"];
            $gender_err = "";
        }

        // storing in database
        if($num1 == 0){
            if(empty($email_err) && empty($phone_err1) && empty($gender_err) && empty($image_err)){
                $sql = "INSERT INTO divyansh_user_data (username, number, email, gender, profile_image) VALUES ('$username', '$phone', '$email', '$gender', '$destination')";
                if(mysqli_query($conn, $sql)){
                   header("location: main.php");
                }
    
            }
        }else{
            $image_err = "";
            if(empty($email_err) && empty($phone_err1) && empty($gender_err) && empty($image_err)){
                $sql = "UPDATE divyansh_user_data SET number='$phone', email='$email', gender='$gender', profile_image='$destination' WHERE username='$username'";
                if(mysqli_query($conn, $sql)){
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
        <form action="" method="POST" enctype="multipart/form-data">
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
                    <input  type="text" id="phone" name="phone" size="15" placeholder="Mobile Number" value="<?php if($num1==1){ echo $phone;} ?>">
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
                    <input  type="test" id="email" name="email" size="15" placeholder="Email" value="<?php if($num1==1){ echo $email;} ?>">
                    <br><br>
                    <p id="email_err"><?php if(!empty($email_err)){ echo $email_err; } ?></p>
                    <br><br>
                    <label class="label">
                        Gender:
                    </label><br>
                    <div>
                        <input class="radio" type="radio" id="male" name="gender"  value="male" <?php if($num1==1){ if($gender == "male"){ echo "checked";}} ?>>
                        <label for="male" class="label label2">
                            Male
                        </label><br>
                        <input class="radio" type="radio" id="female" name="gender" value="female" <?php if($num1==1){ if($gender == "female"){ echo "checked";}} ?>>
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
                    <input  type="file" id="image" name="image" value="<?php if($num1==1){ echo $image;} ?>">
                    <br><br>
                    <p id="image_err"><?php if(!empty($image_err)){ echo $image_err; } ?></p>

            </div>

            <br><br>
            <div class="button1">
                <input name="submit" type="submit" value="Update Profile" class="button" onclick="my()">
            </div>
        </form>
    </div>
</body>
</html>

