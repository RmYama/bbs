<?php
	session_start();

	require_once("class.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);	
	//現在ページNo取得
	$page = $getP->pageNo($_GET);

	//ページング
	$paging = new paging();
	//オフセットと1Pの件数の取得
	$offset = $paging->getOffset($page);
	$item_cnt = $paging->item_cnt;
	//全件取得
	$totalpages = $paging->totalpages;
	
	switch($action){
		case "":
			//初期表示
			$setLayout = new setLayout();
			
			//レイアウト反映
			$tag_header = $setLayout->setHeader();
			$tag_footer = $setLayout->setFooter();
			$site_bgcolor = $setLayout->setSiteBgcolor();

			//クラスのインスタンス化
			$db = new dbAccess();

			$flg = listNewThread($db,$offset,$item_cnt);

			
			require_once("top.php");

			//データベース切断
			$db->db_cut($db);
			break;
			
		default:
			echo "actionの異常エラー";
			break;
	}
?>