<?php
/**
 * If a user is granted access to a canvas
 * add it to the userhascanvas database
 */


include_once("./config.php");

$userid = isset($_POST["userid"])? $_POST["userid"]:json_die("userid not set");
$canvasid = isset($_POST["canvasid"])? $_POST["canvasid"]:json_die("canvasid not set");

$query = "INSERT INTO userhascanvas(userid, canvasid) VALUES(";
$query .= $userid.",";
$query .= $canvasid;
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
