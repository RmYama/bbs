<?php
	//一覧表示画面(model)

	//該当データ抽出
	function makeList($db,$board_id){
	
		$result = array();

		$result["flg"] = false;
		
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
		$result["title"] = $row["title"];

		//該当レス全件取得
		$strSQL ="SELECT a.id as c_id, a.board_id as board_id, a.res_id as res_id, a.user_id as writer_id,".
		         " a.contents as contents, a.created_at as add_time, a.del_flg as del_flg,".
				 " b.nickname as writer".
		         " FROM comment as a, users as b".
				 " WHERE a.user_id = b.id".
				 " AND  a.board_id = :board_id".
				 " ORDER BY res_id asc";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		$result["flg"] = true;
			
		return $result;
	}

	//レス投稿
	function makeRes(){
		
		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$board_id = $_SESSION["join"]["board_id"];
		$comment = $_SESSION["join"]["comment"];
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;

		//res_idの最大値取得
		$strSQL = "SELECT MAX(res_id) as res_id FROM comment".
		          " WHERE board_id = :board_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();
		
		//値の取得
		$row = $db->fetch();
		$res_id = $row["res_id"];

		//res_id + 1
		$res_id +=1;
		
		//commentテーブルに新規追加
		$strSQL2 = "INSERT INTO comment(board_id,res_id,user_id,contents,del_flg)".
		           " VALUES (:board_id, :res_id, :user_id, :comment, :del_flg)";

		//SQL文準備
		$stmt = $db->preparation($strSQL2);

		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		$stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->bindValue(':comment',$comment);
		$stmt->bindValue(':del_flg',0,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);

	}
	
	//スレッドタイトル取得
	function selectTitle($db){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		
		$strSQL = "SELECT title FROM board".
		          " WHERE id = :board_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//値の取得
		$row = $db->fetch();
		$result = $row["title"];
		
		return $result;

	}

	//レス取得
	function selectRes($db){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];
		
		$strSQL = "SELECT contents FROM comment".
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
		$result = $row["contents"];
		
		return $result;
	
	}

	//修正
	function updateRes(){

		//セッションから値を取得
		$board_id = $_SESSION["join"]["board_id"];
		$res_id = $_SESSION["join"]["res_id"];
		$comment = $_SESSION["join"]["comment"];

		//データベースクラスのインスタンス化
		$db = new dbAccess;
		
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
		$db = new dbAccess;
		
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
