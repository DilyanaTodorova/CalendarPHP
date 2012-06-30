<?php
	error_reporting(E_ALL);
	ini_set("display_errors", true);

	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	$mysqli->query("SET NAMES utf8");
	require 'Contact.php';
	session_start();

	if(!isset($_SESSION['username'])){
		die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
	}
	$userid = $_SESSION['userid'];
	$params = array("name" => $_POST['name'], "familyname" => $_POST['familyname'],
	'email' => $_POST['email'], 'birthdate' => $_POST['birthdate'], 'phone' => $_POST['phone'],
	'note' => $_POST['note'],'userid' => $userid);
	
	Contact::createNew($params);
	
?>