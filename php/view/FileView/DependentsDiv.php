<?php


$location="DependentsDiv/";

print "<div id=\"DependentsDiv\">";
print "<center>";
include_once($location.'IncomeDivContainer.php');
$location="DependentsDiv/";
include_once($location.'DepContainerDiv.php');
print "</center>";
print " </div>";

?>