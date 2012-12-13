<?php

$res = selectWhereQuery("file","id",$famId);
$row = mysql_fetch_array($res);
$dep_id = $row['indepedent_id'];

$res = selectWhereQuery("user","family_id", $famId);
 
 $location="";
 $Dependents=0;
 
  
 print "<div id=\"DepContainerDiv\"><label id=\"lbl_Dependents\">Dependents</label>";
   
while($row = mysql_fetch_array($res)){
	if ($row['id']!=$dep_id){
		$currDep = $row;
		include($location.'DependentDiv.php');
		$Dependents++;
	}
}

$top= $Dependents*30+ ($Income*30+220);
 $toppx = $top."px";
    
print "</div>";
print "<div id=\"a_dependent\" style=\"top:$toppx\"><a href=\"#\" onclick=\"NewDepForm('Add')\">Add new Dependent</a></div>";

$dom=new DOMDocument;
?>