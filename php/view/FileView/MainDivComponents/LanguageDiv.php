<?php

/**
 * @author Chris
 * @copyright 2012
 */
 
$Language="";
 
 if($editMode==1 || $editMode == 2){
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Language= $row['language'];
     $Language= LanguageIntToString($row['language']);
     $input_Language="<select class=\"form_input\" id=\"input_Language\" name=\"input_Language\" value=\"$Language\">";//</select>";
	 $options = "";
	 //theOptions
	 $query = "SELECT * FROM `languageconverter`";
	 $res = sqlExecQuery($query);
	 $cntr = 0;
	 while ($row = mysql_fetch_array($res)){
		$name = $row['name'];
		$options = $options . "<option> $name </option>";
		if ($name == $Language){
				$index = $cntr;
		}
		$cntr ++;
	 }
	 
	 $input_Language = $input_Language . $options . "</select>";
	 //<input type=\"text\" onkeypress=\"doAddCombo(event,this)\"/><input type=\"text\" onkeypress=\"doSetDefault(event, this)\">";
     $final_Language=$input_Language;
 // }elseif($editMode==2){
    // $input_Language="<select id=\"input_Language\" name=\"input_Language\" value=\"$Language\"></select>";
    // $final_Language=$input_Language;
 }else{
     $res = selectWhereQuery("file","id",$famId);
	 $row = mysql_fetch_array($res);
	 $dep_id = $row['indepedent_id'];
     $res = selectWhereQuery("user","id", $dep_id);
     $row = mysql_fetch_array($res);
          
     $Language= $row['language'];
     $Language= LanguageIntToString($row['language']);
     $lbl_Language="<label id=\"input_Language\">  $Language </label>";
     $final_Language=$lbl_Language;
 }
 
print("
    <div id=\"div_Language\" class=\"divContainer\">
        <div class=\"divlbl\">Language</div> 
        <div class=\"divinfo\" id=\"div_LanguageInfo\"> $final_Language </div>
    </div>");

if ($editMode == 1){
	 print("
	<script language=\"javascript\">
		var combo = document.getElementById(\"input_Language\");
		combo.selectedIndex = $index;
	</script>"
	);
}

?>