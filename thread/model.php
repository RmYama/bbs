<?php
	//新規スレッドDB登録(model)

	function makeThread(){

		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$title = $_SESSION["join"]["title"];
		$comment = $_SESSION["join"]["comment"];
		
		$img_flg = false;
		if(isset($_SESSION["join"]["thumbnail"]) && $_SESSION["join"]["thumbnail"] != ""){
			$thumbnail = $_SESSION["join"]["thumbnail"];
			$original = $_SESSION["join"]["original"];
			$img_flg = true;
		}

		//データベースクラスのインスタンス化
		$db = new dbAccess();
		
		//boardテーブルに新規追加
		$strSQL = "INSERT INTO board(title) VALUES (:title)";

		//SQL文準備
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':title',$title);

		//SQL文実行
		$db->execute();

		//idの取得
		$board_id = $db->lastInsertId();
		$res_id = (int)0;
		
		//画像のアップロード
		if($img_flg == true){
			$up_img = new uploadImgFile();
			$up_img->fileUpload($thumbnail,$original,$board_id, $res_id);
			$image_file_t = $up_img->img_path_t;
			$image_file_o = $up_img->img_path_o;
		}else{
			$image_file_t = "none";
			$image_file_o = "none";
		}
		
		//commenteテーブルに新規追加
		$strSQL2 = "INSERT INTO comment(board_id, res_id, user_id, contents, image_file_t, image_file_o, del_flg)".
		           " VALUES (:board_id, :res_id, :user_id, :contents, :image_file_t, :image_file_o, :del_flg)";

		//SQL文準備
		$stmt = null;
		$stmt = $db->preparation($strSQL2);

		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		$stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->bindValue(':contents',$comment);
		$stmt->bindValue(':image_file_t',$image_file_t);
		$stmt->bindValue(':image_file_o',$image_file_o);
		$stmt->bindValue(':del_flg',0,PDO::PARAM_INT);

		//SQL文実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);
	}

?>