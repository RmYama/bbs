<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/top.css">
<title>掲示板</title>
<style type="text/css">
<!--
body {
<?php if(isset($site_bgcolor)){ ?>
	background-color:<?php echo $site_bgcolor ?>;
<?php } ?>
}
-->
</style> 
</head>
<body>
<div id="header">
<?php if(isset($tag_header)){ echo  $tag_header."\r\n"; } ?>
<div class="btn-menu">
<ul>
  <li><a href="index.php">トップページ</a></li>
  <li><a href="signup/index.php">新規登録</a></li>
<?php
if($state == "true"){ ?>
  <li><a href="login/index.php?action=logout">ログアウト</a></li>
<?php }else{ ?>
  <li><a href="login/index.php">ログイン</a></li>
<?php } ?>
</ul>
<?php
if($state == "true" && isset($_SESSION["users"]["nickname"])){
	$login_users = $_SESSION["users"]["nickname"] ;
}else{
	$login_users = "ゲスト";
}
?>
<p class="users">ようこそ <b><?php echo $login_users ?></b> さん。</p>
</div><!-- /btn-menu -->
</div><!-- /header -->
<div id="main">
<h2><span>*</span>新着スレッド</h2>
<div class="btn-thread-new">
<a href="thread/index.php" class="thread_new">新規スレッド作成</a>
</div>
<div class="new-list">
<ul>
<?php
if($flg != false){
	while($row = $db->fetch()){
		$id = $row["id"];
		$title = $row["title"];
		$comment = $row["comment"];
		$time = $row["add_time"];
		$res_cnt = $row["res_cnt"]-1;
		$res_id = $row["res_id"];
		$comment = mb_strimwidth($comment,0,63,"…");
?>
  <li>
     <p class="title"><a href="list/index.php?action=list&no=<?php echo $id ?>"><?php echo $title ?></a><span class="rescount"><span>レス数</span><br /><?php echo $res_cnt ?></span></p>
	 <p class="text"><?php echo $comment ?></p>
	 <p class="time"><?php echo $time ?></p>
  </li>
<?php
	}
}
?>
</ul>
</div>
</div><!-- /bbs-box -->
<div class="paging">
<ul>
<?php if($page > 1){ ?>
  <li class="previous"><a href="index.php?page=<?php echo $page-1; ?> ">< 前</a></li>
<?php } ?>
<?php for($i=1;$i <= $totalpages; $i++){ ?>
<?php if($page == $i){ ?>
  <li class="active"><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php }else{ ?>
  <li><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php } ?>
<?php } ?>
<?php if($page < $totalpages){ ?>
  <li class="next"><a href="index.php?page=<?php echo $page+1; ?>">次 ></a></li>
<?php } ?>
</ul>
</div>
</div><!-- /main -->
<div id="footer">
<?php if(isset($tag_footer)){ echo  $tag_footer."\r\n"; } ?>
</div>
<div style="padding:0 15px 15px 0; text-align:right; font-size:12px;"><a href="admin/index.php" style="color:#0FB4D8;">管理画面</a></div>
</body>
</html>