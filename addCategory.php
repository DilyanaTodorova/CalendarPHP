<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);
	session_start();

	if(!isset($_SESSION['username'])){
		die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
	}
	$userid = $_SESSION['userid'];
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	$mysqli->query("SET NAMES utf8");
	
	include_once "Category.php";
	
	$params = array();
	$params['userid'] = $userid;
	$params['type'] = $_POST['categoryType'];
	if(!(empty($_POST['colour'])))
	{
		$params['colour'] = $_POST['colour'];
	}
	
	Category::createNew($params);
	
	$mysqli->close();
?>