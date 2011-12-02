<?php
/**
 * Add a canvas in the database
 * @param user_id of the user who created the canvas
 */
include_once("./config.php");

$user_id = isset($_GET["user_id"])? $_GET["user_id"]:json_die("user id is not set");
$description = isset($_GET["description"])? $_GET["description"]:json_die("description not set");

$query = "INSERT INTO canvas(description, user_id) VALUES('".
$query .= $description."',";
$query .= $user_id;
$query .=")";

$result = mysql_query($query);
if($result) 
{
	echo json_encode(mysql_insert_id());	
}
else
{
	echo json_encode("failure");
}
