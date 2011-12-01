<?php

$host = 'localhost';
$password = '';
$database = 'samples';
$username = 'root';

$connection = mysql_connect($host, $username, $password)  or die(mysql_error()); 
mysql_select_db($database) or die(mysql_error());


/************ Utility functions **************************/

/*
*	Returns a boolean indicating if the table contains
*	rows that match the condition.
*	Parameters:
*				$table (string): the name of the table to search for rows
*				$condition(string): the where clause of the query
*
*/ 
function has_rows($table, $condition) {
	$sql = "select 1 from @{table} where @{condition} limit 1";
	
	$sql = str_replace("@{table}", $table, $sql);
	$sql = str_replace("@{condition}", $condition, $sql);
	
	$result =  mysql_query($sql) or die(mysql_error() . ' - ' . $sql);

	if(mysql_fetch_row($result)) 
		return true;
	else
		return false;
	

}

/*
*	Outputs a pre-formated json response with the error description
*	Closes the stream at the end of the function.
*/
function json_die($error) {
	$json = array("error" => 1, "error_description" => $error);
	echo json_encode($json);
	die();
}

