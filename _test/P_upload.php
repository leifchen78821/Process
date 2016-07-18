<?php
    // if ($_FILES["file"]["error"] > 0){
    //     echo "Error: " . $_FILES["file"]["error"];
    // }
    // else
    // {
    //     // $userid = 123 ;
        
    //     echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
    //     echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
    //     echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
    //     echo "暫存名稱: " . $_FILES["file"]["tmp_name"];
    
    //     if (file_exists("upload/" . $_FILES["file"]["name"])){
    //     echo "檔案已經存在，請勿重覆上傳相同檔案";
    //     }
    //     else
    //     {
    //         // move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$userid.'.'.'png');
    //         move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$_FILES["file"]["name"]);
    //     }
    // }
    if (isset($_POST["submit"]))
    {
        move_uploaded_file($_FILES["file"]["tmp_name"],"upload/".$_FILES["file"]["name"]);
        header("Location: P_upload.php");
    	exit();
    }
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
<body>

    <!--<form action="P_upload.php" method="post" enctype="multipart/form-data">-->
    <form method="post" enctype="multipart/form-data">
    檔案名稱:<input type="file" name="file" id="file" /><br />
    <input type="submit" name="submit" value="上傳檔案" />
    </form>

</body>
</html>