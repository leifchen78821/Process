<?php
  
  $link = mysql_connect("localhost" , "root" , "") or die(mysql_error()) ; 
  $result = mysql_query("set names utf8" , $link);
  mysql_selectdb("monographic",$link);  
  
  $commandText = "select * from MemberProfile";
  $memberresult = mysql_query($commandText, $link);
  
  if (isset($_POST["btnSend"]))
  {
    $checknum = 0 ;
    $sUserName = $_POST["txtUserName"];
    $sUserPassword = $_POST["txtPassword"];
    $sUserPasswordcheck = $_POST["txtPasswordcheck"];
    
    if (trim($sUserName) == ""){
      echo "<script language='JavaScript'>";
  	  echo "alert('帳號不可空白')";
      echo "</script>";
    }
    else if (trim($sUserPassword) == ""){
      echo "<script language='JavaScript'>";
  	  echo "alert('密碼不可空白')";
      echo "</script>";
    }
    else
    {
      
      if($sUserPasswordcheck != $sUserPassword) {
        echo "<script language='JavaScript'>";
    	  echo "alert('密碼確認與設定密碼不一致')";
        echo "</script>";
      }
      else {
        while ($row = mysql_fetch_assoc($memberresult)) {
          if($sUserName == $row["Name"]) {
            $checknum = 1 ;
          }
        }
        
        if($checknum == 1) {
          echo "<script language='JavaScript'>";
      	  echo "alert('此帳號已被使用')";
          echo "</script>";
        }
        else {
          $insertData ="INSERT INTO MemberProfile (Name,Password,Gender,PhoneNumber)  VALUES ( '{$_POST[txtUserName]}' , '{$_POST[txtPassword]}' , '{$_POST[txtGender]}' , '{$_POST[txtPhoneNumber]}' )";  
          $result = mysql_query($insertData, $link);
          echo "<script language='JavaScript'>";
      	  echo "alert('加入會員成功! 系統將自動跳轉至登入頁');location.href='login.php';";
          echo "</script>";
        }
      }
      
      // $insertData ="INSERT INTO MemberProfile (Name,Password,Gender,PhoneNumber)  VALUES ( '{$_POST[txtUserName]}' , '{$_POST[txtPassword]}' , '{$_POST[txtGender]}' , '{$_POST[txtPhoneNumber]}' )";  
      // $result = mysql_query($insertData, $link);
      
      // require("class/sqlConnect.php");
      // $conn = new dbconnect ;
      // $insertData ="INSERT INTO MemberProfile (Name,Password,Gender,PhoneNumber)  VALUES ('{$_POST[txtUserName]}' , '{$_POST[txtPassword]}' , {$_POST[txtGender]} , '{$_POST[txtPhoneNumber]}' )";  
      // $conn -> conn($insertData) ;
      
    //   echo "<script language='JavaScript'>";
  	 // echo "alert('加入會員成功! 系統將自動跳轉至登入頁');location.href='login.php';";
    //   echo "</script>";

    }
    
    // mysql_free_result($result);
    // mysql_close($link);
    
    // $commandText = "select * from MemberProfile";
    // $result = mysql_query($commandText, $link);
    //   while ($row = mysql_fetch_assoc($result))
    //   {
    //     echo "Name：{$row["Name"]}<br>";
    //     echo "Password：{$row["Password"]}<br>";
    //     echo "Gender：{$row["Gender"]}<br>";
    //     echo "PhoneNumber：{$row["PhoneNumber"]}<br>";
    //     echo "<HR>";
    //   }
    
  }
  
?>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>逢甲大玩客 - 會員註冊</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/registration.css">
</head>

<body>
  <form id="form1" name="form1" method="post">
      <div align="center" id="back_index" style="height: 800px; border-radius:20%;">
        <span style="color: white; ">會員系統 - 註冊<br><br><br><br><br><br><br><br><br><br><br><br>
          <div id="circle_regis" style=""> 
          <br><br>
          <br>帳號<span style="color:red">*(必填)</span>：
            <input type="text" placeholder="輸入使用帳號" name="txtUserName" id="txtUserName" value="<?php echo $sUserName ;?>" />
          <br><br>密碼<span style="color:red">*(必填)</span>：
            <input type="password" name="txtPassword" id="txtPassword" />
          <br><br>密碼確認<span style="color:red">*(必填)</span>：
            <input type="password" name="txtPasswordcheck" id="txtPasswordcheck" />
          <br><br>性別：
            <label><input name="txtGender" type="radio" value="1" checked="checked" />男 </label>
            <label><input name="txtGender" type="radio" value="0" />女 </label>
          <br><br>電話：
            <input type="text" name="txtPhoneNumber" id="txtPhoneNumber" />
          
      </div>
          <div class = "regis_atuo_string regis_atuo_string_middle_go" id = "atuo_string_01"></div>
          <div class = "regis_atuo_string regis_atuo_string_long" id = "atuo_string_02"></div>
          <div class = "regis_atuo_string regis_atuo_string_middle_ba" id = "atuo_string_03"></div>
          <div class = "regis_atuo_string regis_atuo_string_short" id = "atuo_string_04"></div>
          <div class = "regis_atuo_string regis_atuo_string_middle_go" id = "atuo_string_05"></div>
          <div class = "regis_atuo_string regis_atuo_string_long" id = "atuo_string_06"></div>
          <div class = "regis_atuo_string regis_atuo_string_middle_ba" id = "atuo_string_07"></div>
          <div class = "regis_atuo_string regis_atuo_string_short" id = "atuo_string_08"></div>
    <span style="">
      <input type="submit" class="but" name="btnSend" id="btnSend" value="送出" style="width:170px;" />
    </span>
  </form>
  
</body>

</html>