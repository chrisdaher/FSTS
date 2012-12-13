<?php

/**
 * @author Chris
 * @copyright 2012
 */

$WorkStatus="";
 
  if($editMode==1 || $editMode == 2){
        $res = selectWhereQuery("file","id",$famId);
        $row = mysql_fetch_array($res);
        $dep_id = $row['indepedent_id'];
        $res = selectWhereQuery("user","id", $dep_id);
        $row = mysql_fetch_array($res);
         
         $WorkStatus= WorkStatusToString($row['work_status']);
         $input_WorkStatus="<select class=\"form_input\" id=\"input_WorkStatus\" name=\"input_WorkStatus\" value=\"$WorkStatus\">";//select>";
		 $options = "";
		 //theOptions
		 $query = "SELECT * FROM `workconverter`";
		 $res = sqlExecQuery($query);
		 $cntr = 0;
		 while ($row = mysql_fetch_array($res)){
			$name = $row['name'];
			$options = $options . "<option> $name </option>";
			if ($name == $WorkStatus){
				$index = $cntr;
			}
			$cntr ++;
		 }
		 
		 $input_WorkStatus = $input_WorkStatus . $options . "</select>";
		 
		 
         $final_WorkStatus=$input_WorkStatus;
 // }elseif($editMode==2){
    // $input_WorkStatus="<select id=\"input_WorkStatus\" name=\"input_WorkStatus\" value=\"$WorkStatus\"></select>";
    // $final_WorkStatus=$input_WorkStatus;

 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     $WorkStatus= WorkStatusToString($row['work_status']);
     $lbl_WorkStatus="<label id=\"input_WorkStatus\">  $WorkStatus </label>";
     $final_WorkStatus=$lbl_WorkStatus;
 }
print("<div id=\"div_WorkStatus\" class=\"divContainer\">
        <div class=\"divlbl\">Work Status</div> 
        <div class=\"divinfo\" id=\"div_WorkStatusInfo\"> $final_WorkStatus </div>
    </div>");
if ($editMode == 1){
	print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_WorkStatus\");
		combo.selectedIndex = $index;
	</script>"
	);
}
?>