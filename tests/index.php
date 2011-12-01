<?php
	include_once('services/config.php');
	
	if(!isset($_GET["user"])) die("User id not set");
	
	$user_id = $_GET["user"];
	$canvas_id = 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Drag and drop samples</title>
		<script type="text/javascript" src="./js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="./js/service-calls.js"></script>
		<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<style>
			#draggable1, #draggable2 { width: 150px; height: 150px; padding: 0.5em; }
		</style>
		<script>
			/* Variables that will hold the state */
			var timestamp = '';
			var timer = setInterval(update, 1000);

			
			//Makes an object draggable and binds events to it
			function make_canvas_element_draggable(element_id) {
				var element = $( "#" + element_id )[0];
				$( "#" + element_id ).draggable({
					start: function() {
						/* Dragging started */
					},
					drag: function() {
						//udpate_server(element);
						update_server(element);
					},
					stop: function() {
						/* Dragging ended */
		
						update_server(element);
						//alert(element.offsetTop + ':' + element.offsetLeft);
					}
				});

			}
		
			$(function() {
				//Add any init functions here
			});
			

			
			function update_server(element) {
				var url = "./services/update_element.php?canvas=<?php echo $canvas_id; ?>";
				
				url = url + "&user='<?php echo $user_id; ?>'";;
				//url = url + "&properties='" + properties_from_element(element) + "'";
				url = url + "&styles='" + styles_from_element(element) + "'";
				url = url + "&content='" + element.innerText + "'";
				url = url + "&id=" + id_from_element(element);
				
				$.getJSON(url, function(data) {if(data.error > 0) alert(data.error_description);});

			}
			
			function update() {
				var url = "./services/get_elements.php?canvas=<?php echo $canvas_id; ?>";
				url = url + "&timestamp=" + timestamp;
				url = url + "&user=" + <?php echo $user_id; ?>;
				
  				$.getJSON(url, 
						function(data) {
							timestamp = data.timestamp;
							for(var i = 0; i < data.elements.length; i++) {
								
								var id = "element_" + data.elements[i].id;
								var newdiv = $('#' + id)[0];
								
								div_from_element(data.elements[i], newdiv);

							}
						});
			}				
			
			$.getJSON("./services/get_elements.php?canvas=<?php echo $canvas_id; ?>", 
						function(data) {
							timestamp = data.timestamp;
							for(var i = 0; i < data.elements.length; i++) {
								
								var newdiv = document.createElement('div');
								div_from_element(data.elements[i], newdiv);
								
								$("#container")[0].appendChild(newdiv);
								
								make_draggable(newdiv.getAttribute('id'));
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
