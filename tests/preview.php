<?php
	include_once('services/config.php');
	
	if(!isset($_GET["user"])) die("User id not set");
	
	$user_id = $_GET["user"];
	$canvas_id = 1;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4000.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Drag and drop samples</title>
		<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="./js/service-calls.js"></script>
		<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	</head>
	<style>
		.demos { width: 800px; height: 600px; border-bottom-color: black; border-bottom-width: 1px; zoom:20%; overflow: hidden; }
	</style>
	<body>
		<script>
			$.getJSON("./services/get_elements.php?canvas=1", 
						function(data) {
							for(var i = 0; i < data.elements.length; i++) {
								
								var newdiv = document.createElement('div');
								div_from_element(data.elements[i], newdiv);
								
								$("#container")[0].appendChild(newdiv);
							}
						});
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
