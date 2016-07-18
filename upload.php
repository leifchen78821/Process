<?php
    session_start();
    
    if (isset($_POST["button_preview"]))
    {
        
        // header("Content-Type:text/html; charset=utf-8");

        // if ($_FILES["file"]["error"] > 0){
        //     echo "Error: " . $_FILES["file"]["error"];
        // }
        // else
        // {
        // $userid = 123 ;
        
        // echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
        // echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
        // echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
        // echo "暫存名稱: " . $_FILES["file"]["tmp_name"];
    
        // if (file_exists("upload/" . $_FILES["file"]["name"])){
        // echo "檔案已經存在，請勿重覆上傳相同檔案";
        // }
        // else
        // {
        // move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$userid.'.'.'png');
        // }
        // }
        
        $_SESSION['Name'] = $_COOKIE["userName"] ;
        $_SESSION['source'] = $_POST["S1"] ;
        $_SESSION['address_X'] = $_POST["address_X"] ;
        $_SESSION['address_Y'] = $_POST["address_Y"] ;
        $_SESSION['image'] = $_FILES["file"]["name"] ;
        $_SESSION['image_tmp'] = $_FILES["file"]["tmp_name"] ;
        $_SESSION['title'] = $_POST["title"] ;
        $_SESSION['article'] = $_POST["article"] ;
        
        move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$_FILES["file"]["name"]);
    	header("Location: upload_preview.php");
    	exit();
    }
    if (isset($_POST["button_clear"]))
    {
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
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>發文編輯</title>
    <script src="js/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="css/upload.css">
    <link rel="stylesheet" href="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.css" />
    <script src="js/jquery-1.9.1.min/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
</head>

<body>
    <form data-ajax="false" method="post" enctype="multipart/form-data"> 
        <div style = "z-index:1 ; position:absolute ; top: 20% ; left:20%">
            <textarea id = "address_X" name = "address_X"><?php echo $_SESSION['address_X'] ; ?></textarea>
            <textarea id = "address_Y" name = "address_Y"><?php echo $_SESSION['address_Y'] ; ?></textarea>
        </div>
        <div id = "backgroud" style = "z-index:5 ;">
            <p id = "top">發文編輯</p>
            <!--<form id="form1" data-ajax="false"  name="form1" method="post" style="width:90%; margin:auto">-->
            <!--    <input type="submit" name="btnOK" id="btnOK" value="test" />-->
            <!--</form>-->
            <div style="width:90%; margin:auto">
                    <div>
                        <p>1. 輸入標題
                        <input type="text" placeholder="寫下一段吸引目光的標題吧!!" name="title" id="title" value="<?php echo $_SESSION['title'] ; ?>" /></p>
                        <p>2. 輸入內文(可嵌入HTML語法) 
                            <textarea placeholder="介紹一下您推薦的地方吧!!" name="article" id="article" rows="10" cols="80"><?php echo $_SESSION['article'] ; ?></textarea>
                            <script>
                                CKEDITOR.replace( 'article', {});
                            </script>
                        </p>
                    </div>
                    <div>
                        <div style="width: 50%;float:left">
                        	<p>3. 請輸入地址</p>
                    		<p>
                    			<textarea placeholder="ex:407台中市西屯區市政北二路238號36樓之1" name="S1" id="source"><?php echo $_SESSION['source'] ; ?></textarea>
                    		</p>
                    		<p>4. 點選測試(測試結果將在右邊) <input type="button" value="測試" name="B1" onclick="trans();">
                    		</p>
                    		<!--<p>3. 地址轉換經緯度結果如下 (格式：Latitude,Longitude)</p>-->
                    		<!--<p>-->
                    		<!--	<textarea rows="9" name="S2" cols="67" id="target"></textarea>-->
                    		<!--</p>-->
        
                        	<p>5. 上傳標題圖檔 </p><input type="file" name="file" id="file" /><br />
                            <!--<input type="submit" name="submit" value="上傳檔案" />-->
                            
                    		<input type="submit" id = "button_preview" name = "button_preview" value="送出預覽">
                    		<div style="width:20%">
                    		    <input type="submit" id = "button_clear" name = "button_clear" value="取消">
                    		</div>
                    	</div>
                    		<script type="text/javascript">
                    
                    		  var _gaq = _gaq || [];
                    		  _gaq.push(['_setAccount', 'UA-1478416-8']);
                    		  _gaq.push(['_setDomainName', 'uhooamber.com']);
                    		  _gaq.push(['_trackPageview']);
                    
                    		  (function() {
                    			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                    		  })();
                    
                    		</script>
                    		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                    		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                    
                        <div id="googleMap"><br><br><br><br><br>地圖偵測結果會在這</div>
                    </div>
            </div>
        </div>
    </form>
    <script>
    
            var i;
            var split;
            
            function trans() {
                i = 0;
                $("#target").val("");
                $("#address_X").val("");
                $("#address_Y").val("");
                var content = $("#source").val();
                split = content.split("\n");
                delayedLoop();
            }

            function delayedLoop() {
                addressToLatLng(split[i]);
                if (++i == split.length) {
                    return;
                }
                window.setTimeout(delayedLoop, 1500);
            }

            function addressToLatLng(addr) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    "address": addr
                }, function (results, status) {
					if ($("#c").attr('checked'))
					{
						addr = addr + "=";
					}
					else {
						addr = "";
					}
                    if (status == google.maps.GeocoderStatus.OK) {
                        
                        var X = $("#address_X").val();
                        $("#address_X").val(results[0].geometry.location.lat());
                        var Y = $("#address_Y").val();
                        $("#address_Y").val(results[0].geometry.location.lng());
                        
                        var content = $("#target").val();
                        $("#target").val(content + addr + results[0].geometry.location.lat() + "," + results[0].geometry.location.lng() + "\n");
                        
                        // ----
                        
                        var mapProp = {
                            center: new google.maps.LatLng( results[0].geometry.location.lat() , results[0].geometry.location.lng() ) ,
                            zoom: 17,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map($("#googleMap")[0], mapProp);
                
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng( results[0].geometry.location.lat() , results[0].geometry.location.lng() ) ,
                        });
                
                        marker.setMap(map);
                
                        // var infowindow = new google.maps.InfoWindow({
                        //     content: "你定位的位置在這"
                        // });
                
                        infowindow.open(map, marker);
                
                
                        google.maps.event.addListener(marker, 'click',
                            function() {
                                map.setZoom(10);
                                map.setCenter(marker.getPosition());
                            });
                
                
                        google.maps.event.addListener(map, 'click', function(event) {
                            var marker = new google.maps.Marker({
                                position: event.latLng,
                                map: map,
                            });
                            var infowindow = new google.maps.InfoWindow({
                                content: '(' + event.latLng.lat() + ',' + event.latLng.lng() + ')'
                            });
                            infowindow.open(map, marker);
                        });
                        
                    // -------
                    
                    } else {
                        var content = $("#target").val();
                        $("#target").val(content + addr + "查無經緯度" + "\n");
                    }
                });
            }
    

    </script>

</body>

</html>
