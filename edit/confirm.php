<?php
	session_start();

	//値の受け取り
	$nickname = $_SESSION['users']['nickname'];
	$res_id = $_SESSION['join']['res_id'];
	
	if(isset($_SESSION['join']['title'])){
		$title = $_SESSION['join']['title'];
	}

	$comment = $_SESSION['join']['comment'];
	
	if(isset($_SESSION['join']['thumbnail']) && $_SESSION['join']['thumbnail'] != "none"){
		$image_file_t = $_SESSION['join']['thumbnail'];
	}

	if(isset($_GET["action"])){
		$action = $_GET["action"];
	}else{
		$action = "";
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/list.css">
<title>掲示板</title>
</head>
<body>
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
<div class="btn-menu">
<ul>
  <li><a href="../index.php">トップページ</a></li>
  <li><a href="../signup/index.php">新規登録</a></li>
  <li><a href="../login/index.php?action=logout">ログアウト</a></li>
</ul>
</div><!-- /btn-menu -->
</div><!-- /header -->
<div id="main">
<div class="entry-box">
<h2><span>*</span>確認画面</h2>
<?php 
if($action != "del"){ 
?>
<p>以下の項目をご確認後、「修正」ボタンを選択してください。</p>
<?php
}else{
?>
<p>以下の項目をご確認後、「削除」ボタンを選択してください。<br />
<span style="color:red;">※スレッドを削除すると、スレッドに書かれたレスも削除されます。</span>
</p>
<?php
}
?>
<table class="entry">
<?php if($res_id == 0){ ?>
<tr>
  <th>タイトル</th>
  <td><?php if(isset($title)){ echo $title; } ?></td>
</tr>
<?php } ?>
<tr>
  <th>ニックネーム</th>
  <td><?php echo $nickname; ?></td>
</tr>
<tr>
  <th>レス本文</th>
  <td><?php echo nl2br($comment); ?></td>
</tr>
<tr>
  <th>画像</th>
  <td><?php if(isset($image_file_t)){ ?>
  	<img src="<?php echo $image_file_t; ?>" />
   <?php } ?>
  </td>
</tr>
</table>
<ul style="margin:15px auto 0 auto; width:400px; overflow:hidden;">
 <li style="float:left;"><a href="index.php?action=back" class="back">前に戻る</a></li>
<?php 
if($action != "del"){ 
?>
 <li style="float:right;"><a href="index.php?action=update" class="entry">修　正</a></li>
<?php
}else{
?>
 <li style="float:right;"><a href="index.php?action=delete" class="entry">削　除</a></li>
<?php
}
?>
</ul>
</div><!-- /entry-box -->
</div><!-- /main -->
</body>
</html>