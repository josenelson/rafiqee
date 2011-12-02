<?php
	require_once('./services/config.php');
	require_once('./services/user_functions.php');
	require_once('./fb/facebook_api.php');


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
		<script>
		$(function() {
			// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			$( "#dialog-message" ).dialog({
				autoOpen: false,
				modal: true,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
						/* Create a new canvas and redirect */
						$.getJSON('./services/user_create_add_canvas.php?user_id=<?php echo $user_id;?>&description=' + title.value,
							function(data){
								alert('./services/user_create_add_canvas.php?user_id=<?php echo $user_id;?>&description=' + title.value);
								window.location = './canvas.php?canvas_id=' + data;
							}
						)},
					Cancel:  function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
		function create_canvas() {
			$( "#dialog-message" ).dialog( "open" );
		}
		
		</script>
		<div id="dialog-message" title="Download complete">
			<form>
				<fieldset>
					<label for="name">Title</label>
					<input type="text" name="title" id="title" class="text ui-widget-content ui-corner-all" />
				</fieldset>
			</form>
		</div>


		<div class="mainpage-header">
			<div class="mainpage-userimage">
        				<img src="<?php echo $userImageUrl;?>" />
       		</div>
        	<div class="mainpage-userinfo">
        		Welcome, <?php echo $user_name;?> <a href="<?php echo $logouturl; ?>">Logout</a>
        		<script>
        			console.log('user id:' + <?php echo $user_id;?>);	
        		</script>	
        	</div>
        	<div class="mainpage-createcanvas" onclick="create_canvas()">
        		New
        	</div>
		</div>
		<div class="mainpage-central-content">
			<?php 
				$canvases = getAllUserCanvas($user_id);
				
				foreach($canvases[$user_id]["accesses"] as $canvas) {
					$url = './get_div_elements.php?canvas_id=' . $canvas['canvas_id'];
					$url =  $url . "&user_id=" . $user_id; 
					?>
					
					<div class="mainpage-canvas-thumb">
						<div><?php echo $canvas['description']; ?></div>
						<div style="zoom:20%">
							<iframe frameborder="0" class="mainpage-canvasframe" src="<?php echo $url;?>" width="100px" height="100px">
  								<p>Your browser does not support iframes.</p>
							</iframe>
						</div>
						<div class="mainpage-canvas-tags">#sketching #research</div>
					</div>	
					<?php
				}
			?>
				
		</div>
	</body>
</html>