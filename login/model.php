<?php

	//ログインチェック(model)

	//データベースに登録
	require_once("../common/db.php");

	function chk_user($user_name,$password){
	 
	  //データベース接続
	  $link = db_link();

	  //ユーザーチェック
	  $strSQL  = '';
	  $strSQL  = 'SELECT * FROM users';
	  $strSQL .= ' WHERE user_name = "'.$user_name.'"';
	  $strSQL .= ' AND password = "'.$password.'"';
	  $result = mysqli_query($link,$strSQL);

	  if(mysqli_num_rows($result) == 1){
			//idとニックネームをセッションで保持
			$row = mysqli_fetch_array($result);
			$_SESSION["users"]["user_id"] = $row["id"];
			$_SESSION["users"]["nickname"] = $row["nickname"];
			$user_flg = "success";
	  }else{
			$user_flg = "error";
	  }
	  
	  //データベース切断
	  db_cut($link);

	  return $user_flg;
	
	}

?>
