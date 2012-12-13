<?php
	function countLine($path){
		//$path = "C:\wamp\www\FSTS\php\services\mysql\phpMySql.php";
		$array = preg_split("/\n/", file_get_contents($path));
		$loc = array();
			
		$noCount = array("//", "/*", "*/", "function", "include", "{", "}", "\n", "<?php", "<?","?>");
		
		$val;
		$isCommentBlock = false;
		$currCount = 0;
		for ($i=0;$i<sizeof($array);$i++){
			$val = isInNoCount($array[$i], $noCount);
			if ($val == -1 && !$isCommentBlock){
				$currCount++;
			}
			else if ($val == 1){
				$isCommentBlock = true;
			}
			else if ($val == 2){
				$isCommentBlock = false;
			}
		}
		//var_dump($currCount);
		return $currCount;
	}
	
	function isInNoCount($line, $noCount){
	
		$begin_comment = 1;
		$end_comment = 2;
		
		$line = trim($line);
		if ($line=='') return 0;
		$val = -1;
		for ($i=0;$i<sizeof($noCount);$i++){
			if (strstr($line, $noCount[$i])){
				if ($i == $begin_comment){
					$val = 1;
				}
				else if($i == $end_comment){
					$val = 2;
				}	
				$val = 0;
			}
		}
		return $val; //count
	}	

?>