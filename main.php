<?php
session_start();
require_once "config.php";
if($_SESSION["Login"]==0){ header("location: login.php"); } if($_SESSION["Profile"]==0){ header("location: profile.php"); }
    $username = $_SESSION["Username"];
    $_SESSION["Fromuser"] = $username;
    $name = $_SESSION["Name"];
    $sql = "SELECT d.username, d.name, d.dob, db.number, db.email, db.gender, db.profile_image FROM divyansh_user as d JOIN divyansh_user_data as db ON d.username=db.username WHERE d.username=?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($result);
    }
    else{
        $num = 0;
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
    if($num == 1){
        $row = mysqli_fetch_assoc($result);
        $profile_image = $row["profile_image"];
        $sqlAU="SELECT d.id, d.username, d.name, d.dob, db.number, db.email, db.gender, db.profile_image FROM divyansh_user as d JOIN divyansh_user_data as db ON d.username=db.username WHERE NOT d.username=?"; 
        $stmtAU = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmtAU, $sqlAU)){
            mysqli_stmt_bind_param($stmtAU, 's', $username);
            mysqli_stmt_execute($stmtAU);
            $resultAU = mysqli_stmt_get_result($stmtAU);
        }
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $message_err="";
        $message = $_POST["text"];
        if(empty($message)){
            echo "<script type='text/javascript'> alert('Message Field Cannot be Empty!!')</script>";
            $message_err = "1";
        }
        if(isset($_COOKIE["Id"])){
            $xyz = $_COOKIE["Id"];    
        }
        else{
            $message_err = "2";
            echo "<script type='text/javascript'> alert('No Chat Selected!!')</script>";
        }

        if(empty($message_err)){
            $touser = $_SESSION["Touser"];
            $fromuser = $username;
            $sqlS = "INSERT INTO divyansh_chat (fromUser, toUser, message) VALUES (?,?,?)";
            $stmtS = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmtS, $sqlS)){
                mysqli_stmt_bind_param($stmtS, 'sss', $fromuser, $touser, $message);
                mysqli_stmt_execute($stmtS);
                $resultS = mysqli_stmt_get_result($stmtS);
            }
        }
    }

    echo "<script type='text/javascript'>
        function chatUi(variable){
        document.cookie = 'Id = ' + variable;
        console.log(variable);
        document.getElementById('xyz').style.display='flex';  
        document.getElementById('abc').style.flex=0.75;
        document.getElementById('xyz').style.flex=1.25;
    }</script>"
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatterBox</title>

    <script>
        var count = 0;
        function ajax_request(){
            console.log("hello");
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("chats").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","chat.php",true);
            xmlhttp.send();
        }

        function chatUI(){
            var xmlhttpN = new XMLHttpRequest();
            xmlhttpN.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("head").innerHTML = this.responseText;
                }
            };
            xmlhttpN.open("GET","chatUI.php",true);
            xmlhttpN.send();
        }

        setInterval(function(){ajax_request(),chatUI()}, 100);
        

    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Balsamiq+Sans&family=Fira+Sans:ital,wght@1,300&family=Shadows+Into+Light&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Goblin+One&display=swap');
        body{
            background-color: #222;
            margin: 0px;
            margin-bottom: 15px;
        }
        .box{
            display: flex;
            background-color: white;
            width:75vw;
            height: 870px;
            margin: auto;
        }
        .user{
            background-color: #27344d;
            height: 870px;
            flex: 1;
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            align-items: center;
        }
        .all_user{
            background-color: green;
            height: 870px;
            flex: 3;
        }
        .heading{
            height: 120px;
            background-color: #3d4e5d;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .content{
            height: 750px;
            background-color: #343c46;
            display: flex;
        }
        .user_list{
            height: 750px;
            flex: 0.75;
            background-color: #343c46;
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            overflow-y: scroll;
            transition: all 1s ease;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .user_list::-webkit-scrollbar{
            display: none;
        }
        .chat{
            height: 750px;
            flex: 1.25;
            display: flex;
            flex-direction: column;
            background-color: #ffdada;
            transition: all 1s ease;
        }
        #header{
            margin: 0px;
            color: white;
            font-family: 'Fira Sans', sans-serif;
            font-size: 80px;
        }
        #image{
            width: 130px;
            height: 130px;
            border: solid thin white;
            border-radius: 50%;
            padding: 5px;
            margin-top: 50px;
            
        }
        #username{
            font-family: 'Shadows Into Light', cursive;
            font-size: 30px;
            margin: 0px;
            color: white;
            text-align: center;
            opacity: 0.5;
        }
        #name{
            font-family: 'Architects Daughter', cursive;
            font-size: 60px;
            font-weight: 100;
            text-align: center;
            margin: 0px;
            color: white;
        }
        .Puser{
            margin: 0px;
            flex: 1
        }
        .list{
            flex: 2
        }
        .label{
            font-family: 'Balsamiq Sans', cursive;
            font-size: 40px;
            display: block;
            margin: 20px;
            text-align: center;
            color: white;
            text-shadow: -5px 0px 5px black;
            text-decoration: none;
            transition: all 0.5s ease;
        }
        .label:hover{
            color: black;
            text-shadow: -2px 0px white;
        }
        .eUser{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #161e2c;
            border-radius: 15px;
            border: 1px solid white;
            width: 300px;
            height: 150px;
            margin: 10px;
            margin-top: 15px;
        }
        #imageU{
            width: 60px;
            height: 60px;
            border: solid thin white;
            border-radius: 50%;
            padding: 5px;
            margin-left: 10px;
            margin-bottom: 20px;
        }
        #usernameU{
            font-family: 'Shadows Into Light', cursive;
            font-size: 30px;
            margin: 0px;
            color: white;
            text-align: center;
            opacity: 0.5;
            margin-right: 10px;
        }
        #nameU{
            font-family: 'Architects Daughter', cursive;
            font-size: 40px;
            font-weight: 100;
            text-align: center;
            margin: 0px;
            color: white;
            margin-right: 10px;
        }
        #text{
            width: 80%;
            align: center;
            height: 60px;
            font-size: 20px;
        }
        .elements{
            display: <?php if(isset($_COOKIE["Id"])){echo "flex";}else{ echo "none";} ?>;
            flex-direction: row-reverse;
            justify-content: space-evenly;
            align-items: center;
            height: 85px;
            max-height: 85px;
            padding-bottom: 5px;
            border-radius: 10px;
            border: 2px solid black;
            margin: 5px;
            background-color: #ebffe2;
        }
        #head{
            height:85px;
            max-height: 85px;
            padding: 5px;
            overflow: hidden;
            display: <?php if(!isset($_COOKIE["Id"])){echo "none";}else{echo "block";} ?>;
        }
        #message{
            display: <?php if(!isset($_COOKIE["Id"])){echo "none";}else{echo "block";} ?>;
            height: 580px;
            max-height: 580px;
            overflow: hidden;
            overflow-y :scroll;
            background-color: #ffdada;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        #message::-webkit-scrollbar{
            display: none;
        }
        #messageSend{
            height: 40px;
            font-size: 20px;
            overflow: hidden;
            background-color: #c8c8c8;
        }
        #chats{
            margin: 5px;
            padding: 10px;
        }
        #initialMsg{
            width: 100%;
            display: <?php if(isset($_COOKIE["Id"])){echo "none";}else{echo "block";} ?>;
            text-align:center;
            position: relative;
            top: 35%;
            font-family: 'Goblin One', cursive;
            font-size: 50px;
            opacity: 50%
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="user">
            <img id="image" src="<?php echo $profile_image; ?>">
            <div class="Puser">
                <h3 id="name"><?php echo $row["name"] ?></h3>
                <p id="username"><?php echo $row["username"] ?></p>
            </div>
            <div class="list">
                <a href="profile.php" id="update_profile" class="label" >Update Profile</a>
                <a href="logout.php" id="logout" class="label">Logout</a>
            </div>
        </div>
        <div class="all_user">
            <div class="heading">
                <h1 id="header">ChatterBox</h1>
            </div>
            <div class="content">
                <div class="user_list" id="abc">
                    <?php while($rowAU=mysqli_fetch_assoc($resultAU)){ ?>
                        <div class="eUser" onclick="chatUi('<?php echo $rowAU['id']; ?>')">
                            <img id="imageU" src="<?php echo $rowAU["profile_image"]; ?>">
                            <div>
                                <h3 id="nameU"><?php echo $rowAU["name"] ?></h3> 
                                <p id="usernameU"><?php echo $rowAU["username"] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="chat" id="xyz">
                        <div id='head'>
                        </div>
                        <div id="message">
                            <div id="chats">

                            </div>
                        </div>
                        <p id="initialMsg">Select a user to start Chatting..</p>
                        <div class="elements" id='def'>
                            <form id="messageForm" method="POST">
                                <input type="submit" id="messageSend" value="Send">
                            </form>
                                <textarea id="text" name="text" form="messageForm" placeholder="Type Here..."><?php if(!empty($message_err)){echo $message;} ?></textarea>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

