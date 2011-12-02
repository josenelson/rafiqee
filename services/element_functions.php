<?php

include_once('./config.php');

function getElementData($canvasid)
{
	$query = "SELECT * FROM elements WHERE canvas=".$canvasid;
	$result = mysql_query($query);

	$elements = array();

	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			array_push($elements, $row);
		}
	}
	return $elements;
}
