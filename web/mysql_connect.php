<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";
//資料庫名稱
$db_name = "db2017";
//資料庫管理者帳號
$db_user = "root";
//對資料庫連線
//mysqli_connect($db_server, $db_user);
$db = mysqli_connect($db_server, $db_user);

if(empty($db)){
	die("無法對資料庫連線");
}

//選擇資料庫
if(!mysqli_select_db($db, $db_name)) {
  die ("無法選擇資料庫");
}
mysqli_query($db, "SET NAMES 'utf8'");

?> 
