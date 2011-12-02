<?php
include_once('./config.php');
include_once("./user_functions.php");


$user_id = isset($_GET["user_id"]) ? $_GET["user_id"]:json_die("user id not set");
//Get all the canvases for a given user
$json = getAllUserCanvas($user_id);

//Return json encoded data
echo json_encode($json);
