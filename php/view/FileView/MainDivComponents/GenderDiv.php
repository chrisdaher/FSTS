<?php

/**
 * FSTS
 * 
 */
 
$Gender="";
 
 if($editMode==1){
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
    $Gender= GenderToString($row['gender']);
	 
     
     $input_Gender="<select class=\"form_input\" id=\"input_Gender\" name=\"input_Gender\" value=\"$Gender\">
	<option>Male</option>
	<option>Female</option>
	 </select>";
	 $index = 1;
	 if ($Gender[0] == 'M' || $Gender[0]=='m') $index = 0;
	 
     $final_Gender=$input_Gender;
 }elseif($editMode==2){
    $input_Gender="<select class=\"form_input\" id=\"input_Gender\" name=\"input_Gender\" value=\"$Gender\">
	<option>Male</option>
	<option>Female</option>
	 </select>";
    $final_Gender=$input_Gender;
 }else{
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Gender= GenderToString($row['gender']);
     
     $lbl_Gender="<label id=\"input_Gender\">  $Gender </label>";
     $final_Gender=$lbl_Gender;
 }
 

print(
    "<div id=\"div_Gender\" class=\"divContainer\">
        <div class=\"divlbl\">Gender</div> 
        <div class=\"divinfo\" id=\"div_GenderInfo\"> $final_Gender </div>
    </div>");
if ($editMode == 1){
	print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_Gender\");
		combo.selectedIndex = $index;
	</script>"
	);
}
?>