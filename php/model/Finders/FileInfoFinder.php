<?php
	include_once("/../FileInfo.php");
	include_once("Finder.php");
	
	class FileInfoFinder extends Finder{
		const TABLE_NAME = "file_info";
		const COLUMN_ID = "id";
		const COLUMN_ADDR_STREET = "addr_street";
		const COLUMN_ADDR_NB = "addr_nb";
		const COLUMN_ADDR_CITY = "addr_city";
		const COLUMN_ADDR_PROV = "addr_prov";
		const COLUMN_ADDR_PCODE = "addr_pcode";
		const COLUMN_NOTES = "notes";
		
		function __construct(){
			$this->setFriendlyName();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("id" => "ID", "addr_street"=>"Street Name", "addr_nb"=>"Street No", "addr_city"=>"City",
								"addr_prov"=>"Province", "addr_pcode"=>"Postal Code", "notes"=>"Notes");
		}
		
		function getSearchKeyByAddrStreet($street){
			return new SearchKey(self::COLUMN_ADDR_STREET, $street);
		}
		
		function getSearchKeyByAddrNumber($nb){
			return new SearchKey(self::COLUMN_ADDR_NB, $nb);
		}
		
		function getSearchKeyByAddrCity($city){
			return new SearchKey(self::COLUMN_ADDR_CITY, $city);
		}
		
		function getSearchKeyByAddrProvince($prov){
			return new SearchKey(self::COLUMN_ADDR_PROV, $prov);
		}
		
		function getSearchKeyByAddrPcode($pcode){
			return new SearchKey(self::COLUMN_ADDR_PCODE, $pcode);
		}
		
		function getSearchKeyByNotes($notes){
			return new SearchKey(self::COLUMN_NOTES, $notes);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$appFound[$i] = new FileInfo($temp[self::COLUMN_ID]);
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