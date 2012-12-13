<?php
$subFolder = "../../Components/";
include_once($subFolder."DroppedFileBuilder.php");

$theKeys = array_keys($_GET);
for ($i = 0;$i<count($theKeys);$i++){
	$_GET[$theKeys[$i]] = preg_replace("/\\\s/"," ",$_GET[$theKeys[$i]]);
}

$FileFoundID=$_GET['FileID'];

$FileDropped = new DroppedFileBuilder($FileFoundID);
$toRet = $FileDropped->getContainer()->toHTML();

echo($toRet);

?>