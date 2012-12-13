<?php
include_once("../../view/Components/EventInfoForm.php");
$AppointID=$_GET['appID'];
$EventID = $_GET['eventID'];

$Appointments = new EventInfoForm($EventID, $AppointID);
$toRet = $Appointments->getAppInfo();

echo $toRet->toHTML();


/*
//get appointment info
$Appointment = new Appointment($AppointID);
$start_date = $Appointment->start_date;
$end_date = $Appointment->end_date;

$start_time = preg_split("/ /", $start_date);
$start_time = $start_time[1];

$end_time = preg_split("/ /", $end_date);
$end_time = $end_time[1];

$start_date = preg_split("/ /", $start_date);
$start_date = $start_date[0];
$end_date = preg_split("/ /", $end_date);
$end_date = $end_date[0];

$capacity = $Appointment->capacity;
$size = $Appointment->size;




print("
        <form class=\"div_AppointmentBoxEdit\" appointmentID=\"$AppointID\">
            <div class=\"div_date\">
                <input type=\"text\" class=\"lbl_StartDateEdit\" name=\"startDate\" value=\"$start_date\"/>
                <input type=\"text\" class=\"lbl_EndDateEdit\" name=\"endDate\" value=\"$end_date\"/>
            </div>
            <div class=\"div_time\">
                <input type=\"text\" class=\"lbl_StartTimeEdit\" name=\"startTime\" value=\"$start_time\"/>
                <input type=\"text\" class=\"lbl_EndTimeEdit\" name=\"endTime\" value=\"$end_time\"/>
            </div>
            
            <div class=\"div_size\">
                <input type=\"text\" class=\"lbl_AppSize\" name=\"appSize\" value=\"$size\"/>
                <input type=\"text\" class=\"lbl_AppCap\" name=\"appCap\" value=\"$capacity\"/>
            </div>

");

    
print("
        </form>
        <div class=\"div_AppOptionsEdit\" appid=\"$AppointID\">
            <button class=\"btn_AppCurrentDelete\" appid=\"$AppointID\"></button>
            <button class=\"btn_AppCurrentCancel\" appid=\"$AppointID\"></button>
            <button class=\"btn_AppCurrentDone\" appid=\"$AppointID\"></button>
        </div>
");
*/
?>