<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
    
    <!-- Meta Tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>出清台大2.0</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" type="image/x-icon" href="images/favicon/apple-touch-icon.png">
    <!-- All CSS Plugins -->
    <link rel="stylesheet" type="text/css" href="css/workplugin.css">
    <!-- Main CSS Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/workstyle.css">
    <!-- Google Web Fonts  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<?php
include("mysql_connect.php");
// get pid, iid
$pid = $_POST['postid'];
$iid = $_POST['itemid'];
// 寫入資料庫
//echo $pid, ' ', $iid;
$seller = mysqli_fetch_row(mysqli_query($db, "SELECT Seller_ID FROM Post WHERE PID='$pid'"));
$insert_sql = "INSERT INTO Interest (Buyer_ID, PID, IID, Interest_Time, Quantity, Time_Match, Place_Match, Seller_ID) VALUES ('$_SESSION[mid]', '$pid', '$iid', CURRENT_TIMESTAMP, '$_POST[quantity]', '$_POST[time_match]', '$_POST[place_match]','$seller[0]')";
//檢查是不是在面交清單中
$order_sql = mysqli_query($db, "SELECT * FROM Orders where Buyer_ID = '$_SESSION[mid]'");
if(mysqli_query($db, $insert_sql))
    echo '<h2 class="mytitle">您已成功排到此商品！即將跳轉至首頁。</h2>';

else echo '<h2 class="mytitle">發生錯誤！請確定您是否已排過此商品！即將跳轉至首頁。</h2>';
echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
?>