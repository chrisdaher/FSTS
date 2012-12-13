<?php
	include_once("../../model/mysqlManager.php");
	
	$query = $_POST["query"];
	$tquery = strtolower($query);
	if (strstr($tquery, "delete")){
		echo "Delete statement is not allowed!";
		return;
	}
	if (strstr($tquery, "insert")){
		echo "Insert statement is not allowed!";
		return;
	}	
	if (strstr($tquery, "update")){
		echo "Update statement is not allowed!";
		return;
	}
	$mysql = new mysqlManager();
	$res = $mysql->executeQuery($query, false);
	
	if ($mysql->error != null){
		echo $mysql->error;
		return;
	}
	
	//echo mysql_fetch_array($res);
	
	 $row = mysql_fetch_array($res);
	 if ($row == null){
		echo "No results found!";
		return;
	 }
	 
	 $keys = array_keys($row); //THOSE ARE THE COLUMN NAMES!
	 $toRet="";
	 
	 $headers = array();
	 $rows = array();
	for ($i=0;$i<sizeof($keys);$i++){
		if($i%2==1){
			$headers[sizeof($headers)] = $keys[$i];
		}
	}
	while ($row){	
		$tempRow = array();
		for ($i=0;$i<sizeof($keys);$i++){
			if($i%2==1){
				$tempRow[sizeof($tempRow)] = $row[$keys[$i]];
			}
		}
		$rows[sizeof($rows)] = $tempRow;
		$row = mysql_fetch_array($res);
	}
	
	$toRet = "<thead><tr>";	
	for($i = 0; $i<sizeof($headers); $i++){
		$toRet.="<th>".$headers[$i]."</th>";
	}
	$toRet.="</thead><tbody>";
	$cntr = 0;
	for ($i = 0;$i<sizeof($rows);$i++){
		$toRet.="<tr>";
			for($j=0;$j<sizeof($rows[$i]);$j++){
			  $toRet.="<td>".$rows[$i][$j]."</td>";
			}
		$toRet.="</tr>";
		$cntr++;
	}
	$toRet.="</tbody>";
	$toRet = "$cntr results found.<br/>" . $toRet;
	
	
	echo $toRet;

?>