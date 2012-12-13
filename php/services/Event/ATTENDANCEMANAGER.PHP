<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	include_once("/../../model/mysqlManager.php");
	
	function setAttendance($isAttending, $fileId, $evid){
		$table_name = "event_attendance";
		$mysql = new mysqlManager();
		
		$unique = array("event_id"=>$evid, "file_id"=>$fileId);
	
		$res = $mysql->createSelectQuery($unique, $table_name, true);
		$row = mysql_fetch_array($res);
		if (!$row){
			//doesnt exist!
			$unique = array("event_id"=>$evid, "file_id"=>$fileId, "isAttending"=>$isAttending);
			$mysql->createInsertQuery($unique, $table_name, true, false);
			if ($mysql->error != null){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			//update
			$unique = array("event_id"=>$evid, "file_id"=>$fileId);
			$param = array("isAttending"=>$isAttending);
			$mysql->createUpdateQuery($unique, $param, $table_name, true);
			if ($mysql->error != null){
				return false;
			}
			else{
				return true;
			}
		}
	}
	
	function checkAttendance($evId, $fileId){
		$table_name = "event_attendance";
		$mysql = new mysqlManager();
		
		$unique = array("event_id"=>$evId, "file_id"=>$fileId);
	
		$res = $mysql->createSelectQuery($unique, $table_name, true);
		$row = mysql_fetch_array($res);
		
		if (!$row) return false;
		if ($row['isAttending'] == 0) return false;
		return true;
	}

?>