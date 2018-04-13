<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");

//判斷是否登入
if($_SESSION['mid'] != null)
{
        //更新資料庫
        $sql = "UPDATE Member SET Name='$_POST[name]', Profile='$_POST[profile]' WHERE MID = '$_SESSION[mid]'";
        mysqli_query($db, $sql);
        echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
}
else
{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
?>