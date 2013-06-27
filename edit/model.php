<?php
	//編集削除画面(model)
	function getThreadTitle($db){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];

		//タイトル取得
		$strSQL = "SELECT title FROM board".
		          " WHERE id = :board_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();
		
		//値の取得
		$row = $db->fetch();
		$title = $row["title"];
		
		return $title;
	}

	//レス取得
	function getRes($db){

		$result = array();

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];
		
		$strSQL = "SELECT contents, image_file_t, image_file_o FROM comment".
		          " WHERE board_id = :board_id".
				  " AND res_id = :res_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//値の取得
		$row = $db->fetch();
		$result["comment"] = $row["contents"];
		$result["image_file_t"] = $row["image_file_t"];
		$result["image_file_o"] = $row["image_file_o"];
				
		return $result;
	
	}

	//修正
	function updateRes(){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];
		$comment = $_SESSION["join"]["comment"];

		//データベースクラスのインスタンス化
		$db = new dbAccess();
		
		$strSQL = "UPDATE comment".
		          " SET contents = :comment".
		          " WHERE board_id = :board_id".
				  " AND res_id = :res_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':comment',$comment);
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);
	}

	//削除
	function deleteData(){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];

		//データベースクラスのインスタンス化
		$db = new dbAccess();
		
		//レス番号によって処理をわける
		if($res_id == 0){
			//スレッド削除

			//関連するレス削除
			$strSQL = "DELETE FROM comment".
			          " WHERE board_id = :board_id";

			//SQL文準備
			$stmt = $db->preparation($strSQL);

			$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);

			//SQL実行
			$db->execute();
	
			//スレッド削除
			$strSQL2 = "DELETE FROM board WHERE id = :board_id";

			//SQL文準備
			$stmt = $db->preparation($strSQL2);

			$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);

			//SQL実行
			$db->execute();

		}else{
			//レス削除
			
			//del_flgに1を立てる
			$strSQL = "UPDATE comment".
			          " SET del_flg = :del_flg".
			          " WHERE board_id = :board_id".
					  " AND res_id = :res_id";

			//SQL文準備
			$stmt = $db->preparation($strSQL);

			$stmt->bindValue(':del_flg',1,PDO::PARAM_INT);
			$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
			$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);

			//SQL実行
			$db->execute();
		}
		
		//データベース切断
		$db->db_cut($db);
	}
?>
