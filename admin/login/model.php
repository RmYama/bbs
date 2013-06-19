<?php

	//ログインチェック(model)

	function chkUser($user_name,$password){
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		//ユーザーチェック
		$strSQL  = "SELECT * FROM users".
		           " WHERE user_name = :user_name".
		           " AND password = :password";

		//SQL文準備
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':user_name',$user_name);
		$stmt->bindValue(':password',$password);

		//SQL実行
		$db->execute();

		if($db->rowCount() == 1){
			//idとニックネームをセッションで保持

			$row = $db->fetch();

			$_SESSION["users"]["user_id"] = $row["id"];
			$_SESSION["users"]["nickname"] = $row["nickname"];
			$user_flg = "success";
			
		}else{
			$user_flg = "error";

		}
		
		//データベース切断
		$db->db_cut($db);
		
		return $user_flg;
	}

?>
