<?php
	session_start();

	//値の受け取り
	$nickname = $_SESSION['users']['nickname'];
	$comment = $_SESSION['join']['comment'];

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
<p>以下の項目をご確認後、「投稿」ボタンを選択してください。</p>
<table class="entry">
<tr>
  <th>ニックネーム</th>
  <td><?php echo $nickname; ?></td>
</tr>
<tr>
  <th>レス本文</th>
  <td><?php echo nl2br($comment); ?></td>
</tr>
</table>
<ul style="margin:15px auto 0 auto; width:400px; overflow:hidden;">
 <li style="float:left;"><a href="index.php?action=back" class="back">前に戻る</a></li>
 <li style="float:right;"><a href="index.php?action=entry" class="entry">投 稿</a></li>
</ul>
</div><!-- /entry-box -->
</div><!-- /main -->
</body>
</html>