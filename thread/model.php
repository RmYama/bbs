<?php
	//新規スレッドDB登録(model)

	function makeThread(){

		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$title = $_SESSION["join"]["title"];
		$comment = $_SESSION["join"]["comment"];
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
		//boardテーブルに新規追加
		$strSQL = "INSERT INTO board(title) VALUES (:title)";

		//SQL文準備
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':title',$title);

		//SQL文実行
		$db->execute();

		//idの取得
		$board_id = $db->lastInsertId();

		$strSQL2 = "INSERT INTO comment(board_id, res_id, user_id, contents, del_flg)".
		           " VALUES (:board_id, :res_id, :user_id, :contents, :del_flg)";

		//SQL文準備
		$stmt = null;
		$stmt = $db->preparation($strSQL2);

		$stmt->bindValue(':board_id',$board_id);
		$stmt->bindValue(':res_id',0,PDO::PARAM_INT);
		$stmt->bindValue(':user_id',$user_id);
		$stmt->bindValue(':contents',$comment);
		$stmt->bindValue(':del_flg',0,PDO::PARAM_INT);

		//SQL文実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);
	}

?>