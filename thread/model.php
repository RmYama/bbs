<?php
	//新規スレッドDB登録(model)
	
	require_once("../common/db.php");

	function make_thread(){

		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$title = $_SESSION["join"]["title"];
		$comment = $_SESSION["join"]["comment"];
		
		//データベース接続
		$link = db_link();
		
		//boardテーブルに新規追加とidの取得
		$board_id = board_insert($link,$title);
		
		//commentテーブルに新規追加
		comment_insert($link, $board_id, $user_id, $comment);
		
		//データベース切断
		db_cut($link);
	
	}

	//boardテーブルに新規追加とidの取得
	function board_insert($link,$title){
	
		//SQLインジェクション対策
		$title = mysqli_real_escape_string($link,trim($title));

		$strSQL = 'INSERT INTO board(title)'.
		          ' VALUES ("'.$title.'")';
		$result = mysqli_query($link, $strSQL);
		
		if(!$result){
			die("スレッドの新規作成に失敗しました（１）".mysqli_error());
		}

		//idの取得
		$board_id = mysqli_insert_id($link);
		
		return $board_id;
	}

	//commentテーブルに新規追加
	function comment_insert($link, $board_id, $user_id, $comment){
		
		//SQLインジェクション対策
		$comment = mysqli_real_escape_string($link,trim($comment));
 
		$strSQL = 'INSERT INTO comment(board_id, res_id, user_id, contents)'.
		          ' VALUES ('.$board_id.',0,'. $user_id .',"'.$comment.'")';
		$result = mysqli_query($link, $strSQL);
	
		if(!$result){
			die("スレッドの新規作成に失敗しました（３）".mysqli_error());
		} 
	}


	
?>