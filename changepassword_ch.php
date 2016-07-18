<?php

header("Content-Type:text/html; charset=utf-8");

  $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
  $result = mysql_query("set names utf8" , $link);
  mysql_selectdb("monographic",$link);
  
    if (isset($_POST["btnOK"]))
    {
        
        $sUserPassword = $_POST["txtPassword"];
        $sUserPasswordcheck = $_POST["txtPasswordcheck"];
        
        if (trim($sUserPassword) == ""){
            echo "<script language='JavaScript'>";
          	echo "alert('密碼不可空白')";
            echo "</script>";
         }
        else if($sUserPasswordcheck != $sUserPassword) {
            echo "<script language='JavaScript'>";
        	echo "alert('密碼確認與設定密碼不一致')";
            echo "</script>";
        }
        else {
            $updatePassword = "UPDATE MemberProfile SET 
                               Password = '{$sUserPassword}'
						       WHERE Name = '{$_COOKIE["userName"]}' ";  
			$result = mysql_query($updatePassword, $link);
            setcookie("userName", "Guest");
            echo "<script language='JavaScript'>";
      	    echo "alert('密碼修改成功,請重新登入');location.href='login.php';";
            echo "</script>";
        }
      
    }

    if (isset($_POST["btnReset"]))
    {
    	header("Location: changepassword_ch.php");
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
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>輸入新密碼</div>
        <div valign="baseline"><input type="password" name="txtPassword" id="txtPassword" /></div>
        <div style="color: #778899 ; top: 52% ; left: -410px ;"><br>確認新密碼</div>
        <div valign="baseline"><input type="password" name="txtPasswordcheck" id="txtPasswordcheck" /></div>
        <input type="submit" class="but" name="btnOK" id="btnOK" value="確認" />
        <input type="reset" class="but" name="btnReset" id="btnReset" value="重設" />
    </div>
  </div>
  
  </form>
</body>

</html>