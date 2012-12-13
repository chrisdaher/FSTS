<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();
include_once("/../../model/mysqlManager.php");
include_once("/../../model/File.php");
include_once("/../../model/User.php");
include_once("/../../model/FileInfo.php");
include_once("/../../services/mysql/phpMySql.php");
include_once("/../../services/mysql/dbSqlToText.php");
$famId = $_SESSION['famId'];

$FirstName=$_POST['input_First'];
$LastName=$_POST['input_Last'];
$StreetNumber=$_POST['input_StreetNumber'];
$StreetName=$_POST['input_Street'];
$City=$_POST['input_City'];
$Province=$_POST['input_Province'];
$PostalCode=$_POST['input_PostalCode'];
$Age=$_POST['input_Age'];
$Gender=$_POST['input_Gender'];
$Medicard=$_POST['input_Medicard'];
$WorkStatus=$_POST['input_WorkStatus'];
$Language=$_POST['input_Language'];
$MaritalStatus=$_POST['input_MaritalStatus'];
$Referral=$_POST['input_Referral'];
$dob = $_POST['input_DateOfBirth'];
$Contact=$_POST['input_Contact'];
$FirstVisit=$_POST['input_FirstVisit'];
$Notes=$_POST['input_Notes'];
$Status=$_POST['input_Status'];

if ($Notes == NULL) $_POST['input_Notes'] = 'Nothing to note.';
$Age = intval($Age);
$StreetNumber = intval($StreetNumber);
$Notes=$_POST['input_Notes'];

//make sure valid inputs
// foreach ($_POST as $pstVar){
	// if ($pstVar == NULL){
		// header( 'Location: ../../File_Page.php?id=' . $famId . '&edit=1') ;
		// die("Invalid inputs");
	// }
// }

//Convert Workstatus to nb
$WorkStatus = WorkStatusToInt($WorkStatus);
$Language = LanguageToInt($Language);
$MaritalStatus = MaritalStatusToInt($MaritalStatus);
$Gender = GenderToInt($Gender);
$Contact = ContactToInt($Contact);
//check first if its an int!!
if (is_int($famId)){
	$file = new File($famId, true);
	//family exist BUT MAKE SURE cause its from a GET!
	
	if (!$file){
		//ERRROR
		echo "ERROR FAMILY DOES NOT EXIST WITH $famId IN DB!";
		echo "<br /> Redirecting...";
		sleep(2);
		header( 'Location: ../../../Homepage%20Prototype.php ') ;
	}
	else{
		//get the file info id
		$fileInfoId = $file->fileInfoId;
		//get the independent id
		$independentId = $file->independentId;
		
		$fileInfoObj = new FileInfo($fileInfoId);
		
		//do the update
		$fileInfoObj->addr_street = $StreetName;
		$fileInfoObj->addr_city = $City;
		$fileInfoObj->addr_nb = $StreetNumber;
		$fileInfoObj->addr_prov = $Province;
		$fileInfoObj->addr_pcode = $PostalCode;
		$fileInfoObj->notes = $Notes;
		
		$fileInfoObj->update();
		
		//this is an FILE INFO update
		// $query = "UPDATE `file_info` SET `addr_street` = '$StreetName', `addr_city` = '$City', 
			// `addr_nb` = '$StreetNumber', `addr_prov` = '$Province', 
			// `addr_pcode` = '$PostalCode', `notes` = '$Notes' WHERE `id` = '$fileInfoId'";
		// sqlExecQuery($query);
		
		//this is the independent update
		
		$user = new User($independentId, false);
		
		$user->first_name = $FirstName;
		$user->last_name = $LastName;
		$user->medicard = $Medicard;
		$user->work_status = $WorkStatus;
		$user->language = $Language;
		$user->marital_status = $MaritalStatus;
		$user->gender = $Gender;
		$user->age = $Age;
		$user->referral = $Referral;
		$user->contact = $Contact;
		$user->first_visit = $FirstVisit;
		$user->dateBirth = $dob;
		
		$user->update();
		
		// $query = "UPDATE `user` SET `first_name` = '$FirstName' , `last_name` = '$LastName', `medicard` = '$Medicard', 
			// `work_status` = '$WorkStatus', `Language` = '$Language', `marital_status` = '$MaritalStatus', `gender` = '$Gender', `age`='$Age',
			// `referral` = '$Referral', `contact` = '$Contact', `first_visit` = '$FirstVisit', `dateBirth`='$dob' WHERE `id` = '$independentId'";
		// sqlExecQuery($query);
		header( 'Location: ../../../File_Page.php?id=' . $famId . '&edit=0') ;
		echo "all good";
	}
}	
else{
	//this is a new file
	//insert for FILE INFO
	
	$fileInfoObj = new FileInfo(-1);
	$fileInfoObj->addr_street = $StreetName;
	$fileInfoObj->addr_city = $City;
	$fileInfoObj->addr_nb = $StreetNumber;
	$fileInfoObj->addr_prov = $Province;
	$fileInfoObj->addr_pcode = $PostalCode;
	$fileInfoObj->notes = $Notes;
	
	$fileInfoObj->update();
	$fileInfoId = $fileInfoObj->id;
	
	// $query = "INSERT INTO  `file_info` (`addr_street`, `addr_nb`, `addr_city`, `addr_prov`, `addr_pcode`, `notes`) VALUES
		// ('$StreetName', '$StreetNumber', '$City', '$Province', '$PostalCode', '$Notes')";
	// $fileInfoId = sqlExecQueryWithId($query);
	
	$user = new User(-1, false);
	
	$user->first_name = $FirstName;
	$user->last_name = $LastName;
	$user->medicard = $Medicard;
	$user->work_status = $WorkStatus;
	$user->language = $Language;
	$user->marital_status = $MaritalStatus;
	$user->gender = $Gender;
	$user->age = $Age;
	$user->referral = $Referral;
	$user->contact = $Contact;
	$user->first_visit = $FirstVisit;
	$user->dateBirth = $dob;
	
	$user->update();
	$indepedentId = $user->id;
	
	//insert for USER INFO
	// $query = "INSERT INTO `user` (`first_name`, `last_name`, `medicard`, `work_status`, `language`, `marital_status`, 
		// `referral`, `contact`, `first_visit`, `age`, `gender`, `dateBirth`) VALUES ('$FirstName', '$LastName', '$Medicard', '$WorkStatus', '$Language',
		// '$MaritalStatus', '$Referral', '$Contact', '$FirstVisit', '$Age', '$Gender', $dob)";
	// $indepedentId = sqlExecQueryWithId($query);
	
	$file = new File(-1, false);
	$file->independentId = $indepedentId;
	$file->fileInfoId = $fileInfoId;
	$file->isActive = 1;
	
	$file->update();
	$famId = $file->id;
	
	//insert for FILE
	// $query = "INSERT INTO `file` (`indepedent_id`, `file_info_id`) VALUES ('$indepedentId', '$fileInfoId')";
	// $famId = sqlExecQueryWithId($query);
	
	//update user info with family id
	$user->family_id = $famId;
	$user->update();
	
	// $query = "UPDATE `user` SET `family_id` = '$famId' WHERE `id` = '$indepedentId'";
	// sqlExecQueryWithId($query);
	
	header( 'Location: ../../../File_Page.php?id=' . $famId . '&edit=0') ;
	echo "new file";
}

?>