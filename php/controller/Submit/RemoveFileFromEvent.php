<?php
$fp = fopen("lock.txt", "a");
while (!flock($fp, LOCK_EX)){}
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("/../../services/mysql/phpMySql.php");
include_once("/../../model/mysqlManager.php");
include_once("/../../model/Appointment.php");
include_once("/../../model/File.php");

$fileID = $_GET["fileID"];
$evid = $_GET["eventId"];

	$mysql = new mysqlManager();
	
	$res = $mysql->createSelectQuery(array("event_id"=>$evid, "file_id"=>$fileID), "event_user_linker", true);
	$row = mysql_fetch_array($res);
	$appID = $row['appointment_id'];
	$app = new Appointment($appID);
	if ($app){
		$file = new File($fileID, true);
		$count = sizeof($file->dependents);
		$count++;
		$app->size-=$count;
		$app->update();
		
		$unique = array("appointment_id"=>$appID, "file_id"=>$fileID);
		$mysql->createDeleteQuery($unique, "event_user_linker", true);
		
		echo "";
	}
	else{
		echo "E";
	}
flock($fp, LOCK_UN); // release the lock
fclose($fp);
?>