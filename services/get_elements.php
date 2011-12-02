<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once('./config.php');

$timestamp = time();

$canvas_id = isset($_GET["canvas_id"])? $_GET["canvas_id"]:die("canvas id not set");
$user_id = isset($_GET["user_id"])? $_GET["user_id"]:die("user id not set");

$query = "SELECT * FROM elements WHERE canvas = " . $canvas_id;

//should log in user here ?

$result = mysql_query($query) or json_die(mysql_error());

$elements = array();
$elements["elements"] = array();
$elements["timestamp"] = $timestamp;

if($result)  {

	while($row = mysql_fetch_assoc($result))
	{
		array_push($elements["elements"], $row);
	}

}
echo json_encode($elements);