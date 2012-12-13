<?php


$location='MainDivComponents/';



print "<div id=\"DataMainDiv\">";
print "<form id=\"form_file\" action=\"php/controller/Submit/FileSubmit.php\" method=\"post\">";
include_once($location.'NameDiv.php');
include_once($location.'AdressDiv.php');
include_once($location.'MedicardDiv.php');
include_once($location.'GenderDiv.php');
include_once($location.'DateOfBirth.php');
include_once($location.'AgeDiv.php');
include_once($location.'FirstVisitDiv.php');
include_once($location.'WorkStatusDiv.php');
include_once($location.'LanguageDiv.php');
include_once($location.'MaritalStatusDiv.php');
include_once($location.'ContactDiv.php');
include_once($location.'ReferralDiv.php');
include_once($location.'NotesDiv.php');
include_once($location.'StatusDiv.php');
print "<input id=\"input_submit\" type=\"submit\"/>";
print "</form>";
print "</div>";
?>