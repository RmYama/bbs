<?php

	//新着スレッド表示(model)
	
	function listNewThread($db,$offset,$item_cnt){

	
		$strSQL = "SELECT a.id as id, a.title as title, a.created_At as add_time, b.contents as comment, ".
		          "count(a.id) as res_cnt, b.res_id as res_id".
		          " FROM board as a LEFT JOIN comment as b".
				  " ON a.id = b.board_id".
				  " GROUP BY a.id".
				  " HAVING b.res_id = 0".
				  " ORDER BY a.created_at desc".
				  " limit :offset, :item_count";
		
		//SQL文準備
		$stmt = $db->preparation($strSQL);
		
		$stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
		$stmt->bindValue(':item_count',$item_cnt,PDO::PARAM_INT);
		
		//SQL実行
		$flg = $db->execute();

		return $flg;
	}


?>