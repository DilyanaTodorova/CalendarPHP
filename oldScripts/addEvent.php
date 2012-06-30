<?php
error_reporting(E_ALL);
session_start();

if(!isset($_SESSION['username'])){
	die('ERROR: You attemped to access a restricted page. Please <a href="login.php">log in</a>');
} else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Add event</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="all" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
		<style type="text/css">
			#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }

			.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
			.ui-timepicker-div dl { text-align: left; }
			.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
			.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
			.ui-timepicker-div td { font-size: 90%; }
			.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
		</style>
		
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.startEvent').datetimepicker();
			});
		</script>
	
	</head>
	
	<body>
	<form id="addEvent" method="POST" action="addEvent.php">
		<input type="text" name="input_note" placeholder="New Event" />
		<br/>
		<input type="text" name="input_place" placeholder="e.g. Sofia" />
		<br/>
		<input type="text" name="input_start" id="chooseDateTime" placeholder="year-mm-dd tt" />
		<br/>
		<input type="submit" name="submit" value="DONE" class="button" />
		<input type="reset" name="reset" value="CLEAR" class="button" />
	</form>
	</body>
</html>

<?php

if(isset($_POST['submit']))
{
	$mysqli = new mysqli("localhost", "root", "root", "WebCalendar");
	$mysqli->query("SET NAMES utf8");
	if($mysqli === false){
		die("ERROR: Could not connect to database " . mysqli_connect_error());
	}
	
	$inputError = false;
	echo '<div id="error_message">';
	
	if(empty($_POST['input_note'])){
		$inputError = true;
		echo "ERROR: Invalid note";
	} else {
		$note = $mysqli->escape_string($_POST['input_note']);
	}

	if($inputError != true && empty($_POST['input_start'])){
		$inputError = true;
		echo "ERROR: Invalid start date";
	} else {
		$start = $mysqli->escape_string($_POST['input_start']);
		$start = date('Y-m-d H:i:s', strtotime($start));
	}
	
	
		$place = $mysqli->escape_string($_POST['input_place']);
		
		$username = $_SESSION['username'];
		$userid = $_SESSION['userid'];
		
		$categoryid = 1;
		
		$addEventQuery = "INSERT INTO Events ( start , place, 
			note, userid, categoryid ) VALUES ( '$start', '$place', 
			'$note', '$userid', '$categoryid')";
	
	if($mysqli->query($addEventQuery) === true){
		echo "Added new event " . $mysqli->insert_id;
	} else {
		echo "ERROR: Could not execute query " . $mysqli->error;
	}
	echo '</div>';
	
	$mysqli->close();
	}
}
?>