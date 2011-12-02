<?php
	require_once('./services/config.php');
	require_once('./services/user_functions.php');
	require_once('./fb/facebook_api.php');


	if(isset($_SESSION["logoutUrl"]))
		$logouturl = $_SESSION["logoutUrl"];
	else 
		$logouturl = '';
		
		
	if(isset($_SESSION["loginUrl"]))
		$loginurl = $_SESSION["loginUrl"];
	else 
		$logouturl = '';
		
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
	<script type="text/javascript">
		function addNewCanvas(){
			var value = $('div#create-new').find('textarea[name=desc]').val();
			if(value!=""){
				$.getJSON('./services/user_create_add_canvas.php?user_id=<?php echo $user_id;?>&description=' + value,
					function(data){
						window.location = './canvas.php?canvas_id=' + data;
				});
			}
			
		}
	</script>
	<body>
		<div class="mainpage-header">
			
			<div id="profile">
				<div id ="profile-picture">
					<img src="<?php echo $userImageUrl;?>"></img>
				</div>
				<div id="welcome-text">
					<p id="welcome">Welcome,</p>
					<p id="profile-name"><?php echo $user_name;?></p>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="logo">
				<img src="images/logo.png">
				<div id="navigation">
				<ul>
					<li><a href="<?php echo $logouturl; ?>">SIGN OUT</a></li>
				</ul>
			</div>
			</div>
        	<div style="clear:both;"></div>
		</div>
		<div class="mainpage-central-content">
			<?php 
				$canvases = getAllUserCanvas($user_id);
				echo "<div id=\"left-main-div\">";
					echo "<div id=\"create-new\">";
						echo "<div id=\"create-new-header\">";
						echo "<p>WHATS NEW?</p>";
						echo "</div>";
						echo "<div id=\"create-form\">";
						echo "<textarea name=\"desc\" style=\"max-width: 99%;min-width: 99%;\" cols=\"30\" rows=\"5\"></textarea>";
						echo "<div id=\"form-controls\"><Button onclick=\"addNewCanvas()\">POST</Button></div>";
						echo "</div>";
					echo "</div>";
				echo "<div id=\"created-div\">";
				echo "<div id=\"created-canvases-header\"><p>CREATED</p></div>";
				echo "<div id=\"created-canvases\">";
				foreach($canvases[$user_id]["created"] as $canvas) {
					$url = './canvas-preview.php?user_id=1&canvas_id=' . $canvas['canvas_id'];
					$url =  $url . "&user_id=" . $user_id; 
					?>
					<a href="canvas.php?canvas_id=<?php echo $canvas['canvas_id'];?>" style="display:block;">
					<div class="mainpage-canvas-thumb">	
						<div>
							<iframe frameborder="0" class="mainpage-canvasframe" src="<?php echo $url;?>">
  								<p>Your browser does not support iframes.</p>
							</iframe>
						</div>
						<div class="canvas-description"><?php echo "<p>".$canvas['description']."</p>"; ?></div>
					</div>	
					</a>
					<?php
				}
				echo "<div style=\"clear:both;\"></div>";
				echo "</div></div>";
				echo "</div>";
				echo "<div id=\"access-div\">";
				echo "<div id=\"access-canvases-header\"><p>ACCESS</p></div>";
				echo "<div id=\"access-canvases\">";
				foreach($canvases[$user_id]["accesses"] as $canvas) {
					$url = './canvas-preview.php?user_id=1&canvas_id=' . $canvas['canvas_id'];
					$url =  $url . "&user_id=" . $user_id; 
					?>
					<a href="canvas.php?canvas_id=<?php echo $canvas['canvas_id'];?>" style="display:block;">
					<div class="mainpage-canvas-thumb">
						
						<div>
							<iframe frameborder="0" class="mainpage-canvasframe" src="<?php echo $url;?>" style="overflow:hidden" >
  								<p>Your browser does not support iframes.</p>
							</iframe>
						</div>
						<div><?php echo $canvas['description']; ?></div>
					</div>	
					</a>
					<?php
				}
				echo "<div style=\"clear:both;\"></div>";
				echo "</div></div>";
				
			?>
				
		</div>
	</body>
</html>