<?php
if(!isset($_POST['submit'])){
		$username = (isset($_COOKIE['name'])) ? $_COOKIE['name'] : '';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Login</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/loginStyle.css" />
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/loginScript.js"></script>
	</head>
	<body>
		<div id="emptyHeader">&nbsp;</div>
		<div id="wrapper">
			<div id="left">
				<div class="content">
					<h1>Добре дошли!</h1>
					<p>Уеб календар 2.0 служи да събирате дигитална информация за вашите срещи и контакти. Сайтът е с лек дизайн, няма никакви излишни менюта - само това, което ви е необходимо за да запазвате вашите предстоящи срещи.</p>
					<p>Ще се радваме ако се присъедините към нашата услуга. Регистрирайте се още сега, ако вече не сте го направили.</p>
				</div>
				<div class="imageCalendar"><img src="images/calendar.png" width="300px"></div>
			</div>
			<div id="rigth">
				<div id="tabbox">
					<a href="#" id="signup" class="tab signup">Регистрация</a>
					<a href="#" id="login" class="tab select">Вписване</a>
				</div>
				<div id="panel">
					<div id="loginbox">
						<h2>Вход</h2>
						<form method="POST" action="index.php">
							<label>Потребителско име:</label>
							<input type="text" name="username" required value="<?php echo $username; ?>"/>
							<br/>
							<label>Парола:</label>
							<input type="password" name="password" required />
							<br/>
							<input type="checkbox" name="sticky" checked >Запомни ме</input>
							<br/>
							<input type="submit" name="submit" value="Log In" />
						</form>
					</div>
					<div id="signupbox">
						<h3>Регистрация</h3>
						<form id="login" action="register.php" method="POST">
							<label>Потребителско име:</label>
							<input type="text" name="input_username" />
							<br/>
							<label>Парола:</label>
							<input type="password" name="input_password" />
							</br>
							<label>Повторете паролата си:</label>
							<input type="password" name="confirm_password" />
							<br/>
							<label>Електронен адрес:</label>
							<input type="text" name="input_email" />
							<br/>
							<input type="submit" name="submit" value="Submit" />
							</form>
					</div>
				</div>
			</div>
			<div id="footer">
				Създадено от Диляна Тодорова
			</div>
		</div>
	</body>
</html><?php
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