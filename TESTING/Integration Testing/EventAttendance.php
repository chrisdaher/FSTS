<?php  
//include_once("../../php/view/Components/html.php");
//include_once("../../php/controller/Submit/GetEventAttendance.php");
//set_error_handler('handleError');

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}


$con = mysql_connect("localhost", "root", "photasmomak", "fsts");
$table = mysql_select_db("fsts", $con);
$result = mysql_query("SELECT * FROM  `event_user_linker` Limit 1");
$eventID = mysql_fetch_array($result);
$eventID = $eventID["event_id"];
//$testRow = mysql_fetch_array($result);

$result = mysql_query("SELECT * FROM  `event_user_linker` WHERE event_id='".$eventID."'");
$fileIDs = array();

while($row = mysql_fetch_array($result)){
    $fileIDs[sizeof($fileIDs)] = $row["file_id"];
}

$files = array();
foreach($fileIDs as $id){
    $result = mysql_query("SELECT file_info_id FROM  `file` WHERE id='".$id."'");
    $fileInfoID = mysql_fetch_array($result);
    $fileInfoID = $fileInfoID["file_info_id"];
    
    $result = mysql_query("SELECT indepedent_id FROM  `file` WHERE id='".$id."'");
    $indepID = mysql_fetch_array($result);
    $indepID = $indepID['indepedent_id'];
    
    $result = mysql_query("SELECT * FROM  `file_info` WHERE id='".$fileInfoID."'"); 
    $testRow = mysql_fetch_array($result);
    
    $result = mysql_query("SELECT * FROM  `user` WHERE id='".$indepID."'");
    $testRow1 = mysql_fetch_array($result);
    
    $files[sizeof($files)] = array_merge($testRow, $testRow1);
    $files[sizeof($files)-1]["event_id"]=$eventID ;  
    $files[sizeof($files)-1]["id"]=$id;
    
    
}
$testRow = $files;
mysql_close($con);

class Test_EventAttendance{
    var $eventID;
    var $testID;
    var $testFirstName;
    var $testLastName;
    var $testStreetNum;
    var $testStreetName;
    var $testPcode;
    
    function __construct($testRow){
        $this->eventID = intval($testRow["event_id"]);
        $this->testID = intval($testRow["id"]);
        $this->testFirstName = $testRow["first_name"];
        $this->testLastName = $testRow["last_name"];
        $this->testStreetNum = $testRow["addr_nb"];
        $this->testStreetName = $testRow["addr_street"];
        $this->testPcode = $testRow["addr_pcode"];
    }
    function doTest(){
        $toRet = "FAILED";
        try{
            $_GET["eventID"]=$this->eventID;
            ob_start();
            include("../../php/controller/Submit/GetEventAttendance.php");
            $toTest = ob_get_clean();
            $toRet = $this->assertGood($toTest);
        }catch(ErrorException $e){
            echo("Could not create FileBlock_MainEventBuilder\n");
            echo($e->getMessage());
        }
        return $toRet;
    }
    private function assertGood($toTest){
        $toRet="";
        if(!strpos($toTest, ">".$this->testID."<")){
            $toRet.='<div class="failed">Failed at ID</div>';
        }
        if(!strpos($toTest, ">".$this->testFirstName."<")){
            $toRet.='<div class="failed">Failed at First Name</div>';
        }
        if(!strpos($toTest, ">".$this->testLastName."<")){
            $toRet.='<div class="failed">Failed at Last Name</div>';
        }
        if(!strpos($toTest, ">".$this->testStreetNum."<")){
            $toRet.='<div class="failed">Failed at Street Number</div>';
        }
        if(!strpos($toTest, ">".$this->testStreetName."<")){
            $toRet.='<div class="failed">Failed at Street Name</div>';
        }
        if(!strpos($toTest, ">".$this->testPcode."<")){
            $toRet.='<div class="failed">Failed at Postal Code</div>';
        }
        if(strlen($toRet)==0){
            $toRet = '<div class="success">Success</div>';
        }
        return $toRet;
    }
}

echo("Test Case 1.0");
echo("</br>");
for($i=0; $i<sizeof($testRow);$i++){
    echo(($i+1).") Testing File ID ".$testRow[$i]["id"]);
    $test = new Test_EventAttendance($testRow[$i]);
    print $test->doTest();
}
echo("</br>");
echo("</br>");
echo("Test Case 1.1");
echo("</br>");
$eventID = -1;
$_GET["eventID"]=$eventID;
ob_start();
include("../../php/controller/Submit/GetEventAttendance.php");
$toTest = ob_get_clean();

if(strlen($toTest)==157){
	echo("Success");
}


?>