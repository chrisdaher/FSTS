<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
$DEFAULT_MAX_NB_FILES = 15;
$MaxNumberOfFiles=$DEFAULT_MAX_NB_FILES;//12 would probly be the max number of files that would fit in the div
$FileIDs = array();//to be provided with an array of FileIDs that were found

if(!empty($_GET["EventID"])){
    $EventID=$_GET["EventID"];
}

$key = $_GET['key'];
$isPostalCode = preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][A-Z]/', $key) || preg_match('/[abceghjklmnprstvxy][0-9][a-z]/', $key) ||
				preg_match('/[abceghjklmnprstvxy][0-9][A-Z]/', $key) || preg_match('/[ABCEGHJKLMNPRSTVXY][0-9][a-z]/', $key);
$isMedicard = preg_match('/\D{4}\s?\d{4}\s?\d{4}/', $key) || preg_match('/\D{4}?\d{4}?\d{4}/', $key);
include_once("/../../services/mysql/phpMySql.php");	
include_once("/../../services/mysql/dbSqlToText.php");	
include_once("/../../model/Finders/IncludeAllFinders.php");

$ff = new FileFinder();
$uf = new UserFinder();
$if = new FileInfoFinder();
$gf = new GlobalFinder($ff);

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
			$id = $usr->id;
			$FileIDs[$cntr] = $id;
			$cntr++;
		}
				
		if (preg_match('/[ ]/i', $key)){
			
			$newMedi = str_replace (" ", "", $key);
			
			$sk = $uf->getSearchKeyByMedicard($newMedi);
			$res = $gf->find(array($sk), false);
		
			for ($i = 0;$i<sizeof($res);$i++){
				$usr = $res[$i];
				$id = $usr->id;
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
				$id = $usr->id;
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
			$userId = $file->independentId;
		
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
				$FileIDs[0] = $file->independentId;
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
					$FileIDs[$cntr] = $user->id;
					$cntr++;
				}
				
				$sk = $uf->getSearchKeyByFirstName($key);
				$res = $gf->find(array($sk), true);
				for ($i=0;$i<sizeof($res);$i++){
					$user = $res[$i];
					$FileIDs[$cntr] = $user->id;
					$cntr++;
				}
				
				$gf->setFinder($if);
				$sk = $if->getSearchKeyByAddrStreet($key);
				$res = $gf->find(array($sk), false);
				for ($i=0;$i<sizeof($res);$i++){
					$fileInfo = $res[$i];
					
					$fileInfo = $res[$i];
					$fileId = $fileInfo->getFamilyId();
					$file = new File($fileId, false);
					$userId = $file->independentId;
					
					$FileIDs[$cntr] = $userId;
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
						$FileIDs[$cntr] = $usr->id;
						$cntr++;
					}
					
					$sk = $uf->getSearchKeyByFirstName($data[1]);
					$sk2 = $uf->getSearchKeyByLastName($data[0]);
					$res = $gf->find(array($sk, $sk2), true);
					for ($i=0;$i<sizeof($res);$i++){
						$usr = $res[$i];
						$FileIDs[$cntr] = $usr->id;
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
							$file = new File($fileId, false);
							$FileIDs[$cntr] = $file->independentId;
							$cntr++;
						}
					}
				}
			}
		}
	}
}
//getAllFilesFromEvent

$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."MiniFileFoundBuilder.php");
$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."Gallery.php");
$NumOfFilesFound=sizeof($FileIDs);

$UserIDs = $FileIDs;
$toRet = "";
$toMatch = $key;
$builder = new MiniFileFoundBuilder(null, null, $EventID);
$Gallery = new Gallery($builder);
$Gallery->doSearch($FileIDs, $toMatch);
$toRet = $Gallery->getContainer()->toHTML();
/*
for($i=0; $i<$NumOfFilesFound;$i++){
    $builder = new MiniFileFoundBuilder($UserIDs[$i], $toMatch, $EventID);
    $toRet .=$builder->getContainer()->toHTML(); 
}
*/
echo $toRet;

?>