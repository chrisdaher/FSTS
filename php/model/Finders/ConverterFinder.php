<?php
	include_once("/../ConverterObject.php");
	include_once("Finder.php");
	
	class ConverterFinder extends Finder{
		const COLUMN_ID = "id";
		const COLUMN_NAME = "name";
		
		function __construct($table){
			$this->setFriendlyName();
			$this->tableName = $table;
			$this->setSearchKeys($this);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("event_id" => "ID", "start_date"=>"Start Date", "end_date"=>"End Date", "text"=>"Text",
								"details"=>"Details", "event_pid"=>"PID", "event_length"=>"Event Length", "event_type_id"=>"Event Type", "rec_id"=>"Rec");
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
		
		function getSearchKeyByName($name){
			return new SearchKey(self::COLUMN_NAME, $name);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$id = $temp[self::COLUMN_ID];
				$name = $temp[self::COLUMN_NAME];
				$appFound[$i] = new ConverterObject($id, $name);
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