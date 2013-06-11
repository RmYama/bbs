<?php

	//ログインチェック(model)

	//データベースに登録
	function chk_user($user_name,$password){
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		//ユーザーチェック
		$strSQL  = '';
		$strSQL  = 'SELECT * FROM users';
		$strSQL .= ' WHERE user_name = "'.$user_name.'"';
		$strSQL .= ' AND password = "'.$password.'"';
		
		//SQL実行
		$db->sql($strSQL);

		if(mysqli_num_rows($db->cur_rec) == 1){
			//idとニックネームをセッションで保持

			$row = $db->fetch_array();

			$_SESSION["users"]["user_id"] = $row["id"];
			$_SESSION["users"]["nickname"] = $row["nickname"];
			$user_flg = "success";

		}else{
			$user_flg = "error";

		}
		
		//データベース切断
		$db->db_cut();
		
		return $user_flg;
	}

?>
