<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title>Unit Testing</title>

    <link type="text/css" href="style.css" rel="stylesheet" />	

</head>
<?php


	include_once("/../../php/services/Logging/LogManager.php");
	include_once("unitTest.php");
	include_once("/model/IncludeComparators.php");
	class TEST_HTML{
           var $TestSuite;
           var $expectedOutputs;
           
           var $ExpectedDiv;
           var $ExpectedImg;
           
           var $ExpectedClass;
           var $ExpectedID;
           var $ExpectedAttribute1;
           var $ExpectedAttribute2;
           
           var $ExpectedText;
           
           var $ExpectedChild1;
           var $ExpectedChild2;
        function __construct(){
            $this->ExpectedImg = array("elementType", new StringComparator(), "img");
            $this->ExpectedDiv = array("elementType", new StringComparator(), "div");
            $this->ExpectedClass = array(array("attributes","class"), new StringComparator(), " testClass");
            $this->ExpectedID = array(array("attributes","id"), new StringComparator(), "testID");
            $this->ExpectedAttribute1 = array(array("attributes","attributeName1"), new StringComparator(), "attributeValue1");
            $this->ExpectedAttribute2 = array(array("attributes","attributeName2"), new StringComparator(), "attributeValue2");
            $this->ExpectedText = array("text", new StringComparator(), "testText");
            $this->ExpectedChild1 = array(array("children", 0), new StringComparator(), "testChild1");
            $this->ExpectedChild2 = array(array("children", 1), new StringComparator(), "testChild2");

        }
        function Test_Constructor(){
            $TestCases = array(
                                    array(),
                                    array("img"), 
                                    array("div", "testClass"),
                                    array("div", array("attributeName1"=>"attributeValue1")),
                                    array("div", array("attributeName1"=>"attributeValue1", "attributeName2"=>"attributeValue2")),
                                    array("div", "testClass", "testID"),
                                    array("div", array("attributeName1"=>"attributeValue1"), "testID"),
                                    array("div", array("attributeName1"=>"attributeValue1", "attributeName2"=>"attributeValue2"), "testID")
                                );
            $expectedOutputs = array(
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedImg),
                                        array($this->ExpectedDiv, $this->ExpectedClass),
                                        array($this->ExpectedDiv, $this->ExpectedAttribute1),
                                        array($this->ExpectedDiv, $this->ExpectedAttribute1 ,$this->ExpectedAttribute2),
                                        array($this->ExpectedDiv, $this->ExpectedClass, $this->ExpectedID),
                                        array($this->ExpectedDiv, $this->ExpectedAttribute1, $this->ExpectedID),
                                        array($this->ExpectedDiv, $this->ExpectedAttribute1, $this->ExpectedAttribute2, $this->ExpectedID)
                                        );
            for($i=0; $i<sizeof($TestCases); $i++){
                echo("Test Case: $i</br>");
                $tu = new unitTest("/../../php/view/Components/html.php", array());
                $tu->executeFunction("__construct", $TestCases[$i], $expectedOutputs[$i]);
                echo("</br>");
    		}	
        }
        function Test_AttributeGetters(){
            $TestCases = array(
                                    array(),
                                    array(), 
                                    array(),
                                    array(),
                                    array("class"),
                                    array(),
                                    array(),
                                    array(),
                                    array("class", ""),
                                    array("class", ""),
                                    array("class", "")
                                );
            $expectedOutputs = array(
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv)
                                        );
            $functionNames = array(
                                    "getID",
                                    "getClass",
                                    "getType",
                                    "getText",
                                    "getAttribute",
                                    "getAttribute",
                                    "getAttributes",
                                    "getChildren",
                                    "getChildIndexBy",
                                    "getSingleLevelChildBy",
                                    "getChildBy"
                                );
            for($i=0; $i<sizeof($TestCases); $i++){
                echo("Test Case: $i</br>");
                $tu = new unitTest("/../../php/view/Components/html.php", array());
                $tu->executeFunction($functionNames[$i], $TestCases[$i], $expectedOutputs[$i]);
                echo("</br>");
    		}	
        }
        function Test_AttributeSetters(){
            $TestCases = array(
                                    array("testID"),
                                    array("testClass"), 
                                    array("div"),
                                    array("testText"),
                                    array("testClass"),
                                    array("attributeName1", "attributeValue1"),
                                    array(array("attributeName1"=>"attributeValue1", "attributeName2"=>"attributeValue2")),
                                    array(array("testChild1", "testChild2")),
                                    array("testChild1"),
                                );
            $expectedOutputs = array(
                                        array($this->ExpectedID),
                                        array($this->ExpectedClass),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedText),
                                        array($this->ExpectedClass),
                                        array($this->ExpectedAttribute1),
                                        array($this->ExpectedAttribute1, $this->ExpectedAttribute2),
                                        array($this->ExpectedChild1, $this->ExpectedChild2),
                                        array($this->ExpectedChild1)
                                        );
            $functionNames = array(
                                    "setID",
                                    "setClass",
                                    "setType",
                                    "setText",
                                    "addClass",
                                    "addAttribute",
                                    "addMultipleAttributes",
                                    "addChildren",
                                    "addChild"
                                );
            for($i=0; $i<sizeof($TestCases); $i++){
                echo("Test Case: $i</br>");
                $tu = new unitTest("/../../php/view/Components/html.php", array());
                $tu->executeFunction($functionNames[$i], $TestCases[$i], $expectedOutputs[$i]);
                echo("</br>");
    		}	
        }
        function Test_OtherFunctions(){
            $TestCases = array(
                                    array(),
                                    array(), 
                                    array(),
                                    array("button"),
                                );
            $expectedOutputs = array(
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array($this->ExpectedDiv),
                                        array(array(array("attributes","class"), new StringComparator(), " JQuery_button")),
                                        );
            $functionNames = array(
                                    "AttributesToHTML",
                                    "ChildrenToHTML",
                                    "toHTML",
                                    "toJQuery",
                                );
            for($i=0; $i<sizeof($TestCases); $i++){
                echo("Test Case: $i</br>");
                $tu = new unitTest("/../../php/view/Components/html.php", array());
                $tu->executeFunction($functionNames[$i], $TestCases[$i], $expectedOutputs[$i]);
                echo("</br>");
    		}	
        }
       	function Test(){
    		echo "html OBJECT UNIT TEST<br/>------------------------------------<br/>";
                echo("<h3>Test Suite: Constructor Testing<br></h1>");
   		       $this->Test_Constructor();
               echo("<h3>Test Suite: 'Getter' Functions Testing<br></h1>");
               $this->Test_AttributeGetters();
               echo("<h3>Test Suite: 'Setter' Functions Testing<br></h1>");
               $this->Test_AttributeSetters();
               echo("<h3>Test Suite: Other Functions Testing<br></h1>");
               $this->Test_OtherFunctions();
    
    		echo "<br/>END OF AdminResult OBJECT UNIT TEST<br/>------------------------------------<br/>";
    		
    	}
    }
	$testHtml = new TEST_HTML();
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