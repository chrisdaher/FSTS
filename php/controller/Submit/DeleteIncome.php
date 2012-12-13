<?php
$IncomeID=$_GET["inc_id"];
$fileID=$_GET["file_id"];

include("/../../model/Income.php");

$inc = new Income($IncomeID);
var_dump($IncomeID);
$inc->delete();
header("location: /FSTS/File_Page.php?id=$fileID");
?>