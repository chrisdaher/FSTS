<?php


$dep_fname="";
$dep_lname="";
$dep_medicard="";
$dep_age="";
$dep_gender="";
$dep_contact="";
$contact = "";

// session_start();

// $dep_id = $_SESSION['depId'];

 // $res = selectWhereQuery("user","id", $dep_id);
 // $row = mysql_fetch_array($res);   
 // $Contact= $row['contact'] - 1;


$comboBox = "<select name=\"dep_contact\" id=\"dep_contact\"  class=\"text\" value=\"$dep_contact\">";
	 $options = "";
	 //theOptions
	 $query = "SELECT * FROM `contactconverter`";
	 $res = sqlExecQuery($query);
	 while ($row = mysql_fetch_array($res)){
		$name = $row['name'];
		$options = $options . "<option> $name </option>";
	 }
	 $comboBox = $comboBox . $options . "</select>";
//if there is info in db then fetch them for that dependent 

print("
<div id=\"dialog_AddDep\" title=\"Add new Dependent\">
	<p class=\"validateTips\">All form fields are required.</p>

	<form name=\"AddDepForm\" action=\"./php/Controller/Submit/AddNewDependentSubmit.php\" method=\"post\">
	<fieldset>
		<label for=\"dep_fname\">First Name</label>
		<input type=\"text\" name=\"dep_fname\" id=\"dep_fname\" class=\"text ui-widget-content ui-corner-all\" value=\"$dep_fname\"/>
		<label for=\"dep_lname\">Last Name</label>
		<input type=\"text\" name=\"dep_lname\" id=\"dep_lname\" class=\"text ui-widget-content ui-corner-all\" value=\"$dep_lname\"/>
		<label for=\"dep_medicard\">Medicard</label>
		<input type=\"text\" name=\"dep_medicard\" id=\"dep_medicard\" value=\"\" class=\"text ui-widget-content ui-corner-all\" value=\"$dep_medicard\"/>
		<label for=\"dep_age\">Age</label>
		<input type=\"text\" name=\"dep_age\" id=\"dep_age\" value=\"\" class=\"text ui-widget-content ui-corner-all\" value=\"$dep_age\"/>
		<label for=\"dep_gender\">Gender</label>
		<select name=\"dep_gender\" id=\"dep_gender\" class=\"text\" value=\"$dep_gender\"><option>Male</option><option>Female</option></select>
        <label for=\"dep_contact\">Relationship</label>
		$comboBox
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