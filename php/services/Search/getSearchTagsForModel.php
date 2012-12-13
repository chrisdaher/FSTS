<?php
	include_once("SearchHelper.php");
	$id = $_GET['id'];
	$id = str_replace(".","", $id);
	
	$id = $modelsHelper[$id];
	//$searchKeys =  $modelTags[$id]->getSearchKeys();
	
	$searchKeys = $modelTags[$id]->getFriendlySearchKeys();	
	
	echo json_encode($searchKeys);
?>