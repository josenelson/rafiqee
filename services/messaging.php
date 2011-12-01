<?php

include_once('./config.php');

/* SQL Queries to be used: problem not working inside the functions */
$SQL_SELECT_EVENTS = "SELECT * FROM events WHERE unix_timestamp > @{unix_timestamp} and user_id !=  @{user_id} and canvas_id = @{canvas_id} order by unix_timestamp desc";
$SQL_INSERT_EVENT = "INSERT INTO events(event_type,canvas_id,unix_timestamp,user_id,source) VALUES(@{event_type},@{canvas_id},@{unix_timestamp},@{user_id},@{source})";
$SQL_UPDATE_EVENT = "UPDATE events SET user_id=@{user_id}, unix_timestamp=@{unix_timestamp} WHERE event_type=@{event_type} and canvas_id=@{canvas_id} and source=@{source}";

/*
*	Waits for events to be updated on the database with timestamp
*	higher than the one supplied.
*	Will use events related to the given timestamp and ignore
*	events triggered by the given user id.
*	Returns a array of event types (array of int)
*	Parameters:
*		$canvas_id (int): the id of the canvas that's listening to the event	
*		$user_id (int): the id of the user that's loged in the canvas 
*		$timestamp (bigint): the timestamp of the last time the source 
*					got data from events
*	Return: a array containing:
*		[] => 
*			[events] => 
*						[event] => (event data)
*						…
*			[timestamp] => (the new timestamp the listener should use for next requests)
*
*/
function wait_for_events($canvas_id, $user_id, $timestamp) {
	global $SQL_SELECT_EVENTS;
	global $SQL_INSERT_EVENT;
	global $SQL_UPDATE_EVENT;

	$sql = str_replace("@{unix_timestamp}", $timestamp, $SQL_SELECT_EVENTS);
	$sql = str_replace("@{user_id}", $user_id, $sql);
	$sql = str_replace("@{canvas_id}", $canvas_id, $sql);
	
	$timestamp = 0;

	$events = array();

	while(true) {  /* long running operation: will loop until some result is found */
		
		$result = mysql_query($sql) or die(mysql_error() . ' - ' . $sql);
		$found_results = false;
	
		while($row = mysql_fetch_assoc($result)){
			$found_results = true;
			
			if($row['unix_timestamp'] > $timestamp) $timestamp = $row['unix_timestamp'];
			
			
			$event = array(); 
			$event['event_type'] =  $row['event_type'];
			$event['user_id'] =  $row['user_id'];
			$event['source'] =  $row['source'];
			
			array_push($events, $event);
		}
	
		if($found_results) break;
	
	}
		
	return array("events" => $events, "timestamp" => $timestamp);
}

/*
*	Trigger a event with the given 
*	type for the canvas.
*	The user_id is the user that triggered 
*	the event.
*	Parameters:
*		$event_type (int): an unique identifier of the event (see event_types.php for details) 
*		$source (int): an id that's related to the event data
*						- for user related events: user_id
*						- for canvas' elements related events it's the element id
*						- (place other event source descriptions here)
*		$canvas_id (int):  the id of the canvas that triggered the event
*	Returns:
*		the timestamp for which the events where updated
*
*/ 
function dispatch_event($event_type, $source, $canvas_id, $user_id) {
	global $SQL_SELECT_EVENTS;
	global $SQL_INSERT_EVENT;
	global $SQL_UPDATE_EVENT;
	
	$timestamp = time();
	
	$sql_where_clause = 'event_type='.$event_type.' and canvas_id='.$canvas_id.' and source='.$source;
	$sql = '';
	
	/* Check if canvas has the event */
	if(has_rows('events', $sql_where_clause)) {
		//Just update
		$sql = str_replace("@{unix_timestamp}", $timestamp, $SQL_UPDATE_EVENT);
		$sql = str_replace("@{user_id}", $user_id, $sql);
		$sql = str_replace("@{canvas_id}", $canvas_id, $sql);
		$sql = str_replace("@{event_type}", $event_type, $sql);
		$sql = str_replace("@{source}", $source, $sql);
	}
	else {
		//Insert
		$sql = str_replace("@{unix_timestamp}", $timestamp, $SQL_INSERT_EVENT);
		$sql = str_replace("@{user_id}", $user_id, $sql);
		$sql = str_replace("@{canvas_id}", $canvas_id, $sql);
		$sql = str_replace("@{event_type}", $event_type, $sql);
		$sql = str_replace("@{source}", $source, $sql);
	}

	mysql_query($sql) or die(mysql_error() . ' - ' . $sql);
	
	return $timestamp;

}