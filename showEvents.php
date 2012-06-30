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
	include_once 'Category.php';
	
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	$resultEvents = $mysqli->query("SELECT * FROM Events WHERE `userid` = '$userid'");
	$resultCategories = $mysqli->query("SELECT * FROM Categories WHERE `userid` = $userid");
	
	$events = array();
	
	while($rowEvent = $resultEvents->fetch_assoc()){
		$events[] = new Event($rowEvent);
	}
	
	$categories = array();
	
	while($rowCategory = $resultCategories->fetch_assoc()){
		$categories[] = new Category($rowCategory['categoryid'],
			$rowCategory['type'], $rowCategory['colour'], $rowCategory['userid']);
	}
?>
		
		<div id="categories">
			<ul id="categoriesList">
				<?php 
					foreach( $categories as $category){
						echo $category;
					}
				?>
			</ul>
			<a class="ff red" href="javascript::;" id="newCategory">+ категория</a>
		</div>
		<div id="todayEvents">
			<h3>Срещи за днес</h3>
			<?php 
				Event::getTodayEvents($userid);
			?>
		</div>
		
		<div id="events">
			<ul class="eventList">
				<h3>Всички срещи</h3>
				<?php 
					$elementCount = 1;
					foreach($events as $event)
					{	
						$elementCount++;
						echo $event;
						if($elementCount % 3 == 0)
							echo '<div style="clear:both;"></div>';
					}
					
				?>
			</ul>
			<div style="clear:both;"></div>
			<a class="ff red" id="addEventButton" href="#">+ събитие</a>
		</div>
		
		
		
	<script type="text/javascript" src="js/scriptEvents.js"></script>