<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	session_start();

	if(!isset($_SESSION['username'])){
		die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
	}
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	require 'Contact.php';
	
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$userid = $_SESSION['userid'];
	$result = $mysqli->query("SELECT * FROM Contacts WHERE `userid` = '$userid'");
	
	$contacts = array();
		
	while($row = $result->fetch_assoc()){
		$contact_params['contactid'] = $row['contactid'];
		$contact_params['name'] = $row['name'];
		$contact_params['familyname'] = $row['familyname'];
		$contact_params['note'] = $row['note'];
		array_push($contacts, $contact_params);
	}
	
	echo json_encode($contacts);
?>