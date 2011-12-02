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

$json = array("error"=>0);

switch($event_type)
{
 	case 1: break;
	case 2: $elementid = $source;
		$styles = isset($_GET["styles"])? $_GET["styles"]:die("styles not set");
		$properties = isset($_GET["properties"])? $_GET["properties"]:die("properties not set");
		$content = isset($_GET["content"])? $_GET["content"]:die("content not set");
		updateElement($source, $styles, $properties, $content);
		break;
	case 3: break;
	case 4: deleteElement($source);
		break;
	case 5: $styles = isset($_GET["styles"])? $_GET["styles"]:die("styles not set");
		$properties = isset($_GET["properties"])? $_GET["properties"]:die("properties not set");
		$content = isset($_GET["content"])? $_GET["content"]:die("content not set");
		$json["data"] = addElement($canvas_id, $user_id, $styles, $properties, $content);
		break;
	

}

dispatch_event($event_type, $source, $canvas_id, $user_id);

/* Return a empty response in case of success */
echo json_encode($json);

//Function to update the elements table
function updateElement($elementid, $styles, $properties, $content)
{

	$query = "UPDATE elements SET styles='";
	$query .= $styles."',";
	$query .= "properties ='";
	$query .= $properties."',";
	$query .= "content ='";
	$query .= $content;
	$query .= "' WHERE id=".$elementid;
	mysql_query($query) or json_die(mysql_error());
}

//Function to delete a given element from the database
function deleteElement($elemid)
{
	$query = "DELETE FROM elements WHERE id=";
	$query .= $elemid;
	mysql_query($query) or json_die(mysql_error());
}

//Function to insert a new element into the database
function addElement($canvasid, $userid, $styles, $properties, $content)
{
	$query = "INSERT INTO elements(user_id, properties, canvas, content, styles) VALUES(";
	$query .= $userid.", '";
	$query .= $properties."',";
	$query .= $canvasid.",'";
	$query .= $content."','";
	$query .= $styles."'";
	$query .= ")";
	mysql_query($query) or json_die(mysql_error());
	return mysql_insert_id();
}
