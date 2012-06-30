<?php
include_once "Category.php";
class Event{
	protected $start;
	protected $place;
	protected $note;
	protected $userid;
	protected $eventid;
	protected $categoryid;
	
	public function __construct($params)
	{
		foreach($params as $field => $value)
		{
			if(property_exists($this, $field))
			{
				$this->{"set$field"}($value);
			}
			
		}
		
	}
	
	public function setStart($start)
	{	
	
		$this->start = date('Y-m-d H:i:s', strtotime($start));
	}
	
	public function getStart()
	{
		return $this->start;
	}
	
	public function setPlace($place)
	{
		$this->place = $place;
	}
	
	public function getPlace()
	{
		return $this->place;
	}
	
	public function setNote($note)
	{
		$this->note = $note;
	}
	
	public function getNote()
	{
		return $this->note;
	}
	
	protected function setEventId($eventid)
	{
		$this->eventid = $eventid;
	}
	
	protected function getEventid()
	{
		return $this->eventid;
	}
	
	protected function getCategoryid()
	{
		return $this->categoryid;
	}
	
	protected function setCategoryid($categoryid)
	{
		$this->categoryid = $categoryid;
	}
	
	public function getCategory()
	{
		GLOBAL $mysqli;
		$takeCategoryNameQuery = "SELECT type FROM Categories where `categoryid` = '$this->categoryid'";
		$result = $mysqli->query($takeCategoryNameQuery);
		$category = $result->fetch_assoc();
		
		return $category['type'];
	}
	
	protected function getCategoryColour()
	{
		GLOBAL $mysqli;
		$takeCategoryNameQuery = "SELECT colour FROM Categories where `categoryid` = '$this->categoryid'";
		$result = $mysqli->query($takeCategoryNameQuery);
		$category = $result->fetch_assoc();
		
		return $category['colour'];
	}
	protected function setUserId($userid)
	{
		$this->userid = $userid;
	}
	
	protected function getUserid()
	{
		return $this->userid;
	}
	
	public function __toString()
	{
		return '<li class="boxElement" id="event-'. $this->getEventid() .'" '.' " style="background-color:'. $this->getCategoryColour() .'""> 
			<div class="tape"></div>
			<div class="text">
			<div class="noteEvent" id="note-'. $this->eventid.'"> '. $this->note .'</div>
			<div class="startEvent" id="start-'.$this->eventid.'">'. $this->start .'</div>
			<div class="placeEvent" id="place-'.$this->eventid.'"> '. $this->place.'</div>
			<div class="categoryEvent" id="category-'. $this->eventid .'"> '. $this->getCategory()  .'</div>
			<div class="contacts">'.$this->takeContacts($this->eventid) .' </div>
			</div>
			<div class="line"></div>
			<div class="bg"></div>
			<div class="actionsEvent">
				<a href="" class="deleteEvent">delete</a>
			</div>
		</li>' ;
	}
	public static function addBirthdate($birthdate, $name, $familyname, $userid)
	{
		$message = 'Да поздравя ' . $name . ' ' . $familyname;
		$date = strtotime($birthdate);
		$date = $date - 24 * 60 * 60 + 10 * 60;
		$date = (date("Y-m-d", $date));
		GLOBAL $mysqli;
		$categoryid = Category::takeBirthdateCategory($userid); 
		$addBirthdateQuery = "INSERT INTO `Events` (`start`,`note`,`userid`,`categoryid`) VALUES ('$birthdate', '$message', '$userid', '$categoryid')";
		$mysqli->query($addBirthdateQuery);
		
		
	}
	public static function createNew($params){
		$labels = '`'.implode('`,`', array_keys($params)).'`';
	
		foreach($params as $key=>$value)
		{
			$params[$key] = self::esc($value);
		}
		GLOBAL $mysqli;
		$params['start'] = date('Y-m-d H:i:s', strtotime($params['start']));
		
		$values = "'".implode("','", array_values($params))."'";
		$mysqli->query("INSERT INTO Events ($labels) values ($values) ");
		$params['eventid'] = $mysqli->insert_id;
		echo (new Event($params));
	}
	
	public static function delete($id){
		GLOBAL $mysqli;
		$mysqli->query("DELETE FROM Events WHERE eventid = '$id'");
	} 
	
	public static function edit($id, $field, $value)
	{
		GLOBAL $mysqli;
		$value = self::esc($value);
		
		if(!$value) throw new Exception("Wrong value to update");
		
		$mysqli->query("UPDATE Events SET `$field` = '$value' WHERE eventid='$id'");
	}
	
	public static function getTodayEvents($id){
		GLOBAL $mysqli;
		$today = date('Y-m-d');
		$todayEventsQuery = "SELECT * FROM Events WHERE `start` > '$today'";
		
		$todayEvents = array();
		$result = $mysqli->query($todayEventsQuery);
		
		while($row = $result->fetch_assoc()){
			$todayEvents[] = (new Event($row));
		}
		
		 foreach($todayEvents as $event){
			echo $event;
		}
	}
	
	public static function addContactsToEvent($eventid, $contacts)
	{
		GLOBAL $mysqli;
		foreach($contacts as $contact){
			$mysqli->query("INSERT INTO ContactList (`eventid`, `contactid`) VALUES ('$eventid', '$contact')");
		}
		
	}
	
	public static function takeContacts($eventid)
	{
		GLOBAL $mysqli;
		$takeContactsQuery = "
		SELECT `Contacts`.`name`, `Contacts`.`familyname`, `Contacts`.`note` 
		FROM Contacts inner join ContactList ON  `Contacts`.`contactid` = `ContactList`.`contactid` 
		WHERE `ContactList`.`eventid` = '$eventid'";
		
		$contactsString = '';
		if($result = $mysqli->query($takeContactsQuery))
		{
			
			if($result->num_rows != 0)
			{
				$contactsString .= 'Заедно със ';
			}
			while($row = $result->fetch_assoc())
			{
				 $contactsString .= $row['name'] . " " . $row['familyname'] . '<br/>' . $row['note'] . '<br/>';
			}
		}
		
		return $contactsString;
	}
	private static function searchByStartDate($startDate)
	{
		return "`Events`.`start` >  '$startDate'";
	}
	private static function searchByEndDate($endDate)
	{
		return " `Events`.`start` <  '$endDate' ";
	}
	private static function searchByName($name)
	{
		$name = '%' . $name . '%';
		return "`Contacts`.`name` LIKE  '$name'";
	}
	private static function searchByFamilyname($familyname)
	{
		$familyname = '%' . $familyname . '%';
		return "`Contacts`.`familyname` LIKE  '$familyname'";
	}
	private static function searchByCategoryid($categoryid)
	{
		return "`Contacts`.`categoryid` = '$categoryid'";
	}
	public static function search($params)
	{
		GLOBAL $mysqli;
		$contactName = '%' . $contactName . '%';
		$contactFamilyName = '%' . $contactFamilyName . '%';
		
		$searchQuery = "SELECT `Events`.`eventid`, `Events`.`start`, `Events`.`place`, `Events`.`note`, `Events`.`categoryid`
						FROM  `Events` 
						INNER JOIN  `ContactList` ON  `Events`.`eventid` =  `ContactList`.`eventid` 
						INNER JOIN  `Contacts` ON  `Contacts`.`contactid` =  `ContactList`.`contactid` 
						WHERE  `Events`.`start` >  '$startDate'
						AND  `Events`.`start` <  '$endDate'
						AND  `Contacts`.`name` LIKE  '$contactName'
						AND `Events`.`categoryid` = '$categoryid'";
	
		$query =  "SELECT `Events`.`eventid`, `Events`.`start`, `Events`.`place`, `Events`.`note`, `Events`.`categoryid`
						FROM  `Events` 
						INNER JOIN  `ContactList` ON  `Events`.`eventid` =  `ContactList`.`eventid` 
						INNER JOIN  `Contacts` ON  `Contacts`.`contactid` =  `ContactList`.`contactid` WHERE `Events`.`userid` = $params[userid] AND ";
		$conditions = array();				
		foreach($params as $searchField => $searchValue)
		{
			if(method_exists(__CLASS__,"searchBy{$searchField}"))
			{
				$conditions[] = call_user_func(array(__CLASS__,"searchBy{$searchField}"),$searchValue);
			}
		}
		$query .= implode(" AND ",$conditions);
		echo "search query " . $query;
		if($result = $mysqli->query($query))
		{
			if($result->num_rows != 0)
			{
				while($row = $result->fetch_assoc())
				{
					echo (new Event($row));
				}
			}
			else
			{
				echo "Няма събития отговарящи на зададените от вас критерии";
			}
		}
		
	}
	private static function esc($str)
	{
		return mysql_real_escape_string(strip_tags($str));
	}
}
?>