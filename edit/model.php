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

		$thumbnail = $_SESSION["join"]["thumbnail"];
		$original = $_SESSION["join"]["original"];
		$old_thumbnail = $_SESSION["join"]["old_thumbnail"];
		$old_original = $_SESSION["join"]["old_original"];

		if(($thumbnail == "none") && ($original == "none")){
			//画像がない（消した）
			$img_flg = false;
			
			if(($old_thumbnail === "none") && ($old_original === "none")){
				$del_fig = false;
			}else{
				$del_fig = true;
			}
			
		}else if(($thumbnail === $old_thumbnail) && ($original === $old_original)){
			//何もしていない
			$img_flg = false;
			$del_fig = false;
		}else{
			//画像が新しくなった → 前の画像を消す
			$img_flg = true;
			$del_fig = true;
		}
		
		//画像のアップロード
		if($img_flg == true){
			$up_img = new uploadImgFile();
			$up_img->fileUpload($thumbnail,$original,$board_id, $res_id);
			$image_file_t = $up_img->img_path_t;
			$image_file_o = $up_img->img_path_o;
		}else{
			$image_file_t = $thumbnail;
			$image_file_o = $original;
		}

		//データベースクラスのインスタンス化
		$db = new dbAccess();
		
		$strSQL = "UPDATE comment".
		          " SET contents = :comment,".
				  " image_file_t = :image_file_t,".
				  " image_file_o = :image_file_o".
		          " WHERE board_id = :board_id".
				  " AND res_id = :res_id";

		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':comment',$comment);
		$stmt->bindValue(':image_file_t',$image_file_t);
		$stmt->bindValue(':image_file_o',$image_file_o);
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		
		//SQL実行
		$db->execute();

		//データベース切断
		$db->db_cut($db);
		
		if($del_fig == true){
			//消しに行くよ！
				$up_img = new uploadImgFile();
				$del_flg = $up_img->fileDelete($old_original,$old_thumbnail);
		}
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
			
			//画像削除
			imageDelete($db,$board_id,$res_id);

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
			
			//画像削除
			imageDelete($db,$board_id,$res_id);
						
			//del_flgに1を立てる
			$strSQL = "UPDATE comment".
			          " SET image_file_t = :image_file_t,".
					  " image_file_o = :image_file_o,".
					  " del_flg = :del_flg".
			          " WHERE board_id = :board_id".
					  " AND res_id = :res_id";

			//SQL文準備
			$stmt = $db->preparation($strSQL);

			$stmt->bindValue(':image_file_t','none');
			$stmt->bindValue(':image_file_o','none');
			$stmt->bindValue(':del_flg',1,PDO::PARAM_INT);
			$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
			$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);

			//SQL実行
			$db->execute();
		}
		
		//データベース切断
		$db->db_cut($db);
	}

function imageDelete($db,$board_id,$res_id){

	//画像削除
	$up_img = new uploadImgFile();

	if($res_id == 0){

		//該当データ抽出
		$strSQL = "SELECT image_file_t,image_file_o FROM comment".
		          " WHERE board_id = :board_id".
				  " AND image_file_t != :image_file_t";
	
		//SQL文準備
		$stmt = $db->preparation($strSQL);
	
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':image_file_t','none');

		//SQL実行
		$db->execute();
	
		while($row = $db->fetch()){
	
			$thumbnail = $row["image_file_t"];
			$original = $row["image_file_o"];

			$del_flg = $up_img->fileDelete($original,$thumbnail);
			
			if($del_flg == false){
				echo "削除できませんでした。";
				exit();
			}
		}

	}else{

		//該当データ抽出
		$strSQL = "SELECT image_file_t,image_file_o FROM comment".
		          " WHERE board_id = :board_id".
		          " AND res_id = :res_id".
				  " AND image_file_t != :image_file_t";
	
		//SQL文準備
		$stmt = $db->preparation($strSQL);
	
		$stmt->bindValue(':board_id',$board_id,PDO::PARAM_INT);
		$stmt->bindValue(':res_id',$res_id,PDO::PARAM_INT);
		$stmt->bindValue(':image_file_t','none');

		//SQL実行
		$db->execute();

		if($db->rowCount() == 1){

			$row = $db->fetch();
			$thumbnail = $row["image_file_t"];
			$original = $row["image_file_o"];

			$del_flg = $up_img->fileDelete($original,$thumbnail);
			
			if($del_flg == false){
				echo "削除できませんでした。";
				exit();
			}
		}
	}
		
	$stmt = null;
}

?>
