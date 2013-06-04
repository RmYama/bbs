<?php

	 //データベース
	 require_once("login_model.php");

	//値の取得
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];

	//入力チェック	
	$err = array();
	$err_flg = 0;

	//ログイン名
	if(empty($user_name) or $user_name == ""){
		$err[$err_flg] = "ログインIDを入力してください。";
		$err_flg += 1;
	}
	
	//パスワード
	if(empty($password) or $password == ""){
		$err[$err_flg] = "パスワードを入力してください。";
		$err_flg += 1;
	}

	//入力エラーがなかったらユーザーチェック
	if($err_flg == 0){
		chk_user($user_name, $password);
	}



?>
