<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include_once("/../../model/mysqlManager.php");
include_once("/../../model/Appointment.php");
include_once("/../../model/File.php");
	
    $fileID = $_GET["fileID"];
    $appID=$_GET['appID'];
	
	$mysql = new mysqlManager();
	$app = new Appointment($appID);
	//reduce size of app
	// $query = "SELECT * FROM `appointment` WHERE `id`='$appID'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	if ($app){
		$file = new File($fileID, true);
		$count = sizeof($file->dependents);
		$count++;
		$app->size-=$count;
		$app->update();
		
		// $query = "UPDATE `appointment` SET `size`='$currSize' WHERE `id`='$appID'";
		// $res = sqlExecQuery($query);
		
		//lets do it!?!?
		$unique = array("appointment_id"=>$appID, "file_id"=>$fileID);
		$mysql->createDeleteQuery($unique, "event_user_linker", true);
				
		echo $app->size;
	}
	else{
		echo "E";
	}
?>