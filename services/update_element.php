<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once('./config.php');

$id = isset($_GET["id"])? $_GET["id"]:json_die("element id not set");
$canvas = isset($_GET["canvas"])? $_GET["canvas"]:json_die("canvas id not set"); /* Not really used */
$user = isset($_GET["user"])? $_GET["user"]:json_die("user id not set");
//$properties = isset($_GET["properties"])? $_GET["properties"]:json_die("properties not set");
$styles = isset($_GET["styles"])? $_GET["styles"]:json_die("styles not set");
$content = isset($_GET["content"])? $_GET["content"]:json_die("content not set");

//SET column_1 = [value1], column_2 = [value2]
$query = "UPDATE elements SET ";
$query = $query . "user_id=" . $user;
//$query = $query . ",properties=" . $properties;
$query = $query . ",styles=" . $styles;
$query = $query . ",content=" . $content;
$query = $query . ",unix_timestamp=" . time();
$query = $query . " WHERE id = " . $id;

$json = array("error" => 0, "error_description" => "");


mysql_query($query) or json_die(mysql_error());

echo json_encode($json);