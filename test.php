<?php
	include_once("/php/model/Event.php");
	include_once("/php/model/mysqlManager.php");
	
	$mysql = new mysqlManager();
	$res = $mysql->createSelectAll("scheduler", true);
	while ($row = mysql_fetch_array($res)){
		$ev = new Event($row['event_id'],true);
		$temp = $ev->text;
		$temp = preg_split("/ /", $temp);
		$temp = $temp[0];
		$ev->text = $temp;
		$ev->update();
		echo "Fixed $temp <br/>";
	}
?>