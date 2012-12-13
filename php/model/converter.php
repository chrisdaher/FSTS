<?php
	include_once("mysqlManager.php");	
	include_once("/../services/security/SecurityManager.php");
	class converter{
		protected $table_name;
		
		
		function __construct($tableName, $secure){
			if (verifyLoginAdmin() || !$secure){
				$this->table_name = $tableName;
				return true;
			}
			return false;
		}
		
		function addRow($name){
			if (!verifyLoginAdmin()) return false;
			$mysql = new mysqlManager();
			$id = $mysql->createInsertQuery(array("name"=>$name), $this->table_name, true, true);
			if ($mysql->error != null){
				return -1;
			}
			return $id;
		}
		
		function removeRow($id){
			if (!verifyLoginAdmin()) return false;
			$mysql = new mysqlManager();
			$mysql->createDeleteQuery(array("id"=>$id), $this->table_name, true);
			if ($mysql->error != null){
				return false;
			}
			return true;
		}
		
		function updateRow($id, $name){
			$unique = array("id"=>$id);
			$para = array("name"=>$name);
			$mysql = new mysqlManager();
			$mysql->createUpdateQuery($unique, $para, $this->table_name, true);
			if ($mysql->error != null){
				return false;
			}
			return true;
		}
		
		function getTableDataJSON(){
			$mysql = new mysqlManager();
			$res = $mysql->createSelectAll($this->table_name, true);

			while($r = mysql_fetch_assoc($res)) {
				$rows[] = $r;
			}
			return json_encode($rows);
		}
		
		function getTableData(){
			$mysql = new mysqlManager();
			$res = $mysql->createSelectAll($this->table_name, true);
			$rows = null;
			while($r = mysql_fetch_assoc($res)) {
				$rows[] = $r;
			}
			return $rows;
		}
		
		function getTableName(){
			return $this->table_name;
		}
		
		function getKey(){
			return "name";
		}
		
		function getIDKey(){
			return "id";
		}
		
		function getRow($id){
			$mysql = new mysqlManager();
			$unique = array("id"=>$id);
			$res = $mysql->createSelectQuery($unique, $this->table_name, true);
			$row = mysql_fetch_array($res);
			
			return $row;
		}
		
	}


?>