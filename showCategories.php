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
	
	include_once 'Category.php';
	
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
	$result = $mysqli->query("SELECT * FROM Categories WHERE `userid` = $userid");
	
	$categories = array();
	
	while($row = $result->fetch_assoc()){
		$categories[] = new Category($row['categoryid'],
			$row['type'], $row['colour'], $row['userid']);
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
</div>