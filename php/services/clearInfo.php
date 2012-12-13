<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	session_start();
	$_SESSION['depId'] = -1;
	$_SESSION['incId'] = -1;
	echo "OK";
?>