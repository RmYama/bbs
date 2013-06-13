<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="list.css">
<title>掲示板</title>
<script language="JavaScript">
<!--
function Del(){
	document.fm1.action = "index.php?action=delCheck";
	document.fm1.submit();
}
-->
</script>
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
<div class="nav">
<a href="index.php?action=list&no=<?php echo $_SESSION["join"]["board_id"]; ?>"><< 前の画面に戻る</a>
</div>
<div class="entry-box">
<h2><span>*</span>編集フォーム</h2>
<p style="padding-left:30px;">修正を行う場合は、以下の項目を編集し「修正」ボタンを選択してください。<br />
削除を行う場合は、「削除」ボタンを選択してください。削除ボタンを選択すると確認画面へ移動します。<br />
<span style="color:red;">※スレッドのタイトルやニックネームの変更は出来ません。</span>
</p>
<form method="post" action="index.php?action=editCheck" name="fm1">
<table class="entry">
<?php if($res_id == 0){ ?>
<tr>
  <th>タイトル</th>
  <td><?php if(isset($title)){ echo $title; } ?><input type="hidden" name="title" value="<?php if(isset($title)){ echo $title; } ?>" /></td>
</tr>
<?php } ?>
<tr>
  <th>ニックネーム</th>
  <td><?php if(isset($nickname)){ echo $nickname; } ?></td>
</tr>
<tr>
  <th>レス本文</th>
  <td><textarea name="comment" cols="45" rows="8"><?php if(isset($comment)){ echo $comment; } ?></textarea><br />
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
  <th colspan="2"><input type="checkbox" name="preview" <?php if(isset($preview)){ echo $preview; } ?> /> プレビューする （投稿前に、内容をプレビューして確認できます）</th>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="btn_edit" value="修正" />　<input type="button" name="btn_del" value="削除" onClick="Del();" />
</div>
</form>
</div><!-- /entry-box -->
</div><!-- /main -->
</body>
</html>