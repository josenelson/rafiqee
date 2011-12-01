<?php


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

echo json_encode($events);



