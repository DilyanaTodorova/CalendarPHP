<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", true);

$mysqli = new mysqli("localhost","root","root","WebCalendar");
$userid = $_SESSION['userid'];

include_once "Event.php";
$myArray = array(69);
Event::addContactsToEvent(118,$myArray);
Event::takeContacts(118);
?>