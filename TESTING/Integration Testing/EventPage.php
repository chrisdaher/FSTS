<?php  
//include_once("../../php/view/Components/html.php");
@include_once("../../php/model/Appointment.php");
@include_once("../../php/model/Event.php");
@include_once("../../php/view/Components/EventInfo.php");
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
$result = mysql_query("SELECT * FROM  `scheduler` Limit 1");

$testRow = mysql_fetch_array($result);

$result = mysql_query("SELECT * FROM  `event_type` WHERE id='".$testRow["event_type_id"]."'");
$testRow1 = mysql_fetch_array($result);
$testRow["event_type"]= $testRow1["name"];

mysql_close($con);


class Test_MainDiv_AppointmentAssignmentBuilder{
    var $testID;
    var $testName;
    var $testStartDate;
    var $testEndDate;
    var $testType;
    
    function __construct($testRow){
        $this->testID = intval($testRow["event_id"]);
        $this->testName = $testRow["event_name"];
        $this->testStartDate = $testRow["start_date"];
        $this->testStartDate = explode(" ", $this->testStartDate);
        $this->testStartDate = $this->testStartDate[0];
        $this->testEndDate = $testRow["end_date"];
        $this->testEndDate = explode(" ", $this->testEndDate);
        $this->testEndDate = $this->testEndDate[0];
        $this->testType = $testRow["event_type"];
    }
    function doTest(){
        $toRet = "FAILED";
        try{
            $MainEventBuilder = new EventInfo($this->testID);
            $toTest = $MainEventBuilder->getEventData()->toHTML();
            $toRet = $this->assertGood($toTest);
        }catch(ErrorException $e){
            echo("Could not create FileBlock_MainEventBuilder\n");
            echo($e->getMessage());
        }
        return $toRet;
    }
    private function assertGood($toTest){
        $toRet="";
        
        if(!strpos($toTest, ">".$this->testName."<")){
            $toRet.='<div class="failed">Failed at Name</div>';
        }
        if(!strpos($toTest, ">".$this->testStartDate."<")){
            $toRet.='<div class="failed">Failed at Start Date</div>';
        }
        if(!strpos($toTest, ">".$this->testEndDate."<")){
            $toRet.='<div class="failed">Failed at End Date</div>';
        }
        if(!strpos($toTest, ">".$this->testType."<")){
            $toRet.='<div class="failed">Failed at Type</div>';
        }
        if(strlen($toRet)==0){
            $toRet = '<div class="success">Success</div>';
        }
        return $toRet;
    }
}

$test = new Test_MainDiv_AppointmentAssignmentBuilder($testRow);
echo $test->doTest();
?>