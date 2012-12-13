<?php

include_once("/../../model/Appointment.php");
$appid = $_GET['appID'];

$app = new Appointment($appid);

// $query = "SELECT * FROM `appointment` where `id`='$appid'";
// $res = sqlExecQuery($query);
// $row = mysql_fetch_array($res);
if (!$app){
	echo "err:err";
}
else{
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	$size = $app->size;
	$cap = $app->capacity;
	echo $size.":".$cap;
}

?>