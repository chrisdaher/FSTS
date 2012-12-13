<?php
	include_once("mysqlManager.php");
	include_once("Event.php");
	include_once("Income.php");
	include_once("/../services/mysql/dbSqlToText.php");
	class User{
		var $id;
		var $first_name;
		var $last_name;
		var $medicard;
		var $work_status;
		var $language;
		var $marital_status;
		var $referral;
		var $contact;
		var $first_visit;
		var $family_id;
		var $age;
		var $gender;
		var $dateBirth;
		var $events;
		var $table_name = "user";
		var $isNew;
		var $listOfIncome;
		
		function __construct($id, $full){
			if ($id != -1){
				return $this->constructWithId($id, $full);
			}
			else{
				$this->isNew = true;
				return false;
			}
			
		}
		
		function getFamilyId(){
			return $this->family_id;
		}
		
		function getWorkStatus(){
			return WorkStatusToString($this->work_status);
		}
		
		function getMaritalStatus(){
			return MaritalStatusIntToString($this->marital_status);
		}
		
		function getLanguage(){
			return LanguageIntToString($this->language);
		}
		
		function delete(){
			$unique = array("id"=>$this->id);
			$mysql = new mysqlManager();
			$mysql->createDeleteQuery($unique, $this->table_name, true);
			
			$unique = array("user_id"=>$this->id);
			$mysql->createDeleteQuery($unique, "income", true);
			$this->isNew = true;
		}		
		
		function update(){
			$mysql = new mysqlManager();
			
			$params = array("first_name"=>$this->first_name, "last_name"=>$this->last_name, "medicard"=>$this->medicard, 
				"work_status"=>$this->work_status, "language"=>$this->language, "marital_status"=>$this->marital_status,
				"referral"=>$this->referral, "contact"=>$this->contact, "first_visit"=>$this->first_visit,
				"family_id"=>$this->family_id, "age"=>$this->age, "gender"=>$this->gender, "dateBirth"=>$this->dateBirth);
			if ($this->isNew){
					$res = $mysql->createInsertQuery($params, $this->table_name, true, true);
					if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
					}
					$this->id = $res;
			}
			else{
				$unique = array("id"=>$this->id);
				$res = $mysql->createUpdateQuery($unique, $params, $this->table_name, true);
				if ($mysql->error != null){
					throw new Exception($mysql->error);
					return false;
				}
			}
			$this->isNew = false;
			return true;
			
		}
		
		function constructWithId($id, $isFull){
			$mysql = new mysqlManager();
			$params = array("id"=>$id);
			$res = $mysql->createSelectQuery($params, $this->table_name,true);
			$row = mysql_fetch_array($res);
			if ($row != null){
				$this->id = $id;
				$this->first_name = $row['first_name'];
				$this->last_name = $row['last_name'];
				$this->medicard = $row['medicard'];
				$this->work_status = $row['work_status'];
				$this->language = $row['language'];
				$this->marital_status = $row['marital_status'];
				$this->referral = $row['referral'];
				$this->contact = $row['contact'];
				$this->first_visit = $row['first_visit'];
				$this->family_id = $row['family_id'];
				$this->age = $row['age'];
				$this->gender = $row['gender'];
				$this->dateBirth = $row['dateBirth'];
				
				if ($isFull){
					$this->loadEvents();
					$this->loadIncome();
				}
				$this->isNew = false;
				return true;
			}
			$this->isNew = true;
			return false;
		}
		
		
		function loadEvents(){
			$mysql = new mysqlManager();
			$params = array("file_id" => $this->family_id);
			$res = $mysql->createSelectQuery($params, "event_user_linker", true);
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$eventId = $row['event_id'];
				$this->events[$cntr] = new Event($eventId, true);
				$cntr++;
			}
		}
		
		function loadIncome(){
			$mysql = new mysqlManager();
			$params = array("user_id"=>$this->id);
			$res = $mysql->createSelectQuery($params, "income", true);
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$incomeId = $row['id'];
				$this->listOfIncome[$cntr] = new Income($incomeId);
				$cntr++;
			}
		}
		
		function addIncome($typeId, $lengthId, $sd, $ed){
			$inc = new Income();
			$inc->user_id = $this->id;
			$inc->income_type_id = $typeId;
			$inc->income_length_id = $lengthId;
			$inc->start_date = $sd;
			$inc->end_date = $ed;
			if ($inc->update()){
				return $inc;
			}
			return false;
		}
		
		function __toString(){
			return "User object id#" . $this->id;
		}
		
		
	
	}

?>