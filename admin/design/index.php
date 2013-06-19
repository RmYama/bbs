<?php
	session_start();

	require_once("../../class.php");
	require_once("../adminclass.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState;
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter;
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//画面レイアウト
			require_once("design.php");
			break;

		case "update":
			//更新
			$tag_header = siteLayoutUpdate();
			require_once("design.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}
?>