<?php
session_start();
require_once "config.php";
    $username = $_SESSION["Username"];
    
    $sql = "SELECT * FROM divyansh_user_data WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num == 1){
        $row = mysqli_fetch_assoc($result);
        $xyz = $row["profile_image"];
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <style>
        body{
            font-family: 'Lato', sans-serif;
            margin: 0px;
            padding-top: 30px;
        }
        h1{
            text-align: center;
            font-size: 50px;
            font-family: 'Playfair Display';
            margin-top: 0px;
            padding-top: 20px;
        }
        a{
            padding: 20px;
            margin-bottom: 30px;
            font-family: 'Playfair Display';
            background-color: white;
            font-size: 30px;
            font-weight: 500;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
            border: 2px solid black;
            text-decoration: none;
        }
        a:hover{
            background-color:  #b5cff0;
        }
        .image{
            display: flex;
            justify-content: space-evenly;
        }
        img{
            width: 100px;
        }
    </style>
</head>
<body>
    <?php if($_SESSION["Login"]==0){ header("location: login.php"); } ?>
    <h1>Welcome <?php echo $_SESSION["Name"]; ?></h1>
    <br><br>
    <div class="image">
        <img src="<?php echo $xyz; ?>">
    </div>
    <br><br>
    <div class="image">
        <a href="profile.php">Update Profile</a>
        <a href="logout.php">Log Out</a>
    </div>
    
</body>
</html>
