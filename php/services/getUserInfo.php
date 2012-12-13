<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	session_start();
	$userId = $_GET['id'];
	$_SESSION['depId'] = $userId;
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	$res = selectWhereQuery("user", "id", $userId);
	$row = mysql_fetch_array($res);
	$row['gender'] = GenderToString($row['gender']);
	echo json_encode($row);
	
?>