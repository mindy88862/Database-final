<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// 登出，將session清空
unset($_SESSION['mid']);
unset($_SESSION['account']);
echo '<meta http-equiv=REFRESH CONTENT=0;url=portfolio.php>';
?>