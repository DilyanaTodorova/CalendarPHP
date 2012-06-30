<?php
class DataBase
{
	private static $mysqli;
	private $localhost = "localhost";
	private $username = "root";
	private $password = "root";
	private $databasename = "WebCalendar";
	
	private function __construct()
	{
		self::$mysqli = new mysqli($localhost, $username, $password, $databasename);
		self::$mysqli->query("SET NAMES utf8");
	}
	
	public function dbMakeQuery($query)
	{
		if(!isset(self::$mysqli))
		{
			$className = __CLASS__;
			self::$mysqli = new $className;
		}
		
		return self::$mysqli->query($query);
	}
	
	public function __clone()
	{
		trigger_error('Грешка не може да има повече от една инстанция на базата', E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Десериализацията е забранена', E_USER_ERROR);
	}
	
}
?>