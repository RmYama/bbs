<?php

	//新着スレッド表示(model)
	
	function listNewThread($db){

		//SQL実行判定
		$sql_flg = false;
		
		$strSQL = "SELECT a.id as id, a.title as title, a.created_At as add_time, b.contents as comment, count(a.id) as res_cnt, b.res_id as res_id".
		          " FROM board as a LEFT JOIN comment as b".
				  " ON a.id = b.board_id".
				  " GROUP BY a.id".
				  " HAVING b.res_id = 0".
				  " ORDER BY a.created_at desc";

		//SQL実行
		$db->sql($strSQL);
		
		$sql_flg = true;

		return $sql_flg;
	}


?>