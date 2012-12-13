<?php
	/* LOCAL SETTINGS 
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPw = NULL;
	$dbName = "fsts";
	*/
	/*TEST SERVER SETTINGS*/
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPw = "photasmomak";
	$dbName = "fsts";
	include_once("/../Logging/LogManager.php");
	if(!function_exists('connectToDb')){
	function connectToDb(){
	
		//global $dbHost, $dbUser, $dbPw, $dbName;
		$dbHost = "localhost";
		$dbUser = "root";	
		$dbPw = "photasmomak";
		$dbName = "fsts";
	
		$con = mysql_connect($dbHost,$dbUser, $dbPw);	
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		
		return $con;
	}
	
	function selectWhereQuery($tableName, $whereColVar, $whereVal){
		$dbHost = "localhost";
		$dbUser = "root";	
		$dbPw = "photasmomak";
		$dbName = "fsts";	
				
		$con = connectToDb();
		
		 mysql_select_db($dbName, $con);
		
				
		$queryString = "SELECT * FROM `$tableName` WHERE `$whereColVar`='$whereVal'";
		logger($queryString);
		$result = mysql_query($queryString);
		
		
		mysql_close($con);
		
		return $result;
	
	}
	
	function safe_field_name($str){
		//return mysql_real_escape_string($str);
		return $str;
	}
	
	function logger($str){
		// $myFile =  "log.txt";
		// $fh = fopen($myFile, 'a') or die("can't open file");
		// if (!$fh) throw new Exception("ASD");
		// $str = $str . "\n";
		// fwrite($fh, $str);
		// fclose($fh);
		$debug = true;
		if ($debug){
			// $backtrace = debug_backtrace();
			// $final = "";
			// for ($i=1;$i<sizeof($backtrace);$i++){
				// $temp = $backtrace[$i]['file'];
				// $pos = strrpos($temp, "\\");
			
				// $final = $final. substr($temp, $pos + 1, (strlen($temp) - $pos));
				// if (($i+1) != sizeof($backtrace)){
					// $final .= "::";
				// }
			// }
			// $final = str_replace(".php","", $final);
			LogManager::Log($str);
		}
	}
	
	function sqlExecQuery($theQuery){
		$theQuery = safe_field_name($theQuery);
		$dbHost = "localhost";
		$dbUser = "root";	
		$dbPw = "photasmomak";
		$dbName = "fsts";	
		$con = connectToDb();
		
		mysql_select_db($dbName, $con);
		
		$result = mysql_query($theQuery);
		logger($theQuery);
		
		$err =  mysql_error();
		if ($err!=""){
			logger("ERROR: " . $err);
		}
		mysql_close($con);
		return $result;
		//return $err;
		
	}
	
	function sqlExecQueryCustom($theQuery, $theRes, $close){
		$dbName = "fsts";	
		
		mysql_select_db($dbName, $theRes);
		$result = mysql_query($theQuery);
		logger($theQuery);
		if ($close){
			mysql_close($theRes);
		}
		return $result;
	}
	
	function sqlExecQueryWithId($theQuery){
		global $dbHost, $dbUser, $dbPw, $dbName;
		$con = connectToDb();
		
		mysql_select_db($dbName, $con);
		
		$result = mysql_query($theQuery);
		
		$theId = mysql_insert_id();
		//echo mysql_error();
		mysql_close($con);
		return $theId;
		
	}
	
	function insertQuery($tableName, $colVar, $colVal){
		
	}
	}

?>