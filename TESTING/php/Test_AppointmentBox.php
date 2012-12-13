<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title>Unit Testing</title>

    <link type="text/css" href="style.css" rel="stylesheet" />	

</head>
<?php


	include_once("/../../php/services/Logging/LogManager.php");
	include_once("unitTest.php");
	include_once("/model/IncludeComparators.php");
	class TEST_AppointmentBox{
           
           var $ExpectedContainer;
        function __construct(){
            $this->ExpectedContainer = array("Container", new HTMLComparator(), '< div class=" div_AppointmentContainer" >< label class=" lbl_StartTime" ></ label>< label class=" lbl_EndTime" ></ label>< div class=" div_AppointmentBox" appointmentID="" ></ div>< div class=" div_AppOptions" appID="" >< button class=" btn_AppInfo JQuery_button" appID="" ></ button>< label class=" lbl_AppCurrent" ></ label>< label class=" lbl_AppSep" >of</ label>< label class=" lbl_AppCapacity" ></ label></ div></ div>');
        }
        function Test_OtherFunctions(){
            $TestCases = array(
                                    array(),
                                );
            $expectedOutputs = array(
                                        array($this->ExpectedContainer),
                                        );
            $functionNames = array(
                                    "__construct",
                                );
            for($i=0; $i<sizeof($TestCases); $i++){
                echo("Test Case: $i</br>");
                $tu = new unitTest("/../../php/view/Components/AppointmentBox.php", array());
                $tu->executeFunction($functionNames[$i], $TestCases[$i], $expectedOutputs[$i]);
                echo("</br>");
    		}	
        }
       	function Test(){
    		echo "AppointmentBox OBJECT UNIT TEST<br/>------------------------------------<br/>";
               echo("<h3>Test Suite: Other Functions Testing<br></h1>");
               $this->Test_OtherFunctions();
    
    		echo "<br/>END OF AdminResult OBJECT UNIT TEST<br/>------------------------------------<br/>";
    		
    	}
    }
	$testHtml = new TEST_AppointmentBox();
	xdebug_start_code_coverage();
	   $testHtml->Test();
	 $cov = xdebug_get_code_coverage();
	 $arrayKeys = array_keys($cov);
	 $vals = array_values($cov);
	
	$total;
	for ($i=0;$i<sizeof($arrayKeys);$i++){
			$lines = count(file($arrayKeys[$i])); 
			$siz = sizeof($vals[$i]);
			echo $arrayKeys[$i] . " || " . (($siz/$lines)*100) . "% <br/>";
			$total+= ($siz/$lines);
	}
	$total/=sizeof($arrayKeys);
	echo "AVERAGE: " . $total*100 . "%";	
	 
	 xdebug_stop_code_coverage();
?>