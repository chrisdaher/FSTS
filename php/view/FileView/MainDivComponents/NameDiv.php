<?php

    
    $firstName="";
    $lastName="";
    

if($editMode== 1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
    $firstName=$row['first_name'];
    $lastName=$row['last_name'];
	
	$input_FirstName="<input type=\"text\" class=\"form_input\" id=\"input_First\" name=\"input_First\" value=\"$firstName\"/> ";
    $input_LastName="<input type=\"text\" class=\"form_input\" id=\"input_Last\" name=\"input_Last\" value=\"$lastName\"/> ";

    $final_FirstName=$input_FirstName;
    $final_LastName=$input_LastName;

}elseif($editMode==2){

	$input_FirstName="<input type=\"text\" class=\"form_input\" id=\"input_First\" name=\"input_First\" value=\"$firstName\"/> ";
    $input_LastName="<input type=\"text\" class=\"form_input\" id=\"input_Last\" name=\"input_Last\" value=\"$lastName\"/> ";

    $final_FirstName=$input_FirstName;
    $final_LastName=$input_LastName;
    
}else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $dep_id = $row['indepedent_id'];
    $res = selectWhereQuery("user","id", $dep_id);
    $row = mysql_fetch_array($res);
    
    $firstName=$row['first_name'];
    $lastName=$row['last_name'];
	
	$lbl_FirstName="<label  id=\"input_First\"> $firstName </label>";
    $lbl_LastName="<label  id=\"input_Last\"> $lastName </label>";

    $final_FirstName=$lbl_FirstName;
    $final_LastName=$lbl_LastName;
}

print<<< END
   <div id="div_Name" class="divContainer">
        <div class="divlbl">Name</div> 
        <div class="divinfo" id="div_First"> $final_FirstName </div>
        <div class="divinfo" id="div_Last"> $final_LastName </div>
    </div>
END;

?>