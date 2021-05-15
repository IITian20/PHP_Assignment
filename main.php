<?php
session_start();
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
            background-color: #f8d16c;
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
            padding: 10px;
            margin-left: 45%;
            margin-bottom: 30px;
            font-family: 'Playfair Display';
            background-color: white;
            font-size: 30px;
            font-weight: 500;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);
            border: 0px;
            text-decoration: none;
        }
        a:hover{
            background-color:  #b5cff0;
        }
    </style>
</head>
<body>
    <?php if($_SESSION["Login"]==0){ $_SESSION["Login"]=0; header("location: login.php"); } ?>
    <h1>Welcome <?php echo $_SESSION["Name"]; ?></h1>
    <a href="logout.php">Log Out</a>
</body>
</html>
