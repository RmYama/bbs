<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="thread.css">
<title>掲示板</title>
</head>
<body>
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
<div class="btn-menu">
<ul>
  <li><a href="../index.php">トップページ</a></li>
  <li><a href="../login/index.php?action=signup">新規登録</a></li>
  <li><a href="../login/index.php?action=logout">ログアウト</a></li>
</ul>
</div><!-- /btn-menu -->
</div><!-- /header -->
<div id="main">
<?php
if(isset($state) && $state == "true"){
?>
<div class="entry-box">
<h2><span>*</span>スレッド投稿フォーム</h2>
<p>以下の項目を入力し、「投稿」ボタンを選択してください。</p>
<form method="post" action="index.php?action=check" name="fm1">
<table class="entry">
<tr>
  <th>ニックネーム</th>
  <td><input type="text" size="20" value="<?php if(isset($nickname)){ echo $nickname; } ?>" name="nickname" disabled="disabled" /></td>
</tr>
<tr>
  <th>タイトル</th>
  <td><input type="text" size="45" value="<?php if(isset($title)){ echo $title; } ?>" name="title" /><br />
  <p class="err-txt">
  <?php
    if(isset($err1) && $err1 != ""){
		echo $err1;
	}
  ?>
  </p>
  </td>
</tr>
<tr>
  <th>スレッド本文</th>
  <td><textarea name="comment" cols="40" rows="10"><?php if(isset($comment)){ echo $comment; } ?></textarea><br />
  <p class="err-txt">
  <?php
    if(isset($err2) && $err2 != ""){
		echo $err2;
	}
  ?>
  </p>
  </td>
</tr>
<tr>
  <th colspan="2"><input type="checkbox" name="preview" <?php if(isset($preview)){ echo $preview; } ?> /> プレビューする （投稿前に、内容をプレビューして確認できます）</th>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="submit" value="投稿" />　<input type="button" value="クリア" onClick="" />
</div>
</form>
</div><!-- /entry-box -->
<?php
}else{
?>
<div class="login-note">
<h2><span>*</span>ログインをする必要があります</h2>
<br />
<a href="../login/index.php"> > ログインはこちら</a>
</div>
<?php
}
?>
</div><!-- /main -->
</body>
</html>