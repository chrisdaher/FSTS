<?php

/**
 * @author Chris
 * @copyright 2012
 */
 
$Medicard="";
 
 if($editMode==1){
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Medicard= $row['medicard'];
     
     $input_Medicard="<input type=\"text\" class=\"form_input\" id=\"input_Medicard\" name=\"input_Medicard\" value=\"$Medicard\" onblur=\"applyMedicard(event)\"/>";
     $final_Medicard=$input_Medicard;
 }elseif($editMode==2){
    $input_Medicard="<input type=\"text\" class=\"form_input\" id=\"input_Medicard\" name=\"input_Medicard\" value=\"$Medicard\" onblur=\"applyMedicard(event)\"/>";
    $final_Medicard=$input_Medicard;
 }else{
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Medicard= $row['medicard'];
     
     $lbl_Medicard="<label id=\"input_Medicard\">  $Medicard </label>";
     $final_Medicard=$lbl_Medicard;
 }
 

print <<< end
    <div id="div_Medicard" class="divContainer">
        <div class="divlbl">Medicard</div> 
        <div class="divinfo" id="div_MedicardInfo"> $final_Medicard </div>
    </div>
end
?>