<?php

	include("../php/db/phpMySql.php");	
	include("../php/db/dbSqlToText.php");	
	
	$myFile = "pcodes.txt";
	$fh = fopen($myFile, 'r');
	$line = true;
	while($line != false){
		$line = fgets($fh);
		$line = chop($line);
		$data = split("/", $line);
		$pcode = $data[0];
		$city = $data[1];
		$query = "INSERT INTO `postalcodeconverter` (`pcode`,`city`) VALUES ('$pcode','$city')";
		sqlExecQuery($query);
		echo $query . "<br/>";
	}
		
	fclose($fh);
		
?>