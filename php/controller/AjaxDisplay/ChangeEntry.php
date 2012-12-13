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
$isIncomeLength = false;
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
else if ($section == "incomelength"){
	$isIncomeLength = true;
}
$tableName = $section . "converter";

if ($section == "eventtype"){
	$tableName = "event_type";
}

if (!$isPostal && !$isIncomeLength){
	if ($id == -1){ //new file{
		$id = addRowToConverter($textArray[0], $tableName);
	}
	else{
		updateRowToConverter($id, $textArray[0], $tableName);
	}
}elseif($isIncomeLength){
    $incomeLength = $textArray[0];
	$value = $textArray[1];

	if ($id == -1){
		$id = addRowToConverterIncomeLength($incomeLength, $value, $tableName);
	}
	else{
		$res = getConverterDataJSON($tableName);
		$res = json_decode($res);
		$res = array_keys($res);
		
		if (in_array($incomeLength, $res)){
			updateRowToConverterIncomeLength($id, $incomeLength, $value, $tableName);
		}
		else{
			$id = addRowToConverterIncomeLength($incomeLength, $value, $tableName);
		}	
	}
}else{
	$pcode = $textArray[0];
	$city = $textArray[1];
	$prov = $textArray[2];
	if ($id == -1){
		$id = addRowToConverterPcode($pcode, $city, $prov, $tableName);
		
		if ($id == -1){
			$textArray[0] = "ERROR";
			$textArray[1] = "Postal Code";
			$textArray[2] = "Already exist!";
		}		
		else{
			$id = $pcode;
		}
	}
	else{
		$res = getConverterDataJSON($tableName);
		$res = json_decode($res);
		$res = array_keys($res);
		
		if (in_array($pcode, $res)){
			updateRowToConverterPcode($pcode, $city, $prov, $tableName);
		}
		else{
			$id = addRowToConverterPcode($pcode, $city, $prov, $tableName);
			if ($id == -1){
				$textArray[0] = "ERROR";
				$textArray[1] = "Postal Code";
				$textArray[2] = "Already exist!";
			}
		}	
	}
	
}

if(sizeof($textArray)>0){
	$tempResult = new AdminResult($textArray, $section, $id);
}

$container = $tempResult->getContainer()->getChildren();

$toRet = "";
for($i=0;$i<sizeof($container);$i++){
    $toRet .= $container[$i]->toHTML();
}
echo $id."::".$toRet;
?>