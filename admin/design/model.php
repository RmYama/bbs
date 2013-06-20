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

		//データベース切断
		$db->db_cut($db);
		
		return $result;

	}

	function siteLayoutUpdate(){
		
		//値取得
		$tag_header = $_POST["tag_header"];
		$tag_footer = $_POST["tag_footer"];
		
		//クラスのインスタンス化
		$chgString = new changeString();
		
		//エンティティ化
		$tag_header = $chgString->entity($tag_header);
		$tag_footer = $chgString->entity($tag_footer);
		
		//データベース接続
		$db = new dbAccess();
		
/*		$strSQL = "INSERT INTO designsettings(tag_header, tag_footer)".
				  " VALUES (:header, :footer)";
*/
		$strSQL = "UPDATE designsettings SET tag_header = :header, tag_footer = :footer";

		
		$stmt = $db->preparation($strSQL);

		$stmt->bindValue(':header',$tag_header);
		$stmt->bindValue(':footer',$tag_footer);
		
		//SQL文実行
		$db->execute();
		
		//データベース切断
		$db->db_cut($db);
		
	}


?>