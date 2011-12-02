<?php
/**
 * Print out all divs for a given canvas
 */

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
