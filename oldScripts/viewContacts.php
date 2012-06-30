<?php
error_reporting(E_ALL);
session_start();

if(!isset($_SESSION['username'])){
	die('ERROR: You attemped to access a restricted page. Please <a href="login.php">log in</a>');
} else {
	$mysqli = new mysqli("localhost", "root", "root", "WebCalendar");
	if($mysqli == false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$userid = $_SESSION['userid'];
	$sql = "SELECT name, familyName, email, birthdate FROM Contacts WHERE userid = '$userid'";
	

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="utf8" lang="utf8">
	<head>
		<script type="text/javascript">
			function editContact(contactid){
				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
				} else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange = function(){
					xmlthhp.open("GET","editContact.php?contactid="+contactid,true);
					xmlhttp.send();
					window.location.reload();
				}
			}
			
			function deleteContact(contactid){
				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
				} else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange = function(){
					alert("Delete contact");
					xmlthhp.open("GET","deleteContact.php?contactid="+contactid,true);
					xmlhttp.send();
					window.location.reload();
				}
			}
		</script>
	</head>
	<body>
		<div id="content">
		<ul>
			<?php
				if($result = $mysqli->query($sql)){
					if($result->num_rows > 0){
						while($row = $result->fetch_assoc()){
							echo '<li>';
							echo '<input type="button" value="delete" onClick="deleteContact(' . $row['contactid'] . ')"/>';
							echo '<input type="button" value="edit" onClick="editContact(' . $row['contactid'] . ')"/>';
							echo '<br/>';
							echo 'Name: ' . '<input type="text" value="' . $row['name'] . '" />' .  '<br/>' ;
							echo 'Familyname: ' . '<input type="text" value="' . $row['familyname'] . '" />' .  '<br/>' ;
							echo 'email: ' . '<input type="text" value="' . $row['email'] . '" />' .  '<br/>' ;
							echo 'birthdate: ' . '<input type="text" value="' . $row['birthdate'] . '" />' .  '<br/>' ;
							echo 'phone: ' . '<input type="text" value="' . $row['phone'] . '" />' .  '<br/>' ;
							echo 'note: ' . '<textarea>' . $row['phone'] . '</textarea>' .  '<br/>' ;
							
							echo '</li>';
						}
					}
				}
			?>
			</ul>
		</div>
	</body>
</html>

<?php

$mysqli->close();
}
?>