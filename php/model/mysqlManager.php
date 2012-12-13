<?php
	include_once("/../services/Logging/LogManager.php");
	class mysqlManager{
		var $dbHost;
		var $dbUser;
		var $dbPw;
		var $dbName;
		var $error;
		var $lastQuery;
		var $debug = false;
		var $con;
		private static $instance;
		function __construct(){
			$this->dbHost = "localhost";
			$this->dbUser = "root";
			$this->dbPw = "photasmomak";
			$this->dbName = "fsts";
			$this->con = false;
		}
		
		public static function getInstance(){
			if (!isset(self::$instance)){
				$className = __CLASS__;
				self::$instance = new $className;
			}
			return self::$instance;
		}
		
		function connect(){
			if (is_resource($this->con)){
				return $this->con;
			}
			else{
				$con = mysql_connect($this->dbHost,$this->dbUser, $this->dbPw);	
				if (!$con)
				{
					die('Could not connect: ' . mysql_error());
				}	
				mysql_select_db($this->dbName, $con);
				$this->con = $con;
				return $con;
			}
		}
				
		function createSelectLikeQuery($unique, $tableName, $exec){
			$uniqueCol = (array_keys($unique));
			$uniqueVal = (array_values($unique));
			
			$uniqueStr ="";
			$con = $this->connect();
			for ($i = 0;$i<sizeof($uniqueCol);$i++){
				$uniqueVal[$i] = mysql_real_escape_string($uniqueVal[$i], $con);
				$uniqueStr.="`$uniqueCol[$i]` LIKE '$uniqueVal[$i]%'";
				if (($i+1) != sizeof($uniqueCol)){
					$uniqueStr.=" AND ";
				}
			}
			mysql_close($con);
			$query = "SELECT * FROM `$tableName` WHERE " . $uniqueStr;
			
			if ($exec){
				return $this->executeQuery($query, false);
			}
			else{
				return $query;
			}
		}
		
		function createSelectQuery($unique, $tableName, $exec){
			$uniqueCol = (array_keys($unique));
			$uniqueVal = (array_values($unique));
			
			$uniqueStr ="";
			$con = $this->connect();
			for ($i = 0;$i<sizeof($uniqueCol);$i++){
				$uniqueVal[$i] = mysql_real_escape_string($uniqueVal[$i], $con);
				$uniqueStr.="`$uniqueCol[$i]`='$uniqueVal[$i]'";
				if (($i+1) != sizeof($uniqueCol)){
					$uniqueStr.=" AND ";
				}
			}
			mysql_close($con);
			$query = "SELECT * FROM `$tableName` WHERE " . $uniqueStr;
			
			if ($exec){
				return $this->executeQuery($query, false);
			}
			else{
				return $query;
			}
		}
		
		function createSelectAll($tableName, $exec){	
			$query = "SELECT * FROM `$tableName`";
			
			if ($exec){
				return $this->executeQuery($query, false);
			}
			else{
				return $query;
			}
		}
		
		function createInsertQuery($params, $tableName, $exec, $withId){
			$query = "INSERT INTO `$tableName` (";
			
			$theKeys = array_keys($params);
			for ($i = 0;$i<sizeof($theKeys);$i++){
				$query .= "`$theKeys[$i]`";
				if (($i + 1) != sizeof($theKeys)){
					$query .= ",";
				}
			}
			
			$query .= ") VALUES (";
			
			$theValues = array_values($params);
			$con = $this->connect();
			for ($i = 0;$i<sizeof($theValues);$i++){
				$theValues[$i] = mysql_real_escape_string($theValues[$i], $con);
				$query .= "'$theValues[$i]'";
				if (($i+1) != sizeof($theValues)){
					$query .= ",";
				}
			}
			mysql_close($con);
			$query .= ")";
			
			if ($exec){
				return $this->executeQuery($query, $withId);
			}
			else{
				return $query;
			}
		}
		
		function executeQuery($query, $withId){
			$con = $this->connect();
			$result = mysql_query($query, $con);
			$this->error =  mysql_error();
			
			$theId = mysql_insert_id();
			mysql_close($con);
			$this->lastQuery = $query;
			
			if ($this->debug){
				LogManager::Log($query);
			}
			
			if ($withId){
				return $theId;
			}
			else{
				return $result;
			}
		}
		
		function createDeleteQuery($unique, $tableName, $exec){
			$uniqueCol = (array_keys($unique));
			$uniqueVal = (array_values($unique));
			
			$uniqueStr ="";
			$con = $this->connect();
			for ($i = 0;$i<sizeof($uniqueCol);$i++){
				$uniqueVal[$i] = mysql_real_escape_string($uniqueVal[$i], $con);
				$uniqueStr.="`$uniqueCol[$i]`='$uniqueVal[$i]'";
				if (($i+1) != sizeof($uniqueCol)){
					$uniqueStr.=" AND ";
				}
			}
			mysql_close($con);
			$query = "DELETE FROM `$tableName` WHERE " . $uniqueStr;
			
			if ($exec){
				return $this->executeQuery($query, false);
			}
			else{
				return $query;
			}
		}
		
		function createUpdateQuery($unique, $params, $tableName, $exec){
			$uniqueCol = (array_keys($unique));
			$uniqueVal = (array_values($unique));
			
			$uniqueStr ="";
			$con = $this->connect();
			for ($i = 0;$i<sizeof($uniqueCol);$i++){
				$uniqueVal[$i] = mysql_real_escape_string($uniqueVal[$i], $con);
				$uniqueStr.="`$uniqueCol[$i]`='$uniqueVal[$i]'";
				if (($i+1) != sizeof($uniqueCol)){
					$uniqueStr.=" AND ";
				}
			}
			
			$theKeys = array_keys($params);
			$theValues = array_values($params);
			
			$query = "UPDATE `$tableName` SET ";
			for ($i=0;$i<sizeof($theKeys);$i++){	
				$theValues[$i] = mysql_real_escape_string($theValues[$i], $con);
				$query .= "`$theKeys[$i]`='$theValues[$i]'";
				if (($i+1) != sizeof($theValues)){
					$query .= ",";
				}
			}
			mysql_close($con);
			$query .= " WHERE " . $uniqueStr;
			
			if ($exec){
				return $this->executeQuery($query, false);
			}
			else{
				return $query;
			}
		}
	}

?>