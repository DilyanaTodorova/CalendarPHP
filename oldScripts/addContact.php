<?php
error_reporting(E_ALL);
session_start();

if(!isset($_SESSION['username'])){
	die('ERROR: You attemped to access a restricted page. Please <a href="login.php">log in</a>');
} else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Add contact</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<body>
	<form id="addEvent" method="POST" action="addContact.php">
		<label>name:</label>
		<input type="text" name="input_name" required="required" placeholder="e.g. Ivan" />
		<br/>
		<label>family name:</label>
		<input type="text" name="input_familyname" placeholder="e.g. Petrov" />
		<br/>
		<label>email:</label>
		<input type="email" name="input_email" placeholder="e.g ivan@petrov.bg" />
		<br/>
		<label>birthdate:</label>
		<input type="date" name="input_birthdate" />
		<br/>
		<label>phone</label>
		<input type="tel" name="input_phone"/>
		<br/>
		<label>note:<label>
		<br/>
		<textarea placeholder="Describe your contacts..." rows="10" cols="50" maxlength="200" name="input_note">
		</textarea>
		<br/>
		<input type="submit" name="submit" value="DONE" id="button" />
		
	</form>
	</body>
</html>
<?php
if(isset($_POST['submit'])){
	$mysqli = new mysqli("localhost", "root", "root", "WebCalendar");
	$mysqli->query("SET NAMES utf8");
	if($mysqli === false){
		die("ERROR: Could not connect to database " . mysqli_connect_error());
	}
	
	$inputError = false;
	echo '<div id="error_message">';
	
	if(empty($_POST['input_name'])){
		$inputError = true;
		echo "ERROR: Invalid name";
	} else {
		$name = $mysqli->escape_string($_POST['input_name']);
	}

	
	
		$familyname = $mysqli->escape_string($_POST['input_familyname']);
		$email = $mysqli->escape_string($_POST['input_email']);
		$birthdate = $mysqli->escape_string($_POST['input_birthdate']);
		$phone = $mysqli->escape_string($_POST['input_phone']);
		$note = $mysqli->escape_string($_POST['input_note']);
		
		$userid = $_SESSION['userid'];
		
		$categoryid = 1;
		
		$addContactQuery = "INSERT INTO Contacts ( name , familyname, 
			email, birthdate, phone, note, userid) VALUES ( '$name', '$familyname', 
			'$email', '$birthdate', '$phone', '$note', '$userid')";
	
	if($mysqli->query($addContactQuery) === true){
		echo "Added new contact " . $mysqli->insert_id;
	} else {
		echo "ERROR: Could not execute query " . $mysqli->error;
	}
	echo '</div>';
	
	$mysqli->close();
	}
}

?>