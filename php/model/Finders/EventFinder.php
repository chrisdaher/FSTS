<?php
	include_once("/../Event.php");
	include_once("Finder.php");
	
	class EventFinder extends Finder{
		
		const TABLE_NAME = "scheduler";
		const COLUMN_EVENT_ID = "event_id";
		const COLUMN_START_DATE = "start_date";
		const COLUMN_END_DATE = "end_date";
		const COLUMN_TEXT = "text";
		const COLUMN_DETAILS = "details";
		const COLUMN_REC_TYPE = "rec_type";
		const COLUMN_EVENT_PID = "event_pid";
		const COLUMN_EVENT_LENGTH = "event_length";
		const COLUMN_EVENT_TYPE_ID_SPEC = "event_type_id";
		const COLUMN_REC_ID = "rec_id";
		const COLUMN_OPEN_SPEC = "open";
		
		
		function __construct(){
			$this->setSpecArray();
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("event_id" => "ID", "start_date"=>"Start Date", "end_date"=>"End Date", "text"=>"Text",
								"event_length"=>"Event Length", "event_type_id"=>"Event Type", "open"=>"Is Open");
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_EVENT_ID, $id);
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
		
		function getSearchKeyByDetails($id){
			return new SearchKey(self::COLUMN_DETAILS, $id);
		}
		
		function getSearchKeyByEventPid($id){
			return new SearchKey(self::COLUMN_EVENT_PID, $id);
		}
		
		function getSearchKeyByEventTypeId($id){
			return new SearchKey(self::COLUMN_EVENT_TYPE_ID, $id);
		}
		
		function getSearchKeyByRecId($id){
			return new SearchKey(self::COLUMN_REC_ID, $id);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$appFound[$i] = new Event($temp[self::COLUMN_EVENT_ID], false);
			}
			return $appFound;
		}
		
		function setSpecArray(){
			$this->specArray = array("event_type_id"=>new SpecConverter("event_type"),
									"open"=>new BooleanSpec());
		}
	}
		
?>