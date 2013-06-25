<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<title>掲示板 -管理画面- </title>
</head>
<body id="login">
<div id="header">
<h1><span>*</span> 会員管理 <span>*</span></h1>
</div><!-- /header -->
<div id="main">
<h2><span>*</span>登録会員一覧</h2>
<?php 
if($db->rowCount() != 0){
?>
<table>
<tr>
  <th class="btn">削 除</th>
  <th>ユーザーID</th>
  <th>ニックネーム</th>
  <th class="btn">詳 細</th>
</tr>
<?php
	while($row = $db->fetch()){
		$user_name = $row["user_name"];
		$nickname = $row["nickname"];
?>
<tr>
  <td><input type="button" value="削除" onClick="" /></td>
  <td><?php echo $user_name; ?></td>
  <td><?php echo $nickname; ?></td>
  <td><input type="button" value="詳細" onClick="" /></td>
</tr>
<?php
	}
?>
</table>
<?php
}else{
?>
<p>登録ユーザーがいません。</p>
<?php
}
?>
</div><!-- /main -->
</body>
</html>