<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/thread.css">
<title>掲示板</title>
<script type="text/javascript" src="../js/fcontrol.js"></script>
</head>
<body>
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
<div class="btn-menu">
<ul>
  <li><a href="../index.php">トップページ</a></li>
  <li><a href="../signup/index.php">新規登録</a></li>
<?php
 if($state == "true"){ ?>
  <li><a href="../login/index.php?action=logout">ログアウト</a></li>
<?php }else{ ?>
  <li><a href="../login/index.php">ログイン</a></li>
<?php } ?>
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
<form method="post" action="index.php?action=check" name="fm1" enctype="multipart/form-data">
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
  <th>画像</th>
  <td><input type="file" size="43" name="image_file" />
  <p class="err-txt">
  <?php
    if(isset($err3) && $err3 != ""){
		echo $err3;
	}
  ?>
  </p>
  <div><img src="<?php if(isset($image_path)){ echo $image_path; } ?>" /><br />
  <a href="index.php?action=imageDel">削除</a>
  </div>
  </td>
</tr>
<tr>
  <th colspan="2"><input type="checkbox" name="preview" <?php if(isset($preview)){ echo $preview; } ?> /> プレビューする （投稿前に、内容をプレビューして確認できます）</th>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="submit" value="投稿" />　<input type="button" onClick="clearFormAll();" value="クリア" />
</div>
</form>
</div><!-- /entry-box -->
<?php
}else{
?>
<div class="login-note">
<h2><span>*</span>ログインをする必要があります</h2>
<br />
<a href="../login/index.php?page=thread"> > ログインはこちら</a>
</div>
<?php
}
?>
</div><!-- /main -->
</body>
</html>