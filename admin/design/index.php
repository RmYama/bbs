<?php
	session_start();

	require_once("../../class.php");
	require_once("../adminclass.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState();
	$state = $login->state();

	//アクションの判定をする
	$getP = new getParameter();
	$action = $getP->action($_GET);

	switch($action){
		case "":
			//画面レイアウト
			$result = array();
			$result = siteLayoutSelect();
			
			$tag_header = $result["tag_header"];
			$tag_footer = $result["tag_footer"];
			$site_bgcolor = $result["site_bgcolor"];
			$paging_cnt = $result["paging_cnt"];

			require_once("design.php");
			break;

		case "check":
			//入力チェック
			$err_chk = new tagDataChk();
			
			//値取得
			$tag_header  = $_POST["tag_header"];
			$tag_footer  = $_POST["tag_footer"];
			$site_bgcolor  = $_POST["site_bgcolor"];
			
			//プロパティに値を代入
			$err_chk->tag_header = $tag_header;
			$err_chk->tag_footer = $tag_footer;
			
			//メソッド実行
			$err1 = $err_chk->chkHeader();
			$err2 = $err_chk->chkFooter();
			
			if($err1 != "" || $err2 != ""){
				//エラー表示
				require_once("design.php");
			}else{
				//データベース更新
				siteLayoutUpdate();

				//完了画面
				nextPage("end.php");
			}
			break;

		default:
			echo "actionの異常エラー";
			break;
	}

	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove();
		$move->pagename = $pagename;
		$move->redirect();

	}

?>