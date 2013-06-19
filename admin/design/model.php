<?php

	//新着スレッド表示(model)
	
	function siteLayoutUpdate(){
		
		//値取得
		$tag_header = $_POST["tag_header"];
		$tag_footer = $_POST["tag_footer"];
		
		//置換
		//クラスのインスタンス化
		$chgString = new changeString;
		
		//渡してみる
		$tag_header = $chgString->replace($tag_header);

		var_dump($tag_header);
		
		//戻し
		$tag_header = $chgString->restore($tag_header);

//		var_dump($tag_header);

		//データベース接続
		
		//SQL
		

		//データベース切断
		return $tag_header;

	}


?>