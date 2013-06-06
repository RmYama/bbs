<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="login.css">
<title>掲示板 -ログイン画面- </title>
</head>
<body id="login">
<div id="main">
<h1>*** ログイン画面 ***</h1>
<h2><span>*</span>ログイン</h2>
<p class="txt">IDとパスワードを入力して「ログイン」ボタンを押してください。</p>
<p class="err-txt" style="text-align: center; font-size:16px;">
  <?php
    if(isset($err3) && $err3 != ""){
		echo $err3;
	}
  ?>
</p>
<form method="post" action="index.php?action=check" name="fm1">
<table>
<tr>
  <th>ログイン名</th>
  <td><input type="text" size="35" name="user_name" value="<?php if(isset($user_name)){ echo $user_name; } ?>"  />
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
  <th>パスワード</th>
  <td><input type="password" size="35" name="password" value ="<?php if(isset($password)){ echo $password; } ?>" />
  <p class="err-txt">
  <?php
    if(isset($err2) && $err2 != ""){
		echo $err2;
	}
  ?>
  </p>
</td>
</tr>
</table>
<div class="btn-area">
<input type="submit" value="ログイン" />　<input type="reset" value="リセット" />
</div>
</form>
</div><!-- /main -->
</body>
</html>