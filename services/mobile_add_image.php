<?php

/**
 * Receives a picture from the mobile client
 * create image on the server
 * add the link to the database
 */
include_once("./config.php");
include_once("./messaging.php");



$user_id = isset($_POST["user_id"])? $_POST["user_id"]:json_die("user_id not set");
$canvas_id = isset($_POST["canvas_id"])? $_POST["canvas_id"]:json_die("canvas_id not set");

//First store image
$base = $_REQUEST['image'];

$binary = base64_decode($base);

header('Content-Type: bitmap; charset=utf-8');
$fileName = tempnam("./canvas-images/", "mobimg");
$file = fopen("./canvas-images/".$fileName, 'wb');
fwrite($file, $binary);
fclose($file);



$content = "<img src ="."./canvas-images/".$filename;
$query = "INSERT INTO elements(user_id, canvas, content, styles) VALUES(";
$query .= $user_id.",";
$query .= $canvas_id.",'";
$query .= $content."','";
$query .= "left: 50px, top: 50px'";
$query .= ")";
$result = mysql_query($query);
$source = mysql_insert_id();
if($result)
{
	echo json_encode("success");
	dispatch_event(5, $source, $canvas_id, $user_id);
}
else
{
	echo json_encode("failure");
}

