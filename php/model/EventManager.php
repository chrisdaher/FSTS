<?php
	include_once("mysqlManager.php");
	include_once("Event.php");
	function getNextEvents($days){
		$mysql = new mysqlManager();
		$tableName = "scheduler";
		$query = $mysql->createSelectAll($tableName, false);
		$query .= " ORDER BY `start_date` LIMIT 0,$days";
		$res = $mysql->executeQuery($query, false);
		
		$toRet = array();
		$cntr = 0;
		while ($row = mysql_fetch_array($res)){
			$id = $row['event_id'];
			$toRet[$cntr] = new Event($id,false);
			$cntr++;
		}
		return $toRet;
	}

?>