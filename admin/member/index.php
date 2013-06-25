<?php
	session_start();

	require_once("../../class.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//会員一覧取得
			$db = new dbAccess;
			$stmt = makeMemberList($db);
			//表示
			require_once("list.php");
			$db->db_cut($db);
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