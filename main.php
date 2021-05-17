<?php
session_start();
require_once "config.php";
    $username = $_SESSION["Username"];
    $name = $_SESSION["Name"];
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
            background-color: cyan;
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
        .top{
            display: flex;
            justify-content: space-around;
        }
        .image{
            display: flex;
            justify-content: center;
            padding-right: 20px
        }
        .img{
            width: 150px;
        }
        .info{
            display: flex;
            justify-content: center;
            border: 2px solid black;
            width: 400px;
            padding: 20px 0px;
            margin: 10px 50px;
            background-color: rgb(235,235,235);;
        }
        .details{
            padding-top: 10px;
            padding-right: 0px;
            padding-left: 20px
        }
        .all_user{
            padding: 10px;
            white-space: nowrap;
            height: 600px;
            width: 600px;
            overflow: hidden;
            overflow-y: scroll;
            margin-bottom: 10px;
        }
        .user{
            display: flex;
            align-items: flex-end;
            justify-content: center;
            flex-direction: column;
        }
        h2{
            align-self: center;
        }
    </style>
</head>
<body>
    <?php if($_SESSION["Login"]==0){ header("location: login.php"); } ?>
    <div class="top">
        <a href="profile.php">Update Profile</a>
        <h1>Welcome to ChatterBox </h1>
        <a href="logout.php">Log Out</a>
    </div>
    
    <br><br>
    <!-- <?php echo $name; ?><br>
    <table>
        <?php $sql="SELECT * FROM divyansh_user WHERE NOT username='$username'"; $result=mysqli_query($conn, $sql); ?>
            
            <?php while($row=mysqli_fetch_assoc($result)) { ?> <tr><?php echo $row["name"];  ?> </tr><br> <?php } ?> 
            
    </table> -->
    <div class="info">
        <div class="image">
            <img src="<?php echo $xyz; ?>" class="img">
        </div>
        <div class="details">
            <p>Name: &nbsp;&nbsp;<?php echo $name; ?></p>
            <p>Userame: &nbsp;&nbsp;<?php echo $username; ?></p>
        </div>
    </div><br>
    <div class="user">
        <h2>All Users</h2><br>
        <div class="all_user">
            <?php $sql="SELECT d.username, d.name, d.dob, db.number, db.email, db.gender, db.profile_image FROM divyansh_user as d JOIN divyansh_user_data as db ON d.username=db.username WHERE NOT d.username='$username'"; $result=mysqli_query($conn, $sql); ?>
            <?php while($row=mysqli_fetch_assoc($result)) { ?> <div class="info"><div class="image"><img src="<?php echo $row["profile_image"]; ?>" class="img"></div> 
                <div class="details">
                    <p>Name: &nbsp;&nbsp;<?php echo $row["name"]; ?></p>
                    <p>Userame: &nbsp;&nbsp;<?php echo $row["username"]; ?></p>
                </div></div><br> <?php } ?>
        </div>
    </div>
    
    
    <br><br>
    
    
</body>
</html>
