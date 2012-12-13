<?php
$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."MainDiv_AdminBuilder.php");

$section = $_GET["Section"];
$text = $_GET["Text"];

$main = new MainDiv_AdminBuilder($section, $text);
$toRet=$main->getContainer()->toHTML();
echo $toRet;
?>