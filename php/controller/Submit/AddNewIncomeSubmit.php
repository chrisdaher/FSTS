<?php

$Person = $_POST['Person'];
$IncomeType = $_POST['Type'];
$IncomeMode = $_POST['Mode'];
$StartDate = $_POST['sDate'];
$EndDate = $_POST['eDate'];
$incVal = $_POST['incVal'];
include_once("/../../model/Income.php");
session_start();
$incId = $_SESSION['incId'];
$_SESSION['incId'] = -1;
$famId = $_SESSION['famId'];
$inc = new Income($incId);
var_dump($incId);

$inc->user_id = $Person;
$inc->income_type_id = $IncomeType;
$inc->income_length_id = $IncomeMode;
$inc->start_date = $StartDate;
$inc->end_date = $EndDate;
$inc->value = $incVal;


if ($inc->update()){
	header("location: /FSTS/File_Page.php?id=$famId");
}
?>