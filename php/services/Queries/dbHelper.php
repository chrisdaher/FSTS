<?php
	include_once("/../../model/Finders/IncludeAllFinders.php");
	
	$models = array(1 => "File", 2 => "User", 3=>"file_info", 4=>"Scheduler", 5=>"Income", 6=>"Appointment");			
	$modelsHelper = array_flip($models);
	$modelTags = array(1=> new FileFinder(), 2=>new UserFinder(), 3=> new FileInfoFinder(), 4=>new EventFinder(), 5=>new IncomeFinder(),
						6=>new AppointmentFinder());
?>