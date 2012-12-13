<?php
	include_once("/../mysqlManager.php");
	include_once("SearchKey.php");
	include_once("SpecConverter.php");
	include_once("GenderSpec.php");
	include_once("BooleanSpec.php");
	
	abstract class Finder{
		protected $tableName;
		protected $searchKeys;
		protected $friendlyName;
		protected $friendlyKeys;
		protected $specArray;
		
		function getTableName(){
			return $this->tableName;
		}
		
		function getSearchKeys(){
			return $this->searchKeys;
		}
		
		function getFriendlyKeys(){
			return array_values($this->friendlyName);
		}
		
		function getFriendlySearchKeys(){
			
			return $this->friendlyKeys;
		}
		
		function setSearchKeys($class){
			$reflect = new ReflectionClass(get_class($class));
			$res = $reflect->getConstants();
			
			$keys = array_keys($res);
			$vals =array_values($res);
			
			$this->searchKeys = array();
			$this->friendlyKeys = array();
			$cntr=0;
			$seccntr = 0;
			$isSpec;
			$specConv;
			for ($i=0;$i<sizeof($res);$i++){
				$isSpec =false;
				$specConv = null;
				$theString = $keys[$i];
				if ((strstr($theString, "COLUMN"))){
					if (strstr($theString, "_SPEC")){
						$theString = preg_replace("/_PREG/","",$theString);
						$isSpec = true;
						$specConv = $this->getSpecConverter($vals[$i]);
					}
					$this->searchKeys[$seccntr] = new SearchKey($vals[$i], "", $isSpec, $specConv);
					
					$seccntr++;
					
					$val = $this->getFriendlyName($vals[$i]);
					
					if (!empty($val)){
						$this->friendlyKeys[$cntr] = new SearchKey($val, "", $isSpec);
						$cntr++;
					}
				}
				
			}
			
		}	
		
		function getFriendlyName($key){			
			$temp = array_flip($this->friendlyName);
			if (!in_array($key, $temp)) return;
			return $this->friendlyName[$key];
		}
		
		function getDbName($val){
			$temp = array_flip($this->friendlyName);
			return $temp[$val];
		}
		
		function getSpecConverter($specName){
			return $this->specArray[$specName];
		}
		
		abstract function setSpecArray();
		abstract function setFriendlyName();
		abstract function buildArrayObjects($res);
		
	}

?>