<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	
	$categoryid = $_POST['id'];
	$value = $_POST['value'];
	
	$values = explode("-",$categoryid);
	
	$field = $values[0];
	$id = $values[1];
	include_once "Category.php";
	
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	Category::edit($id,$field,$value);
	echo $value;
	$mysqli->close();
?>