<?php

	$link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
	$result = mysql_query("set names utf8" , $link);
	mysql_selectdb("monographic",$link);  

	session_start();
     
     date_default_timezone_set('Asia/Taipei');
     $time = date("Y-m-d H:i:s") ;
     
    $imageupload = $_SESSION['image'] ;
     
	if (isset($_POST["button_repair"]))
	{
		header("Location: update.php");
		exit();
	}
	if (isset($_POST["button_send"]))
	{
		date_default_timezone_set('Asia/Taipei');
		$time = date("Y-m-d H:i:s") ;
		
		$updateData = "UPDATE UploadFile SET 
						Time = '{$time}' ,
        				MapSite = '{$_SESSION['source']}' ,
    					Map_X = '{$_SESSION['address_X']}' ,
        				Map_Y = '{$_SESSION['address_Y']}' ,
        				ImageSite = '{$_SESSION['image']}' ,
        				Title = '{$_SESSION['title']}' ,
        				Article = '{$_SESSION['article']}'
						WHERE uID = '{$_SESSION['uID']}' ";  
							
    	$result = mysql_query($updateData, $link);
		
		header("Location: member.php?choose=2");
		$state = $_SESSION['state'] ;
		session_destroy();
		session_start();
		$_SESSION['state'] = $state ;
		
		exit();

	}
	

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>文章預覽</title>
    <link rel="stylesheet" type="text/css" href="css/page_inside.css">
    <link rel="stylesheet" href="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.css" />
    <script src="js/jquery-1.9.1.min/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
</head>

<body>
	<div id = "preview_item">
		預覽文章<br>
		<form data-ajax="false" method="post" enctype="multipart/form-data"> 
			<div id = "preview_item_button_left">
				<input type="submit" id = "button_send" name = "button_send" value="確認送出">
			</div>
			<div id = "preview_item_button_right">
				<input type="submit" id = "button_repair" name = "button_repair" value="修改" style = "top:5% ; right: 30%">
			</div>
		</form>
	</div>
	<div id = "backnumber">
		<textarea id = "address_X" name = "address_X"><?php echo $_SESSION['address_X'] ; ?></textarea>
        <textarea id = "address_Y" name = "address_Y"><?php echo $_SESSION['address_Y'] ; ?></textarea>
	</div>
	<div id = "whiteback">
	    <div id = "background" style = "margin: 3% auto ;">
	        <div id = "title">
	            <?php echo $_SESSION['title'] ; ?>
	        </div>
	        <div id = "image">
	            <?php if($_SESSION['image'] != ""): ?>
	            <img src="<?php echo 'upload/' . $_SESSION['image'] ?>">
	            <?php endif ?>
	        </div>
	        <div id = "article_inside">
	            <?php echo $_SESSION['article'] ; ?>
	        </div>
	        <div id = "map_address"><br><br><br>
	        	<p class = "map_address_title">這地方在哪裡呢!!!?<br></p>
	            <?php echo $_SESSION['source'] ; ?>
	        </div>
        	<?php if($_SESSION['source'] != ""): ?>
            <div id="googleMap" style="width: 50%; height: 400px; margin: 0 5% 10% 5%;"></div>
            <?php endif ?>
	    </div>
    </div>
    <script>
    	
    	var x = document.getElementById("address_X").value ;
    	var y = document.getElementById("address_Y").value ;
    	
		var mapProp = {
			center : new google.maps.LatLng(x,y),
			zoom : 17,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map($("#googleMap")[0], mapProp);

		var marker = new google.maps.Marker({
			position : new google.maps.LatLng(x,y)
		});

		marker.setMap(map);

		var infowindow = new google.maps.InfoWindow({
			content : "好康在這!!"
		});

		infowindow.open(map, marker);

		
		google.maps.event.addListener(marker, 'click', 
		  function() {
			map.setZoom(10);
			map.setCenter(marker.getPosition());
		  });
		

		google.maps.event.addListener(map, 'click', function(event) {
			var marker = new google.maps.Marker({
				position : event.latLng,
				map : map,
			});
			var infowindow = new google.maps.InfoWindow({
				content: '(' + event.latLng.lat() + ','+ event.latLng.lng() + ')'
			});
			infowindow.open(map, marker);
		});
		 
	</script>
</body>

</html>
