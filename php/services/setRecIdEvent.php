<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	$oldId = $_GET['oldId'];
	$newId = $_GET['newId'];
	
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	
	$query = "INSERT INTO `event_rec` (`event_id`, `rec_id`) VALUES ('$oldId', '$newId')";
	$res = sqlExecQuery($query);
	echo json_encode("OK");

?>