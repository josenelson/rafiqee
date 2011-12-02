<?php
/**
 * Returns JSON formatted data containing information about
 * a given element
 */
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once('./config.php');
include_once('./element_functions.php');

$canvas_id = isset($_GET["canvas_id"])? $_GET["canvas_id"]:die("canvas id not set");
$user_id = isset($_GET["user_id"])? $_GET["user_id"]:die("user id not set");


//Get all element data
$elements = array();
$elements["elements"] = getElementsData($canvas_id);
$elements["timestamp"] = time();
echo json_encode($elements);
