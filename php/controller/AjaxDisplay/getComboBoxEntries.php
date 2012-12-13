<?php
$section=$_GET['Section'];
include_once("/../../model/converter.php");

//results as array where $result1[0] is the text of the combo box option
//and $result1[1] is the id of the combo box option in the db
$section = strtolower($section);
if ($section == "maritalstatus"){
	$section = "marital";
}
else if ($section == "relationship"){
	$section = "contact";
}
else if ($section == "workstatus"){
	$section = "work";
}
else if ($section == "postalcode"){
	$isPostal = true;
}

$tableName = $section . "converter";

if ($section == "eventtype"){
	$tableName = "event_type";
}

$conv = new converter($tableName, true);
$res = $conv->getTableData();

$results = array();
for ($i =0;$i<sizeof($res);$i++){	
	$row = $res[$i];
	$results[$i] = array($row['name'], $row['id']);
}
// var_dump($res);

// $result1 = array("$section","1");
// $result2 = array("GET","2");
// $result3 = array("COMBOBOX","3");
// $result4 = array("VALUES","4");
// $result5 = array("FROM DB","5");

// $results = array($result1, $result2 , $result3, $result4, $result5);

$toRet = "";
for($i=0;$i<sizeof($results);$i++){
    $toRet .= $results[$i][0]."=".$results[$i][1] ;
    if($i<sizeof($results)-1){
        $toRet .= "::";
    }
}
echo $toRet;
?>