<?php
	if(isset($_POST['submit']))
	{
		$mysqli = new mysqli("localhost","root","root","WebCalendar");
		
		if($mysqli === false){
			die("ERROR: Could not connect to database" . mysqli_connect_error());
		}
		
		echo '<div id="message">';
		
		$inputError = false;
		if(empty($_POST['input_username'])){
			echo 'ERROR: Please enter a valid username';
			$inputError = true;
		} else {
			$name = $mysqli->escape_string($_POST['input_username']);
		}
		
		if($inputError != true && empty($_POST['input_password'])){
			echo 'ERROR: Please enter a valid password';
			$inputError = true;
		} else {
			$password = $mysqli->escape_string($_POST['input_password']);
		}
		
		if($inputError != true && empty($_POST['input_email'])){
			echo 'Error: Please enter a valid email';
			$inputError = true;
		}else {
			$email = $mysqli->escape_string($_POST['input_email']);
		}
		
		
		if($inputError == false){
			$sql = "INSERT INTO Users(userName, password, email) 
						VALUES ('$name','$password','$email')";
		}
			
		if($mysqli->query($sql) === true){
			echo 'New user added with ID: ' . $mysqli->insert_id;
		} else {
			echo "ERROR: Could not execute query : $sql " . $mysqli->error;
		}
		
		echo '</div>';
		
		$mysqli->close();
	}
?>