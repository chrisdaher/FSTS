<?php

/**
 * @author Chris
 * @copyright 2012
 */
 
 $Contact= "";
 
  if($editMode==1 || $editMode==2){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $Contact= ContactIntToString($row['contact']);
     $input_Contact="<select class=\"form_input\" id=\"input_Contact\" name=\"input_Contact\" value=\"$Contact\">";//</select>";
	 $options = "";
	 //theOptions
	 $query = "SELECT * FROM `contactconverter`";
	 $res = sqlExecQuery($query);
	 $cntr = 0;
	 while ($row = mysql_fetch_array($res)){
		$name = $row['name'];
		$options = $options . "<option> $name </option>";
		if ($name == $Contact){
			$index = $cntr;
		}
		$cntr ++;
	 }
	 
	 $input_Contact = $input_Contact . $options . "</select>";
     
     $final_Contact=$input_Contact;
 // }elseif($editMode==2){
     // $input_Contact="<select id=\"input_Contact\" name=\"input_Contact\" value=\"$Contact\"></select>";
     
     // $final_Contact=$input_Contact;
 }else{
	$index = 0;
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
    $Contact= ContactIntToString($row['contact']);
     
     $lbl_Contact="<label id=\"input_Contact\">  $Contact </label>";
          
     $final_Contact=$lbl_Contact;
 }
 

print("
    <div id=\"div_Contact\" class=\"divContainer\">
        <div class=\"divlbl\">Contact</div> 
        <div class=\"divinfo\" id=\"div_ContactInfo\"> $final_Contact </div>
    </div>"
);

if ($editMode == 1){
	 print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_Contact\");
		combo.selectedIndex = $index;
	</script>"
	);
}

?>
