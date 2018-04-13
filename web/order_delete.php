<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
$pid = $_GET['pid'];
$iid = $_GET['iid'];
$bid = $_GET['bid'];
$post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$pid'");
$post = mysqli_fetch_row($post_sql);
if($post[1] == $_SESSION['mid']){
	//刪除訂單
	mysqli_query($db, "DELETE FROM Orders WHERE PID='$pid' AND IID='$iid' AND Buyer_ID='$bid'");
    echo '<meta http-equiv=REFRESH CONTENT=0;url=order_manage.php?postid='.$pid.'>';	
}

?>