<?php
	$username = "bitbucketapiryannasr";
	$password="bitbucketapi9%";
	$dirName = "bitbucketAPI_temp";
	
	
	$url = "https://api.bitbucket.org/1.0/repositories/ryannasr/soen390_team5/changesets";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 4);
	$json = curl_exec($ch);
	if(!$json) {
		echo curl_error($ch);
		
	}
	curl_close($ch);
	$res = json_decode($json, true);
	$arrKeys = array_keys($res);
	$arrVal = array_values($res);

		$changeSets = $res['changesets'];
	$arrKeys = array_keys($changeSets);
	$lastIndex = count($arrKeys) -1;
	$aChange = $changeSets[$lastIndex];
	$arrKeys = array_keys($aChange);
	
	$prevRevision = $aChange['revision'] -1 ;
	
	echo "<br/><br/>Attempting to update to rev #$prevRevision <br/>";
	
	$output = exec("updateTempRepo.bat $prevRevision $dirName");
	print($output . "<br/>");
	echo "<br/>done<br/>";
	
	include('diff.php');
	$dirName = "bitbucketAPI_temp";
	
	$neededType = 'modified';
	foreach ($files as $file){
		$theFile = $file['file'];
		$theType = $file['type'];
		if (strcmp($theType, $neededType) == 0){
			echo "FILE: $theFile<br/><br/>";
			
			$diff = new diff;
			$text = $diff->inline("$dirName/$theFile", "$theFile",2);
			echo count($diff->changes).' changes';
			echo $text;
			print_r("<br/>");
			print_r("<br/>");
		}
	}

?>