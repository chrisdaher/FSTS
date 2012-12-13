<?php
	include_once("/../Income.php");
	include_once("Finder.php");
	
	class IncomeFinder extends Finder{
		const TABLE_NAME = "income";
		const COLUMN_ID = "id";
		const COLUMN_USER_ID = "user_id";
		const COLUMN_INCOME_TYPE_ID_SPEC = "income_type_id";
		const COLUMN_INCOME_LENGTH_ID_SPEC = "income_length_id";
		const COLUMN_START_DATE = "start_date";
		const COLUMN_END_DATE = "end_date";
		const COLUMN_VALUE = "value";
		
		function __construct(){
			$this->setSpecArray();
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("id" => "ID", "user_id"=>"User ID", "income_type_id"=>"Income Type (ID)", 
								"income_length_id"=>"Income Length (ID)", "start_date"=>"Start Date", "end_date"=>"End Date",
								"value"=>"Value ($)");
		}
		
		function buildArrayObjects($rowArr){
			$inc = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$inc[$i] = new Income($temp[self::COLUMN_ID]);
			}
			return $inc;
		}
		
		function setSpecArray(){
			$this->specArray = array("income_type_id"=>new SpecConverter("incometypeconverter"), 
								"income_length_id"=>new SpecConverter("incomelengthconverter"));
		}
	}
?>