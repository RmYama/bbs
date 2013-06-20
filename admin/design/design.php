<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<title>掲示板 -管理画面- </title>
</head>
<body id="login">
<div id="header">
<h1><span>*</span> レイアウト設定 <span>*</span></h1>
</div><!-- /header -->
<div class="nav" style="margin: 0 auto; width: 780px; padding:6px 0; border-bottom:1px solid #CCCCCC;">
　<a href="../index.php"><< 前の画面に戻る</a>
</div>
<div id="main">
<h2>背景設定</h2>
<div class="color">
<label>背景色：</label><input type="text" /><br />
<label>背景画像：</label><input type="file" /><br />
</div>
<form name="design" action="index.php?action=check" method="post">
<h2>ヘッダーエリア</h2>
<textarea name="tag_header" rows="8" style="width:95%;"><?php if(isset($tag_header)){ echo $tag_header; } ?></textarea>
<br />
<br />
<h2>フッタエリア</h2>
<textarea name="tag_footer" rows="8" style="width:95%;"><?php if(isset($tag_footer)){ echo $tag_footer; } ?></textarea>
<br />
<br />
<div class="btn-area">
<input type="submit" name="submit" value="設定を更新する" />
</div>
</form>
<br />
<br />
</div><!-- /main -->
</body>
</html>