<?php

	//新着スレッド表示(model)
	
	function listNewThread($link){
/*
		//クラスのインスタンス化
		$db= new dbAccess;
		
		//データベース接続
		$link = $db->db_link();
*/

		$strSQL = "SELECT a.id as id, a.title as title, a.created_At as time, b.contents as comment, count(a.id) as res_cnt, b.res_id as res_id".
		          " FROM board as a LEFT JOIN comment as b".
				  " ON a.id = b.board_id".
				  " GROUP BY a.id".
				  " HAVING b.res_id = 0".
				  " ORDER BY a.created_at desc";

		$result = mysqli_query($link,$strSQL);

		
		if(!$result){
			die("新着スレッドの取得に失敗しました".mysqli_error());
		}

/*
			//データベース切断
			$db->db_cut($link);
*/		
		return $result;
	
	}


?>