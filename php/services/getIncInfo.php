<?php
	include_once("/../model/Income.php");
	include_once("/../model/User.php");
	
	session_start();
	$userId = $_GET['id'];
	
	$_SESSION['incId'] = $userId;
	
	$inc = new Income($userId);
	$usr = new User($inc->user_id, false);
	
	$row = array("person"=>$usr->id, "type"=>$inc->income_type_id, 
				"mode"=>$inc->income_length_id, "sDate"=>$inc->start_date, "eDate"=>$inc->end_date, "incVal"=>$inc->value);
	echo json_encode($row);

	
	
?>