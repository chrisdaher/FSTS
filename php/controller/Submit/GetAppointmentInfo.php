<?php

include_once("/../../model/Appointment.php");
include_once("/../../model/File.php");
include_once("/../../model/FileInfo.php");
include_once("/../../model/User.php");
//include("/../../services/mysql/phpMySql.php");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$appID=$_GET['appID'];
//echo "ID #$appID<br/>";
$app = new Appointment($appID);

// $query = "SELECT * FROM `appointment` where `id` = '$appID'";
// $res = sqlExecQuery($query);
// $row = mysql_fetch_array($res);

$startDate = $app->start_date;
$endDate = $app->end_date;
$size = $app->size;
$capacity = $app->capacity;

print("<div id=\"appointmentMainInfo\">".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Start Date - </label><label class=\"lbl_appMainInfo_data\"> ".$startDate."</label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">End Date - </label><label class=\"lbl_appMainInfo_data\">".$endDate." </label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Capacity - </label><label class=\"lbl_appMainInfo_data\">".$capacity."</label></div>".
 "<div class=\"appMainInfoLine\"><label class=\"lbl_appMainInfo_field\">Current Size - </label><label id=\"app_info_size\" class=\"lbl_appMainInfo_data\">".$size."</label></div>".
 "<div class=\"appInfo_separator\">-----------------------</div>".
"</div>");
//get list of files
$files = array();
$cntr = 0;
//$query = "SELECT * FROM `event_user_linker` WHERE (`appointment_id`='$appID')";
$res = $app->getFilesInAppointment();

while ($row = mysql_fetch_array($res)){
	$files[$cntr] = $row['file_id'];
	$cntr++;
}

//INFO IS IN array files.
print("<table id=\"appointmentFilesInfo\">");
print("<thead><tr>
    <th>File ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th></th>
    </tr></thead>
    <tbody>");
for ($i = 0;$i<$cntr;$i++){
	
	
	// $query = "SELECT * FROM `file` WHERE `id`='$files[$i]'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	// //indep id
	// $indepid = $row['indepedent_id'];
	// $fileInfoId = $row['file_info_id'];
	// $query = "SELECT * FROM `user` WHERE `id`='$indepid'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	
	
	// $query = "SELECT * FROM `file_info` WHERE `id`='$fileInfoId'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	
	$file = new File($files[$i], false);
	
	$indepId = $file->independentId;
	$fileinfoId = $file->fileInfoId;
	
	$usr = new User($indepId, false);
	$firstName = $usr->first_name;
	$lastName = $usr->last_name;	
	
	
	$fileInfo = new FileInfo($fileinfoId);
	$addrCity = $fileInfo->addr_city;
	$addrProv = $fileInfo->addr_prov;
	$addrP = $fileInfo->addr_pcode;
	
	print(
       "<tr class=\"div_appInfo_file\" fileID=\"$files[$i]\">". 
        "<td id=\"att_FileID\">".$files[$i]."</td><td id=\"att_FirstName\">".$firstName."</td><td id=\"att_LastName\">".$lastName."</td><td id=\"att_City\">".$addrCity."</td><td id=\"att_Province\">".$addrProv."</td><td id=\"att_Pcode\">".$addrP."</td>".
        "<td id=\"att_buttons\"><button class=\"btn_removeFile\" fileID=\"$files[$i]\" appID=\"$appID\"></button>".
        "<button class=\"btn_editFile\" fileID=\"$files[$i]\"></button></td>".
        "</tr>"
    );
	
}
print("</tbody></table>");


?>