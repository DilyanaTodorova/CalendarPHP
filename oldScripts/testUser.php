<?php
error_reporting(E_ALL);
	$mysqli = new mysqli("localhost", "root", "root", "WebCalendar");
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	$sql = "SELECT userName, password, email, id FROM Users";
	
	if($result = $mysqli->query($sql)){
		if($result->num_rows > 0){
			while($row = $result->fetch_array()){
				echo "\nusername " . $row[0] . "\npassword : " . $row[1] . "\nemeil : " . $row[2] . "\nid : " . $row[3] . "<br/>"; 
			}
			
			$result->close();
		} else {
			echo "ERROR: Could not execute " . $mysql->error;
		}
	} else{
		echo "ERROR: Could not execute " . $mysql->error;
	}
	
	$mysqli->close();
?>