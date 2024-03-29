<?php
	include_once('services/config.php');
	
	if(!isset($_GET["user_id"])) die("User id not set");
	if(!isset($_GET["canvas_id"])) die("Canvas id not set");
	
	$user_id = $_GET["user_id"];
	$canvas_id = $_GET["canvas_id"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Drag and drop samples</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="./js/service-calls.js"></script>
		<script type="text/javascript" src="./js/event-api.js"></script>
		<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />

	</head>
	<body>
		<style>
			#draggable1, #draggable2 { width: 150px; height: 150px; padding: 0.5em; }
			body 
			{
				overflow:hidden;
			}
		</style>
		<script>
			function finish_callback(element_id) {
			
			}
			/*
			*	Makes a element with a given
			*	id draggable in its container
			*/
			function make_draggable(element_id) {
				var element = $( "#" + element_id )[0];
				$( "#" + element_id ).draggable({
					start: function() {
						/* Dragging started */
					},
					drag: function() {
						//udpate_server(element);
						//update_server(element);
					},
					stop: function() {
						/* Dragging ended */
		
						//update_server(element);
						//alert(element.offsetTop + ':' + element.offsetLeft);
					}
				});

			}


			load_elements('container', <?php echo $canvas_id; ?>,  <?php echo $user_id; ?>, make_draggable, finish_callback);
			
			document.body.style.zoom="15%"
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
