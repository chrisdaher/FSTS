<?php
 include_once('/../../services/mysql/phpMySql.php');
 include_once('/../../services/mysql/dbSqlToText.php');
 include_once('/../../model/file.php');
 include_once('/../../model/EventManager.php');

$file = new File($famId, false);
$file->loadEvents(false);

$events = $file->events;



print('
    <div class="AppHistory">
        <div class="HistoryTitle"><label>Event History</label></div>
        <table class="table_AppHis">
        <tr>
        <th>Event ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
');
    for($i=0; $i<sizeof($events);$i++)
    {
        $eventID = $events[$i]->event_id;
        $eventName = $events[$i]->event_name;
        $eventType = $events[$i]->getEventTypeString();
        $startDate = $events[$i]->getStartDate();
        $endDate = $events[$i]->getEndDate();
        print("<tr><td>$eventID</td><td>$eventName</td><td>$eventType</td><td>$startDate</td><td>$endDate</td></tr>"); 
    }
    
print('
        </table>
    </div>
');

?>