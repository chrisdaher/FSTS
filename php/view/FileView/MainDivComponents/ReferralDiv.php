<?php

/**
 * @author Chris
 * @copyright 2012
 */
 
 $Referral= "";
 
  if($editMode==1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $Referral= $row['referral'];
          
     $input_Referral="<input type=\"text\" class=\"form_input\" id=\"input_Referral\" name=\"input_Referral\" value=\"$Referral\"/>";
     
     $final_Referral=$input_Referral;
 }elseif($editMode==2){
     $input_Referral="<input type=\"text\" class=\"form_input\" id=\"input_Referral\" name=\"input_Referral\" value=\"$Referral\"/>";
     
     $final_Referral=$input_Referral;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $Referral= $row['referral'];
     
     $lbl_Referral="<label id=\"input_Referral\">  $Referral </label>";
          
     $final_Referral=$lbl_Referral;
 }
 
print <<< end
    <div id="div_Referral" class="divContainer">
        <div class="divlbl">Referral</div> 
        <div class="divinfo" id="div_ReferralInfo"> $final_Referral </div>
    </div>
end

?>