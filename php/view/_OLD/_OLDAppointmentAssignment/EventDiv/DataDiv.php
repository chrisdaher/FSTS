<?php
$EventID=0;
if(!empty($_GET["EventID"])){
    $EventID=$_GET["EventID"];
}

//get the event info
include("/../../../services/mysql/phpMySql.php");	
include("/../../../services/mysql/dbSqlToText.php");	
$query = "SELECT * FROM `scheduler` WHERE `event_id` = '$EventID' ";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);

$EventName=$row['text'];
$EventType=EventTypeToString($row['event_type_id']);
$EventStartDate=$row['start_date'];
$EventEndDate=$row['end_date'];
$EventCapacity="Capacity";
$EventReccuring=$row['rec_type'];
$EventDetails="EXTRA SHYT";

if ($EventReccuring==""){
	$EventReccuring = "False";
}

$EventLabelClass="lbl_eventlabel";
$EventInfoClass="lbl_eventInfo";
$EventLabelID = array('lbl_EventName','lbl_EventType','lbl_EventStartDate','lbl_EventEndDate','lbl_EventCapacity','lbl_EventRecurring');
$EventLabel = array('Name','Type','Start Date','End Date','Capacity','Recurring');
$EventArray = array($EventName, $EventType, $EventStartDate, $EventEndDate, $EventCapacity, $EventReccuring);

$EventLine="";
print("
    <div id=\"div_Data\">
        ");
        for($i=0;$i<sizeof($EventArray);$i++){
            print("<div id=\"div_DataBox\">");
            $EventLine='<label class="'.$EventLabelClass.'">'.$EventLabel[$i].': </label><label class="'.$EventInfoClass.'" id="'.$EventLabelID[$i].'">'.$EventArray[$i].'</label>';
            print($EventLine);
            print("</div>");
           }
print("
    </div>
"); 


?>