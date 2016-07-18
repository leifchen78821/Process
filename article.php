<?php

    $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
	$result = mysql_query("set names utf8" , $link);
	mysql_selectdb("monographic",$link); 
    
    if ($_COOKIE["userName"] == "Guest")
    {
        $sUserName = "訪客";
    }
    else
    {
        $sUserName = $_COOKIE["userName"] ;
    }
	
	if (isset($_GET["logout"]))
    {
    	setcookie("userName", "Guest");
    	header("Location: article.php?ArticleID=" . $_GET["ArticleID"]);
    	exit();
    }
	
	session_start();
    $Member = "select * from UploadFile where uID = '" . $_GET["ArticleID"] . "' ;" ;
	$result = mysql_query($Member, $link);
	$row = mysql_fetch_assoc($result);
    
    if (isset($_POST["send_message"]))
    {
        if ($_COOKIE["userName"] == "Guest")
        {
            echo "<script language='JavaScript'>";
          	echo "alert('您尚未登入無法發文呦')";
            echo "</script>";
        }
        else
        {
        	date_default_timezone_set('Asia/Taipei');
    		$time = date("Y-m-d H:i:s") ;
            $insertMessage ="INSERT INTO Message (ArticleNumber,Name,Time,MessageSent) 
						VALUES ( 
							'{$_GET[ArticleID]}' , 
							'{$sUserName}' , 
							'{$time}' , 
							'{$_POST[message_send_in]}' )";  
							
    		$result = mysql_query($insertMessage, $link);
            header("Location: article.php?ArticleID=" . $_GET["ArticleID"]);
        	exit();
        }
    }
    
    $Message = "select * from Message where ArticleNumber = '" . $_GET["ArticleID"] . "' order by Time desc ;" ;
	$MessageResult = mysql_query($Message, $link);
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $row["Title"]?></title>
    <link rel="stylesheet" type="text/css" href="css/page_inside.css">
    <link rel="stylesheet" href="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.css" />
    <script src="js/jquery-1.9.1.min/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
</head>

<body>
    <div><a href = "page_<?php echo $_SESSION['state'] ;?>.php" data-ajax="false" ><img class = "lastpage" src="img/lastpage.png"></a></div>
	<div id = "backnumber">
		<textarea id = "address_X" name = "address_X"><?php echo $row["Map_X"] ; ?></textarea>
        <textarea id = "address_Y" name = "address_Y"><?php echo $row["Map_Y"] ; ?></textarea>
	</div>
	<div>
        <p align="right" style="color : black ; font-family:Microsoft JhengHei;"><?php echo "您好阿  " . $sUserName . "  大大<br>" ?>
            <?php if ($sUserName == "訪客"): ?>
                <span style="" align="center" valign="baseline"><a href="login.php" data-ajax="false">不是訪客? 點此登入<br></a>
            <?php else: ?>
                <span style="" valign="baseline"><a href="article.php?ArticleID=<?php echo $_GET["ArticleID"] ; ?>&logout=1" data-ajax="false">登出<br></a>
            <?php endif; ?>
        </p>
    </div>
	<div id = "whiteback">
		<div id = "background">
	        <div id = "title">
	            <?php echo $row["Title"] ; ?>
	        </div>
	        <div id = "image">
	            <?php if($row["ImageSite"] != ''): ?>
	            <img src="upload/<?php echo $row["ImageSite"] ?>">
	            <?php endif ?>
	        </div>
	        <div id = "article_inside">
	            <?php echo $row["Article"] ; ?>
	        </div>
	        <div id = "map_address"><br><br><br>
	        	<p class = "map_address_title">這地方在哪裡呢!!!?<br></p>
	            <?php echo $row["MapSite"] ; ?>
	            <br><br><br><br><br>分享時間 : 
	            <?php echo $row["Time"] ?>
	            <br><br>發文者 : 
	            <?php echo $row["Name"] ?>
	        </div>
        	<?php if($row["MapSite"] != ""): ?>
            <div id="googleMap" style="width: 50%; height: 400px; margin: 0 5% 10% 5%;"></div>
            <?php endif ?>
	    </div>
	    <div id = "message_send">
	    	<br><span style="font-size:18px">　我要留言:</span><br>
	    	<form data-ajax="false" id="form_send" name="form_send" method="post">
	    	<textarea placeholder="寫下你對這篇文章的高見吧!!" name="message_send_in" id="message_send_in" rows="10" cols="80"></textarea>
	    		<div id = "send_img">
		    		<input type="submit" id="send_message" name="send_message" value = "送出"/>
		    	</div>	
	    	</form>
	    </div>
	    
	    <?php while ($MessageRow = mysql_fetch_assoc($MessageResult)): ?>
		<div class = "message">
			<div style = "margin:5px auto;">
	            <div style= "float: left ; font-size:20px" >
	            	<span>　　</sapn><?php echo $MessageRow["Name"] ;?> <span>　在　</spane>
	            </div>
	            <div style= "float: left ; font-size:20px">
	            	<?php echo $MessageRow["Time"] ;?> <span>　時說...</span>
	            </div>
            </div>
            <br><br>
            <div style="margin: 0 0 0 5% ; font-size:25px">
            	<?php echo $MessageRow["MessageSent"] ;?>
            </div>
        </div>
        <?php endwhile ?>
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
