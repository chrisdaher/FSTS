<?php

$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."AdminResult.php");
include_once("/../../services/admin/adminServices.php");
$section = $_GET["Section"];
$id = $_GET["id"];
$textArray = array();
$i=0;

while(true){
	if(!isset($_GET["text".$i])){
		break;
	}

	$textArray[$i]= $_GET["text".$i];
	$i++;

}

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


if(sizeof($textArray)>0){
	$tempResult = new AdminResult($textArray, $section, $id, true);
}else{
	if ($isPostal){
		$Data = $textArray;
	}else{
		$Data= array($textArray[0]);
	}
	$tempResult = new AdminResult($Data, $section, $id);
}

$container = $tempResult->getContainer()->getChildren();

$toRet = "";
for($i=0;$i<sizeof($container);$i++){
    $toRet .= $container[$i]->toHTML();
}
echo $toRet;
?>