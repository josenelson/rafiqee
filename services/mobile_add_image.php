<?php

/**
 * Receives a picture from the mobile client
 * create image on the server
 * add the link to the database
 */

$base = $_REQUEST['image'];

$binary = base64_decode($base);

header('Content-Type: bitmap; charset=utf-8');
$fileName = tempnam("./images/", "mobimg");
$file = fopen("./images/".$fileName, 'wb');
fwrite($file, $binary);
fclose($file);
