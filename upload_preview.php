<?php

	$link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
	$result = mysql_query("set names utf8" , $link);
	mysql_selectdb("monographic",$link);  

	session_start();
	
	$NameArticleNumber = 1 ;
	$Member = "select * from UploadFile where Name = '" . $_SESSION['Name'] . "' ;" ;
	$result = mysql_query($Member, $link);
	while ($row = mysql_fetch_assoc($result))
     {
     	$NameArticleNumber++;
		// echo "Name：{$row["Name"]}<br>";
		// echo "title：{$row["Title"]}<br>";
     }
     
     date_default_timezone_set('Asia/Taipei');
     $time = date("Y-m-d H:i:s") ;
     
    $imageupload = $_SESSION['image'] ;
     
	if (isset($_POST["button_repair"]))
	{
		header("Location: upload.php");
		exit();
	}
	if (isset($_POST["button_send"]))
	{
		$insertData ="INSERT INTO UploadFile (Name,State,Time,ArticleNumber,Title,Article,ImageSite,MapSite,Map_X,Map_Y) 
						VALUES ( 
							'{$_SESSION['Name']}' , 
							'{$_SESSION['state']}' , 
							'{$time}' , 
							'{$NameArticleNumber}' , 
							'{$_SESSION['title']}' , 
							'{$_SESSION['article']}' , 
							'{$imageupload}' , 
							'{$_SESSION['source']}' , 
							'{$_SESSION['address_X']}' , 
							'{$_SESSION['address_Y']}')";  
							
    	$result = mysql_query($insertData, $link);
		
		if($_SESSION['state'] == "food")
		{
			header("Location: page_food.php");
			session_destroy();
			exit();
		}
		else
		{
			header("Location: page_dress.php");
			session_destroy();
			exit();
		}
	}
	
// echo $_SESSION['state'] ;
// echo $_SESSION['Name'] ;
// echo $_SESSION['source'] ;
// echo $_SESSION['address_X'] ;
// echo $_SESSION['address_Y'] ;
// echo $_SESSION['image'] ;
// echo $_SESSION['title'] ;
// echo $_SESSION['article'] ;

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
				<input type="submit" id = "button_repair" name = "button_repair" value="修改(圖片需重新上傳)" style = "top:5% ; right: 30%">
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
	            <?php if($_SESSION['image'] != ''): ?>
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
