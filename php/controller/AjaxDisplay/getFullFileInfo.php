<?php

$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."FileDisplay_MainFileHoverBuilder.php");
$subFolder="\\..\\..\\view\\Components\\";
include_once($subFolder."FileDisplay_MainEventHoverBuilder.php");

$id = $_GET["id"];
$isEvent = $_GET["isEvent"];
$searchString = $_GET["searchString"];

$builder;
if($isEvent=="true"){
    $builder= new FileDisplay_MainEventHoverBuilder($id, $searchString);
}else{
    $builder= new FileDisplay_MainFileHoverBuilder($id, $searchString);
}

$toRet = $builder->getContainer()->toHTML();

echo $toRet;
?>