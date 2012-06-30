<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Добре дошли</title>
	</head>
	
	<body>
		<div id="wrapper">
			<div id="leftColumn">
			<div>
			
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
			
			<div id="loginPanel">
				<form id="login" action="userRegister.php" method="POST">
					<label>User name:</label>
					<input type="text" name="input_username" />
					<label>Password:</label>
					<input type="password" name="input_password" />
					<label>Confirm password:</label>
					<input type="password" name="confirm_password" />
					<label>Emeil:</label>
					<input type="text" name="input_email" />
					
					<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
		</div>
	</body>
</html>