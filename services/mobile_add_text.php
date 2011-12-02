<?php
/**
 * Add text to the db
 */
include_once("./config.php");

$userid = isset($_GET["userid"])? $_GET["userid"]:json_die("userid not set");
$canvasid = isset($_GET["canvasid"])? $_GET["canvasid"]:json_die("canvasid not set");
$content = isset($_GET["content"])? $_GET["content"]:json_die("text not set");

$query = "INSERT INTO elements(user_id, canvas, content, styles) VALUES(";
$query .= $userid.",";
$query .= $canvasid.",'";
$query .= $content."','";
$query .= "left: 50px, top: 50px'";
$query .= ")";
mysql_query($query) or json_die(mysql_error());
