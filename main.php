<?php
session_start();

if(!isset($_SESSION['username'])){
	die('Грешка: Опитвате се да влезете страница за която не сте ауторизиран. Моля влезнете в профила си <a href="login.php">вход</a>');
}

$userid = $_SESSION['userid'];

$mysqli = new mysqli("localhost","root","root","WebCalendar");
$mysqli->query("SET NAMES utf8");

?><!DOCTYPE html>
<html>
	<head>
		<title>Welcome</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/mainStyle.css" />
		<link rel="stylesheet" media="all" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
		<link type="text/css" rel="stylesheet" href="css/jquery.miniColors.css" />
		
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
		<script type="text/javascript" src="js/editable.js"></script>
		<script type="text/javascript" src="js/getContent.js"></script>
		<script type="text/javascript" src="js/jquery.miniColors.js"></script>
		
		<style type="text/css">
			#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }

			.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
			.ui-timepicker-div dl { text-align: left; }
			.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
			.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
			.ui-timepicker-div td { font-size: 90%; }
			.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
		</style>
	</head>
	<body>
		<div class="emptyHeader">
			
		</div>
		<div id="wrapper">
		<h1>Уеб Календар 2.0</h1>
		<div class="tabbox">
				
				<a href="#events" class="tab select" id="eventsTab"><span>Събития</span></a>
				<a href="#contacts" class="tab unselect" id="contactsTab"><span>Контакти</span></a>
				<a href="#search" class="tab unselect" id="searchTab"><span>Търсене</span></a>
				<a href="logout.php" id="logout" class="tab unselect">Изход</a>
			
		</div>
		<div id="panel">
			Здравей, моля избери си някой от табовете.
		</div>
		</div>
	</body>
</html>