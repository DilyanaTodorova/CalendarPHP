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
	
	include_once "Event.php";
	$params = array();
	$params['start'] = $_POST['start'];
	$params['place'] = $_POST['place'];
	$params['note'] = $_POST['note'];
	
	if(!empty($_POST['categoryId']))
	{
		$params['categoryId'] = $_POST['categoryId'];
	}
	$params['userid'] = $userid;
	$contacts = array();
	if(isset($_POST['contacts']))
	{
		$contacts = $_POST['contacts'];
	}
	
	Event::createNew($params);
	Event::addContactsToEvent($mysqli->insert_id,$contacts);
?>