<?php

/**
 * Get all the canvases for a given user id by querying the database
 * @param $userid the userid for which we need all canvases
 * @return array containing all the canvases
 */
function getAllUserCanvas($userid)
{

	//Get the userid
	//$userid = isset($_GET["userid"]) ? $_GET["userid"]:json_die("user id not set");

	//Create array to which we need to add the canvases
	$canvasList = array();
	$canvasList[$userid] = array();
	$canvasList[$userid]["created"] = array();
	$canvasList[$userid]["accesses"] = array();

	//Mysql query to select all the canvas objects that a user has access to
	$queryAccess = "SELECT canvas_id FROM userhascanvas WHERE user_id =".$userid;

	//Run query
	$result = mysql_query($queryAccess);

	//If we get results format to json
	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			//Store the id and description
			$temp = array();
			$temp["canvas_id"] = $row["canvas_id"];
			$temp["description"] = getDescription($row["canvas_id"]);
			array_push($canvasList[$userid]["accesses"], $temp);
		}
	}


	//Create new query to get all canvases that this user has created
	$queryCreated = "SELECT id, description FROM canvas WHERE user_id =".$userid;

	//Run query
	$result =mysql_query($queryCreated);

	//If we get results add to array

	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			$temp = array();
			$temp["canvas_id"] = $row["id"];
			$temp["description"] = $row["description"];
			array_push($canvasList[$userid]["created"], $temp);
			//array_push($canvasList[$userid]["created"]["description"], $row["description"]);
		}
	}

	return $canvasList;
}

/**
 * Get the description for a given canvas id
 */
function getDescription($canvas_id)
{
	$query = "SELECT description FROM canvas WHERE id =".$canvas_id;
	$result = mysql_query($query);
	if($result)
	{
		$row = mysql_fetch_assoc($result);
		return $row["description"];
	}
}
