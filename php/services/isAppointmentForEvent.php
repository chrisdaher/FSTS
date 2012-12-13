<?php
	$appId = $_GET['appId'];
	$evId = $_GET['evId'];
	
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	$query = "SELECT * FROM `appointment` WHERE `id` = '$appId' ";
	$res = sqlExecQuery($query);
	$row = mysql_fetch_array($res);
	if ($row['event_id'] == $evId)
	{
		echo $appId . ":T";
	}
	else{
		echo $appId . ":F";
	}
		
?>