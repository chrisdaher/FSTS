<?php
$Appointments = array();



$evId = $_GET['EventID'];
//get the appointments
$query = "SELECT * FROM `appointment` where `event_id` = '$evId'";
$res = sqlExecQuery($query);
$cntr = 0;
while ($row = mysql_fetch_array($res)){
	$Appointments[$cntr] = $row;
	$cntr ++ ;
}
$AppointmentDay = "No appointments";
if ($cntr >0){
	$theDate = preg_split('/ /', $Appointments[0]['start_date']);
	$dateInfo = getDate(strtotime($theDate[0]));
	//the day
	$day = $dateInfo['mday'];
	$temp = strval($day);
	if(strlen ($temp) < 2){
		$temp = '0'.$temp;
	}

	if ($temp[1] == 1 && $temp[0]!=1){
		$day .= 'st';
	}
	elseif ($temp[1] == 2 && $temp[0]!=1){
		$day .= 'nd';
	}
	elseif ($temp[1] == 3 && $temp[0]!=1){
		$day .= 'rd';
	}
	else{
		$day .=  'th';
	}

	$AppointmentDay=$dateInfo['weekday'] . " " . $dateInfo['month'] . " " . $day . " " . $dateInfo['year']; //$theDate[0];
}

print"<div id=\"div_Calender\">";
print"<div id=\"lbl_AppointmentDay\">";
print($AppointmentDay);
print"</div>";
include("CalenderDiv/GetAppointments.php");
print"    </label>";
 print"</div>";

 
?>