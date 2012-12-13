<?php
	function validateId($id){
		$query = "SELECT * FROM `scheduler` where `event_id` = '$id'";
		$res = sqlExecQuery($query);
		$row = mysql_fetch_array($res);
		if ($row == null){ //error
			return false;
		}
		return true;
	}
?>