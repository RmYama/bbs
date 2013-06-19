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
			//ログイン画面表示

			break;

		case "menu":
			//管理メニュー

		default:
			echo "actionの異常エラー";
			break;
	}
?>