<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once('./config.php');

$canvas = isset($_GET["canvas"])? $_GET["canvas"]:die("canvas id not set");

$query = "SELECT * FROM elements WHERE canvas = " . $canvas;

if(isset($_GET["timestamp"]))
	$query = $query . " and unix_timestamp > " . $_GET["timestamp"];

if(isset($_GET["user_id"]))
	$query = $query . " and  user_id != " . $_GET["user_id"];


$result = mysql_query($query);

$elements = array();
$elements["elements"] = array();
$elements["timestamp"] = time();

if($result)  {

	while($row = mysql_fetch_assoc($result))
	{
		array_push($elements["elements"], $row);
	}

}
echo json_encode($elements);