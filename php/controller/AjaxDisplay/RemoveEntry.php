<?php
include_once("/../../services/admin/adminServices.php");

$id = $_GET["id"];
$section = $_GET["Section"];

$section = strtolower($section);
$isPostal = false;
if ($section == "maritalstatus"){
	$section = "marital";
}
else if ($section == "relationship"){
	$section = "contact";
}
else if ($section == "workstatus"){
	$section = "work";
}
else if ($section == "postalcode"){
	$isPostal = true;
}
$tableName = $section . "converter";

if ($section == "eventtype"){
	$tableName = "event_type";
}

if (!$isPostal){

	removeRowFromConverter($id, $tableName);
}else{
	removeRowFromConverterPcode($id, $tableName);
}

echo "success";
?>