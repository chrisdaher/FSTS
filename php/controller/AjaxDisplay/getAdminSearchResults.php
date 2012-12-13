<?php

$subFolder="..\\..\\view\\Components\\";
include_once($subFolder."AdminResult.php");
include_once("/../../model/Finders/IncludeAllFinders.php");
$search = $_GET["Search"];
$searchFrom = $_GET["From"];
$toRet="";
$results= array();
$Data=null;

$searchFrom = strtolower($searchFrom);
$isPostal = false;
$isIncomeLength = false;
if ($searchFrom == "maritalstatus"){
	$searchFrom = "marital";
}
else if ($searchFrom == "relationship"){
	$searchFrom = "contact";
}
else if ($searchFrom == "workstatus"){
	$searchFrom = "work";
}
else if ($searchFrom == "postalcode"){
	$isPostal = true;
}else if ($searchFrom == "incomelength"){
	$isIncomeLength = true;
}

$tableName = $searchFrom . "converter";

if ($searchFrom == "eventtype"){
	$tableName = "event_type";
}

if ($isPostal){
	$cf = new PostalCodeFinder();
	$gf = new GlobalFinder($cf);
	
	$key = $search;
	$isPostalCode = preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][A-Z]/', $key) || preg_match('/[abceghjklmnprstvxy][0-9][a-z]/', $key) ||
				preg_match('/[abceghjklmnprstvxy][0-9][A-Z]/', $key) || preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][a-z]/', $key);
				
	if ($isPostalCode){
		$sk = $cf->getSearchKeyByPostal($key);
		$res = $gf->find(array($sk), true);
	}
	else{
		$sk = $cf->getSearchKeyByCity($key);
		$res1 = $gf->find(array($sk), true);
        
		$sk = $cf->getSearchKeyByProvince($key);
		$res2 = $gf->find(array($sk), true);
		
		$res = array_merge($res1, $res2);
	}

}elseif ($isIncomeLength){

	$cf = new IncomeLengthFinder($tableName);
	$gf = new GlobalFinder($cf);
	$sk = $cf->getSearchKeyByName($search);
    
	$res = $gf->find(array($sk), true);
}else{
    $cf = new ConverterFinder($tableName);
	$gf = new GlobalFinder($cf);
	$sk = $cf->getSearchKeyByName($search);

	$res = $gf->find(array($sk), true);
}

// $results[0] = array("English");
// $results[1] = array("Married");
// $results[2] = array("Friend");
// $results[3] = array("Employed");
// $results[4] = array("H4R", "St-Laurent", "Quebec");
// $results[5] = array("English");
// $results[6] = array("Married");
// $results[7] = array("Friend");
// $results[8] = array("Employed");
// $results[9] = array("H4R", "St-Laurent", "Quebec");

for($i=0; $i<sizeof($res);$i++){

	if ($isPostal){
	   $conv = $res[$i];
		$pcode = $conv->pcode;
		$city = $conv->city;
		$prov = $conv->province;
		$Data[$i] = array($pcode, $city, $prov);
		
	}elseif($isIncomeLength){
        $conv = $res[$i];
		$incomeLength = $conv->name;
        $value = $conv->value;
		$Data[$i] = array($incomeLength, $value);
	}else{
        $conv = $res[$i];
		$name = $conv->name;
		$Data[$i] = array($name);
	}
}

if($Data==null){
   $toRet = '<tr class="noResults"><td>NO RESULTS.</td><tr>'; 
}else{
    for($i=0; $i<sizeof($Data);$i++){
		$conv = $res[$i];
		if ($isPostal){
			$id = $conv->pcode;
		}elseif($isIncomeLength){
		  $id = $conv->id;
		}
		else{
			$id = $conv->id;
		}
        $tempResult = new AdminResult($Data[$i], $searchFrom, $id);
        $toRet .= $tempResult->getContainer()->toHTML();
    }
}
echo $toRet;
?>