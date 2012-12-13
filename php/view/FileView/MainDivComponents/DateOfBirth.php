<?php 

 $DateOfBirth= "";
 
  if($editMode==1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $DateOfBirth= $row['dateBirth'];
          
     $input_DateOfBirth="<input type=\"text\" class=\"form_input\" id=\"input_DateOfBirth\" name=\"input_DateOfBirth\" value=\"$DateOfBirth\"/>";
     
     $final_DateOfBirth=$input_DateOfBirth;
 }elseif($editMode==2){
     $DateOfBirth=date("Y-m-d");
     $input_DateOfBirth="<input type=\"text\" class=\"form_input\" id=\"input_DateOfBirth\" name=\"input_DateOfBirth\" value=\"$DateOfBirth\"/>";
     
     $final_DateOfBirth=$input_DateOfBirth;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
     $DateOfBirth= $row['dateBirth'];
     
     $lbl_DateOfBirth="<label id=\"input_DateOfBirth\">  $DateOfBirth </label>";
     
     $input_DateOfBirth="<input type=\"text\" id=\"input_DateOfBirth\"/>";
     
     $final_DateOfBirth=$lbl_DateOfBirth;
 }
print <<< end
    <div id="div_DateOfBirth" class="divContainer">
        <div class="divlbl">Date of Birth</div> 
        <div class="divinfo" id="div_DateOfBirthInfo"> $final_DateOfBirth </div>
    </div>
end

?>