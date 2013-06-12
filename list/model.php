<?php
	//一覧表示画面(model)

	//該当データ抽出
	function make_list($db,$no){
	
		$result = array();

		$result["flg"] = false;
		
		//タイトル取得
		$strSQL = "SELECT title FROM board".
		          " WHERE id = ".$no;
		
		//SQl実行
		$db->sql($strSQL);
		
		//値の取得
		$row = $db->fetch_array();	
		$result["title"] = $row["title"];

		//レス全件取得
		$strSQL ="SELECT a.id as c_id, a.board_id as board_id, a.res_id as res_id,".
		         " a.contents as contents, a.created_at as add_time, a.del_flg as del_flg,".
				 " b.nickname as writer".
		         " FROM comment as a, users as b".
				 " WHERE a.user_id = b.id".
				 " AND  a.board_id =". $no.
				 " ORDER BY res_id asc";
				 
		//SQL実行
		$db->sql($strSQL);

		$result["flg"] = true;
			
		return $result;
	}

	//レス投稿
	function make_res(){
		
		//セッションから値を取得
		$user_id = $_SESSION["users"]["user_id"];
		$no = $_SESSION["join"]["no"];
		$comment = $_SESSION["join"]["comment"];
		
		//データベースクラスのインスタンス化
		$db = new dbAccess;

		//SQLインジェクション対策
		$comment = $db->injection($comment);
		
		//res_idの最大値取得
		$strSQL = "SELECT MAX(res_id) as res_id FROM comment".
		          " WHERE board_id = ".$no;
		
		//SQL実行
		$db->sql($strSQL);
		
		//値の取得
		$row = $db->fetch_array();
		$res_id = $row["res_id"];
		
		//res_id + 1
		$res_id +=1;
		
		//commentテーブルに新規追加
		$strSQL2 = "INSERT INTO comment(board_id,res_id,user_id,contents,del_flg)".
		           " VALUES (".$no.",".$res_id.",".$user_id.",'".$comment."',0)";
		
		//SQL実行
		$db->sql($strSQL2);

		//データベース切断
		$db->db_cut();

	}
	
	//スレッド取得
	function select_data($db){

		//セッションから値を取得
		$no = $_SESSION["join"]["no"];
		
		$strSQL = "SELECT id, title FROM board".
		          " WHERE id = ". $no;
		//SQL実行
		$db->sql($strSQL);
		
	
	}

	//レス取得
/*	function select_data(){
	
	}
*/
?>