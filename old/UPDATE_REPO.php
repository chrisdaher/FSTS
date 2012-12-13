<?php
	echo 'Attempting to update...';
	$output = exec('C:\\updateFSTS.bat');
	echo '<br/>';
	echo '<br/>';
	echo $output;
	echo '<br/>';
	echo '<br/>';
	echo 'done';
	//require_once('bitbucketapi.php');
	//displayLatest();

?>