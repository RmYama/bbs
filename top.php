<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/top.css">
<title>掲示板</title>
</head>
<body>
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
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
<p></p>
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
if($flg == true){
	while($row = $db->fetch_array()){
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
</div><!-- /main -->
</body>
</html>