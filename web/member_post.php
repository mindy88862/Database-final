<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--出清文章-->
<?php
include("mysql_connect.php");
//echo '<a href="logout.php">登出</a>  <br><br>';
// get pid
$pid = $_GET['postid'];
// 找到post: PID, seller, post_time, title, time, place, category

$post_sql = mysqli_query($db, "SELECT * FROM Post where PID = '$pid'");
$post = mysqli_fetch_row($post_sql);
// 找到item
$item_sql = mysqli_query($db, "SELECT * FROM Item where PID = '$pid'");
?>




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
    
    <!-- HTML5 shiv and Respond.js support IE8 or Older for HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

 <body>
    <div id="main">
        <div class="container">
            <div class="row">
                 <!-- About Me (Left Sidebar) Start -->
                 <div class="col-md-3">
                   <div class="about-fixed">
                     <div class="my-pic">
                      <?php
                          $pic_name = 'upload_pro_pic/'.$post[1].'.jpg';
                          if(file_exists($pic_name))
                            echo '<img src='.$pic_name.' class="propic">';
                      ?>
                      </div>
                      <div class="my-detail">
                        <div class="white-spacing">
                            <?php
                            $seller_sql = mysqli_query($db, "SELECT * FROM Member where MID = '$post[1]'");
                            $seller = mysqli_fetch_row($seller_sql);
                           

                            echo '<h1>',$seller[3],'('.$seller[1].')','</h1>';
                            echo '<span>',$seller[4],'</span>';
                            //<br/><br/><a href="#" id="pro-button">關於賣家</a>
                            ?>
                        </div> 
                      </div>
                  </div>
                </div>
                <!-- About Me (Left Sidebar) End -->        
                <!-- Portfolio (Right Sidebar) Start -->
                  <div class="col-md-9">
                    <div class="col-md-12 page-body">
                      <div class="row">
                        <div class="sub-title"><!--貼文標題-->
                         <?php
                         echo '<h2>',$post[3],'</h2>';
                         ?>
                          <div class="work-button"><button onclick="history.back()" class="change-bottom all-bottom">返回</a></div>
                        </div>
                        <div class="col-md-12 content-page">
                          <div class="col-md-12 blog-post">
                          <!-- Portfolio Start -->
                            <div><!--portofolio detail start-->
<?php
  $x = 1;
  while($item = mysqli_fetch_row($item_sql)){
    if($content_sql =  mysqli_query($db, "SELECT * FROM Content where PID='$pid' and IID=$item[1]")){
      $content = mysqli_fetch_row($content_sql);
      echo '<div class="row portfolio"><div class="col-sm-6 custom-pad-1 item-area">';//圖片的
      if($content[3])//如果有圖片，印出
      {
        echo '<img src="upload_img/'.$pid.'_'.$item[1].'.jpg" class="img-responsive item-pic">';
      }   
    echo '</div>';//圖片區塊結束
      echo'<div class="col-sm-6 custom-pad-2"><div class="table-responsive"><table class="table table-bordered"><tbody>';//表格框架  
              echo '<tr><td><b>名稱</b></td><td>',$item[2],'</td></tr>'; //物品名稱
              echo '<tr><td><b>面交時間</b></td><td>',$post[4],'</td></tr>';
              echo '<tr><td><b>面交地點</></td><td>',$post[5],'</td></tr>';
              echo '<tr><td><b>數量</b></td><td>',$item[4],'</td></tr>';//數量
              echo '<tr><td><b>價錢</b></td><td>',$item[3],'</td></tr>';//價錢
              if($content[2] == null) $des = '無';
              else $des = $content[2];
              echo '<tr><td><b>關於商品</b></td><td>',$des,'</td></tr>';//物品描述
          echo'</tbody></table></div></div>
        </div>';
    }
    $x = $x + 1;
  }
?>

                                </div>

                                
                                
                                <div class="col-md-12 text-center" id="load-area">
                                 <a href="javascript:void(0)" id="load-more-portfolio" class="load-more-button">Load</a>
                                 <div id="portfolio-end-message"></div>
                                </div>    

                                <div class="col-md-12 text-center buy-area">
                                  <button type="button" class="order">我要排</button>

                                <div class="col-md-12 show-up-area"  style="display:none;">
                                  <form name="buy-form" method="post" action="interest_fin.php" class="pai-form">
                                    <div class="form-group"><label>您想要排的商品為：</label>
                                      <select name="itemid">
                                        <?php                                          
                                          $item_sql = mysqli_query($db, "SELECT * FROM Item where PID = '$pid'");
                                          while($item = mysqli_fetch_row($item_sql)){
                                            echo '<option name="item_s" value='.$item[1].'>'.$item[2].'</option>';
                                          }
                                        ?>
                                      </select>
                                      <?php echo '<input type="hidden" name="postid" value='.$pid.'>';?>
                                    </div>                                    
                                    <div class="form-group"><label>數量：</label>
                                      <input type="number" name="quantity" required="required" value="1" class="count-size" min="1"></input></div>
                                      <div class="form-group"><label>此面交時間為：<?php echo $post[4];?></label></div>
                                      <div class="form-group"><label>是否可配合時間：</label>
                                        <input type="radio" name="time_match" checked="checked" value="1"> 是 </input>
                                        <input type="radio" name="time_match" value="0"> 否 </input>
                                      </div>
                                      <div class="form-group"><label>此面交地點為：<?php echo $post[5];?></label></div>
                                      <div class="form-group"><label>是否可配合地點：</label>
                                        <input type="radio" name="place_match" checked="checked" value="1"> 是 </input>
                                        <input type="radio" name="place_match" value="0e"> 否 </input>
                                      </div>
                                      <div class="form-group"><label>一旦排了就不可以反悔喔！請再次確認數量。</label><br /><br />
                                        <button type="submit" class="check-button">確定要排</button>
                                      </div>
                                    </form>                                  
                                </div>
                              </div> 

                             </div><!-- end of portfolio detail --> 
                         </div><!-- end of portfolio-->  
                         </div>
                  </div>
                  <!-- Portfolio (Right Sidebar) End -->
                
            </div>
         </div>
      </div>
    
      
    
    
    
    <!-- Back to Top Start -->
    <a href="#" class="scroll-to-top"><i class="fa fa-long-arrow-up"></i></a>
    <!-- Back to Top End -->
    
    
    <!-- All Javascript Plugins  -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/plugin.js"></script>
    <!-- Main Javascript File  -->
    <script type="text/javascript" src="js/scripts.js"></script>

    
   </body>
<?php
  //排除未登入、買家就是賣家
  if(!isset($_SESSION['mid'])){
    echo "<script>$('.order').remove();</script>";
  }
  elseif ($post[1]==$_SESSION['mid']) {
    echo "<script>$('.order').remove();</script>";
  }
  else{
    echo "<script>
  var flag = 0;
  var item = '';
   $('.order').on('click',function(){
      if (flag == 0){
        $('.show-up-area').show();
        flag = 1;
      }
      else{
        $('.show-up-area').hide();
        flag = 0;
      }
    });
 </script>";
  }
?>
<!--  <script>
  var flag = 0;
  var item = '';
   $('.order').on('click',function(){
      if (flag == 0){
        $('.show-up-area').show();
        flag = 1;
      }
      else{
        $('.show-up-area').hide();
        flag = 0;
      }
    });
 </script> -->
