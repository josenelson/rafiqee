<?php
/**
 * Add text to the db
 */
include_once("./config.php");

$userid = isset($_POST["userid"])? $_POST["userid"]:json_die("userid not set");
$canvasid = isset($_POST["canvasid"])? $_POST["canvasid"]:json_die("canvasid not set");
$content = isset($_POST["content"])? $_POST["content"]:json_die("text not set");

$query = "INSERT INTO elements(user_id, canvas, content, styles) VALUES(";
$query .= $userid.",";
$query .= $canvasid.",'";
$query .= $content."','";
$query .= "left: 50px, top: 50px'";
$query .= ")";
mysql_query($query) or json_die(mysql_error());
