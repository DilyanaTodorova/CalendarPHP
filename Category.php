<?php
class Category{

	private $categoryid;
	private $type;
	private $colour;
	private $userid;
	
	public function __construct($categoryid, $type, $colour, $userid){
		$this->setCategoryid($categoryid);
		$this->setType($type);
		$this->setColour($colour);
		$this->setUserid($userid);
	}
	
	protected function setCategoryid($data){
		$this->categoryid = $data;
	}
	
	protected function setUserid($userid){
		$this->userid = $userid;
	}
	
	public function setType($type){
		$this->type = $type;
	}
	
	public function setColour($colour){
		$this->colour = $colour;
	}
	
	
	
	public function __toString(){
		return '<li id="category-'. $this->categoryid.'" class="categoryItem">
			<div class="categoryType" id="type-'. $this->categoryid .'"> '. $this->type .'</div>
			<input type="hidden" name="colour-'. $this->categoryid .'" class="color-category" size="6" value='.$this->colour .'/>
			
			<div class="categoryActions">
				<a href="" class="deleteCategory">Delete</a>
			</div>
		</li>';
	}
	
	public static function edit($id, $field, $value){
		GLOBAL $mysqli;
		$value = self::esc($value);
		
		if(!$value) throw new Exseption("Wrong update text!");
		
		$mysqli->query("UPDATE Categories SET `$field` = '$value' WHERE categoryid = '$id'");
	}
	
	public static function delete($id){
		GLOBAL $mysqli;
		
		$mysqli->query("DELETE FROM Categories WHERE categoryid = '$id'");
	}
	
	public static function createNew($params){
		$labels = '`'.implode('`,`', array_keys($params)).'`';
		foreach($params as $key=>$value)
		{
			$params[$key] = self::esc($value);
		}
	GLOBAL $mysqli;
	
	$values = "'".implode("','", array_values($params))."'";
	$mysqli->query("INSERT INTO Categories ($labels) values ($values) ");
	
	echo (new Category($mysqli->insert_id, $params['type'], $params['colour'], $params['userid']));
	
	}
	
	public static function takeBirthdateCategory($userid)
	{
		GLOBAL $mysqli;
		$searchCategoryQuery = "SELECT COUNT(*) FROM `Categories` WHERE `type` = 'рожденни дни' and `userid` = '$userid'";
		if($result = $mysqli->query($searchCategoryQuery))
		{
			$row = $result->fetch_row();
			if($row[0] == 1)
			{	
				$takeCategoryQuery = "SELECT `categoryid` FROM `Categories` WHERE `type` = 'рожденни дни' AND `userid` = '$userid'";
				if($categoryResult = $mysqli->query($takeCategoryQuery))
				{
					 $category = $categoryResult->fetch_assoc();
					 return $category['categoryid'];
				}
				
			} 
			else
			{
				$createCategoryBirthdate = "INSERT INTO `Categories` (`userid`, `type`, `colour`) VALUES('$userid', 'рожденни дни', '#CE1A50')";
				$mysqli->query($createCategoryBirthdate);
				return $mysqli->insert_id;
			}
		}
	}
	private static function esc($str){
		return mysql_real_escape_string(strip_tags($str));
	}
}
?>