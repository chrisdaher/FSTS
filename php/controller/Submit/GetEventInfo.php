<?php

include_once("/../../model/Appointment.php");
include_once("/../../model/FileInfo.php");
//include("/../../services/mysql/phpMySql.php");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$eventID=$_GET['eventID'];
//echo "ID #$appID<br/>";
$event = new Event($eventID, false);

// $query = "SELECT * FROM `appointment` where `id` = '$appID'";
// $res = sqlExecQuery($query);
// $row = mysql_fetch_array($res);

$startDate = $event->getStartDate();
$endDate = $event->getEndDate();
$size = $event->getCurrentEventSize();
$capacity = $event->getEventCapacity();
$subFolder="/../../view/Components/";
include_once($subFolder."SearchGroup_MiniBuilder.php");
$tempComponent = new html("div", "div_searchAttendance");
$tempSub = new SearchGroup_MiniBuilder("Search Here", "Attendance", false);
$tempComponent->addChild($tempSub->getContainer());

print("<div id=\"appointmentMainInfo\">".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Start Date - </label><label class=\"lbl_appMainInfo_data\"> ".$startDate."</label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">End Date - </label><label class=\"lbl_appMainInfo_data\">".$endDate." </label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Capacity - </label><label class=\"lbl_appMainInfo_data\">".$capacity."</label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Current Size - </label><label id=\"app_info_size\" class=\"lbl_appMainInfo_data\">".$size."</label></div>".
 "<div class=\"appInfo_separator\">----------------------------</div>".$tempComponent->toHTML().
"</div>");


print("<table id=\"appointmentFilesInfo\">");
include("GetEventAttendance.php");
print("</table>");


?>