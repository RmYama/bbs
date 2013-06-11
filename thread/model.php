<?php
	//新規スレッドDB登録(model)

	function make_thread(){

		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$title = $_SESSION["join"]["title"];
		$comment = $_SESSION["join"]["comment"];
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;

		//SQLインジェクション対策
		$title = $db->injection($title);
		$comment = $db->injection($comment);
		
		//boardテーブルに新規追加
		$strSQL = 'INSERT INTO board(title)'.
		          ' VALUES ("'.$title.'")';

		//SQL文実行
		$db->sql($strSQL);
		
		//idの取得
		$board_id = mysqli_insert_id($db->link);

		//commentテーブルに新規追加
		$strSQL2 = 'INSERT INTO comment(board_id, res_id, user_id, contents)'.
		           ' VALUES ('.$board_id.',0,'. $user_id .',"'.$comment.'")';

		$db->sql($strSQL2);

		//データベース切断
		$db->db_cut();

	}

?>