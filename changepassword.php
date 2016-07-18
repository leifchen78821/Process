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
          header("Location: changepassword_ch.php");
          $check = 1 ;
        	exit();
        }
      }
      
      if($check != 1)
      {
        echo "<script language='JavaScript'>";
  	    echo "alert('帳號或密碼輸入有誤');location.href='login.php';";
        echo "</script>";
        exit();
      }
      
      mysql_free_result($result);
      mysql_close($link);
      
    }

if (isset($_POST["btnReset"]))
{
	header("Location: changepassword.php");
	exit();
}

?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>逢甲大玩客 - 修改密碼</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
  <form data-ajax="false" id="form1" name="form1" method="post">
    <div align="center" id="back_index" style="">
      <span style="color: white;">會員系統 - 修改密碼<br><br><br><br><br><br><br><br></span>
        <div id="circle" style=""> 
        <div id="long02" style="top: 30% ;"></div>
        <div id="long03" style="top: 33% ;"></div>
        <div id="long01" style=""></div>
        <div id="long02" style=""></div>
        <div id="long03" style=""></div>
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>帳號</div>
        <div valign="baseline"><input type="text" name="txtUserName" id="txtUserName" /></div>
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>密碼</div>
        <div valign="baseline"><input type="password" name="txtPassword" id="txtPassword" />
        </div>
        <input type="submit" class="but" name="btnOK" id="btnOK" value="送出" />
        <input type="reset" class="but" name="btnReset" id="btnReset" value="重設" />
    </div>
  </div>
  
  </form>
</body>

</html>