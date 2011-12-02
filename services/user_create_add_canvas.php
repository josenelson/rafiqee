<?php
/**
 * Add a canvas in the database
 * @param user_id of the user who created the canvas
 */
include_once("./config.php");
include_once("./add_user_access.php");
include_once("../fb/facebook_api.php");

$user_id = isset($_GET["user_id"])? $_GET["user_id"]:json_die("user id is not set");
$description = isset($_GET["description"])? $_GET["description"]:json_die("description not set");

$query = "INSERT INTO canvas(description, user_id) VALUES('";
$query .= $description."',";
$query .= $user_id;
$query .=")";

$result = mysql_query($query);
if($result) 
{
	$insertId = mysql_insert_id();
	
	/* Post for FB */
	postStatusMessage('http://localhost/rafiqee/canvas.php?canvas_id=' . $insertId);
	
	echo json_encode($insertId);	
}
else
{
	echo json_encode("failure");
}
