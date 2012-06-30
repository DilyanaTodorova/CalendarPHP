<?php
	include_once "Contact.php";
	
	$mysqli = new mysqli("localhost","root","root","WebCalendar");
	
	$id=$_GET['id'];
	
	if(Contact::delete($id))
	{
		echo '<div class="contactDeleteMessage">Контакта беше успешно премахнат</div>';
	}
	else
	{
		echo '<div class="contactDeleteMessage">Съжаляваме, но не може да изтриете контакта. Най-вероятно участва в някой от вашите събития</div>';
	}
	
	
	
	$mysqli->close();