<?php
$contactid = $_GET['contactid'];

$mysqli = new mysqli("localhost","root", "root", "WebCalendar");

$deleteContactQuery = "DELETE FROM Contacts WHERE contactid = '$contactid'"; 

$mysqli->query($deleteContactQuery);
$mysqli->close();
?>