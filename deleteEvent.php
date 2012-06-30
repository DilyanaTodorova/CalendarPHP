<?php
	
	$id = $_GET['id'];
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	include_once "Event.php";
	
	Event::delete($id);
?>