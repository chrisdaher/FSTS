<?php
	include_once("mysqlManager.php");
	include_once("User.php");
	include_once("Event.php");
	include_once("Appointment.php");
	include_once("FileInfo.php");
	class File{
		var $independent;
		var $dependents;
		var $id;
		var $independentId;
		var $fileInfoId;
		var $isActive;
		var $file_info;
		var $table_name = "file";
		var $events;
		var $isNew;
		
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
			return $this->id;
		}
		
		function update(){
			$mysql = new mysqlManager();
			$params = array("indepedent_id"=>$this->independentId, "file_info_id"=>$this->fileInfoId, "active"=>$this->isActive);
			if ($this->isNew){
				//$this->independentId = $this->independent->id;
				//$this->fileInfoId = $this->file_info->id;
				//$params = array("indepedent_id"=>$this->independentId, "file_info_id"=>$this->fileInfoId, "active"=>$this->isActive);
				
				$res = $mysql->createInsertQuery($params, $this->table_name, true, true);
				if ($this->independent != null){
					$this->independent->update();
				}
				if ($this->file_info != null){
					$this->file_info->update();
				}
				
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
		
		function constructWithId($id, $full){
			$mysql = new mysqlManager();
			$params = array("id"=>$id);
			$res = $mysql->createSelectQuery($params, $this->table_name,true);
			
			$row = mysql_fetch_array($res);
			if ($row != null){
				$this->id = $id;
				$this->independentId = $row['indepedent_id'];
				$this->fileInfoId = $row['file_info_id'];
				$this->isActive = $row['active'];
				
				if ($this->isActive == 1){
					$this->isActive = true;
				}
				else{
					$this->isActive = false;
				}
				
				if ($full){
					$this->loadIndependent(true);
					$this->loadDependents(true);
					$this->loadFileInfo();
					$this->loadEvents(true);
				}
				$this->isNew = false;
				return true;
			}			
			$this->isNew = true;
			return false;
		}
		
		function loadEvents($full){
			$mysql = new mysqlManager();
			$params = array("file_id" => $this->id);
			$res = $mysql->createSelectQuery($params, "event_user_linker", true);
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$eventId = $row['event_id'];
				$this->events[$cntr] = new Event($eventId, $full);
				$cntr++;
			}
		}
		
		function loadFileInfo(){
			$this->file_info = new FileInfo($this->fileInfoId);
		}
		
		function loadIndependent($full){
			$this->independent = new User($this->independentId, $full);
			
		}
		
		function loadDependents($full){
			$mysql = new mysqlManager();
			$params = array("family_id"=>$this->id);
			$res = $mysql->createSelectQuery($params, "user",true);
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$userId = $row['id'];
				if ($userId != $this->independentId){
					$this->dependents[$cntr] = new User($userId, $full);
					$cntr++;
				}
			}
		}
		
		function getTotalYearlyIncome($load = true){
			if ($load){
				$this->loadDependents(false);
				$this->loadIndependent(false);
				$this->independent->loadIncome();
			}
			$income = $this->independent->listOfIncome;
			if (!(sizeof($income) > 0)){
				$income = array();
			}
			
			
			for ($i=0;$i<sizeof($this->dependents);$i++){
				$this->dependents[$i]->loadIncome();
				if (sizeof($this->dependents[$i]->listOfIncome) > 0){
					$income = array_merge($income, $this->dependents[$i]->listOfIncome);
				}
			}
			$currTotal = 0;
			
			for ($i=0;$i<sizeof($income);$i++){
				$nextYear = new DateTime($income[$i]->end_date);
				$today = new DateTime($income[$i]->start_date);
				$interval = $nextYear->diff($today);
				
				$days = $interval->y*365;
				$days += $interval->m*30;
				$days += $interval->d;
				
				$ratio = $income[$i]->getRatio();
				$ratio = 365/$ratio;
				$val = $income[$i]->value / $ratio;
								
				$currTotal += $val*$days;
				//$currTotal += ($income[$i]->value * $income[$i]->getRatio());
			}
			return $currTotal;
			
		}
		
		function getRemainingYearlyIncome($load = true){
			if ($load){
				$this->loadDependents(false);
				$this->loadIndependent(false);
				$this->independent->loadIncome();
			}
			$income = $this->independent->listOfIncome;
			if (!(sizeof($income) > 0)){
				$income = array();
			}
			
			for ($i=0;$i<sizeof($this->dependents);$i++){
				$this->dependents[$i]->loadIncome();
				if (sizeof($this->dependents[$i]->listOfIncome) > 0){
					$income = array_merge($income, $this->dependents[$i]->listOfIncome);
				}
			}
			$currTotal = 0;
			$today = date("Y-m-d");
			$nextYear = mktime(0,0,0, 1, 1, date("y")+1);
			$nextYear = date("Y-m-d", $nextYear);
			
			$nextYear = new DateTime($nextYear);
			$today = new DateTime($today);
			$interval = $nextYear->diff($today);
			
			$days = $interval->y*365;
			$days += $interval->m*30;
			$days += $interval->d;
			
			for ($i=0;$i<sizeof($income);$i++){
				$nextYear = new DateTime($income[$i]->end_date);
				$today = new DateTime($income[$i]->start_date);
				$interval = $nextYear->diff($today);
				
				$daysi = $interval->y*365;
				$daysi += $interval->m*30;
				$daysi += $interval->d;
				
				$days -= $daysi;
				if ($days <0) $days*=-1;
			
				$ratio = $income[$i]->getRatio();
				$ratio = 365/$ratio;
				$val = $income[$i]->value / $ratio;
				$currTotal += $val*$days;
			}
			
			return $currTotal;
			
		}
		
	}


?>