<?php

	//新着スレッド表示(model)
	
	function siteLayoutSelect(){
		
		//データベース接続
		$db = new dbAccess();
		
		$strSQL = "SELECT * FROM designsettings";

		//SQL文実行
		$db->query($strSQL);
		$rows = $db->fetch();
		
		$result = array();
		$result["tag_header"] = $rows["tag_header"];
		$result["tag_footer"] = $rows["tag_footer"];
		$result["site_bgcolor"] = $rows["site_bgcolor"];
		$result["paging_cnt"] = $rows["paging_cnt"];

		//データベース切断
		$db->db_cut($db);
		
		return $result;

	}

	function siteLayoutUpdate(){
		
		//値取得
		$tag_header = $_POST["tag_header"];
		$tag_footer = $_POST["tag_footer"];
		$site_bgcolor = $_POST["site_bgcolor"];
		$paging_cnt = (int)$_POST["paging_cnt"];
		
		if($site_bgcolor == "" || ereg("#[a-fA-F0-9]{6}$",$site_bgcolor) == false){
			$site_bgcolor = "#FFFFFF";
		}
		
		if($paging_cnt == "" || $paging_cnt == 0){
			$paging_cnt = 5;
		}
		
		//クラスのインスタンス化
		$chgString = new changeString();
		
		//エンティティ化
		$tag_header = $chgString->entity($tag_header);
		$tag_footer = $chgString->entity($tag_footer);

		echo $site_bgcolor;
				
		//データベース接続
		$db = new dbAccess();
		
/*		$strSQL = "INSERT INTO designsettings(tag_header, tag_footer)".
				  " VALUES (:header, :footer)";
*/
		$strSQL = "UPDATE designsettings SET tag_header = :header, tag_footer = :footer,".
		          " site_bgcolor = :site_bgcolor, paging_cnt = :paging_cnt".
				  " WHERE id = 1";

		
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':header',$tag_header);
		$stmt->bindValue(':footer',$tag_footer);
		$stmt->bindValue(':site_bgcolor',$site_bgcolor);
		$stmt->bindValue(':paging_cnt',$paging_cnt);
		
		//SQL文実行
		$db->execute();
		
		//データベース切断
		$db->db_cut($db);
		
	}


?>