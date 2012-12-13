<?php
	include_once("mysqlManager.php");
	class Appointment{
		var $id;
		var $start_date;
		var $end_date;
		var $text;
		var $rec_type;
		var $event_pid;
		var $event_length;
		var $event_id;
		var $capacity;
		var $rec_id;
		var $size;
		var $isNew;
		var $table_name = "appointment";
		var $deleteFlag = false;
		
		function update(){
			$mysql = new mysqlManager();
			
			if ($this->deleteFlag){
				$res = $mysql->createDeleteQuery(array("id"=>$this->id), $this->table_name, true);
				$res = $mysql->createDeleteQuery(array("appointment_id"=>$this->id), "event_user_linker", true);
				
				if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
				}
				return true;
			}
			else{
				$params = array("start_date" => $this->start_date, "end_date"=>$this->end_date,	
								"text"=>$this->text, "rec_type"=>$this->rec_type,
								"event_pid"=>$this->event_pid, "event_length"=>$this->event_length,
								"rec_id"=>$this->rec_id, "capacity"=>$this->capacity, "size"=>$this->size,
								"event_id"=>$this->event_id);
				if ($this->isNew){
					$res = $mysql->createInsertQuery($params, $this->table_name, true, true);
					if ($mysql->error == null){
						//no error
						$this->id = $res;
					}
					else{
						throw new Exception($mysql->error);
						return false;
					}
				}
				else{
					$unique = array("id" => $this->id);
					$res = $mysql->createUpdateQuery($unique, $params, $this->table_name, true);
					if ($mysql->error != null){
						throw new Exception($mysql->error);
						return false;
					}
				}
				$this->isNew = false;
				return true;
			}
		}
		
		function getFilesInAppointment(){
			$mysql = new mysqlManager();
			$param = array("appointment_id"=>$this->id);
			$res = $mysql->createSelectQuery($param, "event_user_linker", true);
			return $res;
		}
				
		function __construct($id){
			$this->deleteFlag = false;
			if ($id != -1){
			
				$mysql = new mysqlManager();
				$params = array("id"=>$id);
				$res = $mysql->createSelectQuery($params, $this->table_name,true);
				$row = mysql_fetch_array($res);
				
				if ($row != null){
					$this->id = $id;
					$this->start_date = $row['start_date'];
					$this->end_date = $row['end_date'];
					$this->text = $row['text'];
					$this->rec_type = $row['rec_type'];
					$this->event_pid = $row['event_pid'];
					$this->event_length = $row['event_length'];
					$this->event_id = $row['event_id'];
					$this->capacity = $row['capacity'];
					$this->size = $row['size'];
					$this->rec_id = $row['rec_id'];
					
					$this->isNew = false;
					
					return true;
				}
				else{
					$this->isNew = true;
					return false;
				}
			}
			else{
				$this->isNew = true;
				return false;
			}	
		}
		
		function getStartDate(){
			$arr = preg_split("/ /", $this->start_date);
			$date = $arr[0];
			return $date;
		}
		
		function getEndDate(){
			$arr = preg_split("/ /", $this->end_date);
			$date = $arr[0];
			return $date;
		}
		
		function getStartTime(){
			//parse the date
			$arr = preg_split("/ /", $this->start_date);
			$time = $arr[1];
			return $time;
		}
		
		function getEndTime(){
			$arr = preg_split("/ /", $this->end_date);
			$time = $arr[1];
			return $time;
		}
		
	}


?>