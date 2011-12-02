<?php

/**
 * Receives a picture from the mobile client
 * create image on the server
 * add the link to the database
 */
include_once("./config.php");
//First store image
$base = $_REQUEST['image'];

$binary = base64_decode($base);

header('Content-Type: bitmap; charset=utf-8');
$fileName = tempnam("./canvas-images/", "mobimg");
$file = fopen("./canvas-images/".$fileName, 'wb');
fwrite($file, $binary);
fclose($file);
