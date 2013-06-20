<?php
	session_start();

	require_once("../../class.php");
	require_once("../adminclass.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//会員一覧
			
			
			//リスト作成
			
			
			
			require_once("list.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}

	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove();
		$move->pagename = $pagename;
		$move->redirect();

	}

?>