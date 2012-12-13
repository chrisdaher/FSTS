<?php

/**
 * @author Chris
 * @copyright 2012
 */
    $StreetNumber="";
    $StreetName="";
    $City="";
    $Province="";
    $PostalCode="";
include_once("/../../../services/getCityFromPcode.php");
 if($editMode==1){
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $fileInfoId = $row['file_info_id'];
    $res = selectWhereQuery("file_info","id", $fileInfoId);
    $row = mysql_fetch_array($res);
    
    $StreetNumber=$row['addr_nb'];
    $StreetName=$row['addr_street'];
    $PostalCode=$row['addr_pcode'];
	$temp = getPcode($PostalCode);
	$temp = preg_split("/::/", $temp);
	if (sizeof($temp) >1){
		$City = $temp[0];
		$Province = $temp[1];
	}
    
    $input_StreetNumber="<input type=\"text\" class=\"form_input\"id=\"input_StreetNumber\" name=\"input_StreetNumber\" value=\"$StreetNumber\"/><label class=\"addr_label\" id=\"addr_number\">No.</label>";
    $input_StreetName="<input type=\"text\" class=\"form_input\" id=\"input_Street\" name=\"input_Street\" value=\"$StreetName\"><label class=\"addr_label\" id=\"addr_street\">Street</label>";
    $input_City="<input type=\"text\" class=\"form_input\" id=\"input_City\" name=\"input_City\" value=\"$City\"><label class=\"addr_label\" id=\"addr_city\">City</label>";
    $input_Province="<input type=\"text\" class=\"form_input\" id=\"input_Province\" name=\"input_Province\" value=\"$Province\"/><label class=\"addr_label\" id=\"addr_province\">Province</label>";
    $input_PostalCode="<input type=\"text\" class=\"form_input\" id=\"input_PostalCode\" name=\"input_PostalCode\" value=\"$PostalCode\" onkeydown=\"applyPostalCode();\" onkeyup=\"applyPostalCode();\" onblur=\"applyPostalCode();\"/><label class=\"addr_label\" id=\"addr_postal\">Postal Code</label>";
    
    $final_StreetNumber=$input_StreetNumber;
    $final_StreetName=$input_StreetName;
    $final_City=$input_City;
    $final_Province=$input_Province;
    $final_PostalCode=$input_PostalCode;
 }elseif($editMode==2){
    $input_StreetNumber="<input type=\"text\" class=\"form_input\" id=\"input_StreetNumber\" name=\"input_StreetNumber\" value=\"$StreetNumber\"/><label class=\"addr_label\" id=\"addr_number\">No.</label>";
    $input_StreetName="<input type=\"text\" class=\"form_input\" id=\"input_Street\" name=\"input_Street\" value=\"$StreetName\"><label class=\"addr_label\" id=\"addr_street\">Street</label>";
    $input_City="<input type=\"text\" class=\"form_input\" id=\"input_City\" name=\"input_City\" value=\"$City\"><label class=\"addr_label\" id=\"addr_city\">City</label>";
    $input_Province="<input type=\"text\" class=\"form_input\" id=\"input_Province\" name=\"input_Province\" value=\"$Province\" /><label class=\"addr_label\" id=\"addr_province\">Province</label>";
    $input_PostalCode="<input type=\"text\" class=\"form_input\" id=\"input_PostalCode\" name=\"input_PostalCode\" value=\"$PostalCode\" onkeydown=\"applyPostalCode();\" onkeyup=\"applyPostalCode();\" onblur=\"applyPostalCode()\"/><label class=\"addr_label\" id=\"addr_postal\">Postal Code</label>";
    
    $final_StreetNumber=$input_StreetNumber;
    $final_StreetName=$input_StreetName;
    $final_City=$input_City;
    $final_Province=$input_Province;
    $final_PostalCode=$input_PostalCode;
 }else{
    $res = selectWhereQuery("file","id",$famId);
    $row = mysql_fetch_array($res);
    $fileInfoId = $row['file_info_id'];
    $res = selectWhereQuery("file_info","id", $fileInfoId);
    $row = mysql_fetch_array($res);
    
    $StreetNumber=$row['addr_nb'];
    $StreetName=$row['addr_street'];
    $PostalCode=$row['addr_pcode'];
	$temp = getPcode($PostalCode);
	$temp = preg_split("/::/", $temp);
	if (sizeof($temp) >1){
		$City = $temp[0];
		$Province = $temp[1];
	}
	
    $lbl_StreetNumber="<label id=\"input_StreetNumber\"> $StreetNumber </label>";
    $lbl_StreetName="<label  id=\"input_Street\"> $StreetName </label>";
    $lbl_City="<label id=\"input_City\"> $City </label>";
    $lbl_Province="<label id=\"input_Province\"> $Province </label>";
    $lbl_PostalCode="<label id=\"input_PostalCode\"> $PostalCode </label>";
    
    $final_StreetNumber=$lbl_StreetNumber;
    $final_StreetName=$lbl_StreetName;
    $final_City=$lbl_City;
    $final_Province=$lbl_Province;
    $final_PostalCode=$lbl_PostalCode;
 }

print<<<end
    <div id="div_Adress" class="divContainer">
        <div class="divlbl">Address</div> 
        <div class="divinfo" id="div_StreetNumber"> $final_StreetNumber </div>
        <div class="divinfo" id="div_Street"> $final_StreetName </div>
        <div class="divinfo" id="div_PostalCode"> $final_PostalCode  </div>
        <div class="divinfo" id="div_City">  $final_City </div>
        <div class="divinfo" id="div_Province">  $final_Province </div>

    </div>
end
?>