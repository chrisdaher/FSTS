<?php

$subFolder="Components\\";
include_once($subFolder."MenuBarBuilder.php");
//get the current username

$Name=$_COOKIE['LoginName'];
$isAdmin = $_SESSION['isAdmin'];

if ($isAdmin == 1){
	$adminButton = "<button id=\"btn_Admin\">Admin</button>";
}
else{
	$adminButton = "";
}


print <<< end
    <div id="div_MenuBar">
        <button id="btn_Home">Home</button>
        <button id="btn_Calender">Calendar</button>
        <button id="btn_Reporting">Reporting</button>
        <button id="btn_Logout">Logout</button>
        $adminButton
    
        <a tabindex="0" href="#search-engines" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="flyout"><label id="label_Name">$Name</label></a>
        
    </div>	
end
?>