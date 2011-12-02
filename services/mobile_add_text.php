<?php
/**
 * Add text to the db
 */
include_once("./config.php");

$user_id = isset($_POST["user_id"])? $_POST["user_id"]:json_die("user_id not set");
$canvas_id = isset($_POST["canvas_id"])? $_POST["canvas_id"]:json_die("canvas_id not set");
$content = isset($_POST["content"])? $_POST["content"]:json_die("text not set");
$content = urldecode($content);

$query = "INSERT INTO elements(user_id, canvas, content, styles) VALUES(";
$query .= $user_id.",";
$query .= $canvas_id.",'";
$query .= $content."','";
$query .= "left: 50px, top: 50px'";
$query .= ")";
mysql_query($query) or json_die(mysql_error());
