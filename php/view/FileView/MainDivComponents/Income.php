<?php

/**
 * FSTS
 * 
 */
 
$Income="";
 
 if($editMode==1){
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
    $Income= IncomeToString($row['income']);
	 
     
     $input_Income="<select class=\"form_input\" id=\"input_Income\" name=\"input_Income\" value=\"$Income\">
	 </select>";
	 $index = 1;
	 if ($Income[0] == 'M' || $Income[0]=='m') $index = 0;
	 
     $final_Income=$input_Income;
 }elseif($editMode==2){
    $input_Income="<select class=\"form_input\" id=\"input_Income\" name=\"input_Income\" value=\"$Income\">
	<option>Male</option>
	<option>Female</option>
	 </select>";
    $final_Income=$input_Income;
 }else{
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Income= IncomeToString($row['Income']);
     
     $lbl_Income="<label id=\"input_Income\">  $Income </label>";
     $final_Income=$lbl_Income;
 }
 

print(
    "<div id=\"div_Income\" class=\"divContainer\">
        <div class=\"divlbl\">Income</div> 
        <div class=\"divinfo\" id=\"div_IncomeInfo\"> $final_Income </div>
    </div>");
if ($editMode == 1){
	print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_Income\");
		combo.selectedIndex = $index;
	</script>"
	);
}
?>