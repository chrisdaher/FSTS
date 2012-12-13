<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	include("mysql/phpMySql.php");	
	include("mysql/dbSqlToText.php");	
	$query = "SElECT * FROM `event_type`";
	$res = sqlExecQuery($query);
	$rows = array();
	while($r = mysql_fetch_assoc($res)) {
		$rows[] = $r;
	}
	echo json_encode($rows);
	
?>