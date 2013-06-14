<?php

	//ログインチェック(model)

	//データベースに登録
	function chkUser($user_name,$password){
		
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
			$user_flg = "error";
		}else{
			$user_flg = "success";

		}
		
		//データベース切断
		$db->db_cut();
		
		return $user_flg;
	}

	function makeUser($user_name,$nickname,$password){
	
		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		$strSQL = "INSERT INTO users".
		          " (user_name, nickname, password)".
				  " VALUES('".$user_name."','".$nickname."','".$password."')";

		$db->sql($strSQL);
	
	}

?>
