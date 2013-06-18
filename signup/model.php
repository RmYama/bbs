<?php

	//ログインチェック(model)

	//データベースに登録
	function chkUser($user_name,$password){
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		//ユーザーチェック
		$strSQL = "SELECT * FROM users".
				  " WHERE user_name = :user_name".
				  " AND password = :password";

		//SQL文準備
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':user_name',$user_name);
		$stmt->bindValue(':password',$password);
		
		//SQL実行
		$db->execute();

		if($db->rowCount() == 1){
			$user_flg = "error";
		}else{
			$user_flg = "success";

		}
		
		//データベース切断
		$db->db_cut($db);
		
		return $user_flg;
	}

	function makeUser($user_name,$nickname,$password){
	
		//データベースクラスのインスタンス化
		$db = new dbAccess;

		$strSQL = "INSERT INTO users (user_name, nickname, password)".
				  " VALUES(:user_name, :nickname, :password)";

		//SQL文準備
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':user_name',$user_name);
		$stmt->bindValue(':nickname',$nickname);
		$stmt->bindValue(':password',$password);

		//SQL実行
		$db->execute();
		
		//データベース切断
		$db->db_cut($db);
	}

?>
