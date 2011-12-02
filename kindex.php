<!DOCTYPE html>
<html>
<head>
	<title>RAFIQEE</title>
	<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css"/>
	
	<script type="text/javascript">
	
		$(document).ready(function(){
			
			$("#element-accordion").accordion();
			$( "#right-hand-panel" ).droppable({ accept: '.movable',
				drop: function(event, ui) {
				
					console.log("Dropped");
				}
			
			
			 });
		
		});
	
	
		function getFlickrData(pageid){
			var stext = $("#flickr-search-text").val();
			if(stext=="")
				return;
				
			//Add a loader
			$('#searched-image').empty();
			$('<img alt="">').attr('id', 'loader').attr('src', 'images/loader.gif').appendTo('#searched-image');
			
			//assign your api key equal to a variable
			var apiKey = '498b63b3c98a061115046a5f3d34bb79';
			
			
			$.getJSON('http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' + apiKey + '&text='+stext+'&page=1&per_page=10&format=json&jsoncallback=?',
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
					
					for(var i=1;i<=3;i++){
						if(i==pageid)
							var html="<span><a href=\"javascript:getFlickrData("+i+");\">"+i+"</a></span>";	
						else
							var html="<span class=\"selected\"><a href=\"javascript:getFlickrData("+i+");\">"+i+"</a></span>";
							
						$('#image-pages').append(html);
					}
					makeLeftDraggable();
			});
			$('#searched-image').find('#loader').remove();
			
			
		}
		
		
		function getYouTubeData(){
			var stext = $("#youtube-search-text").val();
			if(stext=="")
				return;
			//Add a loader
			$('#searched-video').empty();
			//$('<img alt="">').attr('id', 'loader').attr('src', 'images/loader.gif').appendTo('#searched-image');
			$.getJSON('http://gdata.youtube.com/feeds/api/videos/-/%7B'+stext+'%7D?max-results=8&alt=json&orderby=viewCount',
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
						//console.log();
						//console.log(item.title.$t);
					});
					$("#element-accordion").accordion('resize');
					
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
		
	</script>
</head>
<body>
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
				<img src="images/profile.png"></img>
			</div>
			<div id="welcome-text">
				<p id="welcome">Welcome,</p>
				<p id="profile-name">Kaushal Agrawal</p>
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
					<div class="apple-video-search">
						<input type="text" width="250px" id="youtube-search-text" class="sbox"/>
						
						<span style="margin-top:5px;"><a href="javascript:getYouTubeData()"><img src="images/search.png" class="search-image"/></a></span>
					</div>

					
					<div id="searched-video">
					</div>
					<div id="video-pages">
					</div>
				</div>
			</div>
		</div>
		<div id="collaborators">
			<div id="collab-heading"><p>COLLABORATORS</p></div>
			<div id="collab-people">
				<img src="images/profile.png"></img>
				<img src="images/profile.png"></img>
				<img src="images/profile.png"></img>
				<img src="images/profile.png"></img>
				<img src="images/profile.png"></img>
			</div>
		</div>
	</div>
	<div id="right-hand-panel">
	</div>
	<div style="clear:both;"></div>
	</div>
	</div>
</body>
</html>