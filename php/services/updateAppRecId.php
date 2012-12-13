<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	$appId = $_GET['appId'];
	$recId = $_GET['recId'];
	
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	
	
	
	$query = "UPDATE `appointment` SET `rec_id` = '$recId' WHERE `id`='$appId'";
	$res = sqlExecQuery($query);
	$row = mysql_fetch_array($res);
	echo json_encode($row);
		
?>