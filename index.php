<?php

	require_once("class.php");
	require_once("model.php");

	//アクションの判定をする
	$getA = new getAction;
	$action = $getA->action($_GET);

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
