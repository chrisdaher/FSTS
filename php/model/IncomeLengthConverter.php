<?php
	include_once("mysqlManager.php");	
	include_once("converter.php");	
	include_once("/../services/security/SecurityManager.php");	
	
	class IncomeLengthConverter extends converter{
		function __construct(){
			$this->table_name = "incomelengthconverter";
		}
		
		function addRow($name, $ratio){
			$mysql = new mysqlManager();
			$id = $mysql->createInsertQuery(array("name"=>$name, "ratio"=>$ratio), $this->table_name, true, true);
			if ($mysql->error != null){
				return -1;
			}
			return $id;
		}
		
		function updateRow($id, $name, $ratio){
			$unique = array("id"=>$id);
			$params = array("name"=>$name, "ratio"=>$ratio);			
			$mysql = new mysqlManager();
			$res = $mysql->createUpdateQuery($unique, $params, $this->table_name, true);			
			if ($mysql->error != null){
				return false;
			}
			return true;
		}
		
		function getObject($id){
			$unique = array("id"=>$id);
			$mysql = new mysqlManager();
			$res = $mysql->createSelectQuery($unique, $this->table_name, true);
			if ($mysql->error == null){
				return mysql_fetch_array($res);
			}
			return null;
		}
		
	}