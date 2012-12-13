<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
$DEFAULT_MAX_NB_FILES = 15;
$MaxNumberOfFiles=$DEFAULT_MAX_NB_FILES;//12 would probly be the max number of files that would fit in the div
$FileIDs = array();//to be provided with an array of FileIDs that were found

$searchBy = $_GET["SearchBy"];

$key = $_GET['key'];
$isPostalCode = preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][A-Z]/', $key) || preg_match('/[abceghjklmnprstvxy][0-9][a-z]/', $key) ||
				preg_match('/[abceghjklmnprstvxy][0-9][A-Z]/', $key) || preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][a-z]/', $key);
$isMedicard = preg_match('/\D{4}\s?\d{4}\s?\d{4}/', $key) || preg_match('/\D{4}?\d{4}?\d{4}/', $key);
include_once("/../../services/mysql/phpMySql.php");	
include_once("/../../services/mysql/dbSqlToText.php");	
include_once("/../../model/Finders/IncludeAllFinders.php");
$currIds = array();
$ff = new FileFinder();
$uf = new UserFinder();
$if = new FileInfoFinder();
$gf = new GlobalFinder($ff);
if ($searchBy == 'File'){
	$data = preg_split("/ /",$key);
	if ($key != ""){
		//check if key is an ID
		$id = intval($key);
		if ($isMedicard){
			$gf->setFinder($uf);
			
			$sk = $uf->getSearchKeyByMedicard($key);
			$res = $gf->find(array($sk), false);
			
			$cntr = 0;
			
			for ($i = 0;$i<sizeof($res);$i++){
				$usr = $res[$i];
				$id = $usr->family_id;
								
				$FileIDs[$cntr] = $id;
				$cntr++;
			}
					
			if (preg_match('/[ ]/i', $key)){
				
				$newMedi = str_replace (" ", "", $key);
				
				$sk = $uf->getSearchKeyByMedicard($newMedi);
				$res = $gf->find(array($sk), false);
			
				for ($i = 0;$i<sizeof($res);$i++){
					$usr = $res[$i];
					$id = $usr->family_id;
					$FileIDs[$cntr] = $id;
					$cntr++;
				}
				
			}
			else{
				$newMedi = str_replace (" ", "", $key);
				$temp = substr($newMedi, 0,4);
				$temp.= " " .substr($newMedi,4,4);
				$temp.=" " . substr($newMedi,8,8);
				$newMedi = $temp;
				
				$sk = $uf->getSearchKeyByMedicard($newMedi);
				$res = $gf->find(array($sk), false);
			
				for ($i = 0;$i<sizeof($res);$i++){
					$usr = $res[$i];
					$id = $usr->family_id;
					$FileIDs[$cntr] = $id;
					$cntr++;
				}
			}
			
		
		}
		
		else if ($isPostalCode){ //postal code
			$gf->setFinder($if);
			$key = strtoupper($key);
			
			$sk = $if->getSearchKeyByAddrPcode($key);
			$res = $gf->find(array($sk), true);
			$cntr = 0;
			
			for ($i=0;$i<sizeof($res);$i++){
				
				$fileInfo = $res[$i];
				$fileId = $fileInfo->getFamilyId();
				$file = new File($fileId, false);
				$userId = $file->id;
			
				$FileIDs[$cntr] = $userId;
				$cntr++;			
			}
		
		}
		else{
			if ($id != 0 && sizeof($data) == 1){ //an id!{
				$gf->setFinder($ff);
				$sk = $ff->getSearchKeyById($id);
				$res = $gf->find(array($sk), false);
				if (sizeof($res) > 0){
					$file = $res[0];
					$FileIDs[0] = $file->id;
				}
				
			}
			else{ //not id!
				if (sizeof($data) == 1){ //just first name..
					$gf->setFinder($uf);
					$sk = $uf->getSearchKeyByLastName($key);
					$res = $gf->find(array($sk), true);
					$cntr = 0;
					for ($i=0;$i<sizeof($res);$i++){
						$user = $res[$i];
						$FileIDs[$cntr] = $user->family_id;
						$cntr++;
					}
					
					$sk = $uf->getSearchKeyByFirstName($key);
					$res = $gf->find(array($sk), true);
					for ($i=0;$i<sizeof($res);$i++){
						$user = $res[$i];
						$FileIDs[$cntr] = $user->family_id;
						$cntr++;
					}
					
					$gf->setFinder($if);
					$sk = $if->getSearchKeyByAddrStreet($key);
					$res = $gf->find(array($sk), false);
					for ($i=0;$i<sizeof($res);$i++){
						$fileInfo = $res[$i];
						
						$fileInfo = $res[$i];
						$fileId = $fileInfo->getFamilyId();
						
						$FileIDs[$cntr] = $fileId;
						$cntr++;
					}
					
						
				}
				else{ //last name and first name OR ADDRESS!
					if (intval($data[0]) == 0){ //firstname/lastname{
						$gf->setFinder($uf);
						$sk = $uf->getSearchKeyByFirstName($data[0]);
						$sk2 = $uf->getSearchKeyByLastName($data[1]);
						$res = $gf->find(array($sk, $sk2), true);
						$cntr = 0;
						for ($i=0;$i<sizeof($res);$i++){
							$usr = $res[$i];
							$FileIDs[$cntr] = $usr->family_id;
							$cntr++;
						}
						
						$sk = $uf->getSearchKeyByFirstName($data[1]);
						$sk2 = $uf->getSearchKeyByLastName($data[0]);
						$res = $gf->find(array($sk, $sk2), true);
						for ($i=0;$i<sizeof($res);$i++){
							$usr = $res[$i];
							$FileIDs[$cntr] = $usr->family_id;
							$cntr++;
						}
					
					}//else address #+STREET?
					else{
						if ($data[1] != ""){
							$streetNb = intval($data[0]);
							$streetName = $data[1];
							
							$gf->setFinder($if);
							$sk = $if->getSearchKeyByAddrNumber($streetNb);
							$sk2 = $if->getSearchKeyByAddrStreet($streetName);
							$res = $gf->find(array($sk, $sk2), true);
							$cntr = 0;
							for ($i=0;$i<sizeof($res);$i++){
								$fileInfo = $res[$i];
								$fileId = $fileInfo->getFamilyId();
								$FileIDs[$cntr] = $fileId;
								$cntr++;
							}
						}
					}
				}
			}
		}
	}
}
else{
	$ef = new EventFinder();
	$gf->setFinder($ef);
	
	$id = intval($key);
	$cntr = 0;
	$isDate = strstr($key, "-");
	$isNextKeyword = strstr($key, "next ") || $isNextKeyword = strstr($key, "Next ");
	$tempKey = $key;
	$tempKey = strtolower($tempKey);
	
	$isCustomKeyDate = false;
	
	
	if ($tempKey=='tomorrow'){
		// $test = mktime(0,0,0,date("m"), date("d")+1, date("y"));
		// $test = date("Y-m-d",$test);
		// var_dump($test);
		$next = mktime(0,0,0,date("m"), date("d")+1, date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($tempKey=='yesterday'){
		$next = mktime(0,0,0,date("m"), date("d")-1, date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($tempKey=='today'){
		$next = mktime(0,0,0,date("m"), date("d"), date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($isNextKeyword){
		$split = preg_split("/ /", $key);
		
		
		$days = array("sunday"=>0, "monday"=>1, "tuesday"=>2, "wednesday"=>3, "thursday"=>4, "friday"=>5, "saturday"=>6);
		$theKeys = array_keys($days);
		if (sizeof($split) == 2){
			$sear = $split[1];
			$sear = strtolower($sear);
			$today = date("Y-m-d");
			
			if ($sear == 'week'){
				$next = mktime(0, 0, 0, date("m"), date("d")+6, date("y"));
				$next = date("Y-m-d",$next);
				$isCustomKeyDate = true;
			}
			else{
				
				if (in_array($sear, $theKeys)){
					$dayRequested = $days[$sear];
					$dw = date("w");
				
					if (($dayRequested - $dw)>0){
						$diff = $dayRequested - $dw;
					}
					else{
						$diff = (7-$dw) + $dayRequested;
					}
					
					$next = mktime(0, 0, 0, date("m"), date("d")+$diff, date("y"));
					$next = date("Y-m-d",$next);
					$isCustomKeyDate = true;
				}
			}
			
		}
		elseif(sizeof($split)==3){
			$sear = $split[2];
			$after = $split[1];
			
			if ($sear == 'weeks' || $sear=='week'){
				$next = mktime(0, 0, 0, date("m"), date("d")+(($after)*7), date("y"));
				$next = date("Y-m-d",$next);
				$isCustomKeyDate = true;
			}
			else{
			
				$sear = strtolower($sear);
						
				$today = date("Y-m-d");
				if (in_array($sear, $theKeys)){
					$dayRequested = $days[$sear];
					$dw = date("w");
					
					
					
					if (($dayRequested - $dw)>0){
						$diff = $dayRequested - $dw;
					}
					else{
						$diff = (7-$dw) + $dayRequested;
					}
					$diff+=(($after-1)*7);
					$next = mktime(0, 0, 0, date("m"), date("d")+$diff, date("y"));
					$next = date("Y-m-d",$next);		
					$isCustomKeyDate = true;
				}
			}
			
		}
	}
	else{
		if ($id>0 && !$isDate){ //event id search
			$sk = $ef->getSearchKeyById($id);
			$res = $gf->find(array($sk), false);	
			if (sizeof($res)>0){
				$FileIDs[$cntr] = $res[0]->event_id;
				$cntr++;
			}
		}
		else if ($isDate){
			$sk = $ef->getSearchKeyByStartDate($key);
			$res = $gf->find(array($sk), true);
			for ($i=0;$i<sizeof($res);$i++){
				$FileIDs[$cntr] = $res[$i]->event_id;
				$cntr++;
			}
		}
	}
	
	if ($isCustomKeyDate){
		
		$sk = $ef->getSearchKeyByStartDate($next);
		$res = $gf->find(array($sk), true);
		for ($i=0;$i<sizeof($res);$i++){
			$FileIDs[$cntr] = $res[$i]->event_id;
		$cntr++;
		}
	}
	
	$sk = $ef->getSearchKeyByText($key);
	$res = $gf->find(array($sk), true);
	for ($i=0;$i<sizeof($res);$i++){
		$FileIDs[$cntr] = $res[$i]->event_id;
		$cntr++;
	}
	
}
//getAllFilesFromEvent
$subFolder="..\\..\\view\\Components\\";
include_once($subFolder."html.php");
$subFolder="..\\..\\view\\Components\\";
include_once($subFolder."FileBlock_MainFileBuilder.php");
$subFolder="..\\..\\view\\Components\\";
include_once($subFolder."FileBlock_MainEventBuilder.php");
$subFolder="..\\..\\view\\Components\\";
include_once($subFolder."Gallery.php");
$NumOfFilesFound=sizeof($FileIDs);

for ($i=0;$i<sizeof($FileIDs);$i++){
	if (!in_array($FileIDs[$i], $currIds)){
		$id = $FileIDs[$i];
		array_push($currIds, $id);
	}
}
$FileIDs = $currIds;
$UserIDs = $FileIDs;
$toRet = "";
$toMatch = $key;
$builder;

$divHeader = new html("table","resultHeaderContainer");
$titles;
$class = "tableHeader";
if($searchBy=="Event"){
	$ids = $UserIDs;
    $builder = new FileBlock_MainEventBuilder();
    $titles= array("ID", "Name", "Start Date", "End Date", "Type", "Hold");
    $class = "tableEventHeader";
}
else{
    $ids = $UserIDs;
    $builder = new FileBlock_MainFileBuilder();
    $titles= array("ID", "First", "Last", "Street #", "Street Name", "Postal Code", "City", "Province", "flag");
}
for($i=0;$i<sizeof($titles);$i++){
    $header = new html("td", $class."s", $class.($i+1));
    $header->setText($titles[$i]);
    $divHeader->addChild($header);
}
$Gallery = new Gallery($builder);

$Gallery->doSearch($ids, $toMatch);
$toRet = $divHeader->toHTML().$Gallery->getContainer()->toHTML();
/*
for($i=0; $i<$NumOfFilesFound;$i++){
    $builder = new MiniFileFoundBuilder($UserIDs[$i], $toMatch, $EventID);
    $toRet .=$builder->getContainer()->toHTML(); 
}
*/
echo $toRet;

?>