<?php
	$recId = $_GET['recId'];
	$newId = $_GET['newId'];
	
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	
	if ($recId !== ''){
		
		$query = "UPDATE `appointment` SET `event_id`='$newId' WHERE `rec_id`='$recId'";
		$res = sqlExecQuery($query);
		$query = "UPDATE `event_user_linker` SET `event_id`='$newId' WHERE `event_id` LIKE '%$recId'";
		$res = sqlExecQuery($query);
		echo json_encode("OK");
	}

?>