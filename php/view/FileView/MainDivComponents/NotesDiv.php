<?php

/**
 * @author Chris
 * @copyright 2012
 */

 $Notes= "";
 
  if($editMode==1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['file_info_id'];
    $res = selectWhereQuery("file_info","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $Notes= $row['notes'];
          
     $input_Notes="<input type=\"text\" class=\"form_input\" id=\"input_Notes\" name=\"input_Notes\" value=\"$Notes\"/>";
     
     $final_Notes=$input_Notes;
 }elseif($editMode==2){
     $input_Notes="<input type=\"text\" class=\"form_input\" id=\"input_Notes\" name=\"input_Notes\" value=\"$Notes\"/>";
     
     $final_Notes=$input_Notes;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['file_info_id'];
    $res = selectWhereQuery("file_info","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $Notes= $row['notes'];
     
     $lbl_Notes="<label id=\"input_Notes\">  $Notes </label>";
     
     $input_Notes="<input type=\"text\" id=\"input_Notes\"/>";
     
     $final_Notes=$lbl_Notes;
 }
print <<< end
    <div id="div_Notes" class="divContainer">
        <div class="divlbl">Notes</div> 
        <div class="divinfo" id="div_NotesInfo"> $final_Notes </div>
    </div>
end

?>