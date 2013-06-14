<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/signup.css">
<title>掲示板 -ログイン画面- </title>
<script type="text/javascript" src="../js/fcontrol.js"></script>
</head>
<body id="login">
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
<div class="btn-menu">
<ul>
  <li><a href="../index.php">トップページ</a></li>
  <li><a href="index.php">新規登録</a></li>
<?php
 if($state == "true"){ ?>
  <li><a href="../login/index.php?action=logout">ログアウト</a></li>
<?php }else{ ?>
  <li><a href="../login/index.php">ログイン</a></li>
<?php } ?>
</ul>
</div>
<!-- /btn-menu -->
</div><!-- /header -->
<div id="main">
<div class="login-box">
<h2><span>*</span>会員登録</h2>
<p style="padding-bottom:15px; text-align: center;">下記の項目を入力して「登録」ボタンを選択してください。</p>
<p class="err-txt" style="text-align: center; font-size:16px;">
  <?php
    if(isset($err4) && $err4 != ""){
		echo $err4;
	}
  ?>
</p>
<form method="post" action="index.php?action=check" name="fm1">
<table>
<tr>
  <th>ユーザー名</th>
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
  <th>ニックネーム</th>
  <td><input type="text" size="35" name="nickname" value="<?php if(isset($nickname)){ echo $nickname; } ?>"  />
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
  <th>パスワード</th>
  <td><input type="password" size="35" name="password" value ="<?php if(isset($password)){ echo $password; } ?>" />
  <p class="err-txt">
  <?php
    if(isset($err3) && $err3 != ""){
		echo $err3;
	}
  ?>
  </p>
</td>
</tr>
</table>
<div class="btn-area">
<input type="submit" value="登　録" />　<input type="button" onClick="clearFormAll();" value="クリア" />
</div>
</form>
</div><!-- /login-box -->
</div><!-- /main -->
</body>
</html>