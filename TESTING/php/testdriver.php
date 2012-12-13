<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title>Unit Testing</title>

    <link type="text/css" href="style.css" rel="stylesheet" />	

</head>
<?php


	include_once("/../../php/services/Logging/LogManager.php");
	include_once("unitTest.php");
	include_once("/model/IncludeComparators.php");
	
	function appointmentUnitTest(){
		echo "Appointment OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		
		/*
			CLASS NAME: php/model/Appointment.php
			DATE: 17/02/2011
			RESULT:
		
		*/
		
		/*
			FUNCTION NAME: __construct(INT)
			DATE: 17/02/2011
			INPUT: -1
			EXPECTED OUTPUT: 
				id->NOT INT
				isNew = true
			RESULT: OK
		*/
		
		$tu = new unitTest("/../../php/model/Appointment.php", array(-1));
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", array(-1), $expectedOutput);		
		
		
		/*
			FUNCTION NAME: __construct(INT)
			DATE: 17/02/2011
			INPUT: A
			EXPECTED OUTPUT:
				id->NOT INT
				isNew = true
			RESULT: OK
		*/
		
		$tu = new unitTest("/../../php/model/Appointment.php", array("A"));
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", array("A"), $expectedOutput);
		
		
		/*
			FUNCTION NAME: __construct(INT)
			DATE: 17/02/2011
			INPUT: NON-EXISTANT ID
			EXPECTED OUTPUT:
				id->NOT INT
				isNew = true
			RESULT: OK
		*/
		
		$tu = new unitTest("/../../php/model/Appointment.php", array(10));
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", array(10), $expectedOutput);
						
		/*
			FUNCTION NAME: __construct(INT)
			DATE: 17/02/2011
			INPUT: EXISTING ID
			EXPECTED OUTPUT:
				id->ARGUMENT GIVEN
				isNew = FALSE
			RESULT: OK
		*/
		
		$tu = new unitTest("/../../php/model/Appointment.php", array(268));
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("id", new IntComparator(), 268));
		$tu->executeFunction("__construct", array(268), $expectedOutput);
		
		/* 
			FUNCTION NAME: getFilesInAppointment()
			DATE: 17/02/2011
			INPUT: Appointment object isNew = true
			EXPECTED OUTPUT: NULL
			RESULT:
		*/
		$tu = new unitTest("/../../php/model/Appointment.php", array(-1));
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("getFilesInAppointment", array(), $expectedOutput);
		
		
		$input = array(-1);
		$tu = new unitTest("/../../php/model/Appointment.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		
		//set some stuff
		$tu->obj->start_date = "STR_TEST";
		$tu->obj->end_date = "STR_END";
		$tu->obj->text="TEST";
		$tu->obj->capacity = 30;
		$tu->obj->size = 25;
		$tu->obj->event_id = 2;
		$tu->obj->update();
		
		$currId = $tu->obj->id;
		$input = array($currId);
		$tu = new unitTest("/../../php/model/Appointment.php", array($currId));
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("id", new IntComparator(), $currId), array("start_date", new StringComparator(), "STR_TEST"),
								array("text", new StringComparator(), "TEST"),
								array("end_date", new StringComparator(), "STR_END"), array("capacity", new IntComparator(), 30),
								array("size", new IntComparator(), 25), array("event_id", new IntComparator(), 2));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		
		$tu->obj->text="CHANGED";
		$tu->obj->update();
		$input = array($currId);
		$tu = new unitTest("/../../php/model/Appointment.php", array($currId));
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("text", new StringComparator(), "CHANGED"),
								array("id", new IntComparator(), $currId), array("start_date", new StringComparator(), "STR_TEST"),
								array("end_date", new StringComparator(), "STR_END"), array("capacity", new IntComparator(), 30),
								array("size", new IntComparator(), 25), array("event_id", new IntComparator(), 2));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$tu->obj->deleteFlag = true;
		$tu->obj->update();
		
		$currId = $tu->obj->id;
		$input = array($currId);
		$tu = new unitTest("/../../php/model/Appointment.php", array($currId));
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		echo "<br/>END OF Appointment OBJECT UNIT TEST<br/>------------------------------------<br/>";
		
	}
	
	function eventUnitTest(){
		echo "Event OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		$input = array(-1, false);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(-1, true);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(5, false);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(5, true);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(297, false);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new StringComparator(), 297), array("isNew", new BoolComparator(), false),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(297, true);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new StringComparator(), 297), array("isNew", new BoolComparator(), false),
								array("appointments", new NullComparator(), false));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(-1, true);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$tu->obj->start_date = "STR_START";
		$tu->obj->end_date = "STR_END";
		$tu->obj->event_name = "TESTING";
		$tu->obj->details = "DETAILS";
		$tu->obj->text = "TEXT";
		$tu->obj->rec_type = "REC";
		$tu->obj->event_pid = 1;
		$tu->obj->event_length = 5;
		$tu->obj->event_type_id = 2;
		$tu->obj->rec_id = 3;
		$tu->obj->update();
		
		$currId = $tu->obj->event_id;
		$input = array($currId, false);
		
		$tu = new unitTest("/../../php/model/Event.php", $input);
		$expectedOutput = array(array("event_id", new StringComparator(), $currId), array("isNew", new BoolComparator(), false),
								array("appointments", new NullComparator(), true), array("start_date", new StringComparator(), "STR_START"),
								array("end_date", new StringComparator(), "STR_END"), array("event_name", new StringComparator(), "TEXT"),
								array("details", new StringComparator(), "DETAILS"), array("text", new StringComparator(), "TEXT"),
								array("rec_type", new StringComparator(), "REC"), array("event_pid", new IntComparator(), 1),
								array("event_length", new IntComparator(), 5), array("event_type_id", new IntComparator(), 2),
								array("rec_id", new IntComparator(), 3));
		$tu->executeFunction("__construct", $input, $expectedOutput);						
		
		$tu->obj->text = "CHANGED";
		$tu->obj->update();
		$input = array($currId, false);
		
		$tu = new unitTest("/../../php/model/Event.php", $input);
		$expectedOutput = array(array("event_id", new StringComparator(), $currId), array("isNew", new BoolComparator(), false),
								array("appointments", new NullComparator(), true), array("start_date", new StringComparator(), "STR_START"),
								array("end_date", new StringComparator(), "STR_END"), array("event_name", new StringComparator(), "CHANGED"),
								array("details", new StringComparator(), "DETAILS"), array("text", new StringComparator(), "CHANGED"),
								array("rec_type", new StringComparator(), "REC"), array("event_pid", new IntComparator(), 1),
								array("event_length", new IntComparator(), 5), array("event_type_id", new IntComparator(), 2),
								array("rec_id", new IntComparator(), 3));
		$tu->executeFunction("__construct", $input, $expectedOutput);						
		
		$tu->obj->deleteFlag = true;
		$tu->obj->update();
		
		$input = array($currId, false);
		$tu = new unitTest("/../../php/model/Event.php", $input);
		
		$expectedOutput = array(array("event_id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("appointments", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		echo "<br/>END OF Event OBJECT UNIT TEST<br/>------------------------------------<br/>";
		
	}
	
	function fileUnitTest(){
		echo "File OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		$input = array(-1, false);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("independent", new NullComparator(), true), array("dependents", new NullComparator(), true),
								array("file_info", new NullComparator(), true), array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(-1, true);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("independent", new NullComparator(), true), array("dependents", new NullComparator(), true),
								array("file_info", new NullComparator(), true), array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(2, false);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("independent", new NullComparator(), true), array("dependents", new NullComparator(), true),
								array("file_info", new NullComparator(), true), array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(2, true);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("independent", new NullComparator(), true), array("dependents", new NullComparator(), true),
								array("file_info", new NullComparator(), true), array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(34, false);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("id", new IntComparator(), 34),
								array("isNew", new BoolComparator(), false),
								array("independent", new NullComparator(), true), array("dependents", new NullComparator(), true),
								array("file_info", new NullComparator(), true), array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(34, true);
		$tu = new unitTest("/../../php/model/File.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("id", new IntComparator(), 34),
								array("isNew", new BoolComparator(), false),
								array("independent", new NullComparator(), false), array("dependents", new NullComparator(), false),
								array("file_info", new NullComparator(), false), array("events", new NullComparator(), false));
		$tu->executeFunction("__construct", $input, $expectedOutput);	
		
		echo "<br/>END OF File OBJECT UNIT TEST<br/>------------------------------------<br/>";
	}
	
	function fileInfoUnitTest(){
		echo "FileInfo OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		$input = array(-1);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(999);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(64);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("id", new IntComparator(), 64));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		
		$input = array(-1);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$tu->obj->addr_street = "ADDR_STREET";
		$tu->obj->addr_nb = 5;
		$tu->obj->addr_city = "ADDR_CITY";
		$tu->obj->addr_prov = "ADDR_PROV";
		$tu->obj->addr_pcode = "ADDR_PCODE";
		$tu->obj->notes = "NOTESER";
		
		$tu->obj->update();
		$currId = $tu->obj->id;
		
		$input = array($currId);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("id", new IntComparator(), $currId), array("addr_street", new StringComparator(), "ADDR_STREET"),
								array("addr_nb", new IntComparator(), 5), array("addr_city", new StringComparator(), "ADDR_CITY"),
								array("addr_prov", new StringComparator(), "ADDR_PROV"), array("addr_pcode", new StringComparator(), "ADDR_PCODE"),
								array("notes", new StringComparator(), "NOTESER"));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$tu->obj->notes="CHANGED";
		$tu->obj->update();
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("id", new IntComparator(), $currId), array("addr_street", new StringComparator(), "ADDR_STREET"),
								array("addr_nb", new IntComparator(), 5), array("addr_city", new StringComparator(), "ADDR_CITY"),
								array("addr_prov", new StringComparator(), "ADDR_PROV"), array("addr_pcode", new StringComparator(), "ADDR_PCODE"),
								array("notes", new StringComparator(), "CHANGED"));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$tu->obj->deleteFlag = true;
		$tu->obj->update();
		
		$input = array($currId);
		$tu = new unitTest("/../../php/model/FileInfo.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		echo "<br/>END OF FileInfo OBJECT UNIT TEST<br/>------------------------------------<br/>";
		
	}
	
	function userUnitTest(){
		echo "User OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		$input = array(-1, false);
		$tu = new unitTest("/../../php/model/User.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(-1, true);
		$tu = new unitTest("/../../php/model/User.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(53, false);
		$tu = new unitTest("/../../php/model/User.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(53, true);
		$tu = new unitTest("/../../php/model/User.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("events", new NullComparator(), false));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		echo "<br/>END OF User OBJECT UNIT TEST<br/>------------------------------------<br/>";
	}
	
	function incomeUnitTest(){
		echo "Income OBJECT UNIT TEST<br/><br/>------------------------------------<br/>";
		$input = array(-1);
		$tu = new unitTest("/../../php/model/Income.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(-1);
		$tu = new unitTest("/../../php/model/Income.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), false), array("isNew", new BoolComparator(), true),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
		
		$input = array(53);
		$tu = new unitTest("/../../php/model/Income.php", $input);
		
		$expectedOutput = array(array("id", new IsIntComparator(), true), array("isNew", new BoolComparator(), false),
								array("events", new NullComparator(), true));
		$tu->executeFunction("__construct", $input, $expectedOutput);		
				
		echo "<br/>END OF Income OBJECT UNIT TEST<br/>------------------------------------<br/>";
	}
	xdebug_start_code_coverage();
	appointmentUnitTest();
	 fileUnitTest();
	fileInfoUnitTest();
	eventUnitTest();
	 userUnitTest();
	 $cov = xdebug_get_code_coverage();
	 $arrayKeys = array_keys($cov);
	 $vals = array_values($cov);
	
	$total;
	$fileCntr = 0;
	include_once("model/LineCounter.php");
	for ($i=0;$i<sizeof($arrayKeys);$i++){
			//$lines = count(file($arrayKeys[$i])); 
			$temp = strtolower($arrayKeys[$i]);
			if (strstr($temp, "model") && !strstr($temp, "test")){
				$lines = countLine($arrayKeys[$i]);
				$siz = sizeof($vals[$i]);
				
				echo $arrayKeys[$i] . " || "; 
				$total+= ($siz/$lines);
				
				$per = ($siz/$lines)*100;
				
				if ($per >= 60){
					echo "<span class=PER>" . (($siz/$lines)*100) . "%" ."</span><br/>";
				}
				else{
					echo "<span class=FAIL>" . (($siz/$lines)*100) . "%" ."</span><br/>";
				}
				
				echo "Total lines in file ". $lines;
				echo "   ||   Code Coverage " . $siz;
				echo "<br/><br/>";
				$fileCntr++;
			}
	}
	$total/=$fileCntr;
	echo "AVERAGE: " . $total*100 . "%";	
	 
	 xdebug_stop_code_coverage();
?>