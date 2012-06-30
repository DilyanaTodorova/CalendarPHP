<?php
$id = $_GET['id'];

try{
	switch($_GET['action']){
		case 'delete': Contact::delete($id);
		break;
		
		case 'edit': Contact::edit($id, $_GET['field'], $_GET['value']);
		break;
		
		case 'new': Contact::createNew($_GET['value']);
		break;
	}
}
catch(Exception $e){
	die("0");
}

echo "1";
?>