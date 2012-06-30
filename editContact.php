<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	
	$elementid = $_POST['id'];
	$value = $_POST['value'];
	
	$values = explode("-",$elementid);
	
	$field = $values[0];
	$id = $values[1];
	
	include_once "Contact.php";
	
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	Contact::edit($id,$field,$value);
	echo $value;
	$mysqli->close();
	
	?>