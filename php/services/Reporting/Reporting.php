<?php
	include_once("ReportingHelper.php");
	include_once("ListKeyValue.php");
	include_once("/../../model/mysqlManager.php");
	
	
	
	$id = $_POST['query'];
	$start_date = $_POST["sDate"];
	$end_date = $_POST["eDate"];
	if ($start_date == "" || $end_date == ""){
		echo "Invalid start date or end date!";
		return;
	}
	$parse = intval($_POST["interval"]);
	
	if ($parse == 1){
		$dateArray = monthlyParse($start_date, $end_date);
	}
	else if ($parse == 2){
		$dateArray = weeklyParse($start_date, $end_date);
	}
	else if ($parse == 3){
		$dateArray = yearlyParse($start_date, $end_date);
	}
	else{
		return "ERROR";
	}
	
	
	
	$sdString = getdate(strtotime($start_date));
	$edString = getdate(strtotime($end_date));
	
	$day = $sdString['mday'];
	$temp = strval($day);
	if(strlen ($temp) < 2){
		$temp = '0'.$temp;
	}

	if ($temp[1] == 1 && $temp[0]!=1){
		$day .= 'st';
	}
	elseif ($temp[1] == 2 && $temp[0]!=1){
		$day .= 'nd';
	}
	elseif ($temp[1] == 3 && $temp[0]!=1){
		$day .= 'rd';
	}
	else{
		$day .=  'th';
	}
	
	$startDateString = $sdString['month'] . " " . $day . " " . $sdString['year'] ." ($start_date)";
	
	$day = $edString['mday'];
	$temp = strval($day);
	if(strlen ($temp) < 2){
		$temp = '0'.$temp;
	}

	if ($temp[1] == 1 && $temp[0]!=1){
		$day .= 'st';
	}
	elseif ($temp[1] == 2 && $temp[0]!=1){
		$day .= 'nd';
	}
	elseif ($temp[1] == 3 && $temp[0]!=1){
		$day .= 'rd';
	}
	else{
		$day .=  'th';
	}
	
	$endDateString = $edString['month'] . " " . $day . " " . $edString['year'] . " ($end_date)";
	
	$conv = $reportingTags[$id];
	
	$series = array();
	$data = $conv->getTableData();
	$seriesdata = array();
	$seriesdataid = array();
	$cntr = 0;
	$key = $conv->getKey();
	$idKey = $conv->getIDKey();
	
	for ($i=0;$i<sizeof($data);$i++){
		$seriesdata[$cntr] = $data[$i][$key];
		$seriesdataid[$cntr] = $data[$i][$idKey];
		$cntr++;
	}
		
	for ($i=0;$i<sizeof($seriesdata);$i++){
		$series[$i] = new ListKeyValue($seriesdata[$i], $seriesdataid[$i]);
	}
	$mysql = new mysqlManager();
	$tableName = $reportingTables[$id];
	$columnName = $reportingColumns[$id];
	$columnDate = $reportingDateColumn[$id];
	for ($i=0;$i<sizeof($series);$i++){
		for ($j=0;$j<sizeof($dateArray)-1;$j++){
			$start_date = $dateArray[$j];
			$end_date = $dateArray[$j+1];
			
			$query = "SELECT * FROM `" . $tableName . "` WHERE `". $columnName ."` = '" . $series[$i]->dbId . "'";
					
			if ($columnDate != ""){
				$query .= " AND `" . $columnDate . "` >= '" . $start_date . "' AND `" . $columnDate . "` <= '" . $end_date ."'";	
			}
			
			$res = $mysql->executeQuery($query, false);
			$rows = null;
			while($r = mysql_fetch_assoc($res)) {
					$rows[] = $r;
			}
			
			$series[$i]->addKeyValue($dateArray[$j], sizeof($rows));
		}
	}
	echo json_encode($series);
	
	
	function weeklyParse($sd, $ed){
		$data = preg_split("/-/", $sd);
		
		$syear = $data[0];
		$smonth = $data[1];
		$sday = $data[2];
		
		$data = preg_split("/-/", $ed);
		
		$eyear = $data[0];
		$emonth = $data[1];
		$day = $data[2];
		
		$sdObj = new DateTime($sd);
		$edObj = new DateTime($ed);
		
		$interval = getInterval($sdObj, $edObj);
		
		$weeks = getIntervalWeeks($interval);
		$toRet = array();
		$weeks+=2;
		for ($i=0;$i<$weeks;$i++){
			if ($i==0){
				$toRet[$i] = date("Y-m-d", strtotime($sd));
			}else{
				$toRet[$i] = date("Y-m-d",mktime(0,0,0, $smonth, $sday + $i*7, $syear));
			}
		}
		return $toRet;
		
	}
	
	function monthlyParse($sd, $ed){
		$data = preg_split("/-/", $sd);
		
		$syear = $data[0];
		$smonth = $data[1];
		$sday = $data[2];
		
		$data = preg_split("/-/", $ed);
		
		$eyear = $data[0];
		$emonth = $data[1];
		$day = $data[2];
		
		$sdObj = new DateTime($sd);
		$edObj = new DateTime($ed);
		
		$interval = getInterval($sdObj, $edObj);
		
		$months = getIntervalMonths($interval);
		$toRet = array();
		$months+=1;
		for ($i=0;$i<$months;$i++){
			if ($i==0){
				$toRet[$i] = date("Y-m-d", strtotime($sd));
			}else{
				$toRet[$i] = date("Y-m-d",mktime(0,0,0, $smonth + 1*$i, $sday, $syear));
			}
		}
		return $toRet;
	}
	
	function yearlyParse($sd, $ed){
		$data = preg_split("/-/", $sd);
		
		$syear = $data[0];
		$smonth = $data[1];
		$sday = $data[2];
		
		$data = preg_split("/-/", $ed);
		
		$eyear = $data[0];
		$emonth = $data[1];
		$day = $data[2];
		
		$sdObj = new DateTime($sd);
		$edObj = new DateTime($ed);
		
		$interval = getInterval($sdObj, $edObj);
		
		$years = getIntervalYear($interval);
		$toRet = array();
		$years+=1;
		for ($i=0;$i<$years;$i++){
			if ($i==0){
				$toRet[$i] = date("Y-m-d", strtotime($sd));
			}else{
				$toRet[$i] = date("Y-m-d",mktime(0,0,0, $smonth, $sday, $syear + 1*$i));
			}
		}
		return $toRet;
	}
	
	function getInterval($sd, $ed){
		return $ed->diff($sd);
	}
	
	function getIntervalYear($in){
		$years = $in->y;
		$years += ($in->m/12);
		$years += ($in->d/365);
		
		return $years;
	}
	
	function getIntervalMonths($in){
		$months = $in->y*12;
		$months += $in->m;
		$months += ($in->d/30);
		return $months;
	}
	
	function getIntervalWeeks($in){
		$weeks = $in->y*52;
		$weeks += $in->m*4;
		$weeks += ($in->d/7);
		return $weeks;
	}
	
	function getIntervalDays($in){
		$daysTotal = $in->y*365;
		$daysTotal += $in->m*12;
		$daysTotal += $in->d;
		return $daysTotal;
	}
	
?>