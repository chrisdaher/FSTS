<?php
	$models = array(array(1 => "File"), array(2 => "User"), array(3=>"FileInfo"), array(4=>"Event"));
	$modelsBackend = array(1 => "File", 2 => "User", 3=>"FileInfo", 4=>"Event");
	$modelsHelper = array("File"=>1, "User"=>2, "FileInfo"=>3, "Event"=>4);
	
	include_once("/../../model/Finders/IncludeAllFinders.php");
	$modelTags = array(1=> new FileFinder(), 2=>new UserFinder(), 3=> new FileInfoFinder(), 4=>new EventFinder());
	
?>