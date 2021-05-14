<?php

    $servername = "localhost";
    $username = "first_year";
    $password = "first_year";
    $dbname = "first_year";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    	if(!$conn){
		die("Connection failed: ". mysqli_connection_error());
	}
?>
