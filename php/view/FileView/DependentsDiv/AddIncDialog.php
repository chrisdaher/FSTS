<?php

include_once("/../../../model/File.php");
include_once("/../../../model/converter.php");

$dep_fname="";
$dep_lname="";
$dep_medicard="";
$dep_age="";
$dep_gender="";
$dep_contact="";
$contact = "";

$fileId = $famId;
$file = new File($fileId, false);
$file->loadIndependent(false);
$file->loadDependents(false);

$independent = $file->independent;
$dependents = $file->dependents;

	$ComboPerson = "<select class=\"text Person\" id=\"Person\" name=\"Person\">";
	$options = "";
	//theOptions
	$key = $independent->id;
	$options = $options . "<option value=\"$key\">".$independent->first_name . " " . $independent->last_name . "</option>";
	$key= 0;
	for ($i=0;$i<sizeof($dependents);$i++){
		$name = $dependents[$i]->first_name . " " . $dependents[$i]->last_name;
		$key = $dependents[$i]->id;
		$options = $options . "<option value=\"$key\"> $name </option>";
	}
	 
	$ComboPerson = $ComboPerson . $options . "</select>";
	
	$conv = new converter("incometypeconverter", false);
	$row = $conv->getTableData();
	$ComboType = "<select class=\"text Type\" id=\"Type\" name=\"Type\">";
	$options = "";
    $key = 0;

	for ($i=0;$i<sizeof($row);$i++){
		$key=$row[$i]['id'];//this key should represent the id of the Mode in the Mode table
		$name = $row[$i]['name'];
		$options = $options . "<option value=\"$key\"> $name </option>";
	}
	 $ComboType = $ComboType . $options . "</select>";
     
	 
	$conv = new converter("incomelengthconverter", false);
	$row = $conv->getTableData();
		 
	$ComboMode = "<select class=\"text Mode\" id=\"Mode\" name=\"Mode\">";
	$options = "";

    $key = 0;
	 
	 for ($i=0;$i<sizeof($row);$i++){
		$key=$row[$i]['id'];//this key should represent the id of the Mode in the Mode table
		$name = $row[$i]['name'];
		$options = $options . "<option value=\"$key\"> $name </option>";
	}

	 $ComboMode = $ComboMode . $options . "</select>";
//if there is info in db then fetch them for that dependent 

print("
<div id=\"dialog_AddInc\" title=\"Add new Dependent\">
	<p class=\"validateTips\">All form fields are required.</p>

	<form name=\"AddIncForm\" action=\"./php/Controller/Submit/AddNewIncomeSubmit.php\" method=\"post\">
	<fieldset>
		<label for=\"Person\">Person</label>
		$ComboPerson
		<label for=\"Type\">Type of Income</label>
		$ComboType
		<label for=\"Mode\">Income Mode</label>
		$ComboMode
		<label for=\"sDate\">Start Date</label>
		<input type=\"text\" class=\"text ui-widget-content ui-corner-all sDate\" id=\"sDate\" name=\"sDate\"></input>
		<label for=\"eDate\">End Date</label>
		<input type=\"text\" class=\"text ui-widget-content ui-corner-all eDate\" id=\"eDate\" name=\"eDate\"></input>
		<label for=\"incVal\">Income</label>
		<input type=\"text\" class=\"text ui-widget-content ui-corner-all incVal\" id=\"incVal\" name=\"incVal\"></input>
	</fieldset>
	</form>
</div>");

	 // print("
	// <script language=\"javascript\">
		// var combo = document.getElementById(\"dep_contact\");
		// alert($Contact);
		// combo.selectedIndex = $Contact;
	// </script>"
	// );
?>