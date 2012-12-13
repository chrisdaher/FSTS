<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	include_once("/../../model/Appointment.php");
	
	$id = $_GET['id'];
	$app = new Appointment($id);
	$app->deleteFlag = true;
	if ($app->update()){
		echo "S";
	}
	else{
		echo "E";
	}
	
?>