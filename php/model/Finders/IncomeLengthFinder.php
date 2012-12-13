<?php
	include_once("/../IncomeLengthObject.php");
	include_once("Finder.php");
	
	class IncomeLengthFinder extends Finder{
	   const COLUMN_ID = "id";
		const COLUMN_NAME = "name";
		const COLUMN_VALUE = "ratio";
		const TABLE_NAME = "incomelengthconverter";
		
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
		function getSearchKeyByID($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
        
		function getSearchKeyByName($name){
			return new SearchKey(self::COLUMN_NAME, $name);
		}
		
		function getSearchKeyByValue($value){
			return new SearchKey(self::COLUMN_VALUE, $value);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
                $id = $temp[self::COLUMN_ID];
				$name = $temp[self::COLUMN_NAME];
				$value = $temp[self::COLUMN_VALUE];
				$appFound[$i] = new IncomeLengthObject($id, $name, $value);
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