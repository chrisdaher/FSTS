<?php
	include_once("UserFinder.php");
	include_once("EventFinder.php");
	include_once("GlobalFinder.php");
	
	$ff = new UserFinder();
	$gf = new GlobalFinder($ff);
	
	$sk = $ff->getSearchKeyByMedicard("NASR");
	
	$gf->find(array($sk), true);
	
	

?>