<?php



$flag=true;
$source="Images/FlagAlert.png";
$alt="Alert";
$pageType=$_GET['pageType'];

$filepage="FileView";
$AssigningAppointmentpage="AssigningAppointment";
 $FileID= $famId;
$FileID = preg_split("/-/", $FileID);
$FileID = $FileID[0];

print "<div id=\"div_optionBar\">";

print "    <div id=\"div_FileIdNumber\"><label id=\"label_FileIdNumber\">$FileID</label></div>";
        if($flag==true && $pageType=="FileView"){
            print "<div id=\"image_flag\"><image src=\"$source\" alt=\"$alt\"/> </div>";
        }
        if($pageType==$filepage){
            include('ButtonGroup.php');
        }elseif($pageType==$AssigningAppointmentpage){
            print("<div id='center_searchGroup'><center >");
            include('SearchGroup.php');
            print("</center></div>");
        }
        include('EditButton.php');
print "    </div>";


?>