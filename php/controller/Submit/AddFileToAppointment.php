<?php
$fp = fopen("lock.txt", "a");
while (!flock($fp, LOCK_EX)){}
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include("/../../services/mysql/phpMySql.php");
include_once("/../../model/Appointment.php");
include_once("/../../model/File.php");
include_once("/../../model/mysqlManager.php");
$currSize = -1;

$fid = $_GET["fileID"];
$appid = $_GET["appID"];
$evid = $_GET["eventID"];

$app = new Appointment($appid);
$file = new File($fid, true);
$event = new Event($evid, false);

$sizeOfFile = $file->dependents;
$sizeOfFile = sizeof($sizeOfFile);
$sizeOfFile++;
if (!$app){
	echo $fid . ":E:Appointment ID does not exist!";
}
else{
	if (!$event->isOpen){
		echo $fid . ":E:Event is closed!";
	}
	else{
		$ed = $event->end_date;
		$ed = preg_split("/ /", $ed);
		$ed = $ed[0];
		if ($ed < date("Y-m-d")){
			$event->closeEvent();
			$event->update();
			echo $fid.":E:Event end date has passed!";
			
		}
		else{
			if ($app->capacity == $app->size){
				echo $fid.":E:Appointment is full!";
			}
			else if( $app->capacity < ($app->size + $sizeOfFile)){
				echo $fid.":E:Appointment does not fit file size (+$sizeOfFile)";
			}
			else{
				if (!$file){
					echo $fid . ":E:File does not exist!";
				}
				else{
					$found = false;
					for ($i = 0;$i<sizeof($file->events);$i++){
						$ev = $file->events[$i];
						if ($ev->event_id == $evid){
							$found = true;
							break;
						}
					}		
					if ($found){
						echo $fid . ":E:File id already registered in this event!";
					}
					else{
						$mysql = new mysqlManager();
						$params = array("event_id"=>$evid,"file_id"=>$fid,"appointment_id"=>$appid);
						$mysql->createInsertQuery($params, "event_user_linker", true, false);
						if ($mysql->error != null){
							echo $fid . ":E:".$mysql->error;
						}
						else{
							$count = sizeof($file->dependents);
							$count++;
							$app->size+=$count;
							if ($app->update()){
								echo $fid .":S";
							}
							else{
								echo $fid.":E:Something happened...";
							}
						}
					}
				}
			}
		}
	}
}

flock($fp, LOCK_UN); // release the lock
fclose($fp);
// $query = "SELECT * FROM `appointment` WHERE `id`='$appid'";
// $res = sqlExecQuery($query);
// $row = mysql_fetch_array($res);

// if ($row == null){
	// echo $fid . ":E:Appointment ID does not exist!";
// }
// else{
	// $capacity = $row['capacity'];
	// $currSize = intval($row['size']);
	// //fwrite($fp, "IM IN - ".$currSize."\n");
	// //make sure appointment NOT FULL
	// if ($currSize >= $capacity){
		// echo $fid.":E:Appointment is full!";
	// }
	// else{
		// $currSize++;
		
		// //make sure this file is not already registered
		// $query = "SELECT * FROM `event_user_linker` WHERE (`event_id`='$evid' AND `file_id`='$fid')";
		// $res = sqlExecQuery($query);
		// $row = mysql_fetch_array($res);
		// if ($row != null){
			// echo $fid . ":E:File id already registered in this event!";
		// }
		// else{
			// //do the insert
			// $query = "INSERT INTO `event_user_linker` (`event_id`, `file_id`, `appointment_id`) VALUES ('$evid', '$fid', '$appid')";
			// sqlExecQuery($query);
			
			// $query = "UPDATE `appointment` SET `size`='$currSize' WHERE `id`='$appid'";
			// sqlExecQuery($query);
			// echo $fid .":S";
		// }
	// }
// }
// //fwrite($fp, "IM OUT - ".$currSize."\n");

?>