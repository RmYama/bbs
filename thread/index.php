<?php
	session_start();

	//スレッド新規登録処理(Controller)
	require_once("../class.php");
	require_once("model.php");

	//ログイン状態の確認
	$login = new loginState;
	$state = $login->state();

	if($state == "true"){
		//ニックネームを取得
		$nickname = $_SESSION["users"]["nickname"];
	}

	//アクションの判定をする
	$getA = new getAction;
	$action = $getA->action($_GET);

	switch($action){
		case "":
			//初期表示
			require_once("entry_form.php");
			break;
			
		case "check":
			//プレビュー保持
			if(isset($_POST["preview"])){
				$preview = "checked";
			}

			//入力チェック
			$err_chk = new entryDataChk;
			
			//プロパティに値を代入
			$err_chk->title = $_POST["title"];
			$err_chk->comment = $_POST["comment"];
			
			//メソッドを実行して値を取得
			$err1 = $err_chk->chkTitle();
			$err2 = $err_chk->chkComment();
			
			if($err1 != "" || $err2 != ""){
				//入力エラー
				//フォームに値のセット
				$title = $_POST["title"];
				$comment = $_POST["comment"];
				
				//エラー表示
				require_once("entry_form.php");

			}else{
				
				//セッションに値を保存
				$_SESSION["join"]["title"] = $_POST["title"];
				$_SESSION["join"]["comment"] = $_POST["comment"];
				
				//プレビュー判定
				if($preview == "checked"){
					
					//プレビューもセッションに保持
					$_SESSION["join"]["preview"] = $preview;

					//確認画面表示
					nextPage("confirm.php");

				}else{
					//データベース登録
					make_thread();
					//完了画面
					nextPage("end.php");
				}
			}
			break;

		case "back":
			//確認画面から戻ってきた時
			//セッションから値を取得して変数に代入
				$title = $_SESSION["join"]["title"];
				$comment = $_SESSION["join"]["comment"];
				$preview = $_SESSION["join"]["preview"];
			//画面表示
			require_once("entry_form.php");
			break;

		case "entry":
			//データベースに登録
			make_thread();
			//完了画面
			nextPage("end.php");
			break;

		default:
			echo "actionの異常エラー";
			break;
	}

	//リダイレクト
	function nextPage($pagename){

		//classインスタンス化
		$move = new pageMove;
		$move->pagename = $pagename;
		$move->redirect();

	}

?>