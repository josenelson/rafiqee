<?php
	include_once('services/config.php');
	include_once('fb/facebook_api.php');
	include_once('./services/user_functions.php');

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
	$creator_id = getCreatorId($canvas_id);
	
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Canvas</title>
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
		</style>
		
		
		<!-- Kaushal scripts -->
		<script type="text/javascript">
	
		function getStyle(el,styleProp)
		{
	var x = document.getElementById(el);
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
		else if (window.getComputedStyle)
			var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
		return y;
	}
	
		$(document).ready(function(){
			
			$("#element-accordion").accordion();
			$('.stickies').draggable({helper:'clone',appendTo: 'body'});
			$( "#right-hand-canvas" ).droppable({ accept: '.movable',
				drop: function(event, ui) {
					
					console.log(ui);
					
					//create a new element with the following definitions:
					//var newdiv = ui.draggable[0].cloneNode(true);
					var newdiv = document.createElement('div');
					newdiv.innerHTML = ui.draggable[0].innerHTML;
					
					var issticky = false;
					
					if(ui.draggable[0].className.indexOf('stickies')>-1){
						issticky = true;
						/*var sleft = ((ui.offset.left * 1) - 320);
						var stop = ((ui.offset.top * 1) - 40);
						var sid = ui.draggable[0].children[0].getAttribute('id');
						makeSticky(sleft,stop,sid);*/
						
						
					}
					
					$("#right-hand-canvas")[0].appendChild(newdiv);
								
					newdiv.style.position = 'relative';	
					newdiv.style.display = 'inline-block';
					newdiv.style.width = ui.helper.context.clientWidth + 'px';
					newdiv.style.height = ui.helper.context.clientHeight + 'px';
					
					console.log(newdiv.style.top);
					
					var properties = [];
					var values = [];
					properties[0] = 'styles';
					properties[1] = 'properties';
					properties[2] = 'content';
					values[0] = styles_from_element(newdiv);
					values[1] = properties_from_element(newdiv);
					values[2] = content_from_element(newdiv);
													
					dispatch_event(
								5, 
								0, 
								<?php echo $canvas_id; ?>, 
								<?php echo $user_id; ?>, 
								properties,
								values, 
								function (data) {
									var element_id = element_from_id(data);
									newdiv.setAttribute('id', element_id);
									
									make_draggable(element_id);
				
									newdiv.left = ui.draggable[0].offsetLeft; //((ui.offset.left * 1) - 320) + 'px'; //serious hack, do not touch
									newdiv.top = ui.draggable[0].offsetTop; //serious hack, do not touch

									
									if(issticky) makeSticky(0,0,newdiv);								
									
								}
					);

				}
			
			
			 });
		
		});
		var notes = 0;
		
		function createSticky(element) {
			alert(element.innerHTML);
		} 
		
		function close(element) {
			alert('element closed');
		}
		
		function makeSticky(sleft,stop,div){
			
			var txtArea = document.createElement('input');
			txtArea.setAttribute('type', 'text');
			
			div.appendChild(txtArea);
			txtArea.width = '100%';
			txtArea.height = '100%'; 
			txtArea.focus();
			
			txtArea.addEventListener(
										'blur',
										function (e) {
											
											var textDiv = (div.getElementsByTagName('div')[0])/*.getElementsByTagName('div')[0]*/;
											console.log(txtArea.value);
											//console.log(textDiv);
											textDiv.innerHTML += txtArea.value;
											
											div.removeChild(txtArea);
										},
										true
										);
			
			
			
			/*notes++;
			var html="<div id=\"notes-"+notes+"\"style=\"width:200px;height:220px;position:relative;left:"+sleft+";top:"+stop+";\">";
			html +="<div id="+sid+">";
			if(sid=="yellowSticky")
				html+="<div class=\"stickyHandle\" id=\"yellowHandle\">@{text}</div>";
			if(sid=="blueSticky")
				html+="<div class=\"stickyHandle\" id=\"blueHandle\">@{text}</div>";
			if(sid=="pinkSticky")
				html+="<div class=\"stickyHandle\" id=\"pinkHandle\">@{text}</div>";
			if(sid=="greenSticky")
				html+="<div class=\"stickyHandle\" id=\"greenHandle\">@{text}</div>";
			html += "<div class=\"stickyText\">";
			html += "<textarea name=\"stickme\" style=\"max-width: 180px;min-width: 180px;\" cols=\"30\" rows=\"5\" onkeypress=\"return checkEnter('notes-"+notes+"',"+sleft+","+stop+",event,this)\"></textarea>";
			html += "</div></div></div>"
			div.innerHTML = html;
			//$('#right-hand-canvas').append(html);
			$('#right-hand-canvas').find('#notes-'+notes).find('textarea[name=stickme]').focus();
			$('#right-hand-canvas').find('#notes-'+notes).find('textarea[name=stickme]').blur(function() {
  				$('#notes-'+notes).remove();
  				//($("#" + sid)[0]).innerHTML = ($("#" + sid)[0]).innerHTML.replace('@{text}', 'sdfgsg');
  				//$("#" + sid)[0].innerText = 'skgjdlkjglkdfjglk';
			});*/

				
		}
		
		function checkEnter(noteid,sleft,stop,event,tb){
			//console.log("Blah!");
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				if(tb.value!=""){
				}
			}
			if(keycode == '27'){
				console.log("Escape"+noteid);
				$('div#'+noteid).remove();
			}
		} 
		
		function getFlickrData(pageid){
			var stext = $("#flickr-search-text").val();
			if(stext=="")
				return;
				
			//Add a loader
			$('#searched-image').empty();
			$('<img alt="">').attr('id', 'loader').attr('src', 'images/loader.gif').appendTo('#searched-image');
			
			//assign your api key equal to a variable
			var apiKey = '498b63b3c98a061115046a5f3d34bb79';
			
			
			$.getJSON('http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' + apiKey + '&text='+stext+'&tag='+stext+'&page='+pageid+'&per_page=10&format=json&jsoncallback=?',
				function(data){
					//console.log(data);
					$.each(data.photos.photo, function(i,item){
						//build the url of the photo in order to link to it
						if(i%2==0)
							var html = "<div class='image-wrapper movable left-image'>";
						else
							var html = "<div class='image-wrapper movable right-image'>";	
						html += "<div class='image-cropper'>";
						var photoURL = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg'
						html += "<img src='"+photoURL+"'/>";
						html += "</div></div>";
						
						$('#searched-image').append(html);
						//$('<img alt="">').attr('id', i).attr('src', photoURL).appendTo('#searched-image');
						//console.log(photoURL);
					});
					$('#searched-image').append('<div style=\"clear:both;\"></div>');
					$('#image-pages').empty();
					for(var i=1;i<=3;i++){
						if(i==pageid)
							var html="<span class=\"selected\"><a href=\"javascript:getFlickrData("+i+");\">"+i+"</a></span>";	
						else
							var html="<span><a href=\"javascript:getFlickrData("+i+");\">"+i+"</a></span>";
							
							
						$('#image-pages').append(html);
					}
					makeLeftDraggable();
			});
			$('#searched-image').find('#loader').remove();
			
			
		}
		
		
		function getYouTubeData(pageid){
			var stext = $("#youtube-search-text").val();
			if(stext=="")
				return;
			//Add a loader
			$('#searched-video').empty();
			//$('<img alt="">').attr('id', 'loader').attr('src', 'images/loader.gif').appendTo('#searched-image');
			var startIndex =1;
			if(pageid==1)
				startIndex=1;
			else
				startIndex = (pageid*6)+1;
			$.getJSON('http://gdata.youtube.com/feeds/api/videos/-/%7B'+stext+'%7D?max-results=6&start-index='+startIndex+'&alt=json&orderby=viewCount',
				function(data){
					//console.log(data);
					$.each(data.feed.entry, function(i,item){
						if(i%2==0)
							var html = "<div class='video-wrapper movable left-video'>";
						else
							var html = "<div class='video-wrapper movable right-video'>";
						html += "<div class='video-cropper'>";
						var videoString = item.id.$t;
						var splitString = videoString.split("/");
						var videoid = splitString[splitString.length-1];
						html += "<iframe width=\"128\" height=\"116\" src=\"http://www.youtube.com/embed/"+videoid+"?rel=0\" frameborder=\"0\" allowfullscreen></iframe>";
						html += "<div class='video-text'><p>"+item.title.$t+"</p></div>";
						html += "</div></div>";
						//console.log(html);
						$('#searched-video').append(html);
						
					});
					$('#searched-video').append('<div style=\"clear:both;\"></div>');
					$('#video-pages').empty();
					for(var i=1;i<=3;i++){
						if(i==pageid)
							var html="<span class=\"selected\"><a href=\"javascript:getYouTubeData("+i+");\">"+i+"</a></span>";	
						else
							var html="<span><a href=\"javascript:getYouTubeData("+i+");\">"+i+"</a></span>";
							
							
						$('#video-pages').append(html);
					}

					makeVideoDraggable();
					//$("#element-accordion").accordion('resize');
					
			});
		
		}
		
		function makeLeftDraggable(){
			$('.movable').hover(
  				function () {
    				$(this).css({'background-color':'#4AA052'});
  				},
  				function () {
   					 $(this).css({'background-color':'#FFFFFF'});
 				 }
			);
			$('.movable').draggable({helper:'clone',appendTo: 'body'});
		}
		
		function makeVideoDraggable(){
			$('.movable').hover(
  				function () {
    				$(this).css({'background-color':'#4AA052'});
    				$(this).find('p').css({'color':'#FFFFFF'});
  				},
  				function () {
   					 $(this).css({'background-color':'#FFFFFF'});
   					 $(this).find('p').css({'color':'#4AA052'});
 				 }
			);
			$('.movable').draggable({helper:'clone',appendTo: 'body'});
		}
		</script>
		
		
		
		
		
		
		
		<!-- Nelsons scripts -->
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
				console.log(data);
				var id = element_from_id(element_id);
			
				var newdiv = document.createElement('div');
				newdiv.setAttribute("id", id);
					
				div_from_element(data, newdiv);
								
				$("#right-hand-canvas")[0].appendChild(newdiv);
								
				make_draggable(newdiv.getAttribute('id'));
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
					start: function() {},
					drag: function() {},
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
							'right-hand-canvas', 
							<?php echo $canvas_id; ?>,  
							<?php echo $user_id; ?>, 
							make_draggable,
							finished_loading
							);
			   
		</script>
			<div id="bottom-pane">
	
	<div id="left-hand-panel">
		<div id="navigation">
			<ul>
				<li><a href="#">HOME</a>&nbsp;|</li>
				<li><a href="#">SIGN OUT</a></li>
			</ul>
		</div>
		<div id="profile">
			<div id ="profile-picture">
				<?php echo '<img src="' . $userImageUrl . '"></img>'; ?>
			</div>
			<div id="welcome-text">
				<p id="welcome">Welcome,</p>
				<p id="profile-name"><?php echo $user_name; ?></p>
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<div id="element-accordion">
			<h3><a href="#">Images</a></h3>
			<div class="element-body">
				<div id="search-flikr-box">
					<div class="search-holder">
					<div class="apple-search">
						<table cellpadding="0" cellspacing="0"><tbody>
							<tr><td><input type="text" width="250px" id="flickr-search-text" class="sbox"/></td>
						
						
						<td><a href="javascript:getFlickrData(1)"><img src="images/search.png" class="search-image"/></td></tr>
						</tbody></table>
					</div>
					</div>
					<div id="searched-image">
					</div>
					<div id="image-pages">
					</div>
				</div>
			</div>
			<h3><a href="#">Videos</a></h3>
			<div class="element-body">
				<div id="search-video-box">
					<div class="search-holder">
					<div class="apple-search">
						<table cellpadding="0" cellspacing="0"><tbody>
							<tr><td><input type="text" width="250px" id="youtube-search-text" class="sbox"/></td>
							<td><a href="javascript:javascript:getYouTubeData(1)"><img src="images/search.png" class="search-image"/></td></tr>
						</tbody></table>
						
						
					</div>
					</div>

					
					<div id="searched-video">
					</div>
					<div id="video-pages">
					</div>
				</div>
			</div>
			<h3><a href="#">Elements</a></h3>
			<div class="element-body">
				<div id="element-content">
					<div class="text-header"><p>Stickies</p></div>
					<div id="stickies-list">
						<div class="stickies movable" style="margin-right:5px;">
							<div id="yellowSticky">
							<div class="stickyHandle" id="yellowHandle"></div>
							</div>
						</div>
						<div class="stickies movable">
							<div id="blueSticky">
							<div class="stickyHandle" id="blueHandle"></div>
							</div>
						</div>
						<div class="stickies movable" style="margin-right:5px;">
							<div id="pinkSticky">
							<div class="stickyHandle" id="pinkHandle"></div>
							</div>
						</div>
						<div class="stickies movable">
							<div id="greenSticky">
							<div class="stickyHandle" id="greenHandle"></div>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="text-header" style="margin-top:20px;"><p>Tags</p></div>
					<div id="tags-list">
					</div>
				</div>
			</div>
		</div>
		<div id="collaborators">
			<div id="collab-heading"><p>COLLABORATORS</p></div>
			<div id="collab-people">
				<?php
					$collabs = getCollabData($canvas_id);
					foreach($collabs[$canvas_id] as $collab) {
						echo '<img src="' . $collab['img'] . '"></img>';
					
					}
					
					
				?>
			</div>
		</div>
	</div>
	<div id="right-hand-panel">
		<div id="canvas-title-box">
			<div id="canvas-title"><p><?php echo getDescription($canvas_id); ?></p></div>
			<div id="canvas-added"><p><?php echo getUserInfo($creator_id)->{'name'}; ?> </p></div>
		</div>
		<div id="right-hand-canvas" class="demos">
		</div>
	</div>
	<div style="clear:both;"></div>
	</div>
	</div>
	
	</body>
</html>
