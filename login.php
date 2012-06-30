<?php
	if(!isset($_POST['submit'])){
		$username = (isset($_COOKIE['name'])) ? $_COOKIE['name'] : '';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Login</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h2>Login</h2>
		<form method="POST" action="login.php">
			<label>Username</label>
			<input type="text" name="username" required="required" value="<?php echo $username; ?>"/>
			<br/>
			<label>Password</label>
			<input type="password" name="password" required="required"/>
			<br/>
			<input type="checkbox" name="sticky" checked >Remember me</input>
			<br/>
			<input type="submit" name="submit" value="Log In" />
		</form>
	</body>
</html>

<?php
} else {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//check input
	if(empty($username)) {
		die('ERROR: Please enter your username');
	}
	
	if(empty($password)){
		die('ERROR: Please enter a password');
	}
	
	
		$mysqli = new mysqli("localhost", "root", "root", "WebCalendar");
		
		if($mysqli === false){
			die("ERROR: Could not connect to the database");
		}
		
		$username = $mysqli->escape_string($username);
		$password = $mysqli->escape_string($password);
		
		$selectUserQuery = "SELECT userid FROM Users WHERE userName = '$username' AND password = '$password'";
				
		if($result = $mysqli->query($selectUserQuery)) {
				$row = $result->fetch_assoc();
				
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['userid'] = $row['userid'];
				
				if($_POST['sticky']){
					setcookie('name', $_POST['username'], time() + 60*60*24 );
				}
				header('Location: main.php');
		} else {
			echo "Error could not take your data";
		}
		
		$mysqli->close();
}

?>