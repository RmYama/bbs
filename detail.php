<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>掲示板</title>

<script language="JavaScript">
<!--
function Edit(id,mode){
	document.fm1.id.value = id;
	document.fm1.mode.value = mode;
	document.fm1.action = "edit.php";
	document.fm1.submit();
}
-->
</script>
</head>
<body>
<?php 

  require_once("common/db.php");
  require_once("common/sql.php");

  //値の取得
  $id = $_POST['id'];

  //データベース接続
  $dbh = db_link();
	
  //データ抽出
  //boardテーブルから該当のデータを取得
  $stmt = get_selectData_board($dbh,$id);
  $result = $stmt->fetch(PDO::FETCH_BOTH);
  
  $thread_id = $result['id'];
  $title = $result['title'];
  $thread_time = $result['created_at'];
  
  //初期化
  $stmt=null;
  
  //データベース切断
  db_cut($dbh);

?>
<div id="main">
<h1>*** 詳細画面 ***</h1>
<h2><span>*</span><?php echo $title; ?><span class="t-time">作成日：<?php echo $thread_time; ?></span></h2>
<form name="fm1" method="post" action="edit.php" />
<div class="btn-area-top">
<input type="button" onClick="Edit(0,0);" value="コメントする！" />
</div>
<table class="thread">
<tr>
  <th>No</th>
  <th>コメント</th>
  <th>日付</th>
  <th>&nbsp;</th>
<tr>
<?php
  //ccommentテーブルからスレッドの該当データ抽出
  $stmt = comment_selectData_board($dbh,$id);

  //データ出力
  while($result = $stmt->fetch(PDO::FETCH_BOTH)){
    
	//変数に代入
	$res_id = $result['id'];
	$contents = nl2br($result['contents']);
	$res_time = $result['created_at'];

    echo '<tr>';
    echo '<td class="id">'.$res_id.'</td>';
    echo '<td class="comment">'.$contents.'</td>';
    echo '<td class="date">'.$res_time.'</td>';
    echo '<td class="btn-edit"><input type="button" name="" onClick="Edit('.$res_id.',1)" value="編集" /></td>';
    echo '</tr>';
  }
?>
</table>
<input type="hidden" name="id" value="" />
<input type="hidden" name="mode" value="" />
</form>
<div class="link-area">
<a href="index.php"><< 戻る</a>
</div>
</div><!-- /main -->
</body>
</html>