<?php

/**
 * FSTS
 * 
 */
 
$Age="";
 
 if($editMode==1){
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Age= $row['age'];
     
     $input_Age="<input type=\"text\" class=\"form_input\" id=\"input_Age\" name=\"input_Age\" value=\"$Age\"/>";
     $final_Age=$input_Age;
 }elseif($editMode==2){
    $input_Age="<input type=\"text\" class=\"form_input\" id=\"input_Age\" name=\"input_Age\" value=\"$Age\"/>";
    $final_Age=$input_Age;
 }else{
     $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
     
     
     $Age= $row['age'];
     
     $lbl_Age="<label id=\"input_Age\">  $Age </label>";
     $final_Age=$lbl_Age;
 }
 

print <<< end
    <div id="div_Age" class="divContainer">
        <div class="divlbl">Age</div> 
        <div class="divinfo" id="div_AgeInfo"> $final_Age </div>
    </div>
end
?>