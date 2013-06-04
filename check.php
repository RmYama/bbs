<?php
	session_start();
if (!isset($_SESSION['join'])) {
    header('Location: index.php');
	exit();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>掲示板</title>
</head>
<body>
<div id="main">
<h1>*** 確認画面 ***</h1>
<?php 

  require_once("common/db.php");
  require_once("common/sql.php");

    //値の代入
    $name = $_SESSION['join']['name'];
    $title =  $_SESSION['join']['title'];
    $contents =  $_SESSION['join']['contents'];
    $key =  $_SESSION['join']['key'];

	if(isset($_SESSION['join']['preview']) == false){
	  //プレビューしないでデータを登録する

	  //スレッド新規登録
	  make_thread($name, $title, $contents, $key);

     //セッション破棄
	 unset($_SESSION['join']);
	   
	 echo '投稿が完了しました。';

	}else{
	
?>
<div class="entry-box">
<h2><span>*</span>確認</h2>
<p>入力内容のご確認をお願い致します<br />
ご確認の上、お間違いが無ければ「投稿」ボタンを押してください。</p>
<form method="post" action="check.php" name="fm1">
<table class="entry">
<tr>
  <th>ニックネーム</th>
  <td><?php echo $name; ?></td>
</tr>
<tr>
  <th>タイトル</th>
  <td><?php echo $title; ?></td>
</tr>
<tr>
  <th>コメント</th>
  <td><?php echo $contents; ?></td>
</tr>
<tr>
  <th>編集／削除キー</th>
  <td><?php echo $key; ?></td>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="submit" value="投稿" />　<input type="button" value="書き直す" />
</div>
</form>
</div><!-- /entry-box -->
<?php } ?>
</div><!-- /main -->
</body>
</html>