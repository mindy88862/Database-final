<?php session_start();?>
<?php header("Content-Type:text/html; charset=utf-8");?>
<?php
include("mysql_connect.php");
$title = $_POST['post_name']; // 文章標題
$category = $_POST['category']; //類別
$item_num = $_POST['item_num']; //幾個物品
$item_name = $_POST['item_name'];//物品名稱
$item_price = $_POST['item_price']; //價格
$item_qua = $_POST['item_qua'];//每個物品的數量
$item_des = $_POST['item_des']; //描述
$time = $_POST['time'];
$place = $_POST['place'];

if(isset($_SESSION['mid'])){
	$insert_sql = "INSERT INTO Post (Seller_ID, Post_Time, Title, Time, Place, Category) VALUES ('$_SESSION[mid]', CURRENT_TIMESTAMP, '$title', '$time', '$place','$category')";
	//echo $insert_sql;
	mysqli_query($db, $insert_sql); //把貼文寫入資料庫
	$pid = mysqli_insert_id($db); //取得貼文pid

	for($i=0; $i<$item_num; $i++){//把各物品寫入資料庫
		$iid = $i + 1;
		$pic = 0;//如果有圖片= 1
		
		$tmp_name = $_FILES['img']['tmp_name'][$i];//接收圖片檔案
		if($tmp_name != null) $pic = 1;

		$insert_sql = "INSERT INTO Item (PID, IID, Name, Price, Quantity) VALUES ('$pid', '$iid', '$item_name[$i]','$item_price[$i]', '$item_qua[$i]')";
		mysqli_query($db, $insert_sql);	//寫入物品資料

		if($pic)//存圖片
			move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'].'/db/upload_img/'.$pid.'_'.$iid.'.jpg');

		if($item_des[$i]!=null || $tmp_name!=null){//寫敘述和圖片
			$insert_sql = "INSERT INTO Content (PID, IID, Description, Picture) VALUES ('$pid', '$iid', '$item_des[$i]','$pic')";	
			mysqli_query($db, $insert_sql);
		}

	}
	echo '<h2 class="mytitle">發表成功！</h2>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
else{
	echo '<h2 class="mytitle">發表失敗，請先登入！</h2>';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
}

?>