<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");

$name = $_POST['name'];
$Account = $_POST['Account'];
$Password = $_POST['Password'];

$pic = 0;//如果有圖片= 1
$tmp_name = $_FILES['pro-pic']['tmp_name'];

if($tmp_name != null) $pic = 1;

//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($Account != null && $Password != null)//確認密碼： && $pw2 != null && $pw == $pw2
{
        //新增資料進資料庫語法
        $sql = "insert into Member (Account, Password, Name) values ('$Account', '$Password', '$name')";
        if(mysqli_query($db, $sql))
        {
            $_SESSION['account'] = $Account;
            $_SESSION['mid'] =  mysqli_insert_id($db);
            if($pic)//存圖片
                    move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'].'/db/upload_pro_pic/'.$_SESSION['mid'].'.jpg');
                echo '註冊成功!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
        else
        {
                echo '註冊失敗!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
}
else
{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
?>
