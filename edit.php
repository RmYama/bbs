<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>掲示板</title>

</head>
<body>
<?php 

  require_once("common/db.php");
  require_once("common/sql.php");

  //モードとid取得
  $mode = $_POST["mode"];    //モード 0:新規, 1：編集, 2:削除
  $res_id = $_POST["id"];

  //ボタンイベントのチェック
  if(isset($_POST['submit']) || isset($_POST['delete'])){
  
    //モード判定
  
  }else{
  	
	//モード判定
	switch($mode){
		case 1:
		default:
		
	}
	
 
  }
/*
  //送信ボタンチェック
  if(isset($_POST['submit']) && $_POST['submit']=='送信'){

    //入力チェック
	$err_title = 0;
	$err_contents = 0;
	if(!isset($_POST['title']) || $_POST['title']==""){
  		$err_title += 1;		
	}
	
 	if(empty($_POST["contents"])){
  		$err_contents += 1;
	}
	
	if($err_title == 0 && $err_contents == 0){
      //値の取得
      $title = $_POST['title'];
	  $contents = $_POST['contents'];

      //データベース接続
      $dbh = db_link();
	
      //データの追加
      //boardテーブルにINSERT
	  board_insert($dbh,$title);
	
	  //boardテーブルからidの最大取得
	  $max_id = get_board_maxId($dbh);
		
	  //commentテーブルにINSERT
	  comment_insert($dbh,$max_id, $contents);
	
	  //データベース切断
      db_cut($dbh);
	  
	  echo '<script>alert("投稿完了！");</script>';
	}

  }
*/
?>
<div id="main">
<h1>*** 掲示板 ***</h1>
<?php 
if($mode == 0){
  echo '<h2><span>*</span>コメント投稿</h2>';
}else{
  echo '<h2><span>*</span>編集・削除</h2>';
}
?>
<form method="post" action="index.php" name="fm1">
<table class="input-fm">
<tr>
  <th>コメント</th>
  <td>
  <textarea name="contents" rows="7" cols="40"></textarea>
<?php	
	if(isset($err_contents) && $err_contents == 1){
	  echo '<p class="err">コメントを入力してください。</p>';
	}
?>  
  </td>
</tr>
</table>
<div class="btn-area">
<?php 
if($mode == 0){
  echo '<input type="button" name="entry" value="投稿" />';
}else{
  echo '<input type="button" name="edit" value="編集" />　<input type="button" name="delete" onClick="" value="削除" />';
}
?>
</div>
<input type="hidden" value="<?php echo $mode; ?>" name="mode" />
</form>
</div><!-- /main -->
</body>
</html>