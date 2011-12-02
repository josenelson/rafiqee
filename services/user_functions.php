<?php
/**
 * Get all the existing canvases for a given user id
 * returns JSON formatted data, throws an error if a 
 * user id is not set
 * GET parameter is userid
 */

include_once("./config.php");

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
	$query = "SELECT canvasid FROM userhascanvas WHERE userid =".$userid;

	//Run query
	$result = mysql_query($query);

	//If we get results format to json
	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			array_push($canvasList[$userid]["accesses"], $row["canvasid"]);
		}
	}


	//Create new query to get all canvases that this user has created
	$query = "SELECT canvasid FROM canvas WHERE userid =".$userid;

	//Run query
	$result =mysql_query($query);

	//If we get results add to array

	if($result)
	{
		while($row = mysql_fetch_assoc($result))
		{
			array_push($canvasList[$userid]["created"], $row["canvasid"]);
		}
	}

	return $canvasList;
}
