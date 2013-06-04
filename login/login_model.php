<?php

	//データベースに登録
	require_once("../common/db.php");
	require_once("../common/sql.php");

	function chk_user($user_name,$password){
	 
	  //データベース接続
	  $dbh = db_link();

	  //ユーザーチェック
	  $strSQL  = '';
	  $strSQL  = 'SELECT * FROM users';
	  $strSQL .= ' WHERE user_name = "'.$user_name.'"';
	  $strSQL .= ' AND password = "'.$password.'"';
	  
	  $stmt = $dbh->query($strSQL);
	  $result = $stmt->rowCount());
	  
	  //データベース切断
	  db_cut($dbh);

	  return $result;
	
	}

?>
