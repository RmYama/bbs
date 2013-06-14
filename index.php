<?php
	session_start();

	require_once("class.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState;
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter;
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//初期表示
			//クラスのインスタンス化
			$db= new dbAccess;

			$flg = listNewThread($db);
			
			require_once("top.php");

			//データベース切断
			$db->db_cut();

			break;
			
		default:
			echo "actionの異常エラー";
			break;
	}
