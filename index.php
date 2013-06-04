<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>掲示板</title>
<script language="JavaScript">
<!--
//詳細画面へ移動
function Detail(id){
	document.fm2.id.value = id;
	document.fm2.action = "detail.php";
	document.fm2.submit();
}

-->
</script>
</head>
<body>
<div id="main">
<h1>*** 掲示板 ***</h1>
<?php 

  require_once("common/dataChk.php");
  require_once("common/db.php");
  require_once("common/sql.php");

  //投稿ボタンチェック
  if(isset($_POST['submit']) && $_POST['submit']=='投稿'){

    //値の代入
    $name = $_POST['name'];
    $title = $_POST['title'];
    $contents = $_POST['contents'];
    $key = $_POST['key'];
		
    //入力チェック
	$err_flg = 0;
	$err_msg = array();

	if(required($name) == false){
		$err_msg[$err_flg] = '<p class="err">ニックネームを入力してください。</p>';
		$err_flg += 1;
	}

	if(required($title) == false){
		$err_msg[$err_flg] = '<p class="err">タイトルを入力してください。</p>';
		$err_flg += 1;
	}
	
 	if(required($contents) == false){
		$err_msg[$err_flg] = '<p class="err">コメントを入力してください。</p>';
		$err_flg += 1;
	}
	
	if(required($key) == false){
		$err_msg[$err_flg] = '<p class="err">編集／削除キーを入力してください。</p>';
		$err_flg += 1;

	}else{

	  //半角数字かチェック
	  if(preg_match("/^[0-9A-Za-z]+$/", $key)){
	    //文字数チェック
	    if(strNumChk($key) == False){
	      $err_msg[$err_flg] = '<p class="err">編集／削除キーの文字数は4文字～8文字で入力してください。</p>';
	      $err_flg += 1;
	    }
	  }else{
	    $err_msg[$err_flg] = '<p class="err">編集／削除キーは半角英数字のみで入力してください。</p>';
	    $err_flg += 1;
	  }
    }

	if($err_flg == 0){	
	  //セッションに値を保存
	  $_SESSION['join'] = $_POST;
	  var_dump($_SESSION['join']);
      header('Location: check.php');

	}else{
	  echo '<div class="err-box">';
	  echo '<p>エラーです。以下を確認してください。</p>';
	  foreach($err_msg as $value){
	    echo $value;
	  }
	  echo '</div>';
	}
  }
?>
<div class="entry-box">
<h2><span>*</span>スレッド投稿フォーム</h2>
<p>※が付いている項目は入力必須項目です。</p>
<form method="post" action="index.php" name="fm1">
<table class="entry">
<tr>
  <th>ニックネーム<span class="case">※</span></th>
  <td>
<?php
   if(isset($name) == true && $name != ""){
     echo '<input type="text" size="30" name="name" value="'.$name.'" />';
   }else{
     echo '<input type="text" size="30" name="name" />';
   }
?>
  </td>
</tr>
<tr>
  <th>タイトル<span class="case">※</span></th>
  <td>
<?php
   if(isset($title) == true && $title !=""){
     echo '<input type="text" size="45" name="title" value="'.$title.'" />';
   }else{
     echo '<input type="text" size="45" name="title" />';
   }
?>
  </td>
</tr>
<tr>
  <th>コメント<span class="case">※</span></th>
  <td>
<?php
   if(isset($contents) == true && $contents != ""){
     echo '<textarea name="contents" rows="7" cols="42">'.$contents.'</textarea>';
   }else{
     echo '<textarea name="contents" rows="7" cols="42"></textarea>';
   }
?>
  </td>
</tr>
<tr>
  <th>編集／削除キー<span class="case">※</span></th>
  <td>
<?php
   if(isset($key) == true && $key != ""){
     echo '<input type="password" size="10" name="key" value="'.$key.'" />';
   }else{
     echo '<input type="password" size="10" name="key" />';
   }
?>
    <span class="note">　（半角英数字のみで４～８文字）</span>
  </td>
</tr>
<tr>
  <th colspan="2">
<?php
   if(isset($_POST["preview"]) == true){
     echo '<input type="checkbox" name="preview" id="btn-check" class="check" value="0" checked="checked" />';
   }else{
     echo '<input type="checkbox" name="preview" id="btn-check" class="check" value="0" />';
   }
   
?>
   <label for="btn-check">プレビューする （投稿前に内容をプレビューして確認できます）</label>
  </th>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="submit" value="投稿" />　<input type="reset" value="クリア" />
</div>
</form>
</div><!-- /entry-box -->
<div class="bbs-box">
<h2><span>*</span>スレッド一覧</h2>
<form method="post" action="detail.php" name="fm2">
<input type="hidden" name="id" value="" />
</form>
<?php

  //データベース接続
  $dbh = db_link();

  //boardに登録されているデータ全取得
  $stmt = get_allData_board($dbh);


  echo '<table class="thread">';
  echo '<tr>';
	echo '<th>No.</th>';
	echo '<th>title</th>';
	echo '<th>&nbsp;</th>';
  echo '</tr>';

  //boardデータ全件出力
  while($result = $stmt->fetch(PDO::FETCH_BOTH)){
    echo '<tr>';
	echo '<td>'.$result['id'].'</td>';
	echo '<td class="title">'.$result['title'].'</td>';
	echo '<td class="btn"><input type="button" value="詳細" onClick="Detail('.$result['id'].')" /></td>';
    echo '</tr>';
  }
  echo '</table>';
 
  //データベース切断
  db_cut($dbh);
?>
</div><!-- /bbs-box -->
</div><!-- /main -->
</body>
</html>