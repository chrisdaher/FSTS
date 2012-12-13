<?php


 $location="";
 $Income=1;
 
 include_once("/../../../model/File.php");
 include_once("/../../../model/Income.php");
 
  $fileId = $famId;
  $file = new File($fileId, false);
  $file->loadIndependent(true);
  $file->loadDependents(true);
  
  $file->independent->loadIncome();
  $incomes = $file->independent->listOfIncome;
   if (!(sizeof($incomes) > 0)){
		$incomes = array();
   }
  for ($i=0;$i<sizeof($file->dependents);$i++){
	$file->dependents[$i]->loadIncome();
	if (sizeof($file->dependents[$i]->listOfIncome) >0){
		$incomes = array_merge($incomes, $file->dependents[$i]->listOfIncome);
	}
  }
 $Income = sizeof($incomes);
 print "<div id=\"IncomeDivContainer\"><label id=\"lbl_Income\">Income</label>";

	
	for ($i=0;$i<sizeof($incomes);$i++){
		$currIncome = $incomes[$i];
		include($location.'IncomeDiv.php');
	}
	
$top= $Income*30+50;
$toppx = $top."px";
   
$currYear = new DateTime();
$currYear = $currYear->format("Y-m-d");
$currYear = preg_split("/-/", $currYear);
$currYear = $currYear[0];

print "</div>";
print "<div id=\"a_Income\" style=\"top:$toppx\"><a href=\"#\" onclick=\"NewIncForm('Add')\">Add new Income</a></div>";
print "<br/><br/><br/> Total yearly: $" . number_format($file->getTotalYearlyIncome(false), 2);
print "<br/> Total remaining ($currYear): $" . number_format($file->getRemainingYearlyIncome(false), 2);
$dom=new DOMDocument;
?>