<?php

$pageType=$_GET['pageType'];
$Homepage="HomePage";
$AssigningAppointmentpage="AssigningAppointment";

$StartHere="<label id=\"label_Search\">Start here </label>";
if($pageType==$AssigningAppointmentpage){
    $StartHere="";
}


print("
<div id=\"div_SearchGroup\" class=\"ui-widget\">
	$StartHere
    <br />
    <div id=\"div_Search\">
        <label id=\"label_SearchTag1\">File</label>
        <label id=\"label_SearchTag2\">Event</label>
        <input id=\"input_Search\" type=\"text\" onkeyup=\"searchKeyDown(event);\" />
    </div>
    <button id=\"btn_Search\" title=\".ui-icon-circle-zoomin\" class=\"ui-state-default ui-corner-all\">
            <span id=\"icon_search\" class=\"ui-icon ui-icon-search\" onclick=\"searchSubmit(true);\" />
    </button>

</div>
");

?>