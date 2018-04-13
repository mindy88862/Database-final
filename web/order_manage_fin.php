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
	$interest_sql = mysqli_query($db, "SELECT * FROM Interest where PID='$pid' AND IID='$iid' AND Buyer_ID='$bid'");
	$interest = mysqli_fetch_row($interest_sql);
	//增加至訂單
	$time="自議";
	$place="自議";
	if($interest[5]) $time=$post[4];//if time match
	if($interest[6]) $place=$post[5];//if place match	

	$insert_sql = "INSERT INTO Orders (Buyer_ID, PID, IID, Quantity, Time_Match, Place_Match, Seller_ID) VALUES ('$bid', '$pid', '$iid', '$interest[4]', '$time','$place', '$_SESSION[mid]')";

	mysqli_query($db, $insert_sql); //把貼文寫入資料庫
	mysqli_query($db, "DELETE FROM Interest WHERE PID='$pid' AND IID='$iid' AND Buyer_ID='$bid'");//移除排

    echo '<meta http-equiv=REFRESH CONTENT=0;url=order_manage.php?postid='.$pid.'>';	
}
?>