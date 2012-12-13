<?php 

/**
 * @author Chris
 * @copyright 2012
 */
 $FirstVisit= "";
 
  if($editMode==1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $FirstVisit= $row['first_visit'];
          
     $input_FirstVisit="<input type=\"text\" class=\"form_input\" id=\"input_FirstVisit\" name=\"input_FirstVisit\" value=\"$FirstVisit\"/>";
     
     $final_FirstVisit=$input_FirstVisit;
 }elseif($editMode==2){
     $FirstVisit=date("Y-m-d");
     $input_FirstVisit="<input type=\"text\" class=\"form_input\" id=\"input_FirstVisit\" name=\"input_FirstVisit\" value=\"$FirstVisit\"/>";
     
     $final_FirstVisit=$input_FirstVisit;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $FirstVisit= $row['first_visit'];
     
     $lbl_FirstVisit="<label id=\"input_FirstVisit\">  $FirstVisit </label>";
     
     $input_FirstVisit="<input type=\"text\" id=\"input_FirstVisit\"/>";
     
     $final_FirstVisit=$lbl_FirstVisit;
 }
print <<< end
    <div id="div_FirstVisit" class="divContainer">
        <div class="divlbl">First Visit</div> 
        <div class="divinfo" id="div_FirstVisitInfo"> $final_FirstVisit </div>
    </div>
end

?>