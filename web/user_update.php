<?php session_start(); ?>
<?php
include("mysql_connect.php");
$user = mysqli_query($db, "SELECT * FROM Member where Account = '$_SESSION[account]'");
$urow = mysqli_fetch_row($user);
$name = $urow[3];
$profile = $urow[4];
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
                <a class="navbar-brand" href="index.html">出清台大</a>
            </div>
            
            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">主頁</a></li>
                    <li><a href="post.html">發文</a></li>
                    <li><a href="manage.html">管理訂單</a></li>
                    <li><a href="portfolio.html">動態</a></li>
                    <li><a href="login.html">登入/註冊</a></li>                    
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
	
</header><!--/header-->

<section id="update-page">
    <div class="container">
        <div class="center" id="update-special">        
            <h2>更改會員資料</h2>
            <p class="lead">只能改暱稱跟介紹(#)</p>
        </div> 
        <div id="update-area"> 
            <form name="register-form" method="post" action="user_update_fin.php">
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>Username</label>
                        <?php echo '<input type="text" name="name" value="', $name,'" class="form-control">';?>
                    </div>
                    <div class="form-group">
                        <label>Introduce Yourself</label>
                        <?php echo '<input type="text" name="profile" value="', $profile,'" class="form-control">';?>
                    </div>                    
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">更改</button>
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