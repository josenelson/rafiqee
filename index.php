<?php
	include_once('services/config.php');
	include_once('fb/facebook_api.php');

	$logouturl = $_SESSION["logoutUrl"];
	$loginurl = $_SESSION["loginUrl"];
		
	if(isLoggedin()){
		$user = getCurrentUserInfo();
		$user_info = getCurrentUserInfo();

		$user_name = $user_info->{"name"};
		$user_id = $user_info->{"id"};

		$userImageUrl = getUserImageUrl($user_id);
	} 
		
	else {
		header("Location: " . $loginurl);
		die();
	}
		
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>RAFIQEE</title>
	<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="./js/service-calls.js"></script>
	<script type="text/javascript" src="./js/event-api.js"></script>
	<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="css/mainpage.css" rel="stylesheet" type="text/css" />
	<body>
		<div class="mainpage-header">
			<div class="mainpage-userimage">
        				<img src="<?php echo $userImageUrl;?>" />
       		</div>
        	<div class="mainpage-userinfo">
        		Welcome, <?php echo $user_name;?></p> 		
        	</div>
		</div>
		<div class="mainpage-central-content">
			<div class="mainpage-canvas-thumb">
					<div>the quick brown fox jumped over the lazy sheep dog</div>
					<div class="project-thumb-tags">#sketching #research</div>
			</div>		
		</div>
	</body>
</html>