<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	session_start();

	if(!isset($_SESSION['username'])){
		die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
	}

	$userid = $_SESSION['userid'];
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	require 'Category.php';
	
	
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	$result = $mysqli->query("SELECT * FROM Categories WHERE `userid` = '$userid'");
	
	$categories = array();
	
	$category_params['categoryid'] = '';
	$category_params['type'] = 'null category';
	$category_params['colour'] = '#323232';
		
	array_push($categories, $category_params);
	while($row = $result->fetch_assoc()){
		$category_params['categoryid'] = $row['categoryid'];
		$category_params['type'] = $row['type'];
		$category_params['colour'] = $row['colour'];
		
		array_push($categories, $category_params);
	}
	
	echo json_encode($categories);
?>