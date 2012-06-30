<?php
include_once "Event.php";

class Contact{
	private $name;
	private $familyname;
	private $emeil;
	private $birthdate;
	private $phone;
	private $note;
	
	private $userId;
	private $contactId;
	
	public function __construct($contactId, $userId, $name, $familyname = "липсва", 
		$emeil = "липсва", $birthdate = "липсва", $phone = "липсва", $note="липсва")
	{
		$this->setName($name);
		$this->setFamilyName($familyname);
		$this->setEmeil($emeil);
		$this->setBirthdate($birthdate);
		$this->setPhone($phone);
		$this->setNote($note);
		$this->setUserId($userId);
		$this->setContactId($contactId);
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setFamilyName($familyName)
	{
		$this->familyname = $familyName;
	}
	
	public function getFamilyName()
	{
		return $this->familyname;
	}
	
	public function setEmeil($emeil)
	{
		$this->emeil = $emeil;
	}
	
	public function getEmeil()
	{
		return $this->emeil;
	}
	
	public function setBirthdate($birthdate)
	{
		$this->birthdate = $birthdate;
	}
	
	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function setPhone($phone)
	{
		$this->phone = $phone;
	}
	
	public function getPhone()
	{
		return $this->phone;
	}
	public function setNote($note)
	{
		$this->note = $note;
	}
	
	public function getNote()
	{
		return $this->note;
	}
	protected function setUserId($userId)
	{
		$this->userId = $userId;
	}
	
	protected function getUserId()
	{
		return $this->userId;
	}
	
	protected function setContactId($contactId)
	{
		$this->contactId = $contactId;
	}
	
	protected function getContactId()
	{
		return $this->contactId;
	}
	

public function __toString(){
	return '
		<li class="boxElement" id="' . $this->contactId .'" class="contact">
			<div class="tape"></div>
			<div class="text">
			<div class="contactName" id="name-'.$this->contactId .'">' . $this->name .'</div>
			<div class="familyname" id="familyname-'. $this->contactId .'">' . $this->familyname . '</div>
			<div class="email" id="email-'. $this->contactId .'"> '. $this->emeil .'</div>
			<div class="birthdate" id="birthdate-'. $this->contactId.'"> '. $this->birthdate .'</div>
			<div class="phone" id="phone-'. $this->contactId .'">'. $this->phone .'</div>
			<div class="note" id="note-'. $this->contactId.'">'. $this->note .'</div>
			</div>
			<div class="line"></div>
			<div class="bg"></div>
			<div class="actions">
				<a href="#" class="delete">Delete</a>
			</div>
		</li>';
}

public static function edit($id, $field, $value)
{
	GLOBAL $mysqli;
	$value = self::esc($value);
	
	if(!$value) throw new Exception("Wrong update text!");
	
	$mysqli->query(" UPDATE Contacts SET `$field` = '$value' WHERE contactid='$id'");
	
}

public static function delete($id)
{	
	GLOBAL $mysqli;
	$eventParticipationQuery = "SELECT COUNT(`eventid`) FROM `ContactList` WHERE `contactid` = '$id'";
	if($result = $mysqli->query($eventParticipationQuery))
	{
		$row = $result->fetch_row();
		if($row[0] == 0)
		{
			$mysqli->query("DELETE FROM Contacts WHERE contactid='$id'");
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	
}

public static function createNew($params){
	$labels = '`'.implode('`,`', array_keys($params)).'`';
	
	foreach($params as $key=>$value)
	{
		$params[$key] = self::esc($value);
	}
	GLOBAL $mysqli;
	$params['birthdate'] = date('Y-m-d H:i:s', strtotime($params['birthdate']));
		
	$values = "'".implode("','", array_values($params))."'";
	$mysqli->query("INSERT INTO Contacts ($labels) values ($values) ");
			
	echo (new Contact($mysqli->insert_id, $params['userid'], $params['name'],
		$params['familyname'], $params['email'], $params['birthdate'], 
		$params['phone'], $params['note']));
		
		if(!empty($params['birthdate']))
		{
			Event::addBirthdate($params['birthdate'], $params['name'], $params['familyname'],$params['userid']);
		}
}

private static function esc($str)
{
	return mysql_real_escape_string(strip_tags($str));
}

}
?>