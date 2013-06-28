<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/list.css">
<title>掲示板</title>
<script type="text/javascript" src="../js/fcontrol.js"></script>
</head>
<body>
<div id="header">
<h1><span>*</span> 掲示板 <span>*</span></h1>
<div class="btn-menu">
<ul>
  <li><a href="../index.php">トップページ</a></li>
  <li><a href="../signup/index.php">新規登録</a></li>
<?php
 if($state == "true"){ ?>
  <li><a href="../login/index.php?action=logout">ログアウト</a></li>
<?php }else{ ?>
  <li><a href="../login/index.php">ログイン</a></li>
<?php } ?>
</ul>
</div><!-- /btn-menu -->
</div><!-- /header -->
<div id="main">
<div class="nav">
<a href="../index.php"><< 前の画面に戻る</a>
</div>
<div class="list-box">
<h2><span>*</span><?php echo $title ?></h2>
<ul class="list">
<?php
if($flg == true){
	while($row = $db->fetch()){
		$c_id = $row["c_id"];
		$board_id = $row["board_id"];
		$res_no = $row["res_id"];
		$writer_id = $row["writer_id"];
		$contents = $row["contents"];
		$add_time = $row["add_time"];
		$writer = $row["writer"];
		$thumbnail = $row["thumbnail"];
		$original = $row["original"];
		$del_flg = $row["del_flg"];

		if($res_no == 0){
			//スレッド
?>
			<li class="thread">
			  <p class="text"><?php echo nl2br($contents) ?></p>
<?php
		if($thumbnail !== "none"){
?>
			  <p class="img"><a href="<?php echo $original ?>" target="_blank"><img src="<?php echo $thumbnail ?>" /></a></p>
<?php 
		}
?>
			  <p class="info"><span class="name"><?php echo $writer ?></span>　<span class="time"><?php echo $add_time ?></span></p>
<?php
			if(isset($user_id) && $user_id == $writer_id){
?>
				  <div class="links"><a href="../edit/index.php?action=edit&no=<?php echo $res_no ?>">編集/削除</a></div>
<?php 
			}
?>
			</li>
<?php
		}else{
			//レス
?>
			<li class="res">
<?php
			if($del_flg != 1){
?>
			  <p class="info">[<?php echo $res_no ?>] <span class="name"><?php echo $writer ?></span>　<span class="time"><?php echo $add_time ?></span></p>
			  <p class="text"><?php echo nl2br($contents) ?></p>
<?php
		if($thumbnail !== "none"){
?>
			  <p class="img"><a href="<?php echo $original ?>" target="_blank"><img src="<?php echo $thumbnail ?>" /></a></p>
<?php 
		}
?>
<?php
			  if(isset($nickname) && $nickname == $writer){
?>
			    <div class="links"><a href="../edit/index.php?action=edit&no=<?php echo $res_no ?>">編集/削除</a></div>
<?php
			  }

			}else{
?>
			  <p class="info">[<?php echo $res_no ?>] <span class="name">---</span>　<span class="time"><?php echo $add_time ?></span></p>
			  <p class="text">このレスは削除されました。</p>
<?php
			}
?>
			</li>
<?php
		}
	}
}
?>
</ul><!-- /list -->
</div><!-- /list-box -->
<?php
if(isset($state) && $state == "true"){
?>
<div class="entry-box">
<h2><span>*</span>レス投稿フォーム</h2>
<p>以下の項目を入力し、「投稿」ボタンを選択してください。</p>
<form method="post" action="index.php?action=check" name="fm1" enctype="multipart/form-data">
<input type="hidden" name="no" value ="<?php if(isset($no)){ echo $no; } ?>" />
<table class="entry">
<tr>
  <th>ニックネーム</th>
  <td><input type="text" size="45" value="<?php if(isset($nickname)){ echo $nickname; } ?>" name="nickname" disabled="disabled" /></td>
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
  <th>画像</th>
  <td>
<?php
if(isset($image_file_t) && $image_file_t != "none"){
?>
  <input type="file" size="43" name="image_file" disabled="disabled" />
  <p style="color:#FF0000; font-size:13px;">※画像を変更したい場合は先にアップロードした画像を削除してください。</p>
<?php }else{ ?>  
  <input type="file" size="43" name="image_file" />
<?php } ?>  
  <p class="err-txt">
  <?php
    if(isset($err2) && $err2 != ""){
		echo $err2;
	}
  ?>
  </p>
<?php 
if(isset($image_file_t)){
?>
  <div><img src="<?php echo $image_file_t; ?>" /><br />
  <p style="line-height:1.8;"><a style="color:#FF0000; font-size:14px;" href="index.php?action=imageDel">削除</a></p>
  </div>
<?php
}
?>
<?php 
if(isset($del_flg) && $del_flg === true){
?>
<p style="color:#FF0000; font-size:14px;">画像を削除しました。</p>
<?php
}
?>
  </td>
</tr>
<tr>
  <th colspan="2"><input type="checkbox" name="preview" <?php if(isset($preview)){ echo $preview; } ?> /> プレビューする （投稿前に、内容をプレビューして確認できます）</th>
</tr>
</table>
<div class="btn-area">
<input type="submit" name="submit" value="投　稿" />　<input type="button" onClick="clearFormAll();" value="クリア" />
</div>
</form>
</div><!-- /entry-box -->
<?php
}else{
?>
<div class="login-note">
<h2><span>*</span>レスを投稿するにはログインをする必要があります</h2>
<br />
<a href="../login/index.php?page=list"> > ログインはこちら</a>
</div>
<?php
}
?>
</div><!-- /main -->
</body>
</html>