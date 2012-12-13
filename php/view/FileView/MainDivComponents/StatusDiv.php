<?php

/**
 * @author Chris
 * @copyright 2012
 */
 
$res = selectWhereQuery("file","id",$famId);
$row = mysql_fetch_array($res);

 $missingFile = "FALSE";
 $missingMedi = "FALSE";

$Status = "Missing Files: " . $missingFile . " <br>Missing Medicard: " . $missingMedi;
 
 
  if($editMode==1){
        if ($row['FLAG_FILE'] == 1){
        	$missingFile = "TRUE";
        }
        if ($row['FLAG_MEDICARD'] == 1){
        	$missingMedi = "TRUE";
        }
        $Status = "Missing Files: " . $missingFile . " <br>Missing Medicard: " . $missingMedi;
        $input_Status="<input type=\"text\" class=\"form_input\" id=\"input_Status\" name=\"input_Status\" value=\"$Status\"/>";
        $final_Status=$input_Status;
 }elseif($editMode==2){
        $Status = "Missing Files: " . $missingFile . " <br>Missing Medicard: " . $missingMedi;
        $input_Status="<input type=\"text\" class=\"form_input\" id=\"input_Status\" name=\"input_Status\" value=\"$Status\"/>";
        $final_Status=$input_Status;
 }else{
        if ($row['FLAG_FILE'] == 1){
        	$missingFile = "TRUE";
        }
        if ($row['FLAG_MEDICARD'] == 1){
        	$missingMedi = "TRUE";
        }
        
        $Status = "Missing Files: " . $missingFile . " <br>Missing Medicard: " . $missingMedi;

    //$Status= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec suscipit imperdiet elit, ut aliquet velit dignissim nec. Vivamus felis orci, auctor at pharetra vel, rhoncus sed metus.";
 
     $lbl_Status="<label id=\"input_Status\">  $Status </label>";
     

     
     $final_Status=$lbl_Status;
 }
print <<< end
    <div id="div_Status" class="divContainer">
        <div class="divlbl">Status</div> 
        <div class="divinfo" id="div_StatusInfo"> $final_Status </div>
    </div>
end

?>