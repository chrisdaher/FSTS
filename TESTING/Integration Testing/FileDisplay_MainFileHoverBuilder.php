<?php  
//include_once("../../php/view/Components/html.php");
include_once("../../php/view/Components/FileDisplay_MainFileHoverBuilder.php");
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
$result = mysql_query("SELECT * FROM  `file` Limit 1");

$testRow = mysql_fetch_array($result);

$result = mysql_query("SELECT * FROM  `file_info` WHERE id='".$testRow["file_info_id"]."'");
$testRow1 = mysql_fetch_array($result);

$result = mysql_query("SELECT * FROM  `user` WHERE id='".$testRow["indepedent_id"]."'");
$testRow2 = mysql_fetch_array($result);

$toPass = array_merge($testRow,$testRow1);
$toPass = array_merge($toPass, $testRow2);
$toPass["id"]= $testRow["id"];

mysql_close($con);


class Test_FileDisplay_MainFileHoverBuilder{
    var $IndependentID;
    var $testID;
    var $testFirstName;
    var $testLastName;
    var $testAddrNum;
    var $testAddrName;
    var $testCity;
    var $testProvince;
    var $testPCode;
    
    function __construct($testRow){
        $this->IndependentID = ($testRow["indepedent_id"]);
        $this->testID = intval($testRow["id"]);
        $this->testFirstName = $testRow["first_name"];
        $this->testLastName = $testRow["last_name"];
        $this->testAddrNum = $testRow["addr_nb"];
        $this->testAddrName = $testRow["addr_street"];
        $this->testCity = $testRow["addr_city"];
        $this->testProvince = $testRow["addr_prov"];
        $this->testPCode = $testRow["addr_pcode"];
    }
    function doTest(){
        $toRet = "FAILED";
        try{
            $MainEventBuilder = new FileDisplay_MainFileHoverBuilder($this->testID);
            $toTest = $MainEventBuilder->getContainer()->toHTML();
            $toRet = $this->assertGood($toTest);
        }catch(ErrorException $e){
            echo("Could not create FileBlock_MainFileBuilder\n");
            echo($e->getMessage());
        }
        return $toRet;
    }
    private function assertGood($toTest){
        $toRet="";
        
        if(!strpos($toTest, ">".$this->IndependentID."<")){
            $toRet.='<div class="failed">Failed at ID</div>';
        }
        if(!strpos($toTest, ">".$this->testFirstName."<")){
            $toRet.='<div class="failed">Failed at First Name</div>';
        }
        if(!strpos($toTest, ">".$this->testLastName."<")){
            $toRet.='<div class="failed">Failed at Last Name</div>';
        }
        if(!strpos($toTest, ">".$this->testAddrNum."<")){
            $toRet.='<div class="failed">Failed at Street Number</div>';
        }
        if(!strpos($toTest, ">".$this->testAddrName."<")){
            $toRet.='<div class="failed">Failed at Street Name</div>';
        }        
        if(!strpos($toTest, ">".$this->testCity."<")){
            $toRet.='<div class="failed">Failed at City</div>';
        }
        if(!strpos($toTest, ">".$this->testProvince."<")){
            $toRet.='<div class="failed">Failed at Province</div>';
        }
        if(!strpos($toTest, ">".$this->testPCode."<")){
            $toRet.='<div class="failed">Failed at Postal Code</div>';
        }
        if(strlen($toRet)==0){
            $toRet = '<div class="success">Success</div>';
        }
        return $toRet;
    }
}

$test = new Test_FileDisplay_MainFileHoverBuilder($toPass);
echo $test->doTest();
?>