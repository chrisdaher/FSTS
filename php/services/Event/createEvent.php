<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include_once("/../../model/Event.php");
session_start();

$evId = $_SESSION['evId'];
if ($evId == 'new'){
	$ev = new Event(-1, false);
}
else{
	$ev = new Event($evId, false);
}

if ($_POST['end_date'] < date("Y-m-d")){
	$ev->closeEvent();
}
else{
	$ev->openEvent();
}

$ev->openEvent();
if($_POST['isOpen']=="on"){
	$ev->closeEvent();
}
$ev->start_date = $_POST['start_date'] . " 00:00";
$ev->end_date = $_POST['end_date'] . " 00:00";
$ev->event_type_id = $_POST['event_type'];
$ev->text = $_POST['text'];

if ($ev->update()){
	$id = $ev->event_id;
	header( 'Location: ../../../AssigningAppointments.php?EventID='.$id) ;
}
else{
	header( 'Location: ../../../AssigningAppointments.php?EventID=new') ;
}

?>