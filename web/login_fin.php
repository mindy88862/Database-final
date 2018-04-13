<?php session_start(); ?><!--啟用session，要放在網頁最前方-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫，有用到連接MySQL就要include它
include("mysql_connect.php");
$id = $_POST['Account'];
$pw = $_POST['Password'];
//搜尋資料庫資料
$result = mysqli_query($db, "SELECT * FROM Member where Account = '$id'");
$row = @mysqli_fetch_row($result);
//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
if($id != null && $pw != null && $row[1] == $id && $row[2] == $pw)
{
    //將帳號寫入session，方便驗證使用者身份
    $_SESSION['account'] = $id;
    $_SESSION['mid'] = $row[0];
    echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
}
else
{
    echo '<h2 class="mytitle">登入失敗!</h2>';
    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.html>';
}
?>