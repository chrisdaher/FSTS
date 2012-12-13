<?php
    include_once("/../../services/mysql/phpMySql.php");	
    include_once("/../../services/mysql/dbSqlToText.php");	
    include_once("/../../model/Finders/IncludeAllFinders.php");
       
    $key = $_GET["SearchString"];
    $ff = new FileFinder();
    $gf = new GlobalFinder($ff);
    $ef = new EventFinder();
	$gf->setFinder($ef);
	
	$id = intval($key);
	$cntr = 0;
	$isDate = strstr($key, "-");
	$isNextKeyword = strstr($key, "next ") || $isNextKeyword = strstr($key, "Next ");
	$tempKey = $key;
	$tempKey = strtolower($tempKey);
	
	$isCustomKeyDate = false;
	
	$FileIDs = array();
	if ($tempKey=='tomorrow'){
		// $test = mktime(0,0,0,date("m"), date("d")+1, date("y"));
		// $test = date("Y-m-d",$test);
		// var_dump($test);
		$next = mktime(0,0,0,date("m"), date("d")+1, date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($tempKey=='yesterday'){
		$next = mktime(0,0,0,date("m"), date("d")-1, date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($tempKey=='today'){
		$next = mktime(0,0,0,date("m"), date("d"), date("y"));
		$next = date("Y-m-d",$next);
		$isCustomKeyDate = true;
	}
	elseif ($isNextKeyword){
		$split = preg_split("/ /", $key);
		
		
		$days = array("sunday"=>0, "monday"=>1, "tuesday"=>2, "wednesday"=>3, "thursday"=>4, "friday"=>5, "saturday"=>6);
		$theKeys = array_keys($days);
		if (sizeof($split) == 2){
			$sear = $split[1];
			$sear = strtolower($sear);
			$today = date("Y-m-d");
			
			if ($sear == 'week'){
				$next = mktime(0, 0, 0, date("m"), date("d")+6, date("y"));
				$next = date("Y-m-d",$next);
				$isCustomKeyDate = true;
			}
			else{
				
				if (in_array($sear, $theKeys)){
					$dayRequested = $days[$sear];
					$dw = date("w");
				
					if (($dayRequested - $dw)>0){
						$diff = $dayRequested - $dw;
					}
					else{
						$diff = (7-$dw) + $dayRequested;
					}
					
					$next = mktime(0, 0, 0, date("m"), date("d")+$diff, date("y"));
					$next = date("Y-m-d",$next);
					$isCustomKeyDate = true;
				}
			}
			
		}
		elseif(sizeof($split)==3){
			$sear = $split[2];
			$after = $split[1];
			
			if ($sear == 'weeks' || $sear=='week'){
				$next = mktime(0, 0, 0, date("m"), date("d")+(($after)*7), date("y"));
				$next = date("Y-m-d",$next);
				$isCustomKeyDate = true;
			}
			else{
			
				$sear = strtolower($sear);
						
				$today = date("Y-m-d");
				if (in_array($sear, $theKeys)){
					$dayRequested = $days[$sear];
					$dw = date("w");
					
					
					
					if (($dayRequested - $dw)>0){
						$diff = $dayRequested - $dw;
					}
					else{
						$diff = (7-$dw) + $dayRequested;
					}
					$diff+=(($after-1)*7);
					$next = mktime(0, 0, 0, date("m"), date("d")+$diff, date("y"));
					$next = date("Y-m-d",$next);		
					$isCustomKeyDate = true;
				}
			}
			
		}
	}
	else{
		if ($id>0 && !$isDate){ //event id search
			$sk = $ef->getSearchKeyById($id);
			$res = $gf->find(array($sk), false);	
			if (sizeof($res)>0){
				$FileIDs[$cntr] = $res[0]->event_id;
				$cntr++;
			}
		}
		else if ($isDate){
			$sk = $ef->getSearchKeyByStartDate($key);
			$res = $gf->find(array($sk), true);
			for ($i=0;$i<sizeof($res);$i++){
				$FileIDs[$cntr] = $res[$i]->event_id;
				$cntr++;
			}
		}
	}
	
	if ($isCustomKeyDate){
		
		$sk = $ef->getSearchKeyByStartDate($next);
		$res = $gf->find(array($sk), true);
		for ($i=0;$i<sizeof($res);$i++){
			$FileIDs[$cntr] = $res[$i]->event_id;
		$cntr++;
		}
	}
	
	$sk = $ef->getSearchKeyByText($key);
	$res = $gf->find(array($sk), true);
	for ($i=0;$i<sizeof($res);$i++){
		$FileIDs[$cntr] = $res[$i]->event_id;
		$cntr++;
	}
    print('
        <tr>
        <th>Event ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Register</th>
        </tr>
    ');
        for($i=0; $i<sizeof($FileIDs);$i++)
        {
            $event = new Event($FileIDs[$i], false);
            $eventID = $event->event_id;
            $eventName = $event->event_name;
            $eventType = $event->getEventTypeString();
            $startDate = $event->getStartDate();
            $endDate = $event->getEndDate();
            print("<tr><td>$eventID</td><td>$eventName</td><td>$eventType</td><td>$startDate</td><td>$endDate</td><td><button class=\"registerToEvent\" EventID=\"$eventID\"></button></td></tr>"); 
        }
?>	