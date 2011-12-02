<?php

include_once("./config.php");
require_once("./messaging.php");

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');



$canvas_id = isset($_GET["canvas_id"])? $_GET["canvas_id"]:die("canvas id not set");
$user_id = isset($_GET["user_id"])? $_GET["user_id"]:die("user id not set");
$timestamp = isset($_GET["timestamp"])? $_GET["timestamp"]:die("timestamp not set");


$events = wait_for_events($canvas_id, $user_id, $timestamp);

/*	Needs to iterate trough events, 
*	check event type and source, and attach appropriate data.
*
*	Eg. foreach($events['events'] as $event) {
*		if($event['event_type'] == 0) {}
*		else if($event['event_type'] == 1) {}
*		...
*	}
*
*/
$count = 0;
foreach($events["events"] as $event)
{
	switch ($event['event_type'])
	{
	case 1: 
	case 2: 
	case 3: 
	case 4:
	case 5: 
	case 6: $events["events"][$count]["data"] = getElementData($event['source']);
		break;

	}
	$count++;
}

echo json_encode($events);

function getElementData($elementid)
{
	$query = "SELECT * FROM elements WHERE id=".$elementid;
	$result = mysql_query($query);
	$retVal = array();
	//If we get a result return it
	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			$retVal["properties"] = $row["properties"];
			$retVal["content"] = $row["content"];
			$retVal["styles"] = $row["styles"];
		}
	}
	return $retVal;
}

