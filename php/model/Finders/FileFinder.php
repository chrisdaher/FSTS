<?php
	include_once("/../File.php");
	include_once("Finder.php");
	
	class FileFinder extends Finder{
		const TABLE_NAME = "file";
		const COLUMN_ID = "id";
		const COLUMN_INDEPEDENT_ID = "indepedent_id";
		const COLUMN_FILE_INFO_ID = "file_info_id";
		const COLUMN_ACTIVE_SPEC = "active";
		
		
		function __construct(){
			$this->setSpecArray();
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("id" => "ID", "indepedent_id"=>"Independent ID", "file_info_id"=>"File Info ID", "active"=>"Active");
		}
		
		function getSearchKeyByIndepedentId($id){
			return new SearchKey(self::COLUMN_INDEPEDENT_ID, $id);
		}
		
		function getSearchKeyByFileInfoId($id){
			return new SearchKey(self::COLUMN_FILE_INFO_ID, $id);
		}
		
		function getSearchKeyByActive($isActive){
			return new SearchKey(self::COLUMN_ACTIVE, $isActive);
		}
		
		
		function buildArrayObjects($rowArr){
			$filesFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$filesFound[$i] = new File($temp[self::COLUMN_ID], false);
			}
			return $filesFound;
		}
		
		function setSpecArray(){
			$this->specArray = array("active"=>new BooleanSpec());
		}
		
	}
?>