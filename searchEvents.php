<?php
	session_start();

if(!isset($_SESSION['username'])){
	die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
}

$userid = $_SESSION['userid'];

$mysqli = new mysqli("localhost","root","root","WebCalendar");
$mysqli->query("SET NAMES utf8");

include_once "Event.php";

$params = array();
$params['userid'] = $userid;

if(!empty($_POST['startDate'])){
	$params['startDate'] = $_POST['startDate'];
}
if(!empty($_POST['endDate'])){
	$params['endDate'] = $_POST['endDate'];
}
if(!empty($_POST['contactName'])){
	$params['name'] = $_POST['contactName'];
}
if(!empty($_POST['contactFamilyname'])){
	$params['familyname'] = $_POST['contactFamilyname'];
}
if(!empty($_POST['categoryId'])){
	$params['categoryId'] = $_POST['categoryId'];
}
if(!empty($params['startDate']) || !empty($params['endDate']) || !empty($params['name']) || !empty($params['familyname']) || !empty($params['categoryId']))
{
	echo Event::search($params);
}
else
{
	echo "Няма намерени резултати";
}
?>

