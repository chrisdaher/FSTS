<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();
$famId = $_SESSION['famId'];

include_once("/../../model/mysqlManager.php");

$unique = array("id"=>$famId);
$params = array("active"=>0);
$sql = new mysqlManager();

$sql->createUpdateQuery($unique, $params, 'file', true);

// $query = "UPDATE `file` SET `active`='0' WHERE `id`='$famId'";
// sqlExecQuery($query);

header( 'Location: ../../../Homepage.php') ;
?>