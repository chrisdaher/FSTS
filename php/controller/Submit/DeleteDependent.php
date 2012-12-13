<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
$dependID=$_GET["dep_id"];
$fileID=$_GET["file_id"];

//delete dependent based on the id passed, and then redirect to the file passed
include("/../../services/mysql/phpMySql.php");
include("/../../model/mysqlManager.php");

$unique = array("id"=>$dependID);
$sql = new mysqlManager();
$sql->createDeleteQuery($unique, 'user', true);

$unique = array("user_id"=>$dependID);
$sql->createDeleteQuery($unique, 'income', true);

// $query = "DELETE FROM `user` WHERE `id`='$dependID'";
// sqlExecQuery($query);

header( 'Location: ../../../File_Page.php?id=' . $fileID . '&edit=0') ;

?>