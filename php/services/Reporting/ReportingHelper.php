<?php
	include_once("/../../model/converter.php");
	include_once("/../../model/PostalCodeConverter.php");
	
	$reportingModels = array(1 => "Marital Status", 2 => "Language", 3=>"Postal Code", 
											4=>"Relationship", 5=>"Work", 6=>"Event Type",
											7=>"Income Type");			
											
									
	$reportingTags = array(1=> new converter("maritalconverter", false),
											 2=> new converter("languageconverter", false),
											 3=> new PostalCodeConverter(),
											 4=> new converter("contactconverter", false),
											 5=> new converter("workconverter", false),
											 6=> new converter("event_type", false),
											 7=> new converter("incometypeconverter", false));
											 
	$reportingColumns = array(1=>"marital_status", 2=>"language", 3=>"addr_pcode", 4=>"contact", 5=>"work_status",
							6=>"event_type_id", 7=>"income_type_id");
							
	$reportingTables = array(1=>"user", 2=>"user", 3=>"file_info", 4=>"user", 5=>"user", 6=>"scheduler", 7=>"income");
	
	$reportingDateColumn = array(1=>"first_visit", 2=>"first_visit", 3=>"", 4=>"first_visit", 5=>"first_visit",
								6=>"start_date", 7=>"start_date");

	$parseType = array(1=>"Monthly", 2=>"Weekly", 3=>"Yearly");
?>