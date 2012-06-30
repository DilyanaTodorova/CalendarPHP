<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	
	$eventid = $_POST['id'];
	$value = $_POST['value'];
	
	$values = explode("-",$eventid);
	
	$field = $values[0];
	$id = $values[1];
	include_once "Event.php";
	
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	Event::edit($id,$field,$value);
	echo $value;
	$mysqli->close();
?>