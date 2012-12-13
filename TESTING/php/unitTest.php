<?php
	error_reporting(0);
	include_once("/../../php/services/Logging/LogManager.php");
	include_once("model/IComparator.php");
	include_once("model/IntComparator.php");
	class unitTest{
		var $obj;
		var $in;
		var $logFile = "testLog.txt";
		var $className;

		function __construct($className, $input){
			include_once($className);
			$pos = strrpos($className, "/");
			$final = substr($className, $pos + 1, (strlen($className) - $pos));
			$final = str_replace(".php", "", $final);
			$className = $final;
			
			$this->in = $input;
			$this->className = $className;
			//echo "<br/><br/>Attempting to load class '$className' <br/>";
			if (!class_exists($className)){
				echo "Class loading '$className' failed! <br/>";
				throw new Exception("Class does not exist!");
			}
			else{
				$this->obj = new $className();
				call_user_func_array(array($this->obj, "__construct"), $input);
				//echo "Constructed called with ";
				//var_dump($input). "<br/>";		
				if ($this->obj){
					//echo "Class '$className' constructed! <br/><br/>";
				}
			}
		}
		
		function checkVars($expectedOutput){
			$objVars = get_object_vars($this->obj);
			for ($i=0;$i<sizeof($expectedOutput);$i++){
				$varName = $expectedOutput[$i][0];
				$toCheck = $objVars[$varName[0]];
				if(is_array($varName)){
					$toCheck = $objVars[$varName[0]][$varName[1]];
					$varName = $varName[0]."[".$varName[1]."]";
				}
				$comparator = $expectedOutput[$i][1];
				$val = $expectedOutput[$i][2];
				
				//echo "$varName :: $comparator ::  $val";
				if (is_bool($val)){
					if ($val == false){
						$toDisp = "false";
					}
					else{
						$toDisp = "true";
					}
				}
				else{
					$toDisp = $val;
				}
				
				$str =  "Verifying '$varName' ($toCheck) with '$comparator' on ' ".($toDisp)."' ::  ";
				
				$this->printresult(($comparator->compare($toCheck, $val)), $str);
			}
		}

		
		
		function executeFunction($funcName, $params, $expectedOutput){
			$ret = call_user_func_array(array($this->obj, $funcName), $params);				
			//echo "Function called '$funcName' on";
			//var_dump($this->obj) . " <br/>";
			//echo "With params: ";
			//var_dump($params) . "<br/>";
			//verifying the outputs
			$objVars = get_object_vars($this->obj);
			for ($i=0;$i<sizeof($expectedOutput);$i++){
				$varName = $expectedOutput[$i][0];
				$toCheck = $objVars[$varName];
				if(is_array($varName)){
					$toCheck = $objVars[$varName[0]][$varName[1]];
					$varName = $varName[0]."[".$varName[1]."]";
				}
				$comparator = $expectedOutput[$i][1];
				$val = $expectedOutput[$i][2];
				//echo "$varName :: $comparator ::  $val";
				if (is_bool($val)){
					if ($val == false){
						$toDisp = "false";
					}
					else{
						$toDisp = "true";
					}
				}
				else{
					$toDisp = $val;
				}
				if(get_class($comparator)=="HTMLComparator"){
					$toCheck = $toCheck->toText();
				}
				$str =  "Verifying '$varName' ($toCheck) with '$comparator' on ' ".($toDisp)."' ::  ";
				$this->printresult(($comparator->compare($toCheck, $val)), $str);
			}
			return $ret;
		}	
		
		function printresult($isOK, $str){
			
			if ($isOK){
				echo "<span class=OK>".$str . "OK </span><br/>";
			}
			else{
				echo "<span class=FAIL>".$str . "FAIL </span><br/>";
			}
		}
		
		function runUnitTest(){
			$methods = get_class_methods($this->className);
			for ($i = 0;$i<sizeof($methods);$i++){
				if (strcmp($methods[$i], "__construct") != 0){
					echo $methods[$i] . " :: ";
					print_r(call_user_func_array(array($this->obj, $methods[$i]), array()));
					echo "<br/>";
				}				
			}
		}
	}
	
?>