<?php
	include_once("Finders/IncludeAllFinders.php");
	include_once("File.php");
	class SearchManager{
		var $searchArray = false;
		var $dbSearch = false;
		var $globalFinder;
		
		function __construct($arr){
			$this->searchArray = $arr;
			if ($this->searchArray == false){
				$this->dbSearch = false;
			}
		}
				
		function doGeneralSearch($searchKey){
			if ($this->dbSearch){ //search in db
				
			}
			else{ //search in array given
				
			}
		}
		
		function searchById($id){
			if ($this->dbSearch){ //search in db
				$ff = new FileFinder();
				$this->globalFinder = new GlobalFinder($ff);
				$sk = $ff->getSearchKeyById($id);
				$res = $this->globalFinder->find($sk, false);
				$toRet = array();
				$cntr = 0;
				for ($i=0;$i<sizeof($toRet);$i++){
					$file = $toRet[$i];
					$toRet[$cntr] = $file->id;
					$cntr++;
				}
				return $toRet;
			}
			else{ //search in array
				$toRet = array();
				$cntr = 0;
				for ($i=0;$i<sizeof($this->searchArray);$i++){
					$temp = $this->searchArray[$i];
					if ($temp == $id){
						$toRet[$cntr] = $id;
						$cntr++;
					}
				}
				return $toRet;
			}
		}
		
		function searchByMedicard($medi){
			$uf = new UserFinder();
			$this->globalFinder = new GlobalFinder($uf);
			$sk = $uf->getSearchKeyByMedicard($medi);
			$toRet = $this->globalFinder->find($sk, false);
			
			$toRet = array();
			$cntr = 0;
			for ($i=0;$i<sizeof($toRet);$i++){
				$usr = $toRet[$i];
				$toRet[$cntr] = $usr->family_id;
				$cntr++;
			}
			return $toRet;
		}
		
		function searchByName($fname){
			if ($this->dbSearch){
				//not done
			}
			else{
				$toRet = array();
				$cntr = 0;
				for ($i=0;$i<sizeof($this->searchArray);$i++){
					$file = ($this->searchArray[$i]);
					$indep = $file->independent;
					$indepFName = strtolower($indep->first_name);
					$indepLName = strtolower($indep->last_name);
					$fname = strtolower($fname);
					if (strstr($indepFName, $fname) || strstr($indepLName, $fname)){
						$toRet[$cntr] = $this->searchArray[$i]->id;
						$cntr++;
					}
				}
				return $toRet;
			}
		}
		
		function searchByPostalCode($pcode){
			if ($this->dbSearch){
				//not done
			}
			else{
				$toRet = array();
				$cntr = 0;
				for ($i=0;$i<sizeof($this->searchArray);$i++){
					$file = $this->searchArray[$i];
					$fi = $file->file_info;
					$filePCode = $fi->addr_pcode;
					$filePCode = strtolower($filePCode);
					$pcode = strtolower($pcode);
					if (strstr($filePCode, $pcode)){
						$toRet[$cntr] = $this->searchArray[$i]->id;
						$cntr++;
					}
				}
				return $toRet;
			}
		}
		
		function searchByStreetName($name){
			if ($this->dbSearch){
				//not done
			}
			else{

				$toRet = array();
				$cntr = 0;
				for ($i=0;$i<sizeof($this->searchArray);$i++){
					$file = $this->searchArray[$i];
					$fi = $file->file_info;
					$fileStreet = $fi->addr_street;
					$fileStreet = strtolower($fileStreet);
					$name = strtolower($name);
					if (strstr($fileStreet, $name)){
						$toRet[$cntr] = $this->searchArray[$i]->id;
						$cntr++;
					}
				}
				return $toRet;
			}
		}
	}

?>