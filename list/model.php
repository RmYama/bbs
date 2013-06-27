<?php
	//一覧表示画面(model)

	//スレッドタイトル取得
	function getThreadTitle($db,$board_id){

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

	//該当データ抽出
	function makeList($db,$board_id){
	
		$flg = false;
		
		//該当レス全件取得
		$strSQL ="SELECT a.id as c_id, a.board_id as board_id, a.res_id as res_id, a.user_id as writer_id,".
		         " a.contents as contents, a.created_at as add_time, a.image_file_t as thumbnail, a.image_file_o as original,".
				 " a.del_flg as del_flg,".
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

		$flg = true;
			
		return $flg;
	}

	//レス投稿
	function makeRes(){
		
		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$board_id = $_SESSION["join"]["board_id"];
		$comment = $_SESSION["join"]["comment"];

		$img_flg = false;
		if(isset($_SESSION["join"]["thumbnail"]) && $_SESSION["join"]["thumbnail"] != ""){
			$thumbnail = $_SESSION["join"]["thumbnail"];
			$original = $_SESSION["join"]["original"];
			$img_flg = true;
		}
		
		//データベースクラスのインスタンス化
		$db = new dbAccess();

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

		//commentテーブルに新規追加
		$strSQL2 = "INSERT INTO comment(board_id,res_id,user_id,contents,image_file_t,image_file_o,del_flg)".
		           " VALUES (:board_id, :res_id, :user_id, :comment, :image_file_t, :image_file_o, :del_flg)";

		//SQL文準備
		$stmt = $db->preparation($strSQL2);

		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		$stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
		$stmt->bindValue(':image_file_t',$image_file_t);
		$stmt->bindValue(':image_file_o',$image_file_o);
		$stmt->bindValue(':comment',$comment);
		$stmt->bindValue(':del_flg',0,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);
	}
?>


