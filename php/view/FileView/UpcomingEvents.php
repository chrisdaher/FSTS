<?php
 include_once('/../../services/mysql/phpMySql.php');
 include_once('/../../services/mysql/dbSqlToText.php');
 include_once('/../../model/EventManager.php');
 include_once('/../../view/Components/SearchGroup_MiniBuilder.php');

// $file = new File($famId, false);
// $file->loadEvents(false);

// $events = $file->events;
$events = getNextEvents(5);
$searchBar= new SearchGroup_MiniBuilder("Search Here", "Upcoming", false);
$searchBar = $searchBar->getContainer()->toHTML();
print('
    <div class="Upcoming">
        <table class="UpcomingTitle"><tr><td></td><td id="upcomingtitle"><label>Upcoming Events</label></td><td>'.$searchBar.
        '</td></tr></table>
        <table class="table_Upcoming">
        <tr>
        <th>Event ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Register</th>
');
    for($i=0; $i<sizeof($events);$i++)
    {
        $eventID = $events[$i]->event_id;
        $eventName = $events[$i]->event_name;
        $eventType = $events[$i]->getEventTypeString();
        $startDate = $events[$i]->getStartDate();
        $endDate = $events[$i]->getEndDate();
        print("<tr><td>$eventID</td><td>$eventName</td><td>$eventType</td><td>$startDate</td><td>$endDate</td><td><button class=\"registerToEvent\" EventID=\"$eventID\"></button></td></tr>"); 
    }
    
print('
        </table>
    </div>
');
?>