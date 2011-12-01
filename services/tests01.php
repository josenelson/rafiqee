<?php

/* Testing mysqli_* */

$host = 'localhost';
$password = '';
$database = 'samples';
$username = 'root';


echo time();
die();

$connection = mysqli_connect($host, $username, $password)  or die(mysqli_error($connection)); 
mysqli_select_db($connection, $database) or die(mysqli_error($connection));


$sql = "select * from events";
	
$sql = str_replace("@{table}", $table, $sql);
$sql = str_replace("@{condition}", $condition, $sql);
	
$result =  mysqli_query($connection, $sql) or die(mysqli_error($connection) . ' - ' . $sql);

while(($row = mysqli_fetch_assoc($result))) {
	print_r($row);
	print('<br/>');
}

echo '<br/>If not results are displayed the no results where found <br/>';



	

