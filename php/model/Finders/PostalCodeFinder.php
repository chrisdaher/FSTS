<?php
	include_once("/../PostalCodeObject.php");
	include_once("Finder.php");
	
	class PostalCodeFinder extends Finder{
		const COLUMN_PCODE = "pcode";
		const COLUMN_CITY = "city";
		const COLUMN_PROVINCE = "province";
		const TABLE_NAME = "postalcodeconverter";
		
		function __construct(){
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function getSearchKeyByPostal($pcode){
			return new SearchKey(self::COLUMN_PCODE, $pcode);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("event_id" => "ID", "start_date"=>"Start Date", "end_date"=>"End Date", "text"=>"Text",
								"details"=>"Details", "event_pid"=>"PID", "event_length"=>"Event Length", "event_type_id"=>"Event Type", "rec_id"=>"Rec");
		}
		
		function getSearchKeyByCity($city){
			return new SearchKey(self::COLUMN_CITY, $city);
		}
		
		function getSearchKeyByProvince($prov){
			return new SearchKey(self::COLUMN_PROVINCE, $prov);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$pcode = $temp[self::COLUMN_PCODE];
				$city = $temp[self::COLUMN_CITY];
				$prov = $temp[self::COLUMN_PROVINCE];
				$appFound[$i] = new PostalCodeObject($pcode, $city, $prov);
			}
			return $appFound;
		}
		
		function setSpecArray(){
			$this->specArray = array("work_status"=>new SpecConverter("workconverter"), 
								"language"=>new SpecConverter("languageconverter"), 
								"marital_status"=>new SpecConverter("maritalconverter"),
								"gender"=>new GenderSpec());
		}
	}
	
?>