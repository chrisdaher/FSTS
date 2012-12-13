<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

session_start();
include("/../../services/mysql/phpMySql.php");
include("/../../services/mysql/dbSqlToText.php");
include("/../../model/User.php");
$famId = $_SESSION['famId'];
$depId = $_SESSION['depId'];
$_SESSION['depId'] = -1;
$fname= $_POST["dep_fname"];
$lname= $_POST["dep_lname"];
$medicard= $_POST["dep_medicard"];
$age=$_POST["dep_age"];
$contact = $_POST["dep_contact"];
$gender=$_POST["dep_gender"];
$gender = GenderToInt($gender);
$contact = ContactToInt($contact);

if ($depId <= 0){ //new file
	//new user
	$usr = new User(-1, false);
	$usr->first_name = $fname;
	$usr->last_name = $lname;
	$usr->medicard = $medicard;
	$usr->age = $age;
	$usr->gender = $gender;
	$usr->family_id = $famId;
	$usr->contact = $contact;
	
	$usr->update();
	
	// $query = "INSERT INTO `user` (`first_name`, `last_name`, `medicard`, `age`, `gender`, `family_id` ,`contact`) VALUES ('$fname', '$lname', 
	// '$medicard','$age', '$gender', '$famId', '$contact')";
	
	// sqlExecQuery($query);
}
else{
	$usr = new User($depId, true);
	$usr->first_name = $fname;
	$usr->last_name = $lname;
	$usr->medicard = $medicard;
	$usr->age = $age;
	$usr->gender = $gender;
	$usr->contact = $contact;
	
	$usr->update();
	
	// //this is edit
	// $query = "UPDATE `user` SET `first_name` = '$fname' , `last_name`='$lname' , `medicard`='$medicard' , `age`='$age' , `gender`='$gender', 
			// `contact` = '$contact' WHERE `id`='$depId'";
	// sqlExecQuery($query);	
}

header( 'Location: ../../../File_Page.php?id=' . $famId . '&edit=0') ;
?>