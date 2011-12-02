<?php
/**
 * Print out all divs for a given canvas
 */
 
 		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="./js/service-calls.js"></script>
		<script type="text/javascript" src="./js/event-api.js"></script>
		<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />

include_once("./config.php");
$canvasid = isset($_GET["canvasid"])? $_GET["canvasid"]:json_die("canvasid not set");

//Get all the elements for a given canvas
$query = "SELECT properties, styles, content FROM elements WHERE canvas =".$canvasid;

$result = mysql_query($query);

if($result)
{
	while($row = mysql_fetch_assoc($result))
	{
		$str = "<div style='";
		$str .= $row["styles"]."' ";
		$str .= parseProperties($row["properties"]);
		$str .= ">";
		$str .= $row["content"];
		$str .= "</div>";
		echo $str;
	}
}

//Parse properties and correct the formatting
function parseProperties($prop)
{
	$pattern = "/:/";
	$replacement = "=";
	return preg_replace($pattern, $replacement, $prop);
}

>?
