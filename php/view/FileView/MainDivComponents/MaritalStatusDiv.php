<?php

/**
 * @author Chris
 * @copyright 2012
 */

 $MaritalStatus= "";
 
  if($editMode==1 || $editMode == 2){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
    $MaritalStatus= MaritalStatusIntToString($row['marital_status']);
          
     $input_MaritalStatus="<select class=\"form_input\" id=\"input_MaritalStatus\" name=\"input_MaritalStatus\" value=\"$MaritalStatus\">";//</select>";
	 $options = "";
	 //theOptions
	 $query = "SELECT * FROM `maritalconverter`";
	 $res = sqlExecQuery($query);
	 $cntr = 0;
	 while ($row = mysql_fetch_array($res)){
		$name = $row['name'];
		$options = $options . "<option> $name </option>";
		if ($name == $MaritalStatus){
				$index = $cntr;
		}
		$cntr ++;
	 }
	 
	 $input_MaritalStatus = $input_MaritalStatus . $options . "</select>";
     
     $final_MaritalStatus=$input_MaritalStatus;
 // }elseif($editMode==2){
     // $input_MaritalStatus="<select id=\"input_MaritalStatus\" name=\"input_MaritalStatus\" value=\"$MaritalStatus\"></select>";
     
     // $final_MaritalStatus=$input_MaritalStatus;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $MaritalStatus= MaritalStatusIntToString($row['marital_status']);
     
     $lbl_MaritalStatus="<label id=\"input_MaritalStatus\">  $MaritalStatus </label>";
     
     
     $final_MaritalStatus=$lbl_MaritalStatus;
 }
print("
    <div id=\"div_MaritalStatus\" class=\"divContainer\">
        <div class=\"divlbl\">Marital Status</div> 
        <div class=\"divinfo\" id=\"div_MaritalStatusInfo\"> $final_MaritalStatus </div>
    </div>");

	
if ($editMode == 1){
	 print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_MaritalStatus\");
		combo.selectedIndex = $index;
	</script>"
	);
}
?>