<?php

	include_once("mysqlManager.php");
	include_once("Appointment.php");
	include_once("/../services/mysql/dbSqlToText.php");
	class Event{
		var $start_date;
		var $end_date;
		var $event_name;
		var $details;
		var $event_id;
		var $text;
		var $rec_type;
		var $event_pid;
		var $event_length;
		var $event_type_id;
		var $rec_id;
		var $appointments;
		var $table_name = "scheduler";
		var $isOpen;
		var $isNew;
		var $deleteFlag = false;
		function update(){
			$mysql = new mysqlManager();
			if ($this->deleteFlag){
				$res = $mysql->createDeleteQuery(array("event_id"=>$this->event_id), $this->table_name, true);
				$res = $mysql->createDeleteQuery(array("event_id"=>$this->event_id), "appointment", true);
				$res = $mysql->createDeleteQuery(array("event_id"=>$this->event_id), "event_user_linker", true);
				
				
				if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
				}
				return true;
			}
			else{
				$open = 0;
				if ($this->isOpen){
					$open = 1;
				}
				$params = array("start_date" => $this->start_date, "end_date"=>$this->end_date, "event_name"=>$this->event_name,
								"details"=>$this->details, "text"=>$this->text, "rec_type"=>$this->rec_type,
								"event_pid"=>$this->event_pid, "event_length"=>$this->event_length,
								"event_type_id"=>$this->event_type_id, "rec_id"=>$this->rec_id, "open"=>$open);
				if (!$this->isNew){//update
					$unique = array("event_id"=>$this->event_id);
					$res = $mysql->createUpdateQuery($unique, $params, $this->table_name, true);
					if ($mysql->error != null){
						throw new Exception($mysql->error . "<br/>" . $mysql->lastQuery);
						return false;
					}
				}
				else{ //insert
					$res = $mysql->createInsertQuery($params, $this->table_name, true, true);
					if ($mysql->error == null){
						//no error
						$this->event_id = $res;
						//$this->text .= " - ID #" . $this->event_id;
						$this->isNew = false;
						$this->update();
					}
					else{
						throw new Exception($mysql->error);
						return false;
					}
				}
				$this->isNew = false;
				return true;
			}
		}
		
		function __construct($id, $full){
			
			$this->deleteFlag = false;
			if ($id != -1){
				$mysql = new mysqlManager();
				$params = array("event_id"=>$id);
				$res = $mysql->createSelectQuery($params, $this->table_name,true);
				$row = mysql_fetch_array($res);
				
				if ($row !=null){
					$this->start_date = $row['start_date'];
					$this->end_date = $row['end_date'];
					$this->event_name = $row['event_name'];
					$this->details = $row['details'];
					//$this->event_id = $row['event_id'];
					$this->event_id = $id;
					$this->text = $row['text'];
					$this->rec_type = $row['rec_type'];
					$this->event_pid = $row['event_pid'];
					$this->event_length = $row['event_length'];
					$this->event_type_id = $row['event_type_id'];
					$this->rec_id = $row['rec_id'];
					$open = $row['open'];
					
					$this->isOpen = false;
					if ($open == 1){
						$this->isOpen = true;
					}
					
					$this->event_name = $this->text;
					
					if ($full){
						$this->loadAppointments();
					}
					$this->isNew = false;
					return true;
				}
				$this->isNew = true;
				return false;
				
			}
			$this->isNew = true;
		}
		
		function loadAppointments(){
			$mysql = new mysqlManager();
			$params = array("event_id"=>$this->event_id);
			$res = $mysql->createSelectQuery($params, "appointment",true);
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$id = $row['id'];
				$this->appointments[$cntr] = new Appointment($id);
				$cntr++;
			}
		}
		
		function getEventTypeString(){
			return EventTypeToString($this->event_type_id);
		}
		
		function getStartDate(){
			$temp = preg_split("/ /", $this->start_date);
			return $temp[0];
		}
		function getEndDate(){
			$temp = preg_split("/ /", $this->end_date);
			return $temp[0];
		}
		
		function getRecursionString(){
			if ($this->rec_type == "") return "No recursion";
			$arr = preg_split("/_/", $this->rec_type);
			
			/*
				type of recurring encoded in string [type]_[count]_[count2]_[day]_[days]#[extra] 
				
				type - type of repeating “day”,”week”,”week”,”month”,”year”
				count - how much intervals of “type” come between events
				count2 and day - used to define day of month ( first Monday, third Friday, etc ) 
				days - comma separated list of affected week days
				extra - this info is not necessary for calculation, but can be used to correct presentation of recurring details
			
			$test = "week_2___1,5";
			$arr = preg_split("/_/", $test);
			echo "<br/>";
			echo "<br/>";
			echo "<br/>";
			echo "<br/>";
			echo "<br/>";
			var_dump($arr);
			*/
			
			$type = $arr[0];
			$count = $arr[1];
			$count2day = $arr[2];
			
			$occurenceCount = preg_split("/#/", $arr[4]);
			
			$affectedDays = $occurenceCount[0];
			$affectedDays = preg_split("/,/", $affectedDays);
			if (sizeof($affectedDays) < 1){
				$daysPrint = "";
			}else{
				$daysPrint = $this->getAffectedDaysString($affectedDays);
			}
			
			if (sizeof($occurenceCount) > 1){
				$occCount = $occurenceCount[1];
				return "Every $count $type for $occCount $type $daysPrint";			
			}
			else{
				return "Every $count $type $daysPrint";			
			}
			
		}
		
		function closeEvent(){
			$this->isOpen = false;
		}
		
		function openEvent(){
			$this->isOpen = true;
		}
		
		function isOpen(){
			return $this->isOpen;
		}
		function getOpen(){
		$toRet="";
			if($this->isOpen){
				$toRet="Open";
			}else{
				$toRet="Closed";
			}
			return $toRet;
		}
		function getAffectedDaysString($arr){
			$dow = array(0=>"Sunday", 1=>"Monday", 2=>"Tuesday", 3=>"Wednesday", 4=>"Thursday", 5=>"Friday", 6=>"Saturday");
			$temp = "on [";
			
			for ($i = 0;$i<sizeof($arr);$i++){
				$temp.= $dow[intval($arr[$i])];
				if (($i+1) != sizeof($arr)){
					$temp.=", ";
				}
			}
			$temp.="]";
			return $temp;
		}
		
		function getCurrentEventSize(){
			if (sizeof($this->appointments) < 1){
				$this->loadAppointments();
			}
			$total = 0;
			for ($i=0;$i<sizeof($this->appointments);$i++){
				$total += $this->appointments[$i]->size;
			}
			return $total;
		}
		
		function getEventCapacity(){
			if (sizeof($this->appointments) < 1){
				$this->loadAppointments();
			}
			$total = 0;
			for ($i=0;$i<sizeof($this->appointments);$i++){
				$total += $this->appointments[$i]->capacity;
			}
			return $total;
		}
		
		function getRegisteredFiles(){
			$mysql = new mysqlManager();
			$unique = array("event_id" => $this->event_id);
			$res = $mysql->createSelectQuery($unique, "event_user_linker", true);
			$toRet = array();
			$cntr = 0;
			while ($row = mysql_fetch_array($res)){
				$toRet[$cntr] = $row['file_id'];
				$cntr++;
			}
			return $toRet;
		}
	}


?>