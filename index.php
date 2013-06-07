<?php

	require_once("class.php");
	require_once("model.php");

	//アクションの判定をする
	if(array_key_exists("action", $_GET)){
		$action = $_GET["action"];
	}else{
		$action = "";
	}


	switch($action){
		case "":
			//初期表示
			//クラスのインスタンス化
			$db= new dbAccess;
		
			//データベース接続
			$link = $db->db_link();
			
			$result = listNewThread($link);
			
			require_once("top.php");

			//データベース切断
			$db->db_cut($link);

			break;
			
		default:
			echo "actionの異常エラー";
			break;
	}
