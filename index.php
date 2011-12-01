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
	<title>RAFIQEE</title>
	<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function getFlickrData(){
			var stext = $("#flickr-search-text").val();
			if(stext=="")
				return;
				
			//Add a loader
			$('#searched-image').empty();
			$('<img alt="">').attr('id', 'loader').attr('src', 'images/loader.gif').appendTo('#searched-image');
			
			//assign your api key equal to a variable
			var apiKey = '498b63b3c98a061115046a5f3d34bb79';
			
			
			$.getJSON('http://flickr.com/services/rest/?method=flickr.photos.search&api_key=' + apiKey + '&text='+stext+'&page=3&per_page=5&format=json&jsoncallback=?',
				function(data){
					//console.log(data);
					$.each(data.photos.photo, function(i,item){
						//build the url of the photo in order to link to it
						var photoURL = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg'
						$('<img alt="">').attr('id', i).attr('src', photoURL).appendTo('#searched-image');
						//console.log(photoURL);
					});
			});
			$('#searched-image').find('#loader').remove();
			
			
		}
		
	</script>
</head>
<body>
	<div id="search-flikr-box" style="width:300px;">
		<input type="text" width="250px" id="flickr-search-text"/>
		<Button id="search" onclick="getFlickrData()">Search</Button>
	</div>
	<div id="searched-image">
	</div>
	<div id="image-pages">
	</div>
</body>
</html>