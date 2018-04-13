<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");

// 排除未登入
if($_SESSION['account'] != null)
{
    // 找出在排的人清單
    $pid = $_GET['postid'];
    $post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$pid'");
    $post = mysqli_fetch_row($post_sql);
    $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$pid'");
    $item_num = mysqli_num_rows($item_sql);//計算此貼文有多少商品
}
else{
    echo '您無權限觀看此頁面！';
    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
}
?>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>出清台大2.0</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/prettyPhoto.css" rel="stylesheet">      
<link href="css/main.css" rel="stylesheet">
 <link href="css/responsive.css" rel="stylesheet">
 <!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->       

</head>
<body class="homepage">   
<header id="header">
    <nav class="navbar navbar-fixed-top" role="banner">
         <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> <!-- 不一定用得到 -->
                <a class="navbar-brand" href="index.php">出清台大</a>
            </div>
            
            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">主頁</a></li>
                    <li><a href="post.html">發文</a></li>
                    <li><a href="portfolio.php">動態</a></li>
                    <li><a href="logout.php">登出</a></li>                    
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
	
</header><!--/header-->

<section id="manage-title">
  <div class="container manage-header">
    <h2><?php echo $post[3]?></h2>
    <div class="button-set">
        <form method="post" action="post_delete.php">
            <?php echo '<input type="hidden" name="postid" value='.$pid.'>';?>
            <button type="submit" class="btn btn-primary btn-lg" id="end-trans" onclick="return confirm('是否確認刪除這個貼文？此動作將會移除未排到、已排到的所有交易。');">結單</button>
        </form>
    </div>
  </div>
</section>

<section id="manage-choose">
  <div class="container" id="manage-line">
    <div class="about-header">
        <h2 class="mytitle">正在排此商品</h2>
        <h6 class="mysubtitle">查看有哪些人在排你的商品</h6>

    </div>
    <div id="about-content">
        <table class="transtable">
          <colgroup span="7"></colgroup>
            <thead id="table-head">
              <tr class="table-row">
                <th>商品</th>
                <th>買家</th>
                <th>數量</th>
                <th>可否配合時間</th>
                <th>可否配合地點</th>
                <th>下單時間</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="table-body">
                <?php //列出在排商品
                    $time_value = array("否","是");
                    for($i = 1; $i<=$item_num; $i=$i+1){
                        $item = mysqli_fetch_row($item_sql);
                        $uinterest_sql = mysqli_query($db, "SELECT * FROM Interest where Seller_ID='$_SESSION[mid]' AND PID='$pid' AND IID='$i'");
                        if($uinterest_sql != null){
                            while ($uinterest = mysqli_fetch_row($uinterest_sql)) {// 印出訂單
                                $buyer_sql = mysqli_query($db, "SELECT MID,Account FROM Member where MID = '$uinterest[0]'");
                                $buyer = mysqli_fetch_row($buyer_sql);
                                
                                echo '<tr>','<td>', $item[2], '</td>';//商品名稱
                                echo '<td>', $buyer[1], '</td>';//買家
                                echo '<td>', $uinterest[4], '</td>'; //數量
                                echo '<td>', $time_value[$uinterest[5]], '</td>'; //時間
                                echo '<td>', $time_value[$uinterest[6]], '</td>'; //地點
                                echo '<td>', $uinterest[3], '</td>'; //數量                                
                                echo '<td><a href="order_manage_fin.php?pid='.$pid.'&iid='.$item[1].'&bid='.$buyer[0].'" class="change-bottom">確認面交</a></td>';
                                echo '</tr>';
                                
                                
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

  </div>
</section>
<section id="manage-pai">
    <div class="container">
        <div class="about-header">
                <h2 class="mytitle">近期面交</h2>
                <h6 class="mysubtitle">查看最近有哪些面交</h6>
            <!--   <a href="#" class="view-bottom">檢視所有 >></a>-->
            </div>
            <div id="about-content">
                <table class="transtable">
                    <colgroup span="7"></colgroup>
                    <thead id="table-head">
                        <tr class="table-row">
                            <th>商品</th>
                            <th>價格</th>
                            <th>買家</th>
                            <th>數量</th>
                            <th>約定時間</th>
                            <th>約定地點</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php //列出在排商品
                            $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$pid'");
                            $item_num = mysqli_num_rows($item_sql);                       
                            $time_value = array("否","是");
                            for($i = 1; $i<=$item_num; $i=$i+1){
                                $item = mysqli_fetch_row($item_sql);
                                $uinterest_sql = mysqli_query($db, "SELECT * FROM Orders where Seller_ID='$_SESSION[mid]' AND PID='$pid' AND IID='$i'");
                                if($uinterest_sql != null){
                                    while ($uinterest = mysqli_fetch_row($uinterest_sql)) {// 印出有排買家
                                        $buyer_sql = mysqli_query($db, "SELECT MID,Account FROM Member where MID = '$uinterest[0]'");
                                        $buyer = mysqli_fetch_row($buyer_sql);
                                        
                                        
                                        echo '<tr>','<td>',$item[2], '</td>';//商品名稱
                                        echo '<td>', $item[3],'</td>';//價格
                                        echo '<td>', $buyer[1], '</td>';//買家
                                        echo '<td>', $uinterest[4], '</td>'; //數量
                                        echo '<td>', $uinterest[5], '</td>'; //約定時間
                                        echo '<td>', $uinterest[6], '</td>'; //約定地點
                                        echo '<td><a href="order_revise.php?pid='.$pid.'&iid='.$item[1].'&bid='.$buyer[0].'" class="change-bottom">修改時間/地點</a></td>';
                                        echo '<td><a href="order_delete.php?pid='.$pid.'&iid='.$item[1].'&bid='.$buyer[0].'" class="change-bottom">面交完成</a></td>';
                                        echo '<td></td>';
                                        echo '</tr>';
                                    
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</section>

<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="col-sm-6">
                &copy; DataBaseProject Team 3.
        </div>
    </div>
</footer><!--/#footer-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/jquery.isotope.min.js"></script>   
<script src="js/wow.min.js"></script>
<script src="js/main.js"></script>
</body>