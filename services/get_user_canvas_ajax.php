<?php
include_once("./user_functions.php");


$userid = isset($_GET["userid"]) ? $_GET["userid"]:json_die("user id not set");
//Get all the canvases for a given user
$json = getAllUserCanvas($userid);

//Return json encoded data
echo json_encode($json);
