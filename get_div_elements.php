<?php	
	if(!isset($_GET["canvas_id"])) die("Canvas id not set");
	if(!isset($_GET["user_id"])) die("user id not set");
	$canvas_id = $_GET["canvas_id"];
	$user_id = $_GET["user_id"];

		
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
			body {
				overflow: hidden;
			}
			#draggable1, #draggable2 { width: 150px; height: 150px; padding: 0.5em; }
		</style>
		<script>
			
		
			
	
			/*
			*	Makes a element with a given
			*	id draggable in its container
			*/
			function make_draggable(element_id) {
				var element = $( "#" + element_id )[0];
				var server_id = id_from_element(element);
				$( "#" + element_id ).draggable({
					start: function() {

					},
					drag: function() {
					
					},
					stop: function() {
				
					
					}
				});

			}

			function finished_loading(timestamp) {
				  
			}
			
			load_elements(
							'container', 
							<?php echo $canvas_id; ?>,  
							<?php echo $user_id; ?>, 
							make_draggable,
							finished_loading
							);	   
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

