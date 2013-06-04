<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>掲示板</title>
</head>
<body>
<?php 
  require_once("index_control.php");
?>
<div id="main">
<h1>*** 掲示板 ***</h1>
<h2><span>*</span>新着スレッド</h2>
<table class="thread">
<tr>
  <th>No.</th>
  <th>title</th>
  <th>&nbsp;</th>
</tr>



</div><!-- /bbs-box -->
</div><!-- /main -->
</body>
</html>