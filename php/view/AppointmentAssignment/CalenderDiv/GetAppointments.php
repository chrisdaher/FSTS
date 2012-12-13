<?php


 function partition($arr, $left, $right, $part){
	global $arr;
	$i = $left;
	$j = $right;	
	$pivot = $arr[($left+$right)/2];
	
	$d1;
	$d2;
	$dpiv = date($pivot[$part]);
	$temp;
	while ($i <= $j){
	
		$d1 = date($arr[$i][$part]);
		
		while ($d1 < $dpiv){
			$i++;
			$d1 = date($arr[$i][$part]);
		}
		
		$d2 = date($arr[$j][$part]);
		
		while ($d2 > $dpiv){
			$j--;
			$d2 = date($arr[$j][$part]);
		}

		if ($i <= $j){
			$temp = $arr[$i];
			$arr[$i] = $arr[$j];
			$arr[$j] = $temp;
			
			//logger("SWAPPED: " . $arr[$j][$part] . " WITH: " . $arr[$i][$part]);
			$i++;
			$j--;
			
			
		}
	}
	return $i;
 }
 
 function quicksort($arr, $left, $right, $part){
	global $arr;
	$index = partition($arr, $left, $right, $part);
	
	if ($left < ($index-1)){
		quicksort($arr, $left, $index -1, $part);
	}
	if ($index < $right){
		quicksort($arr, $index, $right, $part);
	}
 }


//get appointments of the event

$ContainerHeight = (sizeof($Appointments)*72)."px";
//need to order the appointments

//var_dump($Appointments);
if (sizeof($Appointments) > 1){
	$arr = $Appointments;
	quicksort($arr, 0, sizeof($Appointments) -1, 'start_date');
	$Appointments  = $arr;
}


print("
        <div id=\"div_CalenderBox\" style=\"height:$ContainerHeight\">
");
    foreach($Appointments as $AppointmentID){
        $_GET["AppointmentID"]=$AppointmentID['id'];
        include("CreateAppointmentDiv.php");
    }
print("
        </div>
");
?>