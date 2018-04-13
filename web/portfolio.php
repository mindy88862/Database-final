<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
$post_sql = mysqli_query($db, "SELECT * FROM Post");

?>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>出清台大2.0</title>

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

<!-- Animate.css -->
<link rel="stylesheet" href="css/hydrogen/animate.css">
<!-- Magnific Popup -->
<link rel="stylesheet" href="css/hydrogen/magnific-popup.css">
<!-- Salvattore -->
<link rel="stylesheet" href="css/hydrogen/salvattore.css">
<!-- Theme Style -->
<link rel="stylesheet" href="css/hydrogen/style.css">
<link rel="stylesheet" href="css/main.css">
<!-- Modernizr JS -->
<script src="js/modernizr-2.6.2.min.js"></script>

</head>
<body>
<header>
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
                    <?php 
                        if(isset($_SESSION['mid'])){
                            echo '<li><a href="index.php">主頁</a></li>';
                            echo '<li><a href="post.html">發文</a></li>';
                            echo '<li class="active"><a href="#">動態</a></li>';
                            echo '<li><a href="logout.php">登出</a></li>';
                        } 
                        else{
                            echo '<li class="active"><a href="#">動態</a></li>';
                            echo '<li><a href="login.html">登入/註冊</a></li>';
                        } 
                    ?>
                </ul>
            </div>
        </div><!--/.container-->
    </nav>
</header>
<!-- END .header -->


<div id="fh5co-main">
	<div class="container">
		<div class="center">        
            <h2>錢包在哭</h2>
        </div> 

		<div class="row">

    <div id="fh5co-board" data-columns>

    <?php
    	
        while($post = mysqli_fetch_row($post_sql)){
            $content_sql = mysqli_query($db, "SELECT * FROM Content WHERE PID = '$post[0]' AND Picture='1'");
    		echo '<div class="item"><div class="animate-box">';
			if(mysqli_num_rows($content_sql)<1) echo '<img src="images/img_2.jpg" class="image-popup fh5co-board-img"></div>';
            else{
                $content = mysqli_fetch_row($content_sql);
                echo '<img src="upload_img/'.$content[0].'_'.$content[1].'.jpg" class="image-popup fh5co-board-img"></div>';
            }

    	echo	'<div class="fh5co-desc">
    			<div class="portfolio-infor">';
   			$seller_sql = mysqli_query($db, "SELECT * FROM Member WHERE MID = '$post[1]'");
    			$seller = mysqli_fetch_row($seller_sql);
    			echo '<p class="infor-name">',$post[3],'</p>';//post作者名
    			echo '<p class="infor-time">',$post[2],'</p></div>';//發文時間
    			echo '<div class="short-article">';
    			echo '<p class="article-time">時間：',$post[4],'</p>';//面交時間
                echo '<p class="article-place">地點：',$post[5],'</p></div>';
                echo '<div class="sell-short-bottom portfolio-button">
                	<a href="member_post.php?postid=',$post[0], '"class="change-bottom all-bottom">查看完整貼文</a>
                </div>
    		</div>
    	</div>';   
                
                
       	}
    	
    ?>
    </div>
    </div>
   </div>
</div>

<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="col-sm-6">
                &copy; DataBaseProject Team 3.
        </div>
    </div>
</footer>


<!-- jQuery -->
<script src="js/hydrogen/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="js/hydrogen/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="js/hydrogen/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="js/hydrogen/jquery.waypoints.min.js"></script>
<!-- Magnific Popup -->
<script src="js/hydrogen/jquery.magnific-popup.min.js"></script>
<!-- Salvattore -->
<script src="js/hydrogen/salvattore.min.js"></script>
<!-- Main JS -->
<script src="js/hydrogen/main.js"></script>




</body>
