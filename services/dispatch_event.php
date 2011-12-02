<?php

require_once("./config.php");
require_once("./messaging.php");

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

/*
*	dispatch_event.php?canvas_id=1&user_id=2&source=1&event_type=[&styles=…&properties=…&content=…]
*	
*/

$canvas_id = isset($_GET["canvas_id"])? $_GET["canvas_id"]:die("canvas id not set");
$user_id = isset($_GET["user_id"])? $_GET["user_id"]:die("user id not set");
$source = isset($_GET["source"])? $_GET["source"]:die("source not set");
$event_type = isset($_GET["event_type"])? $_GET["event_type"]:die("event type not set");

/*	Needs to iterate trough events, 
*	check event type and source, and attach appropriate data.
*
*	Eg.
*		if($event_type == 0) {}
*		else if($event_type == 1) {}
*		...
*	
*
*/

dispatch_event($event_type, $source, $canvas_id, $user_id);

/* Return a empty response in case of success */
echo json_encode(array("error" => 0));



