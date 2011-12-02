<?php
/**
 * If a user is granted access to a canvas
 * add it to the userhascanvas database
 */


include_once("./config.php");

$user_id = isset($_POST["user_id"])? $_POST["user_id"]:json_die("user_id not set");
$canvas_id = isset($_POST["canvas_id"])? $_POST["canvas_id"]:json_die("canvas_id not set");

$query = "INSERT INTO userhascanvas(user_id, canvas_id) VALUES(";
$query .= $user_id.",";
$query .= $canvas_id;
$query .= ")";

$result = mysql_query($query);
if($result)
{
	echo json_encode("success");
}
else
{
	echo json_encode("failure");
}
