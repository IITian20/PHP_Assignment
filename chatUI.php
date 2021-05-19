<?php
session_start();
require_once "config.php";
$id = $_COOKIE["Id"];
$sql = "SELECT d.id, d.username, d.name, d.dob, db.number, db.email, db.gender, db.profile_image FROM divyansh_user as d JOIN divyansh_user_data as db ON d.username=db.username WHERE d.id='$id'";
$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #Chatmessages{
            border: 2px solid black;
            height:80px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            max-height: 80px;
            background-color: #3fffd5;
            border-radius: 20px;
        }
        #Chatprofile{
            width: 70px;
            height: 70px;
            border: solid thin black;
            border-radius: 50%;
            padding: 2px;
            background-color: white;
            margin: 0px 20px;
        }
        #Chatname{
            font-size: 40px;
        }
        .elements{
            display: <?php if(isset($_COOKIE["Id"])){echo "flex";}else{ echo "none";} ?>;
        }
    </style>
</head>
<body>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <div id="Chatmessages"> 
                <img id="Chatprofile" src="<?php echo $row['profile_image'];?>">
                <span id="chatName"><?php echo $row['name']; ?></span>
            </div>
            <?php $_SESSION["Touser"] = $row["username"]; ?>
    <?php  } ?>
        
</body>
</html>

