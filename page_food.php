<?php 
    
    session_start();
    $_SESSION['state'] = "food";
    
    $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
	$result = mysql_query("set names utf8" , $link);
	mysql_selectdb("monographic",$link); 
    
    $Member = "select * from UploadFile where State = 'food' order by Time desc ;" ;
	$result = mysql_query($Member, $link);

    setcookie("lastPage", "index.php");
    
    if ($_COOKIE["userName"] == "Guest")
    {
        $sUserName = "訪客" ;
    }
    else
    {
        $sUserName = $_COOKIE["userName"] ;
    }
    
    if (isset($_GET["logout"]))
    {
        setcookie("userName", "Guest");
    	header("Location: page_food.php");
    	exit();
    }
    
    if (isset($_POST["IssuedArticle"]))
    {
        if ($_COOKIE["userName"] == "Guest")
        {
            echo "<script language='JavaScript'>";
          	echo "alert('您尚未登入無法發文呦')";
            echo "</script>";
        }
        else
        {
            header("Location: upload.php");
        	exit();;
        }
    }
    
?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>逢甲大玩客 - 吃貨看這邊</title>
  <link rel="stylesheet" type="text/css" href="css/page.css">
</head>

<body>
    
    <ul class="drop-down-menu">
        <li><p>其他去處　</p>
            <ul>
                <li><a href="connect4site.php">標題</a>
                </li>
                <li><a href="page_food.php">食</a>
                </li>
                <li><a href="page_dress.php">衣</a>
                </li>
                <li><a href="http://www.trivago.com.tw/?cpt=324044602&r=&iRoomType=7&aHotelTestClassifier=&iIncludeAll=0&iGeoDistanceLimit=20000&aPartner=&iGeoDistanceItem=3240446&iPathId=408051&aDateRange%5Barr%5D=2016-07-24&aDateRange%5Bdep%5D=2016-07-25&iViewType=0&bIsSeoPage=false&bIsSitemap=false&">住</a>
                </li>
                <li><a href="http://citybus.taichung.gov.tw/iTravel/">行</a>
                </li>
            </ul>
        </li>
        <?php if($_COOKIE["userName"] == "Guest") : ?>
        <?php else: ?>
        <li><p>　會員專區　</p>
            <ul>
                <li><a href="member.php?choose=1">帳號管理</a>
                </li>
                <li><a href="member.php?choose=2">文章管理</a>
                </li>
                <li><a href="member.php?choose=3">留言管理</a>
                </li>
            </ul>
        </li>
        <?php endif ?>
    </ul>
    
    <div>
        <p align="right" style="color : black ; font-family:Microsoft JhengHei;"><?php echo "您好阿  " . $sUserName . "  大大<br>" ?>
            <?php if ($sUserName == "訪客"): ?>
                <span style="" align="center" valign="baseline"><a href="login.php">不是訪客? 點此登入<br></a>
            <?php else: ?>
                <span style="" valign="baseline"><a href="page_food.php?logout=1">登出<br></a>
            <?php endif; ?>
        </p>
    </div>
    
    <div>
        <img class = "front_pic" src="img/food_front.png">
        <br>
        <form data-ajax="false" id="form1" name="form1" method="post">
        <input type="submit" class="button_page" name="IssuedArticle" id="IssuedArticle" value="我要發文" />
        </form>
        <br>
        <br>
    </div>
    
    <div id = "page_index">
        
        <?php while ($row = mysql_fetch_assoc($result)): ?>
        <a href = "article.php?ArticleID=<?php echo $row["uID"]?>">
            <div class="portfolio-box portfolio-box-container content_box">
                <?php if( $row["ImageSite"] != '' ): ?>
            	<img src="upload/<?php echo $row["ImageSite"] ?>" style="width:300px">
            	<?php else: ?>
            	<img src="img/food_front.png" style="width:300px">
            	<?php endif ?>
            	 <h3><?php echo $row["Title"] ?></h3>
            	 <p><?php echo mb_substr( $row["Article"],0,50,"utf-8"); ?>...</p>
            	
            </div>
        <?php endwhile ?>
        
    </div>
</body>
</html>