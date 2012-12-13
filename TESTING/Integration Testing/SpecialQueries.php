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


echo("Test Case 1.0");
echo("</br>");
$query = "SELECT * FROM  `file`";

$con = mysql_connect("localhost", "root", "photasmomak", "fsts");
$table = mysql_select_db("fsts", $con);
$result = mysql_query($query);
$testRow = array();
while($row = mysql_fetch_array($result)){
    $testRow[sizeof($testRow)] = $row;
}

mysql_close($con);

$toTest = "";
$_POST["query"] = $query;
ob_start();
include_once("../../php/model/mysqlManager.php");
@include("../../php/services/Queries/SpecialQuery.php");
$toTest = ob_get_clean();

$result = "3 results found.<br/><thead><tr><th>id</th><th>indepedent_id</th><th>file_info_id</th><th>FLAG_FILE</th><th>FLAG_MEDICARD</th><th>FLAG_3</th><th>active</th></thead><tbody><tr><td>".$testRow[0][0]."</td><td>".$testRow[0][1]."</td><td>".$testRow[0][2]."</td><td>".$testRow[0][3]."</td><td>".$testRow[0][4]."</td><td>".$testRow[0][5]."</td><td>".$testRow[0][6]."</td></tr><tr><td>".$testRow[1][0]."</td><td>".$testRow[1][1]."</td><td>".$testRow[1][2]."</td><td>".$testRow[1][3]."</td><td>".$testRow[1][4]."</td><td>".$testRow[1][5]."</td><td>".$testRow[1][6]."</td></tr><tr><td>".$testRow[2][0]."</td><td>".$testRow[2][1]."</td><td>".$testRow[2][2]."</td><td>".$testRow[2][3]."</td><td>".$testRow[2][4]."</td><td>".$testRow[2][5]."</td><td>".$testRow[2][6]."</td></tr></tbody>";

if($toTest == $result){
	echo("Success");
}
echo("</br>");
echo("</br>");
echo("Test Case 1.1");
echo("</br>");
$query = "INSERT STATEMENT";
$_POST["query"] = $query;
ob_start();
include_once("../../php/model/mysqlManager.php");
@include("../../php/services/Queries/SpecialQuery.php");
$toTest = ob_get_clean();
if($toTest == "Insert statement is not allowed!"){
	echo("Success");
}
echo("</br>");
echo("</br>");
echo("Test Case 1.2");
echo("</br>");
$query = "DELETE STATEMENT";
$_POST["query"] = $query;
ob_start();
include_once("../../php/model/mysqlManager.php");
@include("../../php/services/Queries/SpecialQuery.php");
$toTest = ob_get_clean();
if($toTest == "Delete statement is not allowed!"){
	echo("Success");
}
echo("</br>");
echo("</br>");
echo("Test Case 1.3");
echo("</br>");
$query = "UPDATE STATEMENT";
$_POST["query"] = $query;
ob_start();
include_once("../../php/model/mysqlManager.php");
@include("../../php/services/Queries/SpecialQuery.php");
$toTest = ob_get_clean();
if($toTest == "Update statement is not allowed!"){
	echo("Success");
}

echo("</br>");
echo("</br>");
echo("Test Case 1.4");
echo("</br>");
$query = "WRONG QUERY";
$_POST["query"] = $query;
ob_start();
include_once("../../php/model/mysqlManager.php");
@include("../../php/services/Queries/SpecialQuery.php");
$toTest = ob_get_clean();
if(strstr($toTest, "You have an error in your SQL syntax;")){
	echo("Success");
}
?>