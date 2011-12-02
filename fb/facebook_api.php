<?php
require 'facebook.php';

$appId = '185097781580098';
$secret = '6cb815ba8fac9e4a6bba04d2c71cf8b6';
$url = 'http://localhost/refiqee';

$facebook = new Facebook(array(
  'appId'  => '185097781580098',
  'secret' => '6cb815ba8fac9e4a6bba04d2c71cf8b6',
));
// Get User ID
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();

$_SESSION["user"] = $user;
$_SESSION["facebook"] = $facebook;
$_SESSION["access_token"] = $facebook->getAccessToken();
$_SESSION["appId"] = $appId;
$_SESSION["url"] = $url;

       
//'AAAAAAITEghMBAIVb8ShZCiu1RlOypQgh8ij6QdRnycXxBsbdtrhU0TDoJNA0hwJdHzYKqequpszXYdYg2P9L2zAocSG4aJoBAWg0UBKRDgKymnbRZA';
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  	$_SESSION["logoutUrl"] = $facebook->getLogoutUrl();
  	$_SESSION["isfacebooklogin"] = true;
} else {
  	$_SESSION["loginUrl"] = $facebook->getLoginUrl();
  	$_SESSION["isfacebooklogin"] = false;
}

function isLoggedin() {
	return $_SESSION["isfacebooklogin"];
}

function getLoggedUserId() {
    return $_SESSION["user"]; 
}

function getCurrentUserInfo() {
	return getUserInfo($_SESSION["user"]); 
}

function getUserInfo($userid) {
	$jsonurl = "https://graph.facebook.com/" . $userid;
	$json = file_get_contents($jsonurl,0,null,null);
	$json_output = json_decode($json);
	return $json_output;
}

function postStatusMessage($canvasUrl)
{
	global $facebook;
	$status = $facebook->api('/me/feed', 'POST', array('message'=>$canvasUrl));
}


function getImageUrl($imageid) {
	$url = "https://graph.facebook.com/" . $imageid;
	$url = $url."?access_token=".$_SESSION["access_token"];
	$json = file_get_contents($url, 0, null, null);
	$jsonoutput = json_decode($json);
	return $jsonoutput->{"picture"};
}


function getCollabData($canvas_id)
{
	$query = "SELECT user_id FROM userhascanvas WHERE canvas_id=".$canvas_id;
	$result = mysql_query($query);
	$json[$canvas_id] = array();
	if($result)
	{
		//Generate random colors for each collaborator
		$count = 0;
		$total = mysql_num_rows($result);
		$colors = array();
		while($count < $total)
		{
			$tempColor = generateRandomColor();
			if(!in_array($tempColor, $colors))
			{
				array_push($colors, $tempColor);
				$count++;
			}
		}
		$colorCount = 0;
		while($row = mysql_fetch_assoc($result))
		{
			$url = "https://graph.facebook.com/".$row["user_id"]."/picture";
			$temp["img"] = $url;
			$jsonurl = "https://graph.facebook.com/".$row["user_id"];
			$tempname = file_get_contents($jsonurl, 0, null, null);
			$tempstr = json_decode($tempname);
			$temp["name"] = $tempstr->{"name"};
			$temp["color"] = $colors[$colorCount];
			$colorCount++;
			array_push($json[$canvas_id], $temp);
		}
	}
	return $json;
}

function generateRandomColor(){
    $randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));
    if (strlen($randomcolor) != 7){
        $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
        $randomcolor = substr($randomcolor,0,7);
    }
return $randomcolor;
}


function getUserImage($userid)
{
	$url = "https://graph.facebook.com/" . $userid."/picture";
	return $url;
}


function printUser() {
	print_r($_SESSION["access_token"]);
}

function getUserImageUrl($userid) {
	return "https://graph.facebook.com/" . $userid . "/picture/";
}
