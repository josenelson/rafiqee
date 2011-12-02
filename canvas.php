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
	
	
	if(!isset($_GET["canvas_id"])) die("Canvas id not set");
	
	$canvas_id = $_GET["canvas_id"];

		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Canvas</title>
		<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="./js/service-calls.js"></script>
		<script type="text/javascript" src="./js/event-api.js"></script>
		<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<style>
			#draggable1, #draggable2 { width: 150px; height: 150px; padding: 0.5em; }
		</style>
		<script>
			
		
			function element_selected(element_id, user_id, data) {
				
			}
			
			function element_dragged(element_id, user_id, data) {
				
				var id = element_from_id(element_id);
				var element = $( "#" + id )[0];
				
				div_from_element(data, element);
			}
			
			function element_droped(element_id, user_id, data) {
				var id = element_from_id(element_id);
				var element = $( "#" + id )[0];
				
				div_from_element(data, element);

			}
			
			function element_added(element_id, user_id, data) {
			
			}
			
			function element_removed(element_id, user_id, data) {
			
			}
			
			function user_logs_in(user_id, user_id, data) {
			
			} 
			
			function user_logs_out(user_id, user_id, data) {
			
			}
		
		/*
			
			1: user clicks on a element: source represents the element clicked
			2: user drags an element: source represents the element that is dragged 
			3: user drops an element: source represents the element that is dropped
			4: user deletes an element: source represents the element that is deleted
			5: user adds a element to the canvas
			6: user logs in
			7: user logs out
			*/
			
			bind_event(1, element_selected);
			bind_event(2, element_dragged);
			bind_event(3, element_droped);
			bind_event(4, element_removed);
			bind_event(5, element_added);
			bind_event(6, user_logs_in);
			bind_event(7, user_logs_out);
			
			/*
			*	Makes a element with a given
			*	id draggable in its container
			*/
			function make_draggable(element_id) {
				var element = $( "#" + element_id )[0];
				var server_id = id_from_element(element);
				$( "#" + element_id ).draggable({
					start: function() {
						/* Dragging started */
						/*dispatch_event(
								1, 
								server_id, 
								<?php echo $canvas_id; ?>, 
								<?php echo $user_id; ?>, 
								[],
								[]
						);*/
					},
					drag: function() {
						/*var properties = [];
						var values = [];
						properties[0] = 'styles';
						properties[1] = 'properties';
						properties[2] = 'content';
						values[0] = styles_from_element(element);
						values[1] = properties_from_element(element);
						values[2] = content_from_element(element);
					

						dispatch_event(
								2, 
								server_id, 
								<?php echo $canvas_id; ?>, 
								<?php echo $user_id; ?>, 
								properties,
								values
						);*/
					},
					stop: function() {
						var properties = [];
						var values = [];
						properties[0] = 'styles';
						properties[1] = 'properties';
						properties[2] = 'content';
						values[0] = styles_from_element(element);
						values[1] = properties_from_element(element);
						values[2] = content_from_element(element);

						dispatch_event(
								3, 
								server_id, 
								<?php echo $canvas_id; ?>, 
								<?php echo $user_id; ?>, 
								properties,
								values
						);
					
					
					}
				});

			}

			function finished_loading(timestamp) {
				   /* canvas_id, user_id, timestamp */
				  start_event_listener(
				  					<?php echo $canvas_id; ?>,  
									<?php echo $user_id; ?>, 
									timestamp
				  );
			}
			
			load_elements(
							'container', 
							<?php echo $canvas_id; ?>,  
							<?php echo $user_id; ?>, 
							make_draggable,
							finished_loading
							);
			
			window.closed
			   
		</script>
		<div id="container" class="demos">
	
			<!--<div id="draggable2" class="ui-widget-content" width="150px" height="150px">
				<p>Drag me around</p>
			</div>
			
			<div id="draggable1" class="ui-widget-content">
				<p>Drag me around</p>
			</div>-->
	
		</div><!-- End demo -->
		<div class="demo-description" style="display: none; ">
		<p>Enable draggable functionality on any DOM element. Move the draggable object by clicking on it with the mouse and dragging it anywhere within the viewport.</p>
		</div><!-- End demo-description -->
	</body>
</html>
