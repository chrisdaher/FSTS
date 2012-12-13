<?php

 $FinalButton;
 if($editMode==1||$editMode==2||$editMode==3){
	if ($editMode == 3){
		$FinalButton="<div id=\"EditButton\"><button class=\"OptionMenuBtn\" id=\"btn_Return\">Return</button></div>";
	}
	else{
		$FinalButton="<div id=\"EditButton\"><button class=\"OptionMenuBtn\" id=\"btn_Done\">Done</button><button class=\"OptionMenuBtn\" id=\"btn_Cancel\">Cancel</button></div>";	
	}
 }
 else{
    $FinalButton="<div id=\"EditButton\"><button class=\"OptionMenuBtn\" id=\"btn_Edit\">Edit</button></div>";
}

    print $FinalButton;

?>