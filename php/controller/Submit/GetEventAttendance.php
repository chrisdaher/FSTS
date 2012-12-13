<?php
//get list of files
include_once("/../../model/Appointment.php");
include_once("/../../model/File.php");
include_once("/../../model/FileInfo.php");
include_once("/../../model/User.php");
include_once("/../../model/SearchManager.php");
include_once("/../../services/Event/AttendanceManager.php");

$eventID=$_GET['eventID'];
$searchKey="";
if(isset($_GET["searchString"])){
    $searchKey=$_GET['searchString'];
}

$event = new Event($eventID, false);
$files = $event->getRegisteredFiles();



if($searchKey!="" && strlen($searchKey) > 2){
	$fileFilled = array();
	$cntr = 0;
	for ($i=0;$i<sizeof($files);$i++){
		$fileFilled[$cntr] = new File($files[$i], false);
		$fileFilled[$cntr]->loadIndependent(false);
		$fileFilled[$cntr]->loadFileInfo(false);
		$cntr++;
	}
	$sp = new SearchManager($fileFilled);
	
	if (intval($searchKey) != 0){
		$files = $sp->searchById($searchKey);
	}
	else{
		$files = $sp->searchByName($searchKey);
		$files = array_merge($files, $sp->searchByPostalCode($searchKey));
		$files = array_merge($files, $sp->searchByStreetName($searchKey));
	}
	
	//check duplciate
	$tempArr = array();
	$cntr = 0;
	for ($i=0;$i<sizeof($files);$i++){
		if (!in_array($files[$i], $tempArr)){
			$tempArr[$cntr] = $files[$i];
			$cntr++;
		}
	}
	$files = $tempArr;
}
$cntr = 0;
//$query = "SELECT * FROM `event_user_linker` WHERE (`appointment_id`='$appID')";
$res;//$event->getFilesInAppointment();
/*
while ($row = mysql_fetch_array($res)){
	$files[$cntr] = $row['file_id'];
	$cntr++;
}
*/
//INFO IS IN array files.
print("<thead><tr>". 
        "<th>ID</th><th>First</th><th>Last</th><th>Street#</th><th>Street Name</th><th>P-Code</th>".
        "<th>Attendance</th>".
        "</tr></thead><tbody>
        ");
for ($i = 0;$i<sizeof($files);$i++){
	
	// $query = "SELECT * FROM `file` WHERE `id`='$files[$i]'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	// //indep id
	// $indepid = $row['indepedent_id'];
	// $fileInfoId = $row['file_info_id'];
	
	// $query = "SELECT * FROM `user` WHERE `id`='$indepid'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	// $firstName = $row['first_name'];
	// $lastName = $row['last_name'];
	
	// $query = "SELECT * FROM `file_info` WHERE `id`='$fileInfoId'";
	// $res = sqlExecQuery($query);
	// $row = mysql_fetch_array($res);
	// $addrNB = $row['addr_nb'];
	// $addrStreet = $row['addr_street'];
	// $addrP = $row['addr_pcode'];
	
	$file = new File($files[$i], false);
	
	$indepId = $file->independentId;
	$fileinfoId = $file->fileInfoId;
	
	$usr = new User($indepId, false);
	$firstName = $usr->first_name;
	$lastName = $usr->last_name;	
	
	
	$fileInfo = new FileInfo($fileinfoId);
	$addrNB = $fileInfo->addr_nb;
	$addrStreet = $fileInfo->addr_street;
	$addrP = $fileInfo->addr_pcode;
	
	$isAttending = checkAttendance($eventID, $files[$i]);
	if ($isAttending){
		print(
		   "<tr class=\"div_appInfo_file\" fileID=\"$files[$i]\">". 
			"<td class=\"att_FileID\">".$files[$i]."</td><td class=\"att_FirstName\">".$firstName."</td><td class=\"att_LastName\">".$lastName."</td><td class=\"att_Number\">".$addrNB."</td><td class=\"att_Street\">".$addrStreet."</td><td class=\"att_PCode\">".$addrP."</td>".
			"<td \"attendance\"><input type=\"checkbox\" checked=\"".$isAttending."\" class=\"btn_attendance\" id=\"btn_Attendance$files[$i]\" fileID=\"$files[$i]\" eventID=\"$eventID\"></input><label class=\"lbl_toggle\" for=\"btn_Attendance$files[$i]\"></label></td>".
			"</tr>"
		);
	}
	else{
		print(
		   "<tr class=\"div_appInfo_file\" fileID=\"$files[$i]\">". 
			"<td class=\"att_FileID\">".$files[$i]."</td><td class=\"att_FirstName\">".$firstName."</td><td class=\"att_LastName\">".$lastName."</td><td class=\"att_Number\">".$addrNB."</td><td class=\"att_Street\">".$addrStreet."</td><td class=\"att_PCode\">".$addrP."</td>".
			"<td \"attendance\"><input type=\"checkbox\" class=\"btn_attendance\" id=\"btn_Attendance$files[$i]\" fileID=\"$files[$i]\" eventID=\"$eventID\"></input><label class=\"lbl_toggle\" for=\"btn_Attendance$files[$i]\"></label></td>".
			"</tr>"
		);
	}
	
}
print("</tbody>");

?>