<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title>Unit Testing</title>

    <link type="text/css" href="style.css" rel="stylesheet" />	

</head>
<?php


	include_once("/../../php/services/Logging/LogManager.php");
	include_once("unitTest.php");
	include_once("/model/IncludeComparators.php");
	class TEST_Reporting{
	   var $testKey;
       var $testValue;
       
       var $testID;
       
        function __construct(){
            $this->testKey = "TestKey";
            $this->testValue = "TestValue";
            
            $this->testID = 1;
        }
        function Test_KeyValue(){
            include("/../../php/services/Reporting/KeyValue.php");
            $keyVal = new KeyValue($this->testKey, $this->testValue);	
            $json = $keyVal->JSONEncode();
            if($json['name']!=$this->testKey){
                echo "FAILED";
            }
            if($json['value']!=$this->testValue){
                echo "FAILED";
            }
            
        }
        function Test_ListKeyValue(){
            include("/../../php/services/Reporting/ListKeyValue.php");
            $keyVal = new ListKeyValue($this->testID);	
            $keyVal->addKeyValue($this->testKey, $this->testValue);
            $json = $keyVal->JSONEncode();
            $temp = $json['keyValues'][0];
            if($json['id']!=$this->testID){
                echo "FAILED";
            }
            if($json['keyValues'][0]->key!=$this->testKey){
                echo "FAILED";
            }
            if($json['keyValues'][0]->value!=$this->testValue){
                echo "FAILED";
            }
        }
       	function Test(){
           $this->Test_KeyValue();
           $this->Test_ListKeyValue();
    	}
    }
    $test = new TEST_Reporting();
	xdebug_start_code_coverage();
	$test->Test();
	 $cov = xdebug_get_code_coverage();
	 $arrayKeys = array_keys($cov);
	 $vals = array_values($cov);
	
	$total;
	$fileCntr = 0;
	include_once("model/LineCounter.php");
	for ($i=0;$i<sizeof($arrayKeys);$i++){
			//$lines = count(file($arrayKeys[$i])); 
			$temp = strtolower($arrayKeys[$i]);
			if (!strstr($temp, "test")){
				$lines = countLine($arrayKeys[$i]);
				$siz = sizeof($vals[$i]);
				
				echo $arrayKeys[$i] . " || "; 
				$total+= ($siz/$lines);
                
				$per = ($siz/$lines)*100;
                if($per>100){
                    $per = 100;
                }
				if ($per >= 60){
					echo "<span class=PER>" . ($per) . "%" ."</span><br/>";
				}
				else{
					echo "<span class=FAIL>" . ($per) . "%" ."</span><br/>";
				}
				
				echo "Total lines in file ". $lines;
                if($siz>$lines){
                    $siz=$lines;
                }
				echo "   ||   Code Coverage " . $siz;
				echo "<br/><br/>";
				$fileCntr++;
			}
	}
	$total/=$fileCntr;
    if($total>1){
        $total=1;
    }
	echo "AVERAGE: " . $total*100 . "%";	
	 
	 xdebug_stop_code_coverage();
?>