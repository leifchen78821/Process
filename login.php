<?php

header("Content-Type:text/html; charset=utf-8");

  $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
  $result = mysql_query("set names utf8" , $link);
  mysql_selectdb("monographic",$link);
  
    if (isset($_POST["btnOK"]))
    {

      $sUserName = $_POST["txtUserName"];
      $sUserPassword = $_POST["txtPassword"];
      $check = 0 ;
  
      $commandText = "select * from MemberProfile";
      $result = mysql_query($commandText, $link);

      while ($row = mysql_fetch_assoc($result))
      {
        // echo "Name：{$row["Name"]}<br>";
        // echo "Password：{$row["Password"]}<br>";
        if($sUserName == $row["Name"] && $sUserPassword == $row["Password"])
        {
          setcookie("userName", "$sUserName");
          header("Location: connect4site.php");
          $check = 1 ;
        	exit();
        }
      }
      
      if($check != 1)
      {
        echo "<script language='JavaScript'>";
  	    echo "alert('帳號或密碼輸入有誤');";
        echo "</script>";
      }
      
      mysql_free_result($result);
      mysql_close($link);
      
    }
    
if (isset($_POST["btnRegis"]))
{
	header("Location: registration.php");
	exit();
}

?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>逢甲大玩客 - 會員登入</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
  <form data-ajax="false" id="form1" name="form1" method="post">
    <div align="center" id="back_index" style="">
      <span style="color: white;">會員系統 - 登入<br><br><br><br><br><br><br><br></span>
        <div id="circle" style=""> 
        <div id="long02" style="top: 30% ;"></div>
        <div id="long03" style="top: 33% ;"></div>
        <div id="long01" style=""></div>
        <div id="long02" style=""></div>
        <div id="long03" style=""></div>
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>帳號</div>
        <div valign="baseline"><input type="text" name="txtUserName" id="txtUserName" value="<?php echo $sUserName ;?>" /></div>
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>密碼</div>
        <div valign="baseline"><input type="password" name="txtPassword" id="txtPassword" />
        </div>
        <input type="submit" class="but" name="btnOK" id="btnOK" value="登入" />
        <input type="reset" class="but" name="btnReset" id="btnReset" value="重設" />
    </div>
    <span style="">
      <input type="submit" class="but" name="btnRegis" id="btnRegis" value="註冊會員" style="width:170px;" />
    </span>
  </div>
  
  </form>
</body>

</html>