<?php
session_start();
require_once "config.php";
$id = $_COOKIE["Id"];
$date = "0";
$count = 0;
$fromUser = $_SESSION["Fromuser"];
$toUser = $_SESSION["Touser"];
$sql = "SELECT id, fromUser, toUser, message, date(date), time(date) FROM (SELECT * FROM divyansh_chat WHERE fromUser='$fromUser' or toUser='$fromUser') as a  WHERE fromUser='$toUser' or toUser='$toUser'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        #msgBox{
            width: 100%;
            margin: 0px;
            float: right;
            display: flex;
            /* flex-direction: <?php if($row['fromUser']==$fromUser){ echo "row-reverse";}else{ echo "row";} ?>; */
        }
        #msgSend{
            background-color: #b6f3b9;
            border: 2px solid black;
            width: 85%;
            height: 40px;
            font-size: 30px;
            display: flex;
            justify-content: space-between;
            border-radius: 10px;
        }
        #msg{
            padding-left: 10px;
        }
        #msgDate{
            align-self: flex-end;
            opacity: 0.5;
            font-size: 15px;
            padding-right: 10px;
            padding-bottom: 2px;
        }
        #msgD{
            text-align: center;
            padding: 15px;
        }   
        #datemsg{
            background-color:#fffbc9;
            padding: 10px;
            border-radius: 10px;
            color: black;
            font-weight:600;
            border: solid 2px black;
        }
    </style>
</head>
<body>
<?php while($row = mysqli_fetch_assoc($result)){if(isset($_COOKIE["Id"])){ if($date != $row["date(date)"]){$date = $row["date(date)"]; $count = 0;}else{ $count=1; }
if($count==0){ ?>
<div id="msgD">
    <span id="datemsg"><?php echo $date; ?></span>
</div>
<?php } ?>
<div id="msgBox" style="flex-direction: <?php if($row['fromUser']==$fromUser){ echo 'row-reverse';}else{ echo 'row';} ?>;">
    <div id="msgSend" style="background-color: <?php if($row['fromUser']==$fromUser){ echo '#e4ffe6';}else{ echo '#b6f3b9';} ?>">
        <span id="msg"><?php echo $row['message']; ?></span>
        <span id="msgDate" style="float:right;"><?php echo $row['time(date)']; ?></span>
    </div>
    <p>&nbsp;&nbsp;</p>
</div>
<br><br>&nbsp;
<?php
}}?>
        
</body>
</html>
