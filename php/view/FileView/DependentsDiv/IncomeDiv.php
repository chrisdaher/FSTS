<?php
 
 include_once("/../../../model/User.php");
 include_once("/../../../model/converter.php");
 $usr = new User($currIncome->user_id,false);
 $conv = new converter("incometypeconverter", false);
 $convTypeRow = $conv->getRow($currIncome->income_type_id);
 $conv = new converter("incomelengthconverter", false);
 $convLengthRow = $conv->getRow($currIncome->income_length_id);
 $Person = $usr->first_name . " " . $usr->last_name;
 $Type = $convTypeRow['name'];
 $Mode = $convLengthRow['name'];
 $sDate = "10/07/2002";
 $eDate = "10/10/2002";
 $incVal = $currIncome->value;
/*
print "<div id=\"IncomeDiv\">";
print '<label class="person">'.$Person.'</label>';
print '<label class="type">'.$Type.'</label>';
print '<label class="mode">'.$Mode.'</label>';
print '<label class="startDate">'.$sDate.'</label>';
print '<label class="endDate">'.$eDate.'</label>';
print "</div>";
*/

 
$incID=$currIncome->id;

$finalString=$Person." | $".$incVal." | ".$Mode; //." | ".$Age." | ".$Gender;

$id="Income".$incID;

print" <div class=\"incomeClass\" id=\"$id\">$finalString<button class=\"inc_btn_edit\" incID=\"$incID\" fileID=\"$famId\">Edit</button><button class=\"inc_btn_remove\" incID=\"$incID\" fileID=\"$famId\">Remove</button></div>";



?>