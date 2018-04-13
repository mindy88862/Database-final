<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.php");
$pid = $_GET['pid'];
$iid = $_GET['iid'];
$bid = $_GET['bid'];

$order_sql = mysqli_query($db, "SELECT * FROM Orders where PID='$pid' AND IID='$iid' AND Buyer_ID='$bid'");
$order = mysqli_fetch_row($order_sql);
$buyer_sql = mysqli_query($db, "SELECT * FROM Member where MID = '$bid'");
$buyer = mysqli_fetch_row($buyer_sql);
if($order[7] != $_SESSION['mid']) echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
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
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
	
</header><!--/header-->

<section id="update-page">
    <div class="container">
        <div class="center" id="update-special">        
            <h2>更改訂單資料</h2>
            <p class="lead">請輸入要更改的面交時間和地點。</p>
        </div> 
        <div id="update-area"> 
            <form name="register-form" method="post" action="order_revise_fin.php">
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>買家：<?php echo $buyer[1]?></label>
                    </div>
                    <div class="form-group">
                        <label>時間</label>
                        <?php echo '<input type="text" name="time" class="form-control" value='.$order[5].'>';?>
                    </div>
                    <div class="form-group">
                        <label>地點</label>
                        <?php echo '<input type="text" name="place" class="form-control" value='.$order[6].'>';?>
                    </div>                    
                    <div class="form-group">
                        <?php 
                            echo '<input type="hidden" name="postid" value='.$pid.'>';
                            echo '<input type="hidden" name="bid" value='.$bid.'>';
                            echo '<input type="hidden" name="iid" value='.$iid.'>';
                        ;?>
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">確認更改</button>
                    </div>
                </div>
            </form> 
        </div><!--/.row-->
    </div><!--/.container-->
</section><!--/#contact-page-->

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
