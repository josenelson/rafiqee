<?php

function addToHasCanvas($user_id, $canvas_id)
{
	$query = "SELECT id FROM userhascanvas WHERE user_id=".$user_id." AND canvas_id=".$canvas_id;
	//echo $query;
	$result = mysql_query($query);
	if(mysql_num_rows($result) == 0)
	{
		$query = "INSERT INTO userhascanvas(user_id, canvas_id) VALUES(";
		$query .= $user_id;
		$query .= ",".$canvas_id;
		$query .= ")";
		mysql_query($query) or die("Insert failed");
	}
	
}
