<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
if($_SESSION['account'] != null)
{
    // 找出會員資料
    $user = mysqli_query($db, "SELECT * FROM Member where MID = '$_SESSION[mid]'");
    $urow = mysqli_fetch_row($user);
    // 找出會員正在排的
    $interest_sql = mysqli_query($db, "SELECT * FROM Interest where Buyer_ID = '$_SESSION[mid]'");
    $cin_sql = mysqli_query($db, "SELECT COUNT(*) FROM Interest where Buyer_ID = '$_SESSION[mid]'");
    $inum = mysqli_fetch_row($cin_sql); //排數量
    // 找出會員等待面交的
    $order_sql = mysqli_query($db, "SELECT * FROM Orders where Buyer_ID = '$_SESSION[mid]'");
    // 找出會員的po文
    $upost_sql = mysqli_query($db, "SELECT * FROM Post where Seller_ID = '$_SESSION[mid]'");
    $cpost_sql = mysqli_query($db, "SELECT COUNT(*) FROM Post where Seller_ID = '$_SESSION[mid]'");
    $pnum = mysqli_fetch_row($cpost_sql);//貼文數量
}
else{//排除未登入
    echo '<meta http-equiv=REFRESH CONTENT=0;url=portfolio.php>';
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>出清台大2.0</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet"><!-- 沒用 -->
	<link rel="stylesheet" href="css/font-awesome.min.css"><!-- 沒用 -->
	<link href="css/animate.min.css" rel="stylesheet"><!-- 動畫-->
    <link href="css/prettyPhoto.css" rel="stylesheet"><!-- 沒用-->
	<link href="css/main.css" rel="stylesheet">
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
                        <li class="active"><a href="#">主頁</a></li>
                        <li><a href="post.html">發文</a></li>
                        <li><a href="portfolio.php">動態</a></li>
                        <li><a href="logout.php">登出</a></li>                    
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
		
    </header><!--/header-->
	
	<div class="slider">
		<div class="container" id="trans-special">
			<div id="about-slider">
                <div class="about-header">
                    <h2 class="mytitle">近期面交</h2>
                    <h6 class="mysubtitle">查看最近有哪些面交</h6>
                <!--   <a href="#" class="view-bottom">檢視所有 >></a>-->
                </div>
                <div id="about-content">
                    <table class="transtable">
                        <colgroup span="6"></colgroup>
                        <thead id="table-head">
                            <tr class="table-row">
                                <?php
                                    if(mysqli_num_rows($order_sql) < 1) echo "<th>目前無等待面交商品！</th>";
                                    else echo '<th>商品</th><th>價錢</th><th>約定時間</th><th>約定地點</th><th>數量</th><th></th>';
                                ?>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                        <?php //列出在排商品
                            while ($order = mysqli_fetch_row($order_sql)) {
                                $post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$order[1]'");
                                $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$order[1]' AND IID='$order[2]'");
                                $post = mysqli_fetch_row($post_sql);
                                $item = mysqli_fetch_row($item_sql);
                                echo '<tr>','<td>', $item[2], '</td>'; //物品名稱
                                echo '<td>', $item[3], '</td>'; //價格
                                echo '<td>', $order[5], '</td>'; //時間
                                echo '<td>', $order[6], '</td>'; //地點
                                echo '<td>', $order[4], '</td>'; //數量
                                echo '<td><a href="member_post.php?postid=',$order[1],'"target="_blank" class="change-bottom">商品連結</a></td>';
                                echo '</td>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
			</div><!--/#about-slider-->
            <div id="about-profile">
                    <div class="about-header">
                        <h2 class="mytitie">個人檔案</h2>
                    </div>
                    <?php
                    //大頭貼，有就顯示，沒有就預設
                        $pic_name = 'upload_pro_pic/'.$_SESSION['mid'].'.jpg';
                        if(file_exists($pic_name))
                            echo '<img src=upload_pro_pic/'.$_SESSION['mid'].'.jpg class="img-responsive profile-pic" id="propic">';

                    ?>
                    <div id="profile-content">
                        <p>姓名：<?php echo $urow[3]; ?><br/>簡介：</p>
                        <p id="profile-descript"><?php echo $urow[4]; ?></p>
                        <div id="profile-button">
                            <a href="user_update.php" id="profile-special">更改資料</a>
                        </div>
                    </div>    
            </div>
		</div>
	</div>

	 <section id="you-as-seller" >
        <div class="container">
           <h2 class="mytitle fadeInDown">你的貼文</h2>
                <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators visible-xs">
                        <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-slider" data-slide-to="1"></li>
                        <li data-target="#carousel-slider" data-slide-to="2"></li>
                    </ol><!-- 防止垮掉ㄉ時候-->

                    <div class="carousel-inner">
                        <?php
                            $page = floor($pnum[0]/3); // 一共幾頁
                            for($i = 0; $i < $page; $i++){//印每一頁
                                $upost1 = mysqli_fetch_row($upost_sql);
                                $upost2 = mysqli_fetch_row($upost_sql);
                                $upost3 = mysqli_fetch_row($upost_sql);

                                if($i == 0) echo '<div class="item active">';//第一頁: active
                                else echo '<div class="item">';
                                for($j = 0; $j < 3; $j++){
                                    if($j == 0){
                                        echo '<div class="post-left seller">';
                                        $upost = $upost1;
                                    }
                                    else if($j == 1){//最右
                                        echo '<div class="post-right seller">';
                                        $upost = $upost3;
                                    }
                                    else{//中間
                                        echo '<div class="post-middle seller">';
                                        $upost = $upost2;
                                    }
                                    $cinterest_sql = mysqli_query($db, "SELECT COUNT(*) FROM Interest where PID = '$upost[0]'");
                                    $cinum = mysqli_fetch_row($cinterest_sql);//正在排的數量
                                    echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                    echo '<p class="update-border">目前共有<i class="update-strong">',$cinum[0],'</i>個人排</p></div>';
                                    echo ' <div class="short-infor"><p class="infor-name">', $upost[3],'</p><p class="infor-time">', $upost[2],'</p></div></div>'; //貼文名稱、時間
                                    echo '<div class="short-article"><p class="article-time">時間：', $upost[4],'</p><p class="article-place">地點：', $upost[5],'</p></div>';//時間地點
                                    echo '<div class="sell-short-bottom"><a href="member_post.php?postid=',$upost[0],'" class="change-bottom all-bottom">查看完整貼文</a><br /><br /><a href="order_manage.php?postid=',$upost[0], '"class="change-bottom all-bottom mana-button">管理/結單</a></div></div>';//兩個按鈕
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                            if($pnum[0] % 3 != 0){//最後一頁
                                $upost = mysqli_fetch_row($upost_sql);
                                $cinterest_sql = mysqli_query($db, "SELECT COUNT(*) FROM Interest where PID = '$upost[0]'");
                                $cinum = mysqli_fetch_row($cinterest_sql);//正在排的數量
                                if($pnum[0] < 3) echo '<div class="item active">';//第一頁
                                else echo '<div class="item">';
                                echo '<div class="post-left seller">';
                                echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                echo '<p class="update-border">目前共有<i class="update-strong">',$cinum[0],'</i>個人排</p></div>';
                                echo ' <div class="short-infor"><p class="infor-name">', $upost[3],'</p><p class="infor-time">', $upost[2],'</p></div></div>'; //貼文名稱、時間
                                echo '<div class="short-article"><p class="article-time">時間：', $upost[4],'</p><p class="article-place">地點：', $upost[5],'</p></div>';//時間地點
                                echo '<div class="sell-short-bottom"><a href="member_post.php?postid=',$upost[0],'" class="change-bottom all-bottom">查看完整貼文</a><br /><br /><a href="order_manage.php?postid=',$upost[0], '"class="change-bottom all-bottom mana-button">管理/結單</a></div></div>';//兩個按鈕
                                echo '</div>';
                                echo '<div class="post-right seller"><div class="post-short"></div></div>';//右邊沒東西
                                if($pnum[0] % 3 == 2){//中間的
                                    $upost = mysqli_fetch_row($upost_sql);
                                    $cinterest_sql = mysqli_query($db, "SELECT COUNT(*) FROM Interest where PID = '$upost[0]'");
                                    $cinum = mysqli_fetch_row($cinterest_sql);//正在排的數量
                                    echo '<div class="post-middle seller">';
                                    echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                    echo '<p class="update-border">目前共有<i class="update-strong">',$cinum[0],'</i>個人排</p></div>';
                                    echo ' <div class="short-infor"><p class="infor-name">', $upost[3],'</p><p class="infor-time">', $upost[2],'</p></div></div>'; //貼文名稱、時間
                                    echo '<div class="short-article"><p class="article-time">時間：', $upost[4],'</p><p class="article-place">地點：', $upost[5],'</p></div>';//時間地點
                                    echo '<div class="sell-short-bottom"><a href="member_post.php?postid=',$upost[0],'" class="change-bottom all-bottom">查看完整貼文</a><br /><br /><a href="order_manage.php?postid=',$upost[0], '"class="change-bottom all-bottom mana-button">管理/結單</a></div></div>';//兩個按鈕
                                    echo '</div>';
                                }
                                else echo '<div class="post-middle seller"><div class="post-short"></div></div>';//如果只有一張
                                echo '</div>';
                            }      
                        ?>
                    </div>
                    
                    <a class="left carousel-control hidden-xs" href="#carousel-slider" data-slide="prev">
                        <i class="fa fa-angle-left"></i> 
                    </a>
                    
                    <a class=" right carousel-control hidden-xs" href="#carousel-slider" data-slide="next">
                        <i class="fa fa-angle-right"></i> 
                    </a>
                </div> 
        </div><!--/.container-->
    </section><!--/#feature-->
	
	 <section id="you-as-buyer">
        <div class="container">
           <h2 class="mytitle fadeInDown">你正在排的商品</h2>
                <div id="carousel-slider2" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators visible-xs">
                        <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-slider" data-slide-to="1"></li>
                        <li data-target="#carousel-slider" data-slide-to="2"></li>
                    </ol><!-- 防止垮掉ㄉ時候-->

                    <div class="carousel-inner">
                        <?php
                            if($inum[0] == 0){//沒排的

                            }
                            else{
                                $page = floor($inum[0]/3); // 一共幾頁
                                for($i = 0; $i < $page; $i++){//印每一頁
                                    $interest1 = mysqli_fetch_row($interest_sql);//依序抓排的清單
                                    $interest2 = mysqli_fetch_row($interest_sql);
                                    $interest3 = mysqli_fetch_row($interest_sql);
                                    if($i == 0) echo '<div class="item active">';//第一頁: active
                                    else echo '<div class="item">';
                                    for($j = 0; $j < 3; $j++){
                                        if($j == 0){
                                            echo '<div class="post-left buyer">';
                                            $interest = $interest1;
                                        }
                                        else if($j == 1){//最右
                                            echo '<div class="post-right buyer">';
                                            $interest = $interest3;
                                        }
                                        else{//中間
                                            echo '<div class="post-middle buyer">';
                                            $interest = $interest2;
                                        }
                                        $post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$interest[1]'");
                                        $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$interest[1]' AND IID='$interest[2]'");
                                        $post = mysqli_fetch_row($post_sql);//排的貼文
                                        $item = mysqli_fetch_row($item_sql);//排的物品
                                        echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                        echo '<p class="update-border">目前你排了<i class="update-strong">',$interest[4],'</i>個</p></div>';
                                        echo ' <div class="short-infor"><p class="infor-name">', $item[2],'</p><p class="infor-time">', $interest[3],'</p></div></div>'; //貼文名稱、時間
                                        echo '<div class="short-article"><p class="article-time">時間：', $post[4],'</p><p class="article-place">地點：', $post[5],'</p><p class="article-price">價錢：$', $item[3],' /個</p></div>';//時間地點價錢
                                        echo '<div class="buy-short-bottom"><a href="member_post.php?postid=',$post[0],'" class="change-bottom all-bottom">查看完整貼文</a></div></div>';//按鈕
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }
                                if($inum[0] % 3 != 0){//最後一頁
                                    $interest = mysqli_fetch_row($interest_sql);//抓排清單
                                    $post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$interest[1]'");
                                    $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$interest[1]' AND IID='$interest[2]'");
                                    $post = mysqli_fetch_row($post_sql);//排的貼文
                                    $item = mysqli_fetch_row($item_sql);//排的物品                              
                                    if($inum[0] < 3) echo '<div class="item active">';//第一頁
                                    else echo '<div class="item">';
                                    echo '<div class="post-left buyer">';
                                    echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                    echo '<p class="update-border">目前你排了<i class="update-strong">',$interest[4],'</i>個</p></div>';
                                    echo ' <div class="short-infor"><p class="infor-name">', $item[2],'</p><p class="infor-time">', $interest[3],'</p></div></div>'; //貼文名稱、時間
                                    echo '<div class="short-article"><p class="article-time">時間：', $post[4],'</p><p class="article-place">地點：', $post[5],'</p><p class="article-price">價錢：$', $item[3],' /個</p></div>';//時間地點價錢
                                    echo '<div class="buy-short-bottom"><a href="member_post.php?postid=',$post[0],'" class="change-bottom all-bottom">查看完整貼文</a></div></div>';//按鈕
                                    echo '</div>';

                                    echo '<div class="post-right buyer"><div class="post-short"></div></div>';//右邊沒東西

                                    if($inum[0] % 3 == 2){//中間的
                                        $interest = mysqli_fetch_row($interest_sql);//抓排清單
                                        $post_sql = mysqli_query($db, "SELECT * FROM Post where PID='$interest[1]'");
                                        $item_sql = mysqli_query($db, "SELECT * FROM Item where PID='$interest[1]' AND IID='$interest[2]'");
                                        $post = mysqli_fetch_row($post_sql);//排的貼文
                                        $item = mysqli_fetch_row($item_sql);//排的物品
                                        echo '<div class="post-middle buyer">';
                                        echo '<div class="post-short"><div class="short-header"><div class="short-update">';
                                        echo '<p class="update-border">目前你排了<i class="update-strong">',$interest[4],'</i>個</p></div>';
                                        echo ' <div class="short-infor"><p class="infor-name">', $item[2],'</p><p class="infor-time">', $interest[3],'</p></div></div>'; //貼文名稱、時間
                                        echo '<div class="short-article"><p class="article-time">時間：', $post[4],'</p><p class="article-place">地點：', $post[5],'</p><p class="article-price">價錢：$', $item[3],' /個</p></div>';//時間地點價錢
                                        echo '<div class="buy-short-bottom"><a href="member_post.php?postid=',$post[0],'" class="change-bottom all-bottom">查看完整貼文</a></div></div>';//按鈕
                                        echo '</div>';
                                    }
                                    else echo '<div class="post-middle buyer"><div class="post-short"></div></div>';//如果只有一張
                                    echo '</div>';
                                }
                            }     
                        ?>

                    </div>
                    
                    <a class="left carousel-control hidden-xs" href="#carousel-slider2" data-slide="prev">
                        <i class="fa fa-angle-left"></i> 
                    </a>
                    
                    <a class=" right carousel-control hidden-xs" href="#carousel-slider2" data-slide="next">
                        <i class="fa fa-angle-right"></i> 
                    </a>
                </div> 
        </div><!--/.container-->
    </section><!--/#recent-works-->	

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
