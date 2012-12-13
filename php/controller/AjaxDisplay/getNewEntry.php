<?php

$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."AdminResult.php");

$section = $_GET["Section"];
$toRet="";
$Data = array("");

if($section == "PostalCode"){
$Data = array("", "", "");
}elseif($section == "IncomeLength"){
$Data = array("", "");
}
$tempResult = new AdminResult($Data, $section, -1, true);
$container = $tempResult->getContainer();
$toRet .= $container->toHTML();
echo $toRet;
?>