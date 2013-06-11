<?php
	//一覧表示画面(model)

	function make_list($db,$no){
	
		$result = array();

		$result["flg"] = false;
		
		//タイトル取得
		$strSQL = "SELECT title FROM board".
		          " WHERE id = ".$no;
		
		$result["title"] = $db->sql($strSQL);
				
		//レス全件取得
		$strSQL ="SELECT a.*, b.nickname".
		         " FROM comment as a, users as b".
				 " WHERE a.user_id = b.id".
				 " AND  a.board_id =". $no.
				 " ORDER BY res_id asc";

		//SQL実行
		$db->sql($strSQL);

		$result["flg"] = true;
			
		//データベース切断
		$db->db_cut();

		return $result;
	}
	
	

?>