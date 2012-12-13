<?php

/**
 * @author Chris
 * @copyright 2012
 */
 

$depID=$currDep['id'];
$famId = $currDep['family_id'];

$Name=$currDep['first_name'] . " " . $currDep['last_name'];
$Medicare=$currDep['medicard'];
$relation = $currDep['contact'];
$relation = ContactIntToString($relation);
$Age = $currDep['age'];
$Gender = GenderToString($currDep['gender']);

$finalString=$Name." | ".$relation; //." | ".$Age." | ".$Gender;

$depNumber=1;
$id="dependent".$depNumber;

print" <div class=\"dependentClass\" id=\"$id\">$finalString<button class=\"dep_btn_edit\" depID=\"$depID\" fileID=\"$famId\">Edit</button><button class=\"dep_btn_remove\" depID=\"$depID\" fileID=\"$famId\">Remove</button></div>";

?>