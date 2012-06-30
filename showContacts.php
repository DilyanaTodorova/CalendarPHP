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

include_once 'Contact.php';

	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	
$result = $mysqli->query("SELECT * FROM Contacts WHERE `userid` = '$userid'");

$contacts = array();

while($row = $result->fetch_assoc()){
	
	$contacts[] = new Contact($row['contactid'], $row['userid'], $row['name'], 
		$row['familyname'], $row['email'], $row['birthdate'], $row['phone'], 
		$row['note']);
}

?>
	<script type="text/javascript" src="js/scriptContacts.js"></script>
		<div id="contacts">
			<ul class="contactList">
				<?php 
					foreach($contacts as $contact){
						echo $contact;
					}
				?>
			</ul>
			<div style="clear:both;"></div>
			<a id="addContactButton" class="ff red" href="#">+ контакт</a>
		
