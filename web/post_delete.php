<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
$pid = $_POST['postid'];
$post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$pid'");
$post = mysqli_fetch_row($post_sql);
if($post[1] == $_SESSION['mid']){
	//刪除商品
	mysqli_query($db, "DELETE FROM Item WHERE PID='$pid'");
	//刪除商品敘述
	mysqli_query($db, "DELETE FROM Content WHERE PID='$pid'");
	//刪除排
	mysqli_query($db, "DELETE FROM Interest WHERE PID='$pid'");
	//刪除訂單
	mysqli_query($db, "DELETE FROM Orders WHERE PID='$pid'");
	//刪除貼文
	mysqli_query($db, "DELETE FROM Post WHERE PID='$pid'");
    echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';	
}
?>