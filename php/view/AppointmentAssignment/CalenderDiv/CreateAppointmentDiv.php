<?php
$AppointID=$_GET['AppointmentID'];

//get appointment info
$query = "SELECT * FROM `appointment` where `id` = '$AppointID'";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);

$start_date = $row['start_date'];
$end_date = $row['end_date'];

$start_time = preg_split("/ /", $start_date);
$start_time = $start_time[1];

$end_time = preg_split("/ /", $end_date);
$end_time = $end_time[1];

//$StartTime=$AppointID*5;
//$Duration= 5;
//$EndTime=$StartTime+$Duration;

$StartTimeText=$start_time;
$EndTimeText=$end_time;

$size = $row['size'];
$cap = $row['capacity'];

print("
    <div class=\"div_AppointmentContainer\">
            <label class=\"lbl_StartTime\">$StartTimeText</label>
            <label class=\"lbl_EndTime\">$EndTimeText</label>
            <div class=\"div_AppOptions\" appID=\"$AppointID\">
                <button class=\"btn_AppInfo\" appID=\"$AppointID\"></button>
                <label class=\"lbl_AppCurrent\">$size</label>
                <label class=\"lbl_AppSep\">of</label>
                <label class=\"lbl_AppCap\">$cap</label>
            </div>
        <div class=\"div_AppointmentBox\" appointmentID=\"$AppointID\">

");

    
print("
        </div>
        
    </div>
");


?>