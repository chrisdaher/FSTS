<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	$id = $_GET['id'];
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	$query = "SELECT * FROM `scheduler` WHERE `event_id` = '$id' ";
	$res = sqlExecQuery($query);
	$row = mysql_fetch_array($res);
	echo json_encode($row);
		
?>