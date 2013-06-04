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
<p>IDとパスワードを入力して「ログイン」ボタンを押してください。</p>
<form name="fm1" action="login_control.php" method="post">
<table>
<tr>
  <th>ログイン名</th>
  <td><input type="text" size="35" name="user_name" /></td>
</tr>
<tr>
  <th>パスワード</th>
  <td><input type="password" size="35" name="password" /></td>
</tr>
</table>
<div class="btn-area">
<input type="submit" value="ログイン" />　<input type="reset" value="リセット" />
</div>
</form>
</div><!-- /main -->
</body>
</html>