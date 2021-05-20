<?php
session_start();
require_once "config.php";
    $username = $_SESSION["Username"];
    $sql1 = "SELECT * FROM divyansh_user_data WHERE username=?";
    $stmt1 = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt1, $sql1)){
        mysqli_stmt_bind_param($stmt1, 's', $username);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $num1 = mysqli_num_rows($result1);
        if($num1 == 1){
            $row1 = mysqli_fetch_assoc($result1);
            $image = $row1["profile_image"];
        }
    }
    if($num1==0){
        $fileName = $_FILES['image']['name'][0];
        $fileTemp = $_FILES['image']['tmp_name'][0];
        $fileError = $_FILES['image']['error'][0];
        $fileSize = $_FILES['image']['size'][0];
        $fileExt = explode('.',$fileName);
        $fileExtF = strtolower(end($fileExt));
    }
    else{
        $fileName = $_FILES['image']['name'][0];
        if(empty($fileName)){
            $fileName = $image;
            $fileTemp = $image;
            $fileError = 0;
            $fileSize = 2;
            $fileExt = explode('.',$fileName);
            $fileExtF = strtolower(end($fileExt));
        }
        else{
            $fileName = $_FILES['image']['name'][0];
            $fileTemp = $_FILES['image']['tmp_name'][0];
            $fileError = $_FILES['image']['error'][0];
            $fileSize = $_FILES['image']['size'][0];
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
                setcookie("Image1", $destination);
                echo "Image Uploaded";
            }
            else{
                echo "Your image size is too big.";
            }
        }
        else{
            echo "Error uploading your image.";
        }
    }
    else{
        echo "You can upload jpg, jpeg, png files only!!";
    }
?>
