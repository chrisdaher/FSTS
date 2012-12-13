<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	include_once("/../../model/Appointment.php");
	
	$start_date = $_GET['startDate'];
	$end_date = $_GET['endDate'];
	$cap = $_GET['cap'];
	$evId = $_GET['evId'];
	$appId = $_GET['appId'];
	
	$app = new Appointment($appId);
	
	$app->start_date = $start_date;
	$app->end_date = $end_date;
	$app->capacity = $cap;
	$app->event_id = $evId;
	
	if ($app->update()){
		echo $app->id;
	}
	else{
		echo "ERROR";
	}

?>