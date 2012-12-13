<?php
	include_once("/../User.php");
	include_once("Finder.php");
	
	class UserFinder extends Finder{
		const TABLE_NAME = "user";
		const COLUMN_ID = "id";
		const COLUMN_FIRST_NAME = "first_name";
		const COLUMN_LAST_NAME = "last_name";
		const COLUMN_MEDICARD = "medicard";
		const COLUMN_WORK_STATUS_SPEC = "work_status";
		const COLUMN_LANGUAGE_SPEC = "language";
		const COLUMN_MARITAL_STATUS_SPEC = "marital_status";
		const COLUMN_REFERRAL = "referral";
		const COLUMN_CONTACT = "contact";
		const COLUMN_FIRST_VISIT = "first_visit";
		const COLUMN_FAMILY_ID = "family_id";
		const COLUMN_AGE = "age";
		const COLUMN_GENDER_SPEC = "gender";
		const COLUMN_DATE_BIRTH = "dateBirth";
		
		function __construct(){
			$this->setFriendlyName();
			$this->setSpecArray();
			$this->tableName = self::TABLE_NAME;
			$this->setSearchKeys($this);
		}
		
		function setFriendlyName(){
			$this->friendlyName = array("id" => "ID", "first_name"=>"First Name", "last_name"=>"Last Name", "medicard"=>"Medicard",
								"work_status"=>"Work Status", "language"=>"Language", "marital_status"=>"Marital Status",   "referral"=>"Referral", "contact"=>"Contact", "first_visit"=>"First Visit", "family_id"=>"File ID",
								"age"=>"Age","gender"=>"Gender","dateBirth"=>"Date Of Birth");
		}
		
		function getSearchKeyById($id){
			return new SearchKey(self::COLUMN_ID, $id);
		}
		
		function getSearchKeyByFirstName($fname){
			return new SearchKey(self::COLUMN_FIRST_NAME, $fname);
		}
		
		function getSearchKeyByLastName($lname){
			return new SearchKey(self::COLUMN_LAST_NAME, $lname);
		}
		
		function getSearchKeyByMedicard($medicard){
			return new SearchKey(self::COLUMN_MEDICARD, $medicard);
		}
		
		function getSearchKeyByWorkStatus($workStatus){
			return new SearchKey(self::COLUMN_WORK_STATUS, $workStatus);
		}
		
		function getSearchKeyByLanguage($language){
			return new SearchKey(self::COLUMN_LANGUAGE, $language);
		}
		
		function getSearchKeyByMaritalStatus($ms){
			return new SearchKey(self::COLUMN_MARITAL_STATUS, $ms);
		}
		
		function getSearchKeyByReferral($rf){
			return new SearchKey(self::COLUMN_REFERRAL, $rf);
		}
		
		function getSearchKeyByContact($cn){
			return new SearchKey(self::COLUMN_CONTACT, $cn);
		}
		
		function getSearchKeyByFirstVisit($fv){
			return new SearchKey(self::COLUMN_FIRST_VISIT, $fv);
		}
		
		function getSearchKeyByFamilyId($id){
			return new SearchKey(self::COLUMN_FAMILY_ID, $id);
		}
		
		function getSearchKeyByAge($age){
			return new SearchKey(self::COLUMN_AGE, $age);
		}
		
		function getSearchKeyByGender($gn){
			return new SearchKey(self::COLUMN_GENDER, $gn);
		}
		
		function getSearchKeyByDateOfBirth($db){
			return new SearchKey(self::COLUMN_DATE_BIRTH, $db);
		}
		
		function buildArrayObjects($rowArr){
			$appFound = array();
						
			for ($i=0;$i<sizeof($rowArr);$i++){
				$temp = $rowArr[$i];
				$appFound[$i] = new User($temp[self::COLUMN_ID], false);
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