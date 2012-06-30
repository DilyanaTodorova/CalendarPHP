<?php
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	$mysqli->query("SET NAMES utf8");
	
	require "Category.php";
	require_once "Event.php";
	
	echo Category::takeBirthdateCategory(6);
	
	 Event::addBirthdate('2012-06-29 00:00:00','Nbbssss','',4);
?>