<?php  
 include_once('/../../services/mysql/phpMySql.php');
 include_once('/../../services/mysql/dbSqlToText.php');

print "<div id=\"FileInfo\">";
 include_once('DependentsDiv.php');
 include_once('DataMainDiv.php');
 print('
            <div id="div_AppDiv">
            ');
                include_once('php/view/FileView/AppHistory.php');
                include_once('php/view/FileView/UpcomingEvents.php');
print('
            </div>
 ');
  print "</div>";

?>