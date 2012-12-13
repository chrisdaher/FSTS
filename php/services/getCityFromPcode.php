<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	$pcode = "";
	if (isset($_GET['pcode'])){
		$pcode = $_GET['pcode'];
	}
	
	include_once("/../model/mysqlManager.php");
	
	
	if ($pcode != ""){
		
	
		$mysql = new mysqlManager();
		$res = $mysql->createSelectQuery(array("pcode"=>$pcode), "postalcodeconverter", true);
		$row = mysql_fetch_array($res);
		if ($row == ""){ //not found
			echo "";
		}
		else{
			echo $row['city'].'::'.$row['province'];
		}
	}
	
	function getPcode($pcode){
		$pcode = substr($pcode, 0,3);
		$mysql = new mysqlManager();
		$res = $mysql->createSelectQuery(array("pcode"=>$pcode), "postalcodeconverter", true);
		$row = mysql_fetch_array($res);
		if ($row == ""){ //not found
			return "";
		}
		else{
			return $row['city'].'::'.$row['province'];
		}
	}
?>