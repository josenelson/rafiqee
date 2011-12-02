<?php
/**
 * Add a canvas in the database
 * @param userid of the user who created the canvas
 */
include_once("./config.php");

$userid = isset($_POST["userid"])? $_POST["userid"]:json_die("user id is not set");
$description = isset($_POST["description"])? $_POST["description"]:json_die("description not set");

$query = "INSERT INTO canvas(description, userid) VALUES('".
$query .= $description."',";
$query .= $userid;
$query .=")";

$result = mysql_query($query);
if($result) 
{
	echo json_encode("success");	
}
else
{
	echo json_encode("failure");
}
