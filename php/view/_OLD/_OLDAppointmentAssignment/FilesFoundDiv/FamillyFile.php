<?php

$UserFoundId=$_GET['UserId'];

$tKey = strtoupper($key);
$keySplit = preg_split("/ /", $tKey);
//get file info
$query = "SELECT * FROM `user` WHERE `id` = '$UserFoundId'";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);

$arrayKeys = array_keys($row);

$tempRow = $row;
for ($i=0;$i<sizeof($arrayKeys);$i++){
	$temp = strtoupper($row[$arrayKeys[$i]]);
	for ($k = 0;$k<sizeof($keySplit);$k++){
		if ($keySplit[$k] != "" && strlen($keySplit[$k])>1){
			if (strpos($temp, $keySplit[$k]) === false){
			}
			else{
				$tempRow[$arrayKeys[$i]] = "<span class=results_found>".$row[$arrayKeys[$i]]."</span>";
			}
		}
	}
}

$FirstName=$tempRow['first_name'];
$LastName=$tempRow['last_name'];

$fileInfo = $row['family_id'];
logger("FAM ID FOUND ". $fileInfo);
$query = "SELECT * FROM `file` WHERE `id` = '$fileInfo'";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);

$userInId = $row['indepedent_id'];
logger("INDEP FOUND ". $userInId);
if ($userInId != $UserFoundId){
	$LastName .= '*';
}
$fileFoundInfo = $row['file_info_id'];
logger("FILE INFO FOUND ". $fileFoundInfo);
$query = "SELECT * FROM `file_info` WHERE `id` = '$fileFoundInfo'";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);
$tempRow = $row;
if ($row){
	$arrayKeys = array_keys($row);
	for ($i=0;$i<sizeof($arrayKeys);$i++){
		$temp = strtoupper($row[$arrayKeys[$i]]);
		for ($k = 0;$k<sizeof($keySplit);$k++){
			if ($keySplit[$k] != "" && strlen($keySplit[$k])>1){
				if (strpos($temp, $keySplit[$k]) === false){
				}
				else{
					$tempRow[$arrayKeys[$i]] = "<span class=results_found>".$row[$arrayKeys[$i]]."</span>";
				}
			}
		}
	}
}
$StreetNumber=$tempRow['addr_nb'];
$StreetName=$tempRow['addr_street'];
$City=$tempRow['addr_city'];
$Province=$tempRow['addr_prov'];
$PostalCode=$tempRow['addr_pcode'];

$EventID=$_GET["EventID"];


//check if file already registered
$query = "SELECT * FROM `event_user_linker` WHERE (`file_id` = '$fileInfo' AND `event_id` = '$EventID')";
$res = sqlExecQuery($query);
$row = mysql_fetch_array($res);
if ($row != null){
	$isDisabled = true;
}
else{
	$isDisabled=false;
}
$divClass="div_FileBlock";
if($isDisabled){
    $divClass="div_FileBlock added";
}
$toDisplayFileInfo = $fileInfo;

if ($fileInfo == $key){
	$toDisplayFileInfo = "<b>".$fileInfo."</b>";
}

$Adress=" $StreetNumber $StreetName $City <br/> $Province $PostalCode ";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    print("
        <div class=\"$divClass\" fileID=\"$fileInfo\" FirstName=\"$FirstName\" LastName=\"$LastName\" StreetNumber=\"$StreetNumber\" StreetName=\"$StreetName\" City=\"$City\" Province=\"$Province\" PostalCode=\"$PostalCode\" >
        File ID : $toDisplayFileInfo
        <br/>
        Name: $FirstName $LastName
        <br/>
        Adress: $Adress
        ");
        
    print("
        </div>
    ");
?>