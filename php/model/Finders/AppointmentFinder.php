<?php
	include_once("/../Appointment.php");
	include_once("Finder.php");
	
	class AppointmentFinder extends Finder{
		
		const TABLE_NAME = "appointment";
		const COLUMN_ID = "id";
		const COLUMN_START_DATE = "start_date";
		const COLUMN_END_DATE = "end_date";
		const COLUMN_TEXT = "text";
		const COLUMN_REC_TYPE = "rec_type";
		const COLUMN_EVENT_PID = "event_pid";
		const COLUMN_EVENT_LENGTH = "event_length";
		const COLUMN_EVENT_ID = "event_id";
		const COLUMN_CAPACITY = "capacity";
		const COLUMN_REC_ID = "rec_id";
		const COLUMN_SIZE = "size";
		
		function __construct(){
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("id" => "ID", "start_date"=>"Start Date", "end_date"=>"End Date", "text"=>"Text",
								"event_length"=>"Event Length", "capacity"=>"Capacity", "size"=>"Size");
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
		
		function getSearchKeyByStartDate($start_date){
			return new SearchKey(self::COLUMN_START_DATE, $start_date);
		}
		
		function getSearchKeyByEndDate($end_date){
			return new SearchKey(self::COLUMN_END_DATE, $end_date);
		}
		
		function getSearchKeyByText($txt){
			return new SearchKey(self::COLUMN_TEXT, $txt);
		}
		
		function getSearchKeyByEventId($id){
			return new SearchKey(self::COLUMN_EVENT_ID, $id);
		}
		
		function getSearchKeyByCapacity($cap){
			return new SearchKey(self::COLUMN_CAPACITY, $cap);
		}
		
		function getSearchKeyByRecId($id){
			return new SearchKey(self::COLUMN_REC_ID, $id);
		}
		
		function getSearchKeyBySize($size){
			return new SearchKey(self::COLUMN_SIZE, $size);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$appFound[$i] = new Appointment($temp[self::COLUMN_ID]);
			}
			return $appFound;
		}
		
		function setSpecArray(){
			$this->specArray = array("event_id"=>new SpecConverter("event_type"));
		}
	}

?>